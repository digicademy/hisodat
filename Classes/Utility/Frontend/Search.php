<?php
namespace ADWLM\Hisodat\Utility\Frontend;

/***************************************************************
 *  Copyright notice
 *
 *  Torsten Schrade <Torsten.Schrade@adwmainz.de>, Academy of Sciences and Literature | Mainz
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Helper utility for search requests
 */
class Search
{

    /**
     * Splits a string into distinct words by whitespace or ,
     * To allow phrase searches " and ' are let in, but preserveQuotes must be set. Makes it
     * possible to search for "Jean-Baptiste le Rond d'Alembert" for example.
     *
     * @param \string  $string
     * @param \string  $pattern
     * @param \boolean $preserveQuotes
     *
     * @return \array
     */
    public static function wordSplit($string, $pattern, $preserveQuotes = false)
    {
        // make sure there is a pattern
        if (empty($pattern)) {
            $pattern = '/[\s\,]+/';
        }
        // break the string into words
        $wordSplit = array_unique(preg_split($pattern, $string, -1, PREG_SPLIT_NO_EMPTY));
        // if quotes should be preserved, do a second processing
        if ($preserveQuotes === true) {
            $wordSplit = preg_split('/\G(?:"[^"]*"|\'[^\']*\'|[^"\'\s]+)*\K\s+/', implode(' ', $wordSplit), -1,
                PREG_SPLIT_NO_EMPTY);
        }

        return $wordSplit;
    }

    /**
     * Takes the submitted array of searchstrings apart and collects searchwords into an array for possible highlighting.
     * Only includes searchstrings joined with AND/OR, not with NOT. A NOT searchstring will NOT be in the
     * text and therefore cannot be highlighted ;)
     *
     * @param \array $searchstrings
     *
     * @return \array $result
     */
    public static function collectSearchwords($searchstrings)
    {
        $result = array();
        foreach ($searchstrings as $key => $value) {
            // empty, then stop
            if (empty($value['searchwords'])) {
                continue;
            }
            // type: phrases
            if ((int)$value['type'] === 2 && (int)$value['operator'] < 30) {
                // properly quote the full string for later phrase highlighting
                $result[] = str_replace('"', '', $value['searchwords']);
                // type: keywords
            } elseif ((int)$value['operator'] < 30) {
                // break into distinct words
                $wordSplit = self::wordSplit($value['searchwords'], null, true);
                foreach ($wordSplit as $word) {
                    $result[] = str_replace('"', '', $word);
                }
            }
        }

        return $result;
    }

    /**
     * Accumulates and fully escapes searchstrings into query MySQL fulltext syntax.
     * OR always separates the searchwords with new parentheses.
     * AND/NOT searchwords are combined into parentheses using +/-.
     *
     * @see: http://dev.mysql.com/doc/refman/5.1/en/fulltext-boolean.html
     *
     * @param \array $searchstrings
     *
     * @return \string
     */
    public static function transformToFulltextSyntax($searchstrings)
    {

        $searchwords = '';

        for ($i = 0; $i < count($searchstrings); $i++) {

            // current row (using a for loop instead of foreach for accessing the multidimenional array)
            $operator = (int)$searchstrings[$i]['operator'];
            $type = (int)$searchstrings[$i]['type'];
            $words = $searchstrings[$i]['searchwords'];
            $queryPart = '';

            switch ($type) {
                case 10:
                    $tablename = 'tx_hisodat_domain_model_persons';
                    break;
                case 20:
                    $tablename = 'tx_hisodat_domain_model_localities';
                    break;
                case 30:
                    $tablename = 'tx_hisodat_domain_model_entities';
                    break;
                case 40:
                    $tablename = 'tx_hisodat_domain_model_events';
                    break;
                case 1:
                case 2:
                default:
                    $tablename = 'tx_hisodat_domain_model_sources';
                    break;
            }

            // ignore empty rows
            if (empty($words)) {
                continue;
            }

            // boolean operators for each row
            switch ($operator) {
                // OR separates existing searchwords with new parentheseses
                case 20:
                    if (empty($searchwords)) {
                        $queryPart = '(';
                    } else {
                        $queryPart = ') (';
                    }
                    break;
                // NOT is joined using -
                case 30:
                    $queryPart = ' -';
                    break;
                // AND is joined using +; the first searchrow always starts with +(= AND)
                case 10:
                default:
                    ($i === 0) ? $queryPart = '(+' : $queryPart = ' +';
                    break;
            }

            // phrases or keywords
            switch ($type) {

                // phrase: quote the whole row and make sure there are no valid inner quotation marks
                case 2:
                    $phrase = str_replace('"', '', $words);
                    $phrase = '"' . $GLOBALS['TYPO3_DB']->fullQuoteStr($phrase, $tablename) . '"';
                    $phrase = str_replace('"\'', '\"', str_replace('\'"', '\"', $phrase));
                    $queryPart .= $phrase;
                    break;

                // (possibly several) keywords (or phrases): join multiple words per row by their according operator
                case 1:
                default:
                    $words = self::wordSplit($words, null, true);

                    // it is possible that one row also contains quoted phrases besides keywords,
                    // therefore go through the result and cater for that
                    foreach ($words as $key => $word) {
                        // phrase
                        if (preg_match('/"/', $word)) {
                            $phrase = str_replace('"', '', $word);
                            $phrase = '"' . $GLOBALS['TYPO3_DB']->fullQuoteStr($phrase, $tablename) . '"';
                            $phrase = str_replace('"\'', '\"', str_replace('\'"', '\"', $phrase));
                            $words[$key] = $phrase;

                            // keyword - quote everything, but remove quotes around the word to comply with fulltext syntax
                            // the whole fulltext string will be quoted in single quotes below
                        } else {
                            $keyword = $GLOBALS['TYPO3_DB']->fullQuoteStr($word, $tablename);
                            $keyword = preg_replace('/(^\'|\'$)/', '', $keyword);
                            $words[$key] = $keyword;
                        }
                    }

                    if ($operator === 20) {
                        $queryPart .= implode(' ', $words);
                    } elseif ($operator === 30) {
                        $queryPart .= implode(' -', $words);
                    } else {
                        $queryPart .= implode(' +', $words);
                    }

                    break;
            }
            // extend the current searchwords
            $searchwords .= $queryPart;
        }
        // close all parentheses and trim but only if there are any searchwords
        if (!empty($searchwords)) {
            if ($searchwords{0} !== '(') {
                $searchwords = '(' . trim($searchwords) . ')';
            } else {
                $searchwords = trim($searchwords) . ')';
            }
        }
        // fully quote the string
        $searchwords = '\'' . $searchwords . '\'';

        return $searchwords;
    }

