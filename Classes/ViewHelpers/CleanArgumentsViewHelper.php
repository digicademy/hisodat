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

use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Cleans an arguments array from empty or unwished entries. Also provides the possibility to
 * substitute specific entries in the array. Useful for link generation.
 *
 * = Example =
 *
 * {namespace paginate = ADWLM\Paginator\ViewHelpers}
 *
 * {h:CleanArguments(arguments : arguments, substitute : {myObject : 'myValue'}, takeout : {submit : 1})}
 *
 */
class CleanArgumentsViewHelper extends AbstractViewHelper
{

    /**
     * Initialize ViewHelper arguments
     *
     * @return void
     */
    public function initializeArguments(){

        $this->registerArgument(
            'arguments',
            'array',
            'The arguments to be cleaned.',
            true
        );
        $this->registerArgument(
            'takeout',
            'array',
            'The arguments which should be taken out.',
            false,
            array()
        );
        $this->registerArgument(
            'substitute',
            'array',
            'The arguments which should be substituted.',
            false,
            array()
        );
    }

    /**
     * Cleans and returns the arguments array
     *
     * @return string The imploded array
     */
    public function render()
    {

        $arguments = $this->arguments['arguments'];
        $takeout = $this->arguments['takeout'];
        $substitute = $this->arguments['substitute'];

        $cleanArguments = array();

        foreach ($arguments as $key => $value) {
            if (!$value || $takeout[$key]) {
                continue;
            } else {
                $cleanArguments[$key] = $value;
            }
        }

        if (count($substitute) > 0) {
            ArrayUtility::mergeRecursiveWithOverrule($cleanArguments, $substitute, true, false);
        }

        return $cleanArguments;
    }
}
