<?php
namespace ADWLM\Hisodat\Controller;

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

class EntitiesController extends CommonController
{

    /**
     * entitiesRepository
     *
     * @var \ADWLM\Hisodat\Domain\Repository\EntitiesRepository
     */
    protected $entitiesRepository;

    /**
     * Use constructor DI and not @inject because it's best
     * @see: https://gist.github.com/NamelessCoder/3b2e5931a6c1af19f9c3f8b46e74f837
     *
     * @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
     * @param \ADWLM\Hisodat\Domain\Repository\EntitiesRepository $entitiesRepository
     */
    public function __construct(
        \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager,
        \ADWLM\Hisodat\Domain\Repository\EntitiesRepository $entitiesRepository
    )
    {
        parent::__construct($configurationManager);
        $this->entitiesRepository = $entitiesRepository;
    }

    /**
     * Displays a single Entities
     *
     * @param \ADWLM\Hisodat\Domain\Model\Entities $entity
     */
    public function showAction(\ADWLM\Hisodat\Domain\Model\Entities $entity)
    {
        // assign current settings
        $this->view->assign('settings', $this->settings);

        // assign current arguments
        $this->view->assign('arguments', $this->request->getArguments());

        // assign the entity
        $this->view->assign('entity', $entity);
    }

}
