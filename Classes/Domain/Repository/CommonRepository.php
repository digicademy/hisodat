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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

class CommonRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * Performs a findAll with storage pids as basis
     *
     * @param string $pidList
     * @param string $orderByProperties
     *
     * @return object The result from the query
     * @throws
     */
    public function findAllInPids($pidList, $orderByProperties = 'name')
    {

        // initialize query object and set storage page to false
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        // set the storagePid(s) for the query
        $query->matching($query->in('pid', GeneralUtility::trimExplode(',', $pidList, 1)));

        // result order
        $query->setOrderings(array($orderByProperties => QueryInterface::ORDER_ASCENDING));

        // go
        return $query->execute();
    }

    /**
     * Finds object by persistentIdentifier
     *
     * @param string $persistentIdentifier
     *
     * @return object The result from the query
     * @throws
     */
    public function findByPersistentIdentifier($persistentIdentifier)
    {

        // initialize query object and set storage page to false
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        // set the storagePid(s) for the query
        $query->matching($query->equals('persistentIdentifier', $persistentIdentifier));

        // just one result
        $query->setLimit(1);

        // go
        return $query->execute();
    }

    /**
     * Performs a findBy (properties act as filters).
     *
     * @param array  $settings
     * @param string $pidList
     * @param array  $filters
     *
     * @return object The result from the query
     * @throws
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
        $constraints[] = $query->in('pid', GeneralUtility::trimExplode(',', $pidList, 1));

        // TODO: match with fulltext index? - as long as there is no dedicated normalized name work with string variants; will not find names that begin with accented letters...
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

        // apply constraints to query
        $query->matching($query->logicalAnd($constraints));

        // go
        return $query->execute();
    }

}
