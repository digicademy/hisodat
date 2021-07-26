<?php
namespace ADWLM\Hisodat\ViewHelpers;

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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

use voku\helper\HtmlDomParser;

/**
 * @see http://simplehtmldom.sourceforge.net/manual.htm
 * @see: https://github.com/voku/simple_html_dom (replaced the former)
 * @see: https://packagist.org/packages/voku/simple_html_dom
 * @see also: http://stackoverflow.com/questions/8564578/php-search-text-highlight-function
 * @see also: http://stackoverflow.com/questions/8193327/ignore-html-tags-in-preg-replace/8193700#8193700
 */

class HighlightViewHelper extends AbstractViewHelper
{

    /**
     * As this ViewHelper renders HTML, the output must not be escaped.
     *
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * Initialize ViewHelper arguments
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument(
            'terms',
            'array',
            'Terms to be highlighted.',
            false,
            array()
        );
        $this->registerArgument(
            'class',
            'string',
            'The css class to be added.',
            false,
            'term'
        );
        $this->registerArgument(
            'tag',
            'string',
            'The HTML tag which should be used.',
            false,
            'span'
        );
    }

    /**
     * Highlights terms (case insensitive) in the given HTML fragment using the Simple HTML DOM Library.
     * Supports phrases ("my term") and word truncations (ter*). Truncations may only occur at the end of
     * each term, any occurences at the beginning or in the middle of a term will be skipped.
     *
     * @throws
     *
     * @return string The content with the highlighted terms
     */
    public function render()
    {

        $terms = $this->arguments['terms'];
        $class = $this->arguments['class'];
        $tag = $this->arguments['tag'];

        // first get complete HTML content by rendering the children
        $content = $this->renderChildren();

        // if terms were given
        if (count($terms) > 0) {

            // initialize HTML DOM parser
            $htmlDomParser = GeneralUtility::makeInstance('voku\helper\HtmlDomParser');

            if ($htmlDomParser instanceof HtmlDomParser) {

                // read $current content into DOM
                $htmlFragment = $htmlDomParser::str_get_html($content);

                // search the text nodes for the terms
                foreach ($htmlFragment->find('text') as $textnode) {

                    foreach ($terms as $term) {
                        // fully remove quotes
                        $term = str_ireplace('"', '', $term);
                        // if term contains a wildcard/truncation at it's end match with ignoring the word endings
                        if (substr($term, -1) == '*') {
                            $term = str_ireplace('*', '', $term);
                            $textnode->plaintext = preg_replace('/(\b' . preg_quote($term) . '.*?\b)/i',
                                '<' . htmlspecialchars($tag) . ' class="' . htmlspecialchars($class) . '">$1</' . htmlspecialchars($tag) . '>',
                                $textnode->plaintext);
                            // match terms (case insensitive)
                        } else {
                            $textnode->plaintext = preg_replace('/(' . preg_quote($term) . ')/i',
                                '<' . htmlspecialchars($tag) . ' class="' . htmlspecialchars($class) . '">$1</' . htmlspecialchars($tag) . '>',
                                $textnode->plaintext);
                        }
                    }
                }

                // write DOM object back to string
                $content = $htmlFragment->save();

            } else {
                throw new \TYPO3\CMS\Core\Error\Exception('Voku HtmlDomParser could not be instantiated', 1364804201);
            }
        }

        return $content;
    }
}
