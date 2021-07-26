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

use \TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Relations that persons or entities can take in respect to the source object
 */
class Relations extends AbstractEntity
{

    /**
     * Identifier for import/export/exchange
     *
     * @var \string $persistentIdentifier
     */
    protected $persistentIdentifier;

    /**
     * The type of relation: person, locality, event
     *
     * @var \string $relationType
     */
    protected $relationType;

    /**
     * Details of the archive
     *
     * @var \string $description
     */
    protected $description;

    /**
     * role
     *
     * @var \ADWLM\Hisodat\Domain\Model\Roles $role
     */
    protected $role;

    /**
     * Date information for the relation
     *
     * @var \ADWLM\Hisodat\Domain\Model\DateRanges $dateRange
     */
    protected $dateRange;

    /**
     * Geodata for the relation
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\ADWLM\Hisodat\Domain\Model\Geodata> $geodata
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $geodata;

    /**
     * The related source
     *
     * @var \ADWLM\Hisodat\Domain\Model\Sources $source
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $source;

    /**
     * sourceSortby
     *
     * @var \integer $sourceSortby
     */
    protected $sourceSortby;

    /**
     * entity
     *
     * @var \ADWLM\Hisodat\Domain\Model\Entities $entity
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $entity;

    /**
     * entitySortby
     *
     * @var \integer $entitySortby
     */
    protected $entitySortby;

    /**
     * event
     *
     * @var \ADWLM\Hisodat\Domain\Model\Events $event
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $event;

    /**
     * eventSortby
     *
     * @var \integer $eventSortby
     */
    protected $eventSortby;

    /**
     * person
     *
     * @var \ADWLM\Hisodat\Domain\Model\Persons $person
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $person;

    /**
     * personSortby
     *
     * @var \integer $personSortby
     */
    protected $personSortby;

    /**
     * locality
     *
     * @var \ADWLM\Hisodat\Domain\Model\Localities $locality
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $locality;

    /**
     * localitySortby
     *
     * @var \integer $localitySortby
     */
    protected $localitySortby;

    /**
     * sourceSymmetric
     *
     * @var \ADWLM\Hisodat\Domain\Model\Sources $sourceSymmetric
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $sourceSymmetric;

    /**
     * sourceSymmetricSortby
     *
     * @var \integer $sourceSymmetricSortby
     */
    protected $sourceSymmetricSortby;

    /**
     * entitySymmetric
     *
     * @var \ADWLM\Hisodat\Domain\Model\Entities $entitySymmetric
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $entitySymmetric;

    /**
     * entitySymmetricSortby
     *
     * @var \integer $entitySymmetricSortby
     */
    protected $entitySymmetricSortby;

    /**
     * eventSymmetric
     *
     * @var \ADWLM\Hisodat\Domain\Model\Events $eventSymmetric
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $eventSymmetric;

    /**
     * eventSymmetricSortby
     *
     * @var \integer $eventSymmetricSortby
     */
    protected $eventSymmetricSortby;

    /**
     * personSymmetric
     *
     * @var \ADWLM\Hisodat\Domain\Model\Persons $personSymmetric
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $personSymmetric;

    /**
     * personSymmetricSortby
     *
     * @var \integer $personSymmetricSortby
     */
    protected $personSymmetricSortby;

    /**
     * localitySymmetric
     *
     * @var \ADWLM\Hisodat\Domain\Model\Localities $localitySymmetric
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $localitySymmetric;

    /**
     * localitySymmetricSortby
     *
     * @var \integer $localitySymmetricSortby
     */
    protected $localitySymmetricSortby;

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
     * Returns the relationType
     *
     * @return \string
     */
    public function getRelationType()
    {
        return $this->relationType;
    }

