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

class FormEngine
{

    function getSingleField_preProcess($table, $field, &$row, $altName, $palette, &$extra, $pal, &$pObj)
    {
        // the following $TCA features are only executed for extension hisodat
        if (substr($table, 0, 10) == 'tx_hisodat') {

            $fieldConfiguration = $GLOBALS['TCA'][$table]['columns'][$field];

            // get TCEFORMS related TSConfig for current table
            $TSConfig = BackendUtility::getTCEFORM_TSconfig($table, $row);

            // FEATURE 1: have text fields where the RTE only opens in full screen mode - this will only work for fields where the RTE is configured with types - not with defaultExtras
            if ($extra && $TSConfig[$field]['RTEFullScreenOnly'] == 1 && get_class($GLOBALS['SOBE']) != 'SC_wizard_rte') {
                // check that we're not in fullscreen mode and if not inject a flag that points to the uid and therefore disables the RTE; cf. TYPO3 Core API: rte_transform[] key/value pairs
                $extra = substr_replace(':rte_transform[', ':rte_transform[flag=uid|', 0);
            }

            //FEATURE 2: extend the whitelist of TCA properties that can be overriden from PageTSConfig
            $pObj->allowOverrideMatrix['select'][] = 'wizards';
            $pObj->allowOverrideMatrix['select'][] = 'foreign_table';
            $pObj->allowOverrideMatrix['select'][] = 'foreign_table_where';

            // field type group
            $pObj->allowOverrideMatrix['group'][] = 'wizards';
        }
    }

}
