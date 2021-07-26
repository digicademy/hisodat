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
use ADWLM\Hisodat\Utility\Frontend\Search;

class EventsRepository extends CommonRepository
{

    /**
     * Performs a MySQL Fulltext search on the events repository using a statement
     *
     * @param array $arguments
     * @param array $settings
     *
     * @return array
     */
    public function findByFulltext($arguments = array(), $settings = array())
    {

        // set statement
        $statement = 'SELECT tx_hisodat_domain_model_events.uid FROM tx_hisodat_domain_model_events';

        // split searchwords and set index
        $searchwords = Search::transformToFulltextSyntax($arguments['searchstrings']);

        if (!empty($searchwords)) {

            $indexFields = GeneralUtility::trimExplode(',', $settings['index']['mysql']['fields']['events'], 1);
            $index = implode(',', $indexFields);

            $statement .= ' WHERE MATCH (' . $index . ') AGAINST (' . $searchwords . ' IN BOOLEAN MODE)';

            // pids
            $statement .= ' AND tx_hisodat_domain_model_events.pid IN(' . (int)$settings['recordPids']['events'] . ')';

            // enable fields
            $statement .= ' AND tx_hisodat_domain_model_events.hidden = 0 AND tx_hisodat_domain_model_events.deleted = 0';

            // ordering
            $statement .= ' ORDER BY tx_hisodat_domain_model_events.name ASC';

            // create the query object
            $query = $this->createQuery();

            // ignore storage PID and use TS/FF settings instead
            $query->getQuerySettings()->setRespectStoragePage(false);

            // set statement
            // TODO: statement method not there anymore? @see: https://forum.typo3.org/index.php/t/213781/-typo3-german-prepared-statements-in-extbase-typo3-7-6
            $query->statement($statement);

            // execute
            $result = $query->execute(true);
        } else {
            $result = '';
        }

        return $result;
    }

}
