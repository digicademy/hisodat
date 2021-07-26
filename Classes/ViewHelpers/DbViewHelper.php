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

class DbViewHelper extends AbstractViewHelper
{

    /**
     * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
     */
    protected $contentObject;

    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     */
    protected $configurationManager;

    /**
     * Use constructor DI and not @inject because it's best
     * @see: https://gist.github.com/NamelessCoder/3b2e5931a6c1af19f9c3f8b46e74f837
     *
     * @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
     */
    public function __construct(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager)
    {
        $this->configurationManager = $configurationManager;
        $this->contentObject = $this->configurationManager->getContentObject();
    }

    /**
     * Initialize ViewHelper arguments
     *
     * @return void
     */
    public function initializeArguments(){

        $this->registerArgument(
            'uids',
            'mixed',
            'The list/array/... of the uids.',
            true
        );
        $this->registerArgument(
            'table',
            'string',
            'The db table from which to fetch.',
            true
        );
        $this->registerArgument(
            'field',
            'string',
            'The field from which to fetch.',
            true
        );
        $this->registerArgument(
            'hsc',
            'boolean',
            'HTML special char the returned values.',
            false,
            true
        );
        $this->registerArgument(
            'forceArrayReturn',
            'boolean',
            'Force the return values to be in an array.',
            false,
            false
        );
    }

    /**
     * [DESCRIPTION...]
     *
     * @return mixed The fetched field values from the submitted uid list
     */
    public function render()
    {

        $uids = $this->arguments['uids'];
        $table = $this->arguments['table'];
        $field = $this->arguments['field'];
        $hsc = $this->arguments['hsc'];
        $forceArrayReturn = $this->arguments['forceArrayReturn'];

        if (is_array($uids)) {
            $recordUids = $uids;
        } else {
            $recordUids = GeneralUtility::trimExplode(',', $uids, 1);
        }

        if (count($recordUids) > 0 || $forceArrayReturn === true) {
            $values = array();
            foreach ($recordUids as $uid) {
                if ($hsc == true) {
                    $values[(int)$uid] = htmlspecialchars($this->contentObject->cObjGetSingle('TEXT', array('data' => 'DB:' . $table . ':' . $uid . ':' . $field)));
                } else {
                    $values[(int)$uid] = $this->contentObject->cObjGetSingle('TEXT', array('data' => 'DB:' . $table . ':' . $uid . ':' . $field));
                }
            }

        } else {

            if ($hsc == true) {
                $values = htmlspecialchars($this->contentObject->cObjGetSingle('TEXT', array('data' => 'DB:' . $table . ':' . implode('', $recordUids) . ':' . $field)));
            } else {
                $values = $this->contentObject->cObjGetSingle('TEXT', array('data' => 'DB:' . $table . ':' . implode('', $recordUids) . ':' . $field));
            }
        }

        return $values;
    }
}
