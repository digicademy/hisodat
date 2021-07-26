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

class DistinctErrorsViewHelper extends AbstractViewHelper
{

    /**
     * Initialize ViewHelper arguments
     *
     * @return void
     */
    public function initializeArguments(){

        $this->registerArgument(
            'argumentErrors',
            'array',
            'Get the error codes for the errors.',
            true
        );
    }

    /**
     *
     * @return array Distinct errors
     */
    public function render()
    {
        $argumentErrors = $this->arguments['argumentErrors'];

        $distinctErrors = array();
        foreach ($argumentErrors as $error) {
            $distinctErrors[$error->getCode()] = $error;
        }

        return $distinctErrors;
    }
}
