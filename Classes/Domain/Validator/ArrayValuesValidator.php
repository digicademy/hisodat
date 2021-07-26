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
 * Validator that checks the values of a two dimensional array for certain types
 */
class ArrayValuesValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
{

    protected $supportedOptions = array(
        'type' => array('', 'The type of value to test', 'string')
    );

    /**
     * @param array $array
     *
     * @return boolean
     */
    public function isValid($array)
    {

        $result = true;

        if (is_array($array)) {

            switch ($this->options['type']) {

                case 'boolean':
                    $result = $array === array_filter($array, 'is_bool');
                    break;

                case 'null':
                    $result = $array === array_filter($array, 'is_null');
                    break;

                case 'integer':
                    $result = $array === array_filter($array, 'is_int');
                    break;

                case 'float':
                    $result = $array === array_filter($array, 'is_float');
                    break;

                case 'string':
                    $result = $array === array_filter($array, 'is_string');
                    break;

                case 'numeric':
                    $result = $array === array_filter($array, 'is_numeric');
                    break;

                case 'digit':
                    $result = $array === array_filter($array, 'ctype_digit');
                    break;

                case 'alnum':
                    $result = $array === array_filter($array, 'ctype_alnum');
                    break;

                case 'alpha':
                    $result = $array === array_filter($array, 'ctype_alpha');
                    break;
            }

        } elseif (empty($array)) {

            // do nothing

        } else {

            $this->addError('Submitted value is neither an array nor empty.', 1364329563);
            $result = false;
        }

        return $result;
    }
}
