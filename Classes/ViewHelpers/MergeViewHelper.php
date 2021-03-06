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

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class MergeViewHelper extends AbstractViewHelper
{

    /**
     * Initialize ViewHelper arguments
     *
     * @return void
     */
    public function initializeArguments(){

        $this->registerArgument(
            'array1',
            'array',
            'array1 is an existing variable in the current template variable container',
            true
        );
        $this->registerArgument(
            'array2',
            'array',
            'array to be melted within array1',
            true
        );
        $this->registerArgument(
            'removeEmptyElements',
            'boolean',
            'boolean flag if/to remove empty elements',
            false,
            false
        );
        $this->registerArgument(
            'keepZeros',
            'boolean',
            'boolean flag if/to keep zero values',
            false,
            true
        );
    }

    /**
     * Merges array2 with array1; array1 is an existing variable in the current template variable container and the key of the argument
     * is used to identify it. If it can't be identified, nothing happens. Zeros, NULL and empty values in the melted array can be removed
     * using the according arguments.
     *
     * @return void
     */
    public function render()
    {
        $array1 = $this->arguments['array1'];
        $array2 = $this->arguments['array2'];
        $removeEmptyElements = $this->arguments['removeEmptyElements'];
        $keepZeros = $this->arguments['keepZeros'];

        // get the key of array1 to identify which variable to replace
        $key = key($array1);

        if ($this->templateVariableContainer->exists($key) && count($array2) > 0) {
            // first remove the identified variable from the current container
            $this->templateVariableContainer->remove($key);
            // melt both arrays
            \TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule($array1[$key], $array2);
            $melt = $array1[$key];

            // possibly remove zeros, NULL and empty values
            if ($removeEmptyElements === true && $keepZeros === true) {
                $melt = array_diff($melt, array(''));
            } elseif ($removeEmptyElements === true && $keepZeros === false) {
                $melt = array_filter($melt);
            }
            // write the melted variable back the current container
            $this->templateVariableContainer->add($key, $melt);
        }

        return;
    }
}
