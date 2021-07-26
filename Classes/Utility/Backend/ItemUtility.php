<?php
namespace ADWLM\Hisodat\Utility\Backend;

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

class ItemUtility
{

    /**
     * Reduces the number of items in the relation_type field according to the
     * possible relations depending on the parent object that is currently
     * edited
     *
     * 10 - Source <> Person - item[0]
     * 20 - Source <> Locality - item[1]
     * 30 - Source <> Entity - item[2]
     * 40 - Source <> Event - item[3]
     * 50 - Source <> Source - item[4]
     * 110 - Person <> Locality - item[5]
     * 120 - Person <> Entity - item[6]
     * 130 - Person <> Event - item[7]
     * 140 - Person <> Person - item[8]
     * 210 - Locality <> Entity - item[9]
     * 220 - Locality <> Event - item[10]
     * 230 - Locality <> Locality - item[11]
     * 310 - Entity <> Event - item[12]
     * 320 - Entity <> Entity - item[13]
     * 410 - Event <> Event - item[14]
     *
     * @param array  $parameters
     * @param object $parentObject
     *
     * @return \array
     */
    public function possibleItemsForRelation($parameters, &$parentObject)
    {

        $parentInformation = $parentObject->inline->inlineNames['form'];
        $items = $parameters['items'];

        if (strpos($parentInformation, 'tx_hisodat_domain_model_sources')) {
            unset($items[5]);
            unset($items[6]);
            unset($items[7]);
            unset($items[8]);
            unset($items[9]);
            unset($items[10]);
            unset($items[11]);
            unset($items[12]);
            unset($items[13]);
            unset($items[14]);
        }

        if (strpos($parentInformation, 'tx_hisodat_domain_model_persons')) {
            unset($items[1]);
            unset($items[2]);
            unset($items[3]);
            unset($items[4]);
            unset($items[9]);
            unset($items[10]);
            unset($items[11]);
            unset($items[12]);
            unset($items[13]);
            unset($items[14]);
        }

        if (strpos($parentInformation, 'tx_hisodat_domain_model_localities')) {
            unset($items[0]);
            unset($items[2]);
            unset($items[3]);
            unset($items[4]);
            unset($items[6]);
            unset($items[7]);
            unset($items[8]);
            unset($items[12]);
            unset($items[13]);
            unset($items[14]);
        }

        if (strpos($parentInformation, 'tx_hisodat_domain_model_entities')) {
            unset($items[0]);
            unset($items[1]);
            unset($items[3]);
            unset($items[4]);
            unset($items[5]);
            unset($items[7]);
            unset($items[8]);
            unset($items[10]);
            unset($items[11]);
            unset($items[14]);
        }

        if (strpos($parentInformation, 'tx_hisodat_domain_model_events')) {
            unset($items[0]);
            unset($items[1]);
            unset($items[2]);
            unset($items[4]);
            unset($items[5]);
            unset($items[6]);
            unset($items[8]);
            unset($items[9]);
            unset($items[11]);
            unset($items[13]);
        }

        $parameters['items'] = $items;

        return $parameters;
    }

}
