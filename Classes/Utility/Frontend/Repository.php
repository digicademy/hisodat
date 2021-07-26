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

/**
 * Helper utility for extbase repositories
 */
class Repository
{

    /**
     * Resolves incoming integer to property for sorting
     *
     * @param integer $orderBy
     *
     * @return string
     *
     */
    public static function resolveOrderBy($orderBy)
    {
        switch ((int)$orderBy) {
            case 10:
                $orderBy = 'identifier';
                break;
            case 20:
                $orderBy = 'persistentIdentifier';
                break;
            case 40:
                $orderBy = 'title';
                break;
            case 50:
                $orderBy = 'sorting';
                break;
            case 60:
                $orderBy = 'signature';
                break;
            case 65:
                $orderBy = 'signatureAddition';
                break;
            case 70:
                $orderBy = 'dateRange.startDate';
                break;
            case 80:
                $orderBy = 'dateRange.endDate';
                break;
            case 90:
                $orderBy = 'dateRange.dateKey';
                break;
            default:
                $orderBy = 'uid';
                break;
        }

        return $orderBy;
    }

}