    /**
     * Sets the relationType
     *
     * @param \string $relationType
     *
     * @return void
     */
    public function setRelationType($relationType)
    {
        $this->relationType = $relationType;
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
     * Returns the role
     *
     * @return \ADWLM\Hisodat\Domain\Model\Roles $role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Sets the role
     *
     * @param \ADWLM\Hisodat\Domain\Model\Roles $role
     *
     * @return void
     */
    public function setRole(\ADWLM\Hisodat\Domain\Model\Roles $role)
    {
        $this->role = $role;
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
     * Returns the geodata
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\ADWLM\Hisodat\Domain\Model\Geodata> $geodata
     */
    public function getGeodata()
    {
        return $this->geodata;
    }

    /**
     * Sets the geodata
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\ADWLM\Hisodat\Domain\Model\Geodata> $geodata
     *
     * @return void
     */
    public function setGeodata($geodata)
    {
        $this->geodata = $geodata;
    }

    /**
     * Returns the source
     *
     * @return \ADWLM\Hisodat\Domain\Model\Sources $source
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Sets the source
     *
     * @param \ADWLM\Hisodat\Domain\Model\Sources $source
     *
     * @return void
     */
    public function setSource(\ADWLM\Hisodat\Domain\Model\Sources $source)
    {
        $this->source = $source;
    }

    /**
     * Returns the sourceSortby
     *
     * @return \integer $sourceSortby
     */
    public function getSourceSortby()
    {
        return $this->sourceSortby;
    }

    /**
     * Sets the source
     *
     * @param \integer $sourceSortby
     *
     * @return void
     */
    public function setSourceSortby($sourceSortby)
    {
        $this->sourceSortby = $sourceSortby;
    }

    /**
     * Returns the locality
     *
     * @return \ADWLM\Hisodat\Domain\Model\Localities $locality
     */
    public function getLocality()
    {
        return $this->locality;
    }

    /**
     * Sets the locality
     *
     * @param \ADWLM\Hisodat\Domain\Model\Localities $locality
     *
     * @return void
     */
    public function setLocality(\ADWLM\Hisodat\Domain\Model\Localities $locality)
    {
        $this->locality = $locality;
    }

    /**
     * Returns the localitySortby
     *
     * @return \integer $localitySortby
     */
    public function getLocalitySortby()
    {
        return $this->localitySortby;
    }

    /**
     * Sets the locality
     *
     * @param \integer $localitySortby
     *
     * @return void
     */
    public function setLocalitySortby($localitySortby)
    {
        $this->localitySortby = $localitySortby;
    }

    /**
     * Returns the entity
     *
     * @return \ADWLM\Hisodat\Domain\Model\Entities $entity
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Sets the entity
     *
     * @param \ADWLM\Hisodat\Domain\Model\Entities $entity
     *
     * @return void
     */
    public function setEntity(\ADWLM\Hisodat\Domain\Model\Entities $entity)
    {
        $this->entity = $entity;
    }

    /**
     * Returns the entitySortby
     *
     * @return \integer $entitySortby
     */
    public function getEntitySortby()
    {
        return $this->entitySortby;
    }

    /**
     * Sets the entity
     *
     * @param \integer $entitySortby
     *
     * @return void
     */
    public function setEntitySortby($entitySortby)
    {
        $this->entitySortby = $entitySortby;
    }

    /**
     * Returns the event
     *
     * @return \ADWLM\Hisodat\Domain\Model\Events $event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Sets the event
     *
     * @param \ADWLM\Hisodat\Domain\Model\Events $event
     *
     * @return void
     */
    public function setEvent(\ADWLM\Hisodat\Domain\Model\Events $event)
    {
        $this->event = $event;
    }

    /**
     * Returns the eventSortby
     *
     * @return \integer $eventSortby
     */
    public function getEventSortby()
    {
        return $this->eventSortby;
    }

    /**
     * Sets the event
     *
     * @param \integer $eventSortby
     *
     * @return void
     */
    public function setEventSortby($eventSortby)
    {
        $this->eventSortby = $eventSortby;
    }

    /**
     * Returns the person
     *
     * @return \ADWLM\Hisodat\Domain\Model\Persons $person
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * Sets the person
     *
     * @param \ADWLM\Hisodat\Domain\Model\Persons $person
     *
     * @return void
     */
    public function setPerson(\ADWLM\Hisodat\Domain\Model\Persons $person)
    {
        $this->person = $person;
    }

    /**
     * Returns the personSortby
     *
     * @return \integer $personSortby
     */
    public function getPersonSortby()
    {
        return $this->personSortby;
    }

    /**
     * Sets the person
     *
     * @param \integer $personSortby
     *
     * @return void
     */
    public function setPersonSortby($personSortby)
    {
        $this->personSortby = $personSortby;
    }

    /**
     * Returns the sourceSymmetric
     *
     * @return \ADWLM\Hisodat\Domain\Model\Sources $sourceSymmetric
     */
    public function getSourceSymmetric()
    {
        return $this->sourceSymmetric;
    }

    /**
     * Sets the source
     *
     * @param \ADWLM\Hisodat\Domain\Model\Sources $sourceSymmetric
     *
     * @return void
     */
    public function setSourceSymmetric(\ADWLM\Hisodat\Domain\Model\Sources $sourceSymmetric)
    {
        $this->source = $sourceSymmetric;
    }

    /**
     * Returns the sourceSymmetricSortby
     *
     * @return \integer $sourceSymmetricSortby
     */
    public function getSourceSymmetricSortby()
    {
        return $this->sourceSymmetricSortby;
    }

    /**
     * Sets the sourceSymmetric
     *
     * @param \integer $sourceSymmetricSortby
     *
     * @return void
     */
    public function setSourceSymmetricSortby($sourceSymmetricSortby)
    {
        $this->sourceSymmetricSortby = $sourceSymmetricSortby;
    }

    /**
     * Returns the localitySymmetric
     *
     * @return \ADWLM\Hisodat\Domain\Model\Localities $localitySymmetric
     */
    public function getLocalitySymmetric()
    {
        return $this->localitySymmetric;
    }

    /**
     * Sets the localitySymmetric
     *
     * @param \ADWLM\Hisodat\Domain\Model\Localities $localitySymmetric
     *
     * @return void
     */
    public function setLocalitySymmetric(\ADWLM\Hisodat\Domain\Model\Localities $localitySymmetric)
    {
        $this->locality = $localitySymmetric;
    }

    /**
     * Returns the localitySymmetricSortby
     *
     * @return \integer $localitySymmetricSortby
     */
    public function getLocalitySymmetricSortby()
    {
        return $this->localitySymmetricSortby;
    }

    /**
     * Sets the localitySymmetric
     *
     * @param \integer $localitySymmetricSortby
     *
     * @return void
     */
    public function setLocalitySymmetricSortby($localitySymmetricSortby)
    {
        $this->localitySymmetricSortby = $localitySymmetricSortby;
    }

    /**
     * Returns the entitySymmetric
     *
     * @return \ADWLM\Hisodat\Domain\Model\Entities $entitySymmetric
     */
    public function getEntitySymmetric()
    {
        return $this->entitySymmetric;
    }

    /**
     * Sets the entitySymmetric
     *
     * @param \ADWLM\Hisodat\Domain\Model\Entities $entitySymmetric
     *
     * @return void
     */
    public function setEntitySymmetric(\ADWLM\Hisodat\Domain\Model\Entities $entitySymmetric)
    {
        $this->entity = $entitySymmetric;
    }

    /**
     * Returns the entitySymmetricSortby
     *
     * @return \integer $entitySymmetricSortby
     */
    public function getEntitySymmetricSortby()
    {
        return $this->entitySymmetricSortby;
    }

    /**
     * Sets the entitySymmetric
     *
     * @param \integer $entitySymmetricSortby
     *
     * @return void
     */
    public function setEntitySymmetricSortby($entitySymmetricSortby)
    {
        $this->entitySymmetricSortby = $entitySymmetricSortby;
    }

    /**
     * Returns the eventSymmetric
     *
     * @return \ADWLM\Hisodat\Domain\Model\Events $eventSymmetric
     */
    public function getEventSymmetric()
    {
        return $this->eventSymmetric;
    }

    /**
     * Sets the eventSymmetric
     *
     * @param \ADWLM\Hisodat\Domain\Model\Events $eventSymmetric
     *
     * @return void
     */
    public function setEventSymmetric(\ADWLM\Hisodat\Domain\Model\Events $eventSymmetric)
    {
        $this->event = $eventSymmetric;
    }

    /**
     * Returns the eventSymmetricSortby
     *
     * @return \integer $eventSymmetricSortby
     */
    public function getEventSymmetricSortby()
    {
        return $this->eventSymmetricSortby;
    }

    /**
     * Sets the eventSymmetric
     *
     * @param \integer $eventSymmetricSortby
     *
     * @return void
     */
    public function setEventSymmetricSortby($eventSymmetricSortby)
    {
        $this->eventSymmetricSortby = $eventSymmetricSortby;
    }

    /**
     * Returns the personSymmetric
     *
     * @return \ADWLM\Hisodat\Domain\Model\Persons $personSymmetric
     */
    public function getPersonSymmetric()
    {
        return $this->personSymmetric;
    }

    /**
     * Sets the personSymmetric
     *
     * @param \ADWLM\Hisodat\Domain\Model\Persons $personSymmetric
     *
     * @return void
     */
    public function setPersonSymmetric(\ADWLM\Hisodat\Domain\Model\Persons $personSymmetric)
    {
        $this->person = $personSymmetric;
    }

    /**
     * Returns the personSymmetricSortby
     *
     * @return \integer $personSymmetricSortby
     */
    public function getPersonSymmetricSortby()
    {
        return $this->personSymmetricSortby;
    }

    /**
     * Sets the personSymmetric
     *
     * @param \integer $personSymmetricSortby
     *
     * @return void
     */
    public function setPersonSymmetricSortby($personSymmetricSortby)
    {
        $this->personSymmetricSortby = $personSymmetricSortby;
    }

}
