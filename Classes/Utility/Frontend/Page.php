<?php
namespace ADWLM\Hisodat\Utility\Frontend;

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
use TYPO3\CMS\Core\Utility\MathUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class Page
{

    /**
     * Find all ids from given ids and level
     *
     * @param string  $pidList   comma seperated list of ids
     * @param integer $recursive recursive levels
     *
     * @return string comma seperated list of ids
     */
    public static function extendPidListByChildren($pidList = '', $recursive = 0)
    {
        if ($recursive <= 0) {
            return $pidList;
        }

        $cObj = GeneralUtility::makeInstance(ContentObjectRenderer::class);

        $recursive = MathUtility::forceIntegerInRange($recursive, 0);

        $pidList = array_unique(GeneralUtility::trimExplode(',', $pidList, 1));

        $result = array();

        foreach ($pidList as $pid) {

            $pid = MathUtility::forceIntegerInRange($pid, 0);

            if ($pid) {
                $children = $cObj->getTreeList(-1 * $pid, $recursive);
                if ($children) {
                    $result[] = $children;
                }
            }
        }

        return implode(',', $result);
    }
}
