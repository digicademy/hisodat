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

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 *
 * Validator that compares a given date range and checks dates for correct format
 *
 * @see https://gist.github.com/849247
 */
class DateRangeValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
{

    protected $supportedOptions = array(
        'minDate' => array('1', 'Minimum date allowed', 'integer'),
        'maxDate' => array('3000', 'Maximum date allowed', 'integer')
    );

    /**
     * AbstractValidator commands to implement this method
     * @param mixed $value
     */
    protected function isValid($value)
    {
    }

    /**
     * Checks a submitted date range to be valid: $startDate has to be earlier than $endDate and both need to use the correct
     * string format YYYY-MM-DD. Empty values for either $startDate or $endDate are also valid.
     *
     * @param mixed $startDate
     * @param mixed $endDate
     *
     * @param array $options
     * @return \TYPO3\CMS\Extbase\Error\Result TRUE/FALSE depending on validation success
     */
    public function isValidAll($startDate, $endDate, $options = null)
    {

        // initialize
        $this->options = $options;
        $this->result = new \TYPO3\CMS\Extbase\Error\Result;

        // both values empty: return true
        if (strlen($startDate) === 0 && strlen($endDate) === 0) {
            $result = true;
            // both values submitted: check corret format of both and then compare that startDate is earlier than endDate
        } elseif (strlen($startDate) > 0 && strlen($endDate) > 0) {
            $startDate = $this->checkAndProcessDate($startDate);
            $endDate = $this->checkAndProcessDate($endDate);
            if (is_array($startDate) && is_array($endDate)) {
                if ($this->dateComparisson($startDate, $endDate) !== false) {
                    $result = true;
                }
            }
            // only startDate submitted: check correct format
        } elseif (strlen($startDate) > 0 && strlen($endDate) === 0) {
            if ($startDate = $this->checkAndProcessDate($startDate) !== false) {
                $result = true;
            }
            // only endDate submitted: check correct format
        } elseif (strlen($startDate) === 0 && strlen($endDate) > 0) {
            if ($endDate = $this->checkAndProcessDate($endDate) !== false) {
                $result = true;
            }
        }

        return $this->result;
    }

    /**
     * Explodes a date string and checks if year 400-1600, month 0-12, day 0-31 and returns the existing date parts or FALSE if incorrect format.
     * Allowed formats are: (Y)YYY-MM-DD, (Y)YYY-MM, (Y)YYY
     * Valid examples: 0800-01-01, 800-01-00, 800-00-00, 800-12-31, 800-12, 800-00, 800
     *
     * @param string $date
     *
     * @return array with integers or FALSE
     */
    private function checkAndProcessDate($date)
    {

        if (!preg_match('/^[0-9\-]*$/', $date)) {
            $this->addError('Date may only contain numbers and hyphens', 1323062924);
            $dateComponents = false;
        }

        // date components may only be integers
        $dateComponents = \TYPO3\CMS\Core\Utility\GeneralUtility::intExplode('-', $date);

        if (is_array($dateComponents) && count($dateComponents) <= 3) {
            if ($dateComponents[0] < (int)$this->options['minDate'] || $dateComponents[0] > (int)$this->options['maxDate']) {
                $this->addError('Invalid year: Value must be between ' . (int)$this->options['minDate'] . ' and ' . $this->options['maxDate'] . '',
                    1323215068);
                $dateComponents = false;
            }
            if (isset($dateComponents[1])) {
                if ($dateComponents[1] < 0 || $dateComponents[1] > 12) {
                    $this->addError('Invalid month: Value must be between 0 and 12', 1323215239);
                    $dateComponents = false;
                }
            }
            if (isset($dateComponents[2])) {
                if ($dateComponents[2] < 0 || $dateComponents[2] > 31) {
                    $this->addError('Invalid day: Value must be between 0 and 31', 1323215301);
                    $dateComponents = false;
                }
            }
        } else {
            $this->addError('Date has invalid format', 1323214434);
            $dateComponents = false;
        }

        return $dateComponents;
    }

    /**
     * Compares $startDate against $endDate. If year is equal compares month, if year and month are equal compares days.
     *
     * @param array $startDate
     * @param array $endDate
     *
     * @return boolean TRUE if $startDate is earlier or equal than $endDate, otherwise FALSE
     */
    private function dateComparisson($startDate, $endDate)
    {
        $result = false;
        // year comparison
        if ($startDate[0] < $endDate[0]) {
            $result = true;
            // equal years
        } elseif ($startDate[0] === $endDate[0]) {
            // month comparison
            if (isset($startDate[1]) && isset($endDate[1])) {
                if ($startDate[1] < $endDate[1]) {
                    $result = true;
                    // equal months
                } elseif ($startDate[1] === $endDate[1]) {
                    // day comparison
                    if (isset($startDate[2]) && isset($endDate[2])) {
                        if ($startDate[2] <= $endDate[2]) {
                            $result = true;
                        } else {
                            $this->addError('Given start day after end day', 1322607720);
                        }
                    } else {
                        $this->addError('Equal start/end year and month but no start/end days set', 1322607733);
                    }
                } else {
                    $this->addError('Given start month after end month', 1322607742);
                }
            } else {
                $this->addError('Equal start/end year but no start/end month set', 1322607751);
            }
        } else {
            $this->addError('Given start year after end year', 1322607759);
        }

        return $result;
    }
}
