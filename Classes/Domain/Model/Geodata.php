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
 * A simple geodata / point object
 */
class Geodata extends AbstractValueObject
{

    /**
     * A point has a label
     *
     * @var \string $label
     */
    protected $label;

    /**
     * The certainty of the point
     *
     * @var \integer $certainty
     */
    protected $certainty;

    /**
     * The x coordinate
     *
     * @var \float $x
     */
    protected $x;

    /**
     * The y coordinate
     *
     * @var \float $y
     */
    protected $y;

    /**
     * The z coordinate
     *
     * @var \float $z
     */
    protected $z;

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
     * Returns the label
     *
     * @return \integer
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Sets the label
     *
     * @param \integer $label
     *
     * @return void
     */
    public function setLabel($label)
    {
        $this->label = $label;
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
     * Returns the x coordinate
     *
     * @return \float
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Sets the x
     *
     * @param \float $x coordinate
     *
     * @return void
     */
    public function setX($x)
    {
        $this->x = $x;
    }

    /**
     * Returns the y coordinate
     *
     * @return \float
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * Sets the y
     *
     * @param \float $y coordinate
     *
     * @return void
     */
    public function setY($y)
    {
        $this->y = $y;
    }

    /**
     * Returns the z coordinate
     *
     * @return \float
     */
    public function getZ()
    {
        return $this->z;
    }

    /**
     * Sets the z
     *
     * @param \float $z coordinate
     *
     * @return void
     */
    public function setZ($z)
    {
        $this->z = $z;
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
