<?php
namespace ADWLM\Hisodat\Utility\Backend;

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

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Concerned with label retrieval for records in the backend
 */
class LabelUtility
{

    /**
     * Retrieves the labels in the backend for the relations between HISODAT objects. The relations table serves as a 1:n:n:1 with columns
     * for each object that could possibly related with each other object and some additional columns like description etc. This function
     * checks which columns are filled for the current relation and then fetches the labels from the according foreign tables in DB.
     * This function is registered in ext_tables.php using "label_userFunc".
     *
     * @param $parameters
     * @param $parentObject
     *
     * @return mixed
     */
    public function relationsLabel(&$parameters, &$parentObject)
    {

        // since we need the label user func in IRRE as well as in list module, fetch the relevant record/fields from DB (parameters doesn't contain all fields in list module)
        $row = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow('relation_type,role,source,person,locality,entity,event,source_symmetric,person_symmetric,locality_symmetric,entity_symmetric,event_symmetric',
            'tx_hisodat_domain_model_relations', 'uid=' . (int)$parameters['row']['uid']);

        // if a role is assigned in the current relation, get it's name, otherwise leave it blank
        $role = $this->getRoleName($row);

        // separates left and right object; @TODO: object separator could be made configurable later on
        $objectSeparator = ' &lt;&gt; ';

        // switch the label context according to the type of the current relation
        switch ($row['relation_type']) {
            // person <> source
            case 10:
                $parameters['title'] = $this->getPersonLabel($row['person']) . $objectSeparator . $this->getSourceLabel($row['source']) . ' (' . $role . ')';
                break;
            // locality <> source
            case 20:
                $parameters['title'] = $this->getLocalityLabel($row['locality']) . $objectSeparator . $this->getSourceLabel($row['source']) . ' (' . $role . ')';
                break;
            // entity <> source
            case 30:
                $parameters['title'] = $this->getEntityLabel($row['entity']) . $objectSeparator . $this->getSourceLabel($row['source']) . ' (' . $role . ')';
                break;
            // event <> source
            case 40:
                $parameters['title'] = $this->getEventLabel($row['event']) . $objectSeparator . $this->getSourceLabel($row['source']) . ' (' . $role . ')';
                break;
            // source <> source
            case 50:
                $parameters['title'] = $this->getSourceLabel($row['source']) . $objectSeparator . $this->getSourceLabel($row['source_symmetric']) . ' (' . $role . ')';
                break;
            // person <> locality
            case 110:
                $parameters['title'] = $this->getPersonLabel($row['person']) . $objectSeparator . $this->getLocalityLabel($row['locality']) . ' (' . $role . ')';
                break;
            // person <> entity
            case 120:
                $parameters['title'] = $this->getPersonLabel($row['person']) . $objectSeparator . $this->getEntityLabel($row['entity']) . ' (' . $role . ')';
                break;
            // person <> event
            case 130:
                $parameters['title'] = $this->getPersonLabel($row['person']) . $objectSeparator . $this->getEventLabel($row['event']) . ' (' . $role . ')';
                break;
            // person <> person
            case 140:
                $parameters['title'] = $this->getPersonLabel($row['person']) . $objectSeparator . $this->getPersonLabel($row['person_symmetric']) . ' (' . $role . ')';
                break;
            // locality <> entity
            case 210:
                $parameters['title'] = $this->getLocalityLabel($row['locality']) . $objectSeparator . $this->getEntityLabel($row['entity']) . ' (' . $role . ')';
                break;
            // locality <> event
            case 220:
                $parameters['title'] = $this->getLocalityLabel($row['locality']) . $objectSeparator . $this->getEventLabel($row['event']) . ' (' . $role . ')';
                break;
            // locality <> locality
            case 230:
                $parameters['title'] = $this->getLocalityLabel($row['locality']) . $objectSeparator . $this->getLocalityLabel($row['locality_symmetric']) . ' (' . $role . ')';
                break;
            // entity <> event
            case 310:
                $parameters['title'] = $this->getEntityLabel($row['entity']) . $objectSeparator . $this->getEventLabel($row['event']) . ' (' . $role . ')';
                break;
            // entity <> entity
            case 320:
                $parameters['title'] = $this->getEntityLabel($row['entity']) . $objectSeparator . $this->getEntityLabel($row['entity_symmetric']) . ' (' . $role . ')';
                break;
            // event <> event
            case 410:
                $parameters['title'] = $this->getEventLabel($row['event']) . $objectSeparator . $this->getEventLabel($row['event_symmetric']) . ' (' . $role . ')';
                break;
        }

        return $parameters;
    }

