<?php
namespace ADWLM\Hisodat\Hooks\Backend;

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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;

class DataHandler
{

    /**
     * Generates UUIDs for the persistent_identifier fields of the hisodat tables if this is configured in TSConfig.
     * If its not configured for a given table the persistent_identifier field is left untouched.
     * If a persistent_identifier field already contains a value this is also left untouched.
     *
     * @param $status
     * @param $table
     * @param $id
     * @param $fieldArray
     * @param $pObj
     */
    public function processDatamap_postProcessFieldArray($status, $table, $id, &$fieldArray, &$pObj)
    {
        // generate xml conformant uuids as persistent identifiers for archives, sources, persons, entities, localities, events, keywords, roles, relations
        // if configured in TSConfig for the respective table
        if ($table == 'tx_hisodat_domain_model_sources' ||
            $table == 'tx_hisodat_domain_model_persons' ||
            $table == 'tx_hisodat_domain_model_entities' ||
            $table == 'tx_hisodat_domain_model_localities' ||
            $table == 'tx_hisodat_domain_model_events' ||
            $table == 'tx_hisodat_domain_model_archives' ||
            $table == 'tx_hisodat_domain_model_roles' ||
            $table == 'tx_hisodat_domain_model_relations' ||
            $table == 'tx_hisodat_domain_model_keywords'
        ) {
            $generate = false;

            // get TSConfig for currentPAge
            $tsConfig = $GLOBALS['BE_USER']->getTSConfig('TCEFORM', BackendUtility::getPagesTSconfig((int) $pObj->checkValue_currentRecord['pid']));

            // if UUID generation is configured for current table on current page
            if ($tsConfig['properties'][$table . '.']['persistent_identifier.']['generateUuid']) {

                switch ($status) {

                    case 'new':
                        // copy record - can be guessed because in this case t3_origuid is filled and a origin record exists
                        if ($fieldArray['t3_origuid'] > 0) {
                            $originalRecord = GeneralUtility::makeInstance(ConnectionPool::class)
                                ->getConnectionForTable($table)
                                ->select(
                                    ['persistent_identifier'], // fields
                                    $table, // from
                                    [ 'uid' => (int)$fieldArray['t3_origuid'] ] // where
                                )->fetch();
                            if ($originalRecord['persistent_identifier']) {
                                $generate = true;
                            }
                        // create record
                        } elseif (empty($fieldArray['persistent_identifier'])) {
                            $generate = true;
                        }

                        break;

                    case 'update':
                        $record = GeneralUtility::makeInstance(ConnectionPool::class)
                            ->getConnectionForTable($table)
                            ->select(
                                ['persistent_identifier'], // fields
                                $table, // from
                                [ 'uid' => (int)$id ] // where
                            )->fetch();

                        if (empty($fieldArray['persistent_identifier']) && !$record['persistent_identifier']) {
                            $generate = true;
                        }

                        break;
                }

            }

            if ($generate == true) {
                do {
                    $uuid = $this->generateUUID();
                } while (preg_match('/^[a-z]/', $uuid) !== 1);
                $fieldArray['persistent_identifier'] = $uuid;
            }
        }
    }

    /**
     * Generates a universally unique identifier (UUID) according to RFC 4122 v4.
     * The algorithm used here, might not be completely random. Copied from the identity extension.
     *
     * @return string The universally unique id
     * @author Unknown
     */
    private function generateUUID()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff));
    }

}
