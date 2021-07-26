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
 * The different roles that objects can have in relations to sources
 */
class Roles extends AbstractEntity
{

    /**
     * Identifier for import/export/exchange
     *
     * @var \string $persistentIdentifier
     */
    protected $persistentIdentifier;

    /**
     * Specifies to which objects this role relates
     *
     * @var \string $roleType
     */
    protected $roleType;

    /**
     * The name of the role
     *
     * @var \string $name
     */
    protected $name;

    /**
     * Name variants of the role
     *
     * @var \string $nameVariants
     */
    protected $nameVariants;

    /**
     * A description of the role
     *
     * @var \string $description
     */
    protected $description;

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
     * Returns the roleType
     *
     * @return \string $roleType
     */
    public function getRoleType()
    {
        return $this->roleType;
    }

    /**
     * Sets the roleType
     *
     * @param \string $roleType
     *
     * @return void
     */
    public function setRoleType($roleType)
    {
        $this->roleType = $roleType;
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

}