    /**
     * Fetches the name for a given role with a separator string
     *
     * @param array $row The current relation record
     *
     * @return string The name of the role or an empty string
     */
    private function getRoleName($row)
    {
        if ($row['role'] > 0) {
            // separates role name from left and right object; @TODO: role separator could be made configurable later on
//          $roleSeparator = ': ';
            // fetch foreign role record
            $roleRecord = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getConnectionForTable('tx_hisodat_domain_model_roles')
                ->select(
                    ['*'], // fields
                    'tx_hisodat_domain_model_roles', // from
                    [ 'uid=' . $row['role'] ] // where
                )->fetch();
            // build role name with separator
//          $roleName = htmlspecialchars($roleRecord['name']) . $roleSeparator;
            $roleName = htmlspecialchars($roleRecord['name']);
        } else {
            $roleName = '';
        }

        return $roleName;
    }

    /**
     * Fetches a foreign person record and returns the person's name as label
     *
     * @param integer $uid The uid for the person record to fetch
     *
     * @return string The person label
     */
    private function getPersonLabel($uid)
    {
        if ($uid > 0) {
            $person = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getConnectionForTable('tx_hisodat_domain_model_persons')
                ->select(
                    ['*'], // fields
                    'tx_hisodat_domain_model_persons', // from
                    [ 'uid=' . (int)$uid ] // where
                )->fetch();
            $personLabel = htmlspecialchars($person['name']);
        } else {
            $personLabel = '';
        }

        return $personLabel;
    }

    /**
     * Fetches a foreign locality record and returns the locality's name as label
     *
     * @param integer $uid The uid for the locality record to fetch
     *
     * @return string The locality label
     */
    private function getLocalityLabel($uid)
    {
        if ($uid > 0) {
            $locality = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getConnectionForTable('tx_hisodat_domain_model_localities')
                ->select(
                    ['*'], // fields
                    'tx_hisodat_domain_model_localities', // from
                    [ 'uid=' . (int)$uid ] // where
                )->fetch();
            $localityLabel = htmlspecialchars($locality['name']);
        } else {
            $localityLabel = '';
        }

        return $localityLabel;
    }

    /**
     * Fetches a foreign entity record and returns the entity's name as label
     *
     * @param integer $uid The uid for the entity record to fetch
     *
     * @return string The entity label
     */
    private function getEntityLabel($uid)
    {
        if ($uid > 0) {
            $entity = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getConnectionForTable('tx_hisodat_domain_model_entities')
                ->select(
                    ['*'], // fields
                    'tx_hisodat_domain_model_entities', // from
                    [ 'uid=' . (int)$uid ] // where
                )->fetch();
            $entityLabel = htmlspecialchars($entity['name']);
        } else {
            $entityLabel = '';
        }

        return $entityLabel;
    }

    /**
     * Fetches a foreign source record and returns the source's identifier as label
     *
     * @param integer $uid The uid for the source record to fetch
     *
     * @return string The source label
     */
    private function getSourceLabel($uid)
    {
        if ($uid > 0) {
            $source = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getConnectionForTable('tx_hisodat_domain_model_sources')
                ->select(
                    ['*'], // fields
                    'tx_hisodat_domain_model_sources', // from
                    [ 'uid=' . (int)$uid ] // where
                )->fetch();
            if ($source['identifier']) {
                $sourceLabel = htmlspecialchars($source['identifier']);
            } elseif ($source['title']) {
                $sourceLabel = htmlspecialchars(\TYPO3\CMS\Core\Utility\GeneralUtility::fixed_lgd_cs($source['title'],
                    60, '...'));
            } else {
                $sourceLabel = htmlspecialchars($source['persistent_identifier']);
            }
        } else {
            $sourceLabel = '';
        }

        return $sourceLabel;
    }

    /**
     * Fetches a foreign event record and returns the event's name as label
     *
     * @param integer $uid The uid for the event record to fetch
     *
     * @return string The event label
     */
    private function getEventLabel($uid)
    {
        if ($uid > 0) {
            $event = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getConnectionForTable('tx_hisodat_domain_model_events')
                ->select(
                    ['*'], // fields
                    'tx_hisodat_domain_model_events', // from
                    [ 'uid=' . (int)$uid ] // where
                )->fetch();
            $eventLabel = htmlspecialchars($event['name']);
        } else {
            $eventLabel = '';
        }

        return $eventLabel;
    }
}
