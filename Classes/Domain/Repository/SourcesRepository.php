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

use ADWLM\Hisodat\Utility\Frontend\Repository;
use ADWLM\Hisodat\Utility\Frontend\Search;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * Repository for Sources
 */
class SourcesRepository extends CommonRepository
{

    /**
     * Repository for persons
     *
     * @var \ADWLM\Hisodat\Domain\Repository\PersonsRepository
     */
    protected $personsRepository;

    /**
     * Repository for localities
     *
     * @var \ADWLM\Hisodat\Domain\Repository\LocalitiesRepository
     */
    protected $localitiesRepository;

    /**
     * Repository for entities
     *
     * @var \ADWLM\Hisodat\Domain\Repository\EntitiesRepository
     */
    protected $entitiesRepository;

    /**
     * Repository for events
     *
     * @var \ADWLM\Hisodat\Domain\Repository\EventsRepository
     */
    protected $eventsRepository;

    /**
     * Use constructor DI and not @inject because it's best
     * @see: https://gist.github.com/NamelessCoder/3b2e5931a6c1af19f9c3f8b46e74f837
     *
     * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface      $objectManager
     * @param \ADWLM\Hisodat\Domain\Repository\PersonsRepository    $personsRepository
     * @param \ADWLM\Hisodat\Domain\Repository\LocalitiesRepository $localitiesRepository
     * @param \ADWLM\Hisodat\Domain\Repository\EntitiesRepository   $entitiesRepository
     * @param \ADWLM\Hisodat\Domain\Repository\EventsRepository     $eventsRepository
     */
    public function __construct(
        \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager,
        \ADWLM\Hisodat\Domain\Repository\PersonsRepository $personsRepository,
        \ADWLM\Hisodat\Domain\Repository\LocalitiesRepository $localitiesRepository,
        \ADWLM\Hisodat\Domain\Repository\EntitiesRepository $entitiesRepository,
        \ADWLM\Hisodat\Domain\Repository\EventsRepository $eventsRepository
    ) {
        parent::__construct($objectManager);
        $this->personsRepository = $personsRepository;
        $this->localitiesRepository = $localitiesRepository;
        $this->entitiesRepository = $entitiesRepository;
        $this->eventsRepository = $eventsRepository;
    }

    /**
     * Performs a findAll on the repository with the possibility to influence the result ordering
     * and/or to return a raw result instead of an object storage.
     *
     * @param array   $settings
     * @param boolean $raw
     *
     * @return object The result from the query
     * @throws
     */
    public function findAllInPidsWithOrdering($settings = array(), $raw = false)
    {

        // initialize query object and set storage page to false - use TS/FF settings instead
        $query = $this->createQuery();

        // set the storagePid(s) for the query using the FF/TS settings instead of the default storagePid
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->in('pid', GeneralUtility::trimExplode(',', $settings['recordPids']['sources'], 1)));

        // determine the result order and sorting
        switch ((int)$settings['ascDesc']) {
            case 20:
                $orderings = array(Repository::resolveOrderBy($settings['orderBy']) => QueryInterface::ORDER_DESCENDING);
                break;
            case 10:
            default:
                $orderings = array(Repository::resolveOrderBy($settings['orderBy']) => QueryInterface::ORDER_ASCENDING);
                break;
        }
        $query->setOrderings($orderings);