    /**
     * Takes arguments from a fulltext search and converts them to a specially formatted querystring that can be
     * passed along with a single argument. This saves some characters in respect to the imminent GET limit for
     * complex searches.
     *
     * @param \array $arguments
     *
     * @return \string
     */
    public static function argumentsToQuerystring($arguments)
    {
        $queryString = '';
        $querystringArray = array();
        foreach ($arguments as $key => $argument) {
            if ($key == 'searchstrings') {
                $searchstrings = array();
                foreach ($argument as $searchstring) {
                    // put searchstring components into fixed sequence
                    $searchstrings[] = implode(';',
                        array(
                            'operator' => $searchstring['operator'],
                            'type' => $searchstring['type'],
                            'searchwords' => $searchstring['searchwords'],
                            'role' => $searchstring['role'],
                        )
                    );
                }
                if (!empty($searchstrings)) {
                    $querystringArray[] = 'searchstrings:' . implode('@', $searchstrings);
                }
            } elseif (is_array($argument) && !empty($argument)) {
                $querystringArray[] = $key . ':' . implode(';', $argument);
            } elseif (!empty($argument)) {
                $querystringArray[] = $key . ':' . $argument;
            }
        }
        if (!empty($querystringArray)) {
            $queryString = implode('+', $querystringArray);
        }

        return $queryString;
    }

    /**
     * Converts a querystring from a former fulltext search back to the original arguments.
     *
     * @param \string $querystring
     *
     * @return \array
     */
    public static function querystringToArguments($querystring)
    {

        $arguments = array();
        $queryStringArray = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode('+', $querystring, 1);

        foreach ($queryStringArray as $queryStringComponent) {

            $key = substr($queryStringComponent, 0, stripos($queryStringComponent, ':'));
            $value = substr($queryStringComponent, stripos($queryStringComponent, ':') + 1);

            if ($key == 'searchstrings') {

                $labels = array('0' => 'operator', '1' => 'type', '2' => 'searchwords', '3' => 'role');

                if (preg_match('/@/', $value)) {
                    $searchrows = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode('@', $value);
                    foreach ($searchrows as $searchrow) {
                        $searchrow = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(';', $searchrow);
                        \TYPO3\CMS\Core\Utility\ArrayUtility::remapArrayKeys($searchrow, $labels);
                        $arguments[$key][] = $searchrow;
                    }

                } else {
                    $searchrow = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(';', $value, 1);
                    \TYPO3\CMS\Core\Utility\ArrayUtility::remapArrayKeys($searchrow, $labels);
                    $arguments[$key][] = $searchrow;

                }

            } elseif ($key == 'keywords' || $key == 'archives' || $key == 'pages') {

                if (stripos($value, ';')) {
                    $values = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(';', $value, 1);
                    $arguments[$key] = $values;
                } else {
                    $arguments[$key][] = $value;
                }

            } elseif (stripos($value, ';')) {

                $arguments[$key] = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(';', $value, 1);

            } else {

                $arguments[$key] = $value;

            }
        }

        return $arguments;
    }

    /**
     * Amends a date string with possibly missing month/day components and ensures that the date is
     * in the format YYYY-MM-DD.
     *
     * @param \string $dateString
     *
     * @return \string
     */
    public static function getFormattedDate($dateString)
    {
        // split into components
        $dateComponents = \TYPO3\CMS\Core\Utility\GeneralUtility::intExplode('-', $dateString);
        // fill up year with leading zeros
        $dateComponents[0] = sprintf('%04d', $dateComponents[0]);
        // add month component if missing and/or pad with leading zeros
        if ($dateComponents[1]) {
            $dateComponents[1] = sprintf('%02d', $dateComponents[1]);
        } else {
            $dateComponents[1] = '00';
        }
        // add day component if missing or pad with leading zeros
        if ($dateComponents[2]) {
            $dateComponents[2] = sprintf('%02d', $dateComponents[2]);
        } else {
            $dateComponents[2] = '00';
        }

        return implode('-', $dateComponents);
    }

}
