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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

class RolesRepository extends CommonRepository
{

    /**
     * Performs a findAll on the repository with certain storage pids as basis
     *
     * @param string  $pidList
     * @param integer $roleType
     *
     * @return object The result from the query
     */
    public function findAllInPidsWithTypes($pidList, $roleType = 0)
    {

        // initialize query object and set storage page to false
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        // set the constraints for the query
        $constraints = array();
        if ($roleType > 0) {
            $constraints[] = $query->like('roleType', '%' . $roleType . '%');
        }
        $constraints[] = $query->in('pid', GeneralUtility::trimExplode(',', $pidList, 1));

        // set query
        $query->matching($query->logicalAnd($constraints));

        // result order
        $query->setOrderings(array('name' => QueryInterface::ORDER_ASCENDING));

        // go
        return $query->execute();
    }

}
