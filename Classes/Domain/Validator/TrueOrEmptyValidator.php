<?php
namespace ADWLM\Hisodat\Domain\Validator;

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
 * Validator used for checkboxes - checked = 1, unchecked = empty
 */
class TrueOrEmptyValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
{

    /**
     * @param mixed $value
     *
     * @return boolean
     */
    public function isValid($value)
    {
        $this->errors = array();
        if (empty($value)) {
            $result = true;
        } elseif ((int)$value === 1) {
            $result = true;
        } else {
            $this->addError('The given value is neither true nor emtpy.', 1323195236);
            $result = false;
        }

        return $result;
    }
}
