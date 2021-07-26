<?php
namespace ADWLM\Hisodat\Xclass;

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

class RelationHandler extends \TYPO3\CMS\Core\Database\RelationHandler
{

    /**
     * Prepare items from itemArray to be transferred to the TCEforms interface (as a comma list); this XCLASS provides an
     * exception for the hisodat person, localities, entities, events and sources tables that use symmetric relations with IRRE and
     * TCA group fields and therefore run into a display bug from the "other" side of a symmetric relation; this function has to be
     * used since the problematic function isOnSymmetricSide is only called statically within IRRE context and XCLASS has no effect
     * on it: @see https://forge.typo3.org/issues/22643
     *
     * @see TYPO3\CMS\Backend\Form\DataPreprocessor::renderRecord_groupProc
     * @see \TYPO3\CMS\Core\Database\RelationHandler::isOnSymmetricSide
     *
     * @return string
     */
    public function readyForInterface()
    {
        if (!is_array($this->itemArray)) {
            return false;
        }
        $output = array();
        // For use when getting the paths
        $perms_clause = $GLOBALS['BE_USER']->getPagePermsClause(1);
        $titleLen = intval($GLOBALS['BE_USER']->uc['titleLen']);
        foreach ($this->itemArray as $key => $val) {
            $theRow = $this->results[$val['table']][$val['id']];
            if ($theRow && is_array($GLOBALS['TCA'][$val['table']])) {
                switch ($val['table']) {
                    case 'tx_hisodat_domain_model_persons':
                    case 'tx_hisodat_domain_model_localities':
                    case 'tx_hisodat_domain_model_entities':
                    case 'tx_hisodat_domain_model_events':
                    case 'tx_hisodat_domain_model_sources':
                        $output[] = $val['id'];
                        break;
                    default:
                        $label = GeneralUtility::fixed_lgd_cs(strip_tags(BackendUtility::getRecordTitle($val['table'],
                            $theRow)), $titleLen);
                        $label = $label ? $label : '[...]';
                        $output[] = str_replace(',', '', $val['table'] . '_' . $val['id'] . '|' . rawurlencode($label));
                        break;
                }
            }
        }

        return implode(',', $output);
    }

}
