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

use \TYPO3\CMS\Backend\Utility\BackendUtility;

/**
 * HOOK class for TCEFORM inline records
 */
class InlineElement implements \TYPO3\CMS\Backend\Form\Element\InlineElementHookInterface
{


    public function init(&$parentObject)
    {
    }


    public function renderForeignRecordHeaderControl_preProcess(
        $parentUid,
        $foreignTable,
        array $childRecord,
        array $childConfig,
        $isVirtual,
        array &$enabledControls
    ) {
    }

    /**
     * This hook is used to correct the following bug regarding the use of the suggest wizard in combination with an IRRE child record: The suggest wizard for any field of a child record is
     * broken when all IRRE records are in collapsed state and the parent record has no field with suggest wizard. In case that constellation occurs, the functions printNeededJSFunctions/JSbottom
     * from TCEFORMS will not include the file t3lib/js/jsfunc.tceforms_suggest.js because they are only called from alt_doc.php and not from class.t3lib_tceforms_inline. Therefore, when all
     * IRRE records are collapsed, alt_doc.php subsumes that there are no fields with suggest wizard and doesn't include the file.
     */
    public function renderForeignRecordHeaderControl_postProcess(
        $parentUid,
        $foreignTable,
        array $childRecord,
        array $childConfig,
        $isVirtual,
        array &$controlItems
    ) {
        // restrict check to tx_hisodat tables
        if (substr($foreignTable, 0, 10) == 'tx_hisodat') {
            // walk through the fields of the child record and check if one has a suggest wizard
            foreach ($childRecord as $field => $value) {
                $configuration = BackendUtility::getTcaFieldConfiguration($foreignTable,
                    $field);
                if ($configuration['wizards']['suggest']) {
                    // @see: typo3/sysext/backend/Resources/Public/JavaScript/FormEngine.js
                    $this->getPageRenderer()->loadRequireJsModule('TYPO3/CMS/Backend/FormEngineSuggest');
                    break;
                }
            }
        }
    }

}
