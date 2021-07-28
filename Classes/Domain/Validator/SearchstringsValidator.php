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
 * Validator for a bag of searchstrings
 */
class SearchstringsValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
{

    protected $supportedOptions = array(
        'regularExpression' => array(
            '/^[\.\,\"\'\-\*\p{L}\p{M}\p{N}\p{Sk}\s]*$/u',
            'Regular expression for filtering out invalid characters',
            'string'
        ),
        'allowEmpty' => array(false, 'Wether to allow empty values', 'boolean'),
        'minLength' => array(3, 'The minimum length of a searchterm', 'integer')
    );

    /**
     * [DESCRIPTION]
     *
     * @param mixed $value
     *
     * @return boolean
     */
    public function isValid($searchstrings)
    {
        $result = true;
        if (is_array($searchstrings)) {
            foreach ($searchstrings as $searchstring) {
                if (count($searchstring) === 4 && isset($searchstring['type']) && isset($searchstring['searchwords']) && isset($searchstring['operator']) && isset($searchstring['role'])) {
                    // type validation
                    switch ($searchstring['type']) {
                        case 1:
                        case 2:
                        case 10:
                        case 20:
                        case 30:
                        case 40:
                            break;
                        default:
                            $this->addError('Invalid value for searchstring type.', 1322670699);
                            $result = false;
                            break;
                    }
                    // searchwords validation
                    if (!empty($searchstring['searchwords']) && !preg_match($this->options['regularExpression'],
                            $searchstring['searchwords'])
                    ) {
                        $this->addError('Search term contains invalid characters.', 1322671441);
                        $result = false;
                    }
                    if (!empty($searchstring['searchwords']) && strlen($searchstring['searchwords']) < (int)$this->options['minLength']) {
                        $this->addError('Search term must be at least three characters long.', 1323057652);
                        $result = false;
                    }
                    if (empty($searchstring['searchwords']) && $this->options['allowEmpty'] == 'FALSE') {
                        $this->addError('No empty values allowed.', 1364277275);
                        $result = false;
                    }
                    // operator validation
                    switch ($searchstring['operator']) {
                        case 10:
                        case 20:
                        case 30:
                            break;
                        default:
                            $this->addError('Invalid value for searchstring operator.', 1322670699);
                            $result = false;
                            break;
                    }
                    // role validation
                    if (ctype_digit($searchstring['role']) === false) {
                        $this->addError('Invalid value for searchstring role.', 1364681390);
                        $result = false;
                    }

                } else {
                    $this->addError('Invalid format of searchstring operators.', 1322670699);
                    $result = false;
                    break;
                }
            }
        } else {
            $this->addError('Invalid format for searchstrings.', 1322670430);
            $result = false;
        }

        return $result;
    }
}
