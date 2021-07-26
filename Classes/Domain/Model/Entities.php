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
 * Entities of the source corpus
 */
class Entities extends AbstractEntity
{

    /**
     * Persistent Identifier
     *
     * @var \string $persistentIdentifier
     */
    protected $persistentIdentifier;

    /**
     * Name of the entity
     *
     * @var \string $name
     */
    protected $name;

    /**
     * Variants of the entities name
     *
     * @var \string $nameVariants
     */
    protected $nameVariants;

    /**
     * Details of the entity
     *
     * @var \string $description
     */
    protected $description;

    /**
     * Images
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $images
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $images;

    /**
     * An entity can be dated to a specific time period
     *
     * @var \ADWLM\Hisodat\Domain\Model\DateRanges $dateRange
     */
    protected $dateRange;

    /**
     * An entity can be related to other objects
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\ADWLM\Hisodat\Domain\Model\Relations> $relations
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $relations;

    /**
     * Keywords for the entity
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\ADWLM\Hisodat\Domain\Model\Keywords> $keywords
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $keywords;

    /**
     * Returns the GND
     *
     * @return \string
     */
    public function getPersistentIdentifier()
    {
        return $this->persistentIdentifier;
    }

    /**
     * Sets the GND
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
     * Returns the name
     *
     * @return \string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
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
     * Returns the nameVariants
     *
     * @return \string
     */
    public function getNameVariants()
    {
        return $this->nameVariants;
    }

    /**
     * Sets the nameVariants
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
     * Returns the description
     *
     * @return \string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
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
     * Returns the image
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $images
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Sets the image
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $images
     *
     * @return void
     */
    public function setImages($images)
    {
        $this->images = $images;
    }

    /**
     * Returns the dateRange
     *
     * @return \ADWLM\Hisodat\Domain\Model\DateRanges $dateRange
     */
    public function getDateRange()
    {
        return $this->dateRange;
    }

    /**
     * Sets the dateRange
     *
     * @param \ADWLM\Hisodat\Domain\Model\DateRanges $dateRange
     *
     * @return void
     */
    public function setDateRange(\ADWLM\Hisodat\Domain\Model\DateRanges $dateRange)
    {
        $this->dateRange = $dateRange;
    }

    /**
     * Returns the relations
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\ADWLM\Hisodat\Domain\Model\Relations> $relations
     */
    public function getRelations()
    {
        return $this->relations;
    }

    /**
     * Sets the relations
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\ADWLM\Hisodat\Domain\Model\Relations> $relations
     *
     * @return void
     */
    public function setRelations($relations)
    {
        $this->relations = $relations;
    }

    /**
     * Returns the keywords
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\ADWLM\Hisodat\Domain\Model\Keywords> $keywords
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Sets the keywords
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\ADWLM\Hisodat\Domain\Model\Keywords> $keywords
     *
     * @return void
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

}
