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

/**
 * Helper utility for pagination
 */
class Pagination
{

    /**
     * Determines the first/last/previous/next/total/current objects in a CSV list in respect to the given $uid.
     * If the given $uid is the first/last in the set, the next/previous values are set to the current id respectively.
     *
     * @param integer $uid
     * @param string  $uids
     *
     * @return array
     */
    public static function getValuesFromCsv($uid, $uids)
    {
        $pagination = array();
        $uids = GeneralUtility::trimExplode(',', $uids, 1);
        if (count($uids) > 0) {
            $current = (array_search($uid, $uids));
            $pagination['first'] = reset($uids);
            $pagination['last'] = end($uids);
            $pagination['next'] = $uids[$current + 1];
            $pagination['previous'] = $uids[$current - 1];
            $pagination['currentRecord'] = $current + 1;
            $pagination['total'] = count($uids);
            if (empty($pagination['next'])) {
                $pagination['next'] = $uid;
            }
            if (empty($pagination['previous'])) {
                $pagination['previous'] = $uid;
            }
        }

        return $pagination;
    }

}
