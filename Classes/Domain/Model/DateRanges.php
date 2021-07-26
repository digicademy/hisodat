<?php
namespace ADWLM\Hisodat\Domain\Model;

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

use TYPO3\CMS\Extbase\DomainObject\AbstractValueObject;

/**
 * The dating range for sources, localities, persons and entities
 */
class DateRanges extends AbstractValueObject
{

    /**
     * The type of the date (Gregorian, Julian, etc.)
     *
     * @var \integer $type
     */
    protected $type;

    /**
     * The certainty of the date
     *
     * @var \integer $certainty
     */
    protected $certainty;

    /**
     * The startdate of the range
     *
     * @var \string $startDate
     */
    protected $startDate;

    /**
     * The enddate of the range
     *
     * @var \string $endDate
     */
    protected $endDate;

    /**
     * A specific date sorting key for special dating circumstances
     *
     * @var \string $dateKey
     */
    protected $dateKey;

    /**
     * A textual comment for the date
     *
     * @var \string $dateComment
     */
    protected $dateComment;

    /**
     * The parent record to which this date belongs
     *
     * @var \string $parentRecord
     */
    protected $parentRecord;

    /**
     * The parent table to which this date belongs
     *
     * @var \string $ident
     */
    protected $ident;

    /**
     * Returns the type
     *
     * @return \integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the type
     *
     * @param \integer $type
     *
     * @return void
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Returns the certainty
     *
     * @return \integer
     */
    public function getCertainty()
    {
        return $this->certainty;
    }

    /**
     * Sets the certainty
     *
     * @param \integer $certainty
     *
     * @return void
     */
    public function setCertainty($certainty)
    {
        $this->certainty = $certainty;
    }

    /**
     * Returns the startDate
     *
     * @return \string
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Sets the startDate
     *
     * @param \string $startDate
     *
     * @return void
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * Returns the endDate
     *
     * @return \string
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Sets the endDate
     *
     * @param \string $endDate
     *
     * @return void
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * Returns the dateKey
     *
     * @return \string
     */
    public function getDateKey()
    {
        return $this->dateKey;
    }

    /**
     * Sets the dateKey
     *
     * @param \string $dateKey
     *
     * @return void
     */
    public function setDateKey($dateKey)
    {
        $this->dateKey = $dateKey;
    }

    /**
     * Returns the dateComment
     *
     * @return \string
     */
    public function getDateComment()
    {
        return $this->dateComment;
    }

    /**
     * Sets the dateComment
     *
     * @param \string $dateComment
     *
     * @return void
     */
    public function setDateComment($dateComment)
    {
        $this->dateComment = $dateComment;
    }

    /**
     * Returns the ident
     *
     * @return \string $ident
     */
    public function getIdent()
    {
        return $this->ident;
    }

    /**
     * Sets the ident
     *
     * @param \string $ident
     *
     * @return void
     */
    public function setIdent($ident)
    {
        $this->ident = $ident;
    }

    /**
     * Returns the parentRecord
     *
     * @return \string $parentRecord
     */
    public function getParentRecord()
    {
        return $this->parentRecord;
    }

    /**
     * Sets the parentRecord
     *
     * @param \string $parentRecord
     *
     * @return void
     */
    public function setParentRecord($parentRecord)
    {
        $this->parentRecord = $parentRecord;
    }

}