        // go
        return $query->execute($raw);
    }

    /**
     * Performs a findByUid/Pid on the repository for the submitted source uids
     * and returns the objects or a raw result.
     *
     * @param string  $uids
     * @param array   $settings
     * @param boolean $raw
     *
     * @return object The result from the query
     * @throws
     */
    public function findByUids($uids, $settings = array(), $raw = false)
    {

        // initialize query object
        $query = $this->createQuery();

        // reset storagePid and set uid and pid constraint instead
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching(
            $query->logicalAnd(
                $query->in('uid', GeneralUtility::trimExplode(',', $uids, 1)),
                $query->in('pid', GeneralUtility::trimExplode(',', $settings['recordPids']['sources'], 1))
            )
        );

        // determine the result order and sorting
        switch ((int)$settings['ascDesc']) {
            case 20:
                $orderings = array(Repository::resolveOrderBy($settings['orderBy']) => QueryInterface::ORDER_DESCENDING);
                break;
            case 10:
            default:
                $orderings = array(Repository::resolveOrderBy($settings['orderBy']) => QueryInterface::ORDER_ASCENDING);
                break;
        }
        $query->setOrderings($orderings);

        // execute the query
        return $query->execute($raw);
    }

    /**
     * Finds object by identifier
     *
     * @param string $identifier
     *
     * @return object The result from the query
     * @throws
     */
    public function findByIdentifier($identifier)
    {

        // initialize query object and set storage page to false
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        // set the storagePid(s) for the query
        $query->matching($query->equals('identifier', $identifier));

        // just one result
        $query->setLimit(1);

        // go
        return $query->execute();
    }

    /**
     * Performs a MySQL statement on the sources possibly combining fulltext indexes
     * from sources, persons, localities and entities and applying different filter combinations.
     *
     * @param array $arguments
     * @param array $settings
     *
     * @return array
     */
    public function findByFulltext($arguments = array(), $settings = array())
    {
        // take searchstrings apart and remove empty rows - phrases/keywords need to be separated from persons, localities, entities and events
        $sourcesSearchstrings = array();
        $relatedObjectsSearchstrings = array();
        $personAndRoleFlag = 0;
        $localityAndRoleFlag = 0;
        $entityAndRoleFlag = 0;
        $eventAndRoleFlag = 0;
        if (is_array($arguments['searchstrings'])) {
            foreach ($arguments['searchstrings'] as $searchstring) {
                if ($searchstring['type'] < 10 && $searchstring['searchwords'] != '') {
                    $sourcesSearchstrings[] = $searchstring;
                } elseif ($searchstring['type'] >= 10 && $searchstring['searchwords'] != '') {
                    switch ((int)$searchstring['type']) {
                        case 10:
                            ($searchstring['role'] > 0) ? $personAndRoleFlag = 2 : $personAndRoleFlag = 1;
                            break;
                        case 20:
                            ($searchstring['role'] > 0) ? $localityAndRoleFlag = 2 : $localityAndRoleFlag = 1;
                            break;
                        case 30:
                            ($searchstring['role'] > 0) ? $entityAndRoleFlag = 2 : $entityAndRoleFlag = 1;
                            break;
                        case 40:
                            ($searchstring['role'] > 0) ? $eventAndRoleFlag = 2 : $eventAndRoleFlag = 1;
                            break;
                    }
                    $relatedObjectsSearchstrings[] = $searchstring;
                }
            }
        }

        // set fulltext if applicable
        $fulltextFields = '';
        if (!empty($sourcesSearchstrings)) {
            // note: this method fully quotes the searchstrings
            $searchwords = Search::transformToFulltextSyntax($sourcesSearchstrings);
            // set the index to match searchwords against
            $indexFields = GeneralUtility::trimExplode(',', $settings['index']['mysql']['fields']['sources'], 1);
            $index = implode(',', $indexFields);
            $fulltextFields = 'MATCH (' . $index . ') AGAINST (' . $searchwords . ' IN BOOLEAN MODE) AS matches';
        }

        // prepare group concat fields for related objects
        $groupConcatFields = array();
        if ($personAndRoleFlag > 0) {
            if ($personAndRoleFlag === 2) {
                $groupConcatFields[] = '
                    GROUP_CONCAT(DISTINCT tx_hisodat_domain_model_relations.person) AS persons,
                    GROUP_CONCAT(DISTINCT tx_hisodat_domain_model_relations.person, tx_hisodat_domain_model_relations.role) AS persons_roles
                ';
            } else {
                $groupConcatFields[] = 'GROUP_CONCAT(DISTINCT tx_hisodat_domain_model_relations.person) AS persons';
            }
        }
        if ($localityAndRoleFlag > 0) {
            if ($localityAndRoleFlag === 2) {
                $groupConcatFields[] = '
                    GROUP_CONCAT(DISTINCT tx_hisodat_domain_model_relations.locality) AS localities,
                    GROUP_CONCAT(DISTINCT tx_hisodat_domain_model_relations.locality, tx_hisodat_domain_model_relations.role) AS localities_roles
                ';
            } else {
                $groupConcatFields[] = 'GROUP_CONCAT(DISTINCT tx_hisodat_domain_model_relations.locality) AS localities';
            }
        }
        if ($entityAndRoleFlag > 0) {
            if ($entityAndRoleFlag === 2) {
                $groupConcatFields[] = '
                    GROUP_CONCAT(DISTINCT tx_hisodat_domain_model_relations.entity) as entities,
                    GROUP_CONCAT(DISTINCT tx_hisodat_domain_model_relations.entity, tx_hisodat_domain_model_relations.role) as entities_roles
                ';
            } else {
                $groupConcatFields[] = 'GROUP_CONCAT(DISTINCT tx_hisodat_domain_model_relations.entity) as entities';
            }
        }

        if ($eventAndRoleFlag > 0) {
            if ($eventAndRoleFlag === 2) {
                $groupConcatFields[] = '
                    GROUP_CONCAT(DISTINCT tx_hisodat_domain_model_relations.event) as events,
                    GROUP_CONCAT(DISTINCT tx_hisodat_domain_model_relations.event, tx_hisodat_domain_model_relations.role) as events_roles
                ';
            } else {
                $groupConcatFields[] = 'GROUP_CONCAT(DISTINCT tx_hisodat_domain_model_relations.event) as events';
            }
        }

        $groupConcatFields = implode(',', $groupConcatFields);

        // begin the statement
        $statement = 'SELECT tx_hisodat_domain_model_sources.uid';

        // set the appropriate fields depending on the submitted searchstrings
        if (!empty($relatedObjectsSearchstrings) && !empty($sourcesSearchstrings)) {
            $statement .= ', ' . $groupConcatFields . ', ' . $fulltextFields;
        } elseif (!empty($relatedObjectsSearchstrings) && empty($sourcesSearchstrings)) {
            $statement .= ', ' . $groupConcatFields;
        } elseif (empty($relatedObjectsSearchstrings) && !empty($sourcesSearchstrings)) {
            $statement .= ', ' . $fulltextFields;
        }

        // set the table
        $statement .= ' FROM tx_hisodat_domain_model_sources';

        // join date ranges table if necessary
        $dateRangeEnableFields = '';
        if (!empty($arguments['startDate'])
            || !empty($arguments['endDate'])
            || $settings['orderBy'] == 70
            || $settings['orderBy'] == 80
            || $settings['orderBy'] == 90
        ) {
            $statement .= ' LEFT JOIN tx_hisodat_domain_model_dateranges ON tx_hisodat_domain_model_dateranges.parent_record = tx_hisodat_domain_model_sources.uid';
            $dateRangeEnableFields = ' AND tx_hisodat_domain_model_dateranges.deleted=0 AND tx_hisodat_domain_model_dateranges.t3ver_state<=0 AND tx_hisodat_domain_model_dateranges.pid<>-1 AND tx_hisodat_domain_model_dateranges.hidden=0 AND tx_hisodat_domain_model_dateranges.sys_language_uid IN (0,-1)';
        }

        // join keywords MM table if necessary
        if (!empty($arguments['keywords'])) {
            $statement .= ' LEFT JOIN tx_hisodat_keywords_mm ON tx_hisodat_keywords_mm.uid_local = tx_hisodat_domain_model_sources.uid';
        }

        // join the relation table if roles were set or persons, localities, entities demanded
        if (!empty($relatedObjectsSearchstrings) || !empty($arguments['roles'])) {
            $statement .= ' LEFT JOIN tx_hisodat_domain_model_relations ON tx_hisodat_domain_model_relations.source = tx_hisodat_domain_model_sources.uid';
        }

        // set enable fields
        $statement .= ' WHERE tx_hisodat_domain_model_sources.deleted = 0 AND tx_hisodat_domain_model_sources.t3ver_state <= 0 AND tx_hisodat_domain_model_sources.pid <> -1 AND tx_hisodat_domain_model_sources.hidden = 0 AND tx_hisodat_domain_model_sources.sys_language_uid IN (0,-1)' . $dateRangeEnableFields;

        // set keywords
        if (!empty($arguments['keywords'])) {
            $statement .= ' AND tx_hisodat_keywords_mm.ident = \'tx_hisodat_domain_model_sources\'';
            $statement .= ' AND tx_hisodat_keywords_mm.uid_foreign IN (' . implode(',',
                    $GLOBALS['TYPO3_DB']->cleanIntArray($arguments['keywords'])) . ')';
        }

        // dates have already been validated, but may need to be filled up with leading zeros; MySQL BETWEEN needs proper YYYY-MM-DD strings
        if (!empty($arguments['startDate']) || !empty($arguments['endDate'])) {
            if ($arguments['startDate'] && $arguments['endDate']) {
                $startDate = Search::getFormattedDate($arguments['startDate']);
                $endDate = Search::getFormattedDate($arguments['endDate']);
                $statement .= ' AND tx_hisodat_domain_model_dateranges.start_date BETWEEN ' . $GLOBALS['TYPO3_DB']->fullQuoteStr($startDate,
                        'tx_hisodat_domain_model_dateranges') . ' AND ' . $GLOBALS['TYPO3_DB']->fullQuoteStr($endDate,
                        'tx_hisodat_domain_model_dateranges');
            } elseif ($arguments['startDate'] && empty($arguments['endDate'])) {
                $startDate = Search::getFormattedDate($arguments['startDate']);
                $statement .= ' AND tx_hisodat_domain_model_dateranges.start_date BETWEEN ' . $GLOBALS['TYPO3_DB']->fullQuoteStr($startDate,
                        'tx_hisodat_domain_model_dateranges') . ' AND \'' . Search::getFormattedDate($settings['validation']['dateRanges']['maxDate']) . '\'';
            } elseif (empty($arguments['startDate']) && $arguments['endDate']) {
                $endDate = Search::getFormattedDate($arguments['endDate']);
                $statement .= ' AND tx_hisodat_domain_model_dateranges.start_date BETWEEN \'' . Search::getFormattedDate($settings['validation']['dateRanges']['minDate']) . '\' AND ' . $GLOBALS['TYPO3_DB']->fullQuoteStr($endDate,
                        'tx_hisodat_domain_model_dateranges');
            }
        }

        // set pids
        if (!empty($arguments['pages'])) {
            $statement .= ' AND tx_hisodat_domain_model_sources.pid IN(' . implode(',',
                    $GLOBALS['TYPO3_DB']->cleanIntArray($arguments['pages'])) . ')';
        } else {
            $statement .= ' AND tx_hisodat_domain_model_sources.pid IN(' . $settings['recordPids']['sources'] . ')';
        }

        // set archives
        if (!empty($arguments['archives'])) {
            $statement .= ' AND tx_hisodat_domain_model_sources.archive IN (' . implode(',',
                    $GLOBALS['TYPO3_DB']->cleanIntArray($arguments['archives'])) . ')';
        }

        // set signatures
        if (!empty($arguments['signatures'])) {
            $signatures = Search::wordSplit($arguments['signatures'], null, true);
            $signatureDisjunction = array();
            foreach ($signatures as $signature) {
                if (stristr($signature, '"')) {
                    $signature = 'tx_hisodat_domain_model_sources.signature LIKE ' . $GLOBALS['TYPO3_DB']->fullQuoteStr(str_replace('"',
                            '', $signature), 'tx_hisodat_domain_model_sources');
                } else {
                    $signature = 'tx_hisodat_domain_model_sources.signature LIKE ' . $GLOBALS['TYPO3_DB']->fullQuoteStr('%' . $signature . '%',
                            'tx_hisodat_domain_model_sources');
                }
                $signatureDisjunction[] = $signature;
            }
            $statement .= ' AND (' . implode(' OR ', $signatureDisjunction) . ')';
        }

        // set images
        if ($arguments['onlyWithImages'] == 1) {
            $statement .= ' AND tx_hisodat_domain_model_sources.images != \'\'';
        }

        $statement .= ' GROUP BY tx_hisodat_domain_model_sources.uid';

        // possible fulltext sub-queries on related objects (persons, localities, entities)
        if (!empty($relatedObjectsSearchstrings)) {

            $repositoryName = '';
            $concatColumnName = '';
            $relatedObjects = array();

            foreach ($relatedObjectsSearchstrings as $searchstring) {

                switch ($searchstring['type']) {
                    case 10:
                        ($searchstring['role'] > 0) ? $concatColumnName = 'persons_roles' : $concatColumnName = 'persons';
                        $repositoryName = 'personsRepository';
                        break;
                    case 20:
                        ($searchstring['role'] > 0) ? $concatColumnName = 'localities_roles' : $concatColumnName = 'localities';
                        $repositoryName = 'localitiesRepository';
                        break;
                    case 30:
                        ($searchstring['role'] > 0) ? $concatColumnName = 'entities_roles' : $concatColumnName = 'entities';
                        $repositoryName = 'entitiesRepository';
                        break;
                    case 40:
                        ($searchstring['role'] > 0) ? $concatColumnName = 'events_roles' : $concatColumnName = 'events';
                        $repositoryName = 'eventsRepository';
                        break;
                }

                $objectUids = $this->$repositoryName->findByFulltext(array(
                    'searchstrings' => array(
                        0 => array(
                            'operator' => 10,
                            'type' => 1,
                            'searchwords' => $searchstring['searchwords']
                        )
                    )
                ), $settings);

                if (!empty($objectUids)) {

                    // slice one level off the array
                    $uids = array_map(function ($a) {
                        return array_pop($a);
                    }, $objectUids);

                    // possibly append role value to array values
                    if ($searchstring['role'] > 0) {
                        foreach ($uids as $key => $uid) {
                            $uids[$key] .= $searchstring['role'];
                        }
                    }

                    // build a csv list of uids
                    $uids = implode(',', $uids);

                    // prepare FIND_IN_SET statement for each uid
                    if ((int)$searchstring['operator'] === 10) {
                        $relatedObjects[]['AND'] = 'FIND_IN_SET(\'' . str_replace(',', '\', ' . $concatColumnName . ') OR FIND_IN_SET(\'', $uids) . '\', ' . $concatColumnName . ')';
                    }
                    if ((int)$searchstring['operator'] === 20) {
                        $relatedObjects[]['OR'] = 'FIND_IN_SET(\'' . str_replace(',', '\', ' . $concatColumnName . ') OR FIND_IN_SET(\'', $uids) . '\', ' . $concatColumnName . ')';
                    }
                    if ((int)$searchstring['operator'] === 30) {
                        $relatedObjects[]['AND'] = '(FIND_IN_SET(\'' . str_replace(',', '\', ' . $concatColumnName . ') = 0) AND (FIND_IN_SET(\'', $uids) . '\', ' . $concatColumnName . ') = 0)';
                    }

                } else {
                    // if no result make sure that the boolean search combinations still hold true
                    if ((int)$searchstring['operator'] === 10) {
                        $relatedObjects[]['AND'] = '0 = 1';
                    }
                    if ((int)$searchstring['operator'] === 20) {
                        $relatedObjects[]['OR'] = '0 = 1';
                    }
                }
            }
        }

        // bring possible related objects into query syntax
        $relatedObjectsStatement = '';
        if (!empty($relatedObjects)) {
            foreach ($relatedObjects as $key => $value) {
                if ($key === 0) {
                    $relatedObjectsStatement .= '(' . $value[key($value)] . ') ';
                } else {
                    $relatedObjectsStatement .= key($value) . ' (' . $value[key($value)] . ') ';
                }
            }
        }

        // set HAVING statement taking boolean search operators from searchstrings into account
        if (!empty($relatedObjectsStatement) && !empty($sourcesSearchstrings)) {
            if ((int)$sourcesSearchstrings[0]['operator'] === 20 || (int)$relatedObjectsSearchstrings[0]['operator'] === 20) {
                $statement .= ' HAVING (matches > 0) OR (' . $relatedObjectsStatement . ')';
            } else {
                $statement .= ' HAVING matches > 0 AND ' . $relatedObjectsStatement;
            }
        } elseif (!empty($relatedObjectsStatement) && empty($sourcesSearchstrings)) {
            $statement .= ' HAVING ' . $relatedObjectsStatement;
        } elseif (empty($relatedObjectsStatement) && !empty($sourcesSearchstrings)) {
            $statement .= ' HAVING matches > 0';
        }

        // set ordering for query
        switch ($settings['ascDesc']) {
            case 10:
                $orderings = Repository::resolveOrderBy($settings['orderBy']) . ' ASC';
                break;
            case 20:
                $orderings = Repository::resolveOrderBy($settings['orderBy']) . ' DESC';
                break;
            default:
                $orderings = 'identifier ASC';
                break;
        }

        if ($settings['orderBy'] >= 70 && $settings['orderBy'] <= 90) {
            switch ($settings['orderBy']) {
                case 70:
                    $statement .= ' ORDER BY tx_hisodat_domain_model_dateranges.' . str_replace('dateRange.startDate', 'start_date', $orderings);
                    break;
                case 80:
                    $statement .= ' ORDER BY tx_hisodat_domain_model_dateranges.' . str_replace('dateRange.endDate', 'end_date', $orderings);
                    break;
                case 90:
                    $statement .= ' ORDER BY tx_hisodat_domain_model_dateranges.' . str_replace('dateRange.dateKey', 'date_key', $orderings);
                    break;
            }
        } else {
            $statement .= ' ORDER BY tx_hisodat_domain_model_sources.' . $orderings;
        }

        // create the query object
        $query = $this->createQuery();

        // ignore storage PID and use TS/FF settings instead
        $query->getQuerySettings()->setRespectStoragePage(false);

        // set statement
        // TODO: statement method not there anymore? @see: https://forum.typo3.org/index.php/t/213781/-typo3-german-prepared-statements-in-extbase-typo3-7-6
        $query->statement($statement);

        // if NO searchwords and NO arguments were submitted return empty !!
        $result = array();
        if (!empty($sourcesSearchstrings)
            || !empty($relatedObjectsStatement)
            || !empty($arguments['roles'])
            || !empty($arguments['keywords'])
            || !empty($arguments['startDate'])
            || $arguments['endDate']
            || !empty($arguments['pages'])
            || !empty($arguments['archives'])
            || $arguments['signatures']
            || $arguments['onlyWithImages']
        ) {

            $resultArray = $query->execute(true);
            if (!empty($resultArray)) {
                foreach ($resultArray as $row) {
                    $result[] = $row['uid'];
                }
            }
        }

        return $result;
    }
}
