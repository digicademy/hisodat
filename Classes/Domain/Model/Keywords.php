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

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Keywords define abstract qualities or terms for entities, localities or persons
 */
class Keywords extends AbstractEntity
{

    /**
     * Identifier for import/export/exchange
     *
     * @var \string $persistentIdentifier
     */
    protected $persistentIdentifier;

    /**
     * The name of the keyword
     *
     * @var \string $name
     */
    protected $name;

    /**
     * Name variants of the keyword
     *
     * @var \string $nameVariants
     */
    protected $nameVariants;

    /**
     * A description of the keyword
     *
     * @var \string $description
     */
    protected $description;

    /**
     * Can be used to generate separate keyword lists depending on the object
     *
     * @var \string $keywordType
     */
    protected $keywordType;

    /**
     * Keywords can be grouped hierarchically
     *
     * @var \ADWLM\Hisodat\Domain\Model\Keywords $parentKeyword
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $parentKeyword;

    /**
     * Keywords can be classified by another keyword
     *
     * @var \ADWLM\Hisodat\Domain\Model\Keywords $classification
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $classification;

    /**
     * Keywords can reference to another keyword (see other)
     *
     * @var \ADWLM\Hisodat\Domain\Model\Keywords $seeOther
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $seeOther;

    /**
     * Returns the persistentIdentifier
     *
     * @return \string
     */
    public function getPersistentIdentifier()
    {
        return $this->persistentIdentifier;
    }

    /**
     * Sets the persistentIdentifier
     *
     * @param \string $persistentIdentifier
     *
     * @return void
     */
    public function setPersistentIdentifier($persistentIdentifier)
    {
        $this->persistentIdentifier = $persistentIdentifier;
    }

    /**
     * getName
     *
     * @return \string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * setName
     *
     * @param \string $name
     *
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * getNameVariants
     *
     * @return \string
     */
    public function getNameVariants()
    {
        return $this->nameVariants;
    }

    /**
     * setNameVariants
     *
     * @param \string $nameVariants
     *
     * @return void
     */
    public function setNameVariants($nameVariants)
    {
        $this->nameVariants = $nameVariants;
    }

    /**
     * getDescription
     *
     * @return \string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * setDescription
     *
     * @param \string $description
     *
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns the keywordType
     *
     * @return \string $keywordType
     */
    public function getKeywordType()
    {
        return $this->keywordType;
    }

    /**
     * Sets the keywordType
     *
     * @param \string $keywordType
     *
     * @return void
     */
    public function setKeywordType($keywordType)
    {
        $this->keywordType = $keywordType;
    }

    /**
     * Returns the parentKeyword
     *
     * @return \ADWLM\Hisodat\Domain\Model\Keywords $parentKeyword
     */
    public function getParentKeyword()
    {
        return $this->parentKeyword;
    }

    /**
     * Sets the parenKeyword
     *
     * @param \ADWLM\Hisodat\Domain\Model\Keywords $parentKeyword
     *
     * @return void
     */
    public function setParentKeyword(\ADWLM\Hisodat\Domain\Model\Keywords $parentKeyword)
    {
        $this->parentKeyword = $parentKeyword;
    }

    /**
     * Returns the classification
     *
     * @return \ADWLM\Hisodat\Domain\Model\Keywords $classification
     */
    public function getClassification()
    {
        return $this->classification;
    }

    /**
     * Sets the classification
     *
     * @param \ADWLM\Hisodat\Domain\Model\Keywords $classification
     *
     * @return void
     */
    public function setClassification(\ADWLM\Hisodat\Domain\Model\Keywords $classification)
    {
        $this->classification = $classification;
    }

    /**
     * Returns the seeOther
     *
     * @return \ADWLM\Hisodat\Domain\Model\Keywords $seeOther
     */
    public function getSeeOther()
    {
        return $this->seeOther;
    }

    /**
     * Sets the seeOther
     *
     * @param \ADWLM\Hisodat\Domain\Model\Keywords $seeOther
     *
     * @return void
     */
    public function setSeeOther(\ADWLM\Hisodat\Domain\Model\Keywords $seeOther)
    {
        $this->seeOther = $seeOther;
    }

}
