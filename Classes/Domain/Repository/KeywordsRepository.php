<?php
namespace ADWLM\Hisodat\Domain\Repository;

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

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Repository for Keywords
 */
class KeywordsRepository extends CommonRepository
{

    /**
     * Performs a findAll on the repository with certain storage pids as basis
     *
     * @param string $pidList
     * @param array  $keywordTypes
     *
     * @return object The result from the query
     */
    public function findAllInPidsWithTypes($pidList, $keywordTypes = array(0 => 0))
    {

        // initialize query object and set storage page to false
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        // set the constraints for the query
        $constraints = array();

        // keyword types are in a csv list - cheat a bit using a string comparison to stay in line with extbase's ORM
        $types = array();
        foreach ($keywordTypes as $type) {
            $types[] = $query->like('keywordType', '%' . $type . '%');
        }

        $constraints[] = $query->logicalOr($types);
        $constraints[] = $query->in('pid', GeneralUtility::intExplode(',', $pidList, 1));

        // set query
        $query->matching($query->logicalAnd($constraints));

        // result order
        $query->setOrderings(array('name' => QueryInterface::ORDER_ASCENDING));

        // go
        return $query->execute();
    }

    /**
     * Finds all child keywords for a given parent keyword
     *
     * @param \ADWLM\Hisodat\Domain\Model\Keywords $keyword
     * @param array $settings
     *
     * @return object The result from the query
     */
    public function findChildrenForParent(\ADWLM\Hisodat\Domain\Model\Keywords $keyword, $settings)
    {

        // initialize query object and set storage page to false
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        // set the constraints for the query
        $constraints = array();

        // pid constraint
        $constraints[] = $query->in('pid', GeneralUtility::intExplode(',', $settings['recordPids']['keywords'], 1));

        // parent keyword constraint
        $constraints[] = $query->equals('parentKeyword', $keyword);

        // set query
        $query->matching($query->logicalAnd($constraints));

        // result order
        if ($settings['filters']['alphabet']['orderByProperties']) {
            $orderByProperties = $settings['filters']['alphabet']['orderByProperties'];
        } else {
            $orderByProperties = 'name';
        }
        $query->setOrderings(array($orderByProperties => QueryInterface::ORDER_ASCENDING));

        // go
        return $query->execute();
    }

    /**
     * Performs a findBy on keywords for based on filters. The keywords repository implements it's own method
     * because the registers plugin allows some more filter settings for keywords (ancestors and classifications)
     * than for the other objects.
     *
     * @param array  $settings
     * @param string $pidList
     * @param array  $filters
     *
     * @return object The result from the query
     */
    public function findByFilters($settings, $pidList, $filters = array())
    {

        // initialize query object and set storage page to false - use TS/FF settings instead
        $query = $this->createQuery();

        // set the storagePid(s) for the query using the FF/TS settings instead of the default storagePid
        $query->getQuerySettings()->setRespectStoragePage(false);

        // set ordering of the result
        $orderings = array($settings['filters']['alphabet']['orderByProperties'] => QueryInterface::ORDER_ASCENDING);
        $query->setOrderings($orderings);

        // initialize constraints
        $constraints = array();

        // pid constraint
        $constraints[] = $query->in('pid', GeneralUtility::intExplode(',', $pidList, 1));

        // letter constraint
        if ($filters['alphabet']['letterRange']) {
            $letterLowercase = mb_strtolower(substr($filters['alphabet']['letterRange'], 0,
                (int)$settings['filters']['alphabet']['maxLetterRangeLength']), 'UTF-8');
            $constraints[] = $query->logicalOr(
                $query->like($settings['filters']['alphabet']['filterProperty'], $letterLowercase . '%'),
                $query->like($settings['filters']['alphabet']['filterProperty'],
                    mb_strtoupper($letterLowercase, 'UTF-8') . '%'),
                $query->like($settings['filters']['alphabet']['filterProperty'], ucfirst($letterLowercase) . '%')
            );
        }

// @TODO: this can lead to a fatal mysql error if for example 'familyName' is set but the calling register plugin is keywords
        if ($filters['search']['searchstring'] !== '') {
            $constraints[] = $query->like($settings['filters']['search']['filterProperty'],
                '%' . $filters['search']['searchstring'] . '%');
        }

        // classification constraint
        if ($settings['filters']['keywords']['classifications']) {
            $classifications = GeneralUtility::intExplode(',', $settings['filters']['keywords']['classifications'], 1);
            $constraints[] = $query->in('classification', $classifications);
        }

        // parent keyword constraint
        if ($settings['filters']['keywords']['parentKeywords']) {
            $parentKeywords = GeneralUtility::intExplode(',', $settings['filters']['keywords']['parentKeywords'], 1);
            $constraints[] = $query->in('parentKeyword', $parentKeywords);
        }

        // apply constraints to query
        $query->matching($query->logicalAnd($constraints));

        // go
        return $query->execute();
    }

}
