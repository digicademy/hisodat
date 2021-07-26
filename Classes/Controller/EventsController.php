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

class EventsController extends CommonController
{

    /**
     * eventsRepository
     *
     * @var \ADWLM\Hisodat\Domain\Repository\EventsRepository
     */
    protected $eventsRepository;

    /**
     * Use constructor DI and not @inject because it's best
     * @see: https://gist.github.com/NamelessCoder/3b2e5931a6c1af19f9c3f8b46e74f837
     *
     * @param \ADWLM\Hisodat\Domain\Repository\EventsRepository $eventsRepository
     */
    public function __construct(
        \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager,
        \ADWLM\Hisodat\Domain\Repository\EventsRepository $eventsRepository
    )
    {
        parent::__construct($configurationManager);
        $this->eventsRepository = $eventsRepository;
    }

    /**
     * Displays a single event
     *
     * @param \ADWLM\Hisodat\Domain\Model\Events $event
     */
    public function showAction(\ADWLM\Hisodat\Domain\Model\Events $event)
    {
        // assign current settings
        $this->view->assign('settings', $this->settings);

        // assign current arguments
        $this->view->assign('arguments', $this->request->getArguments());

        // assign the event
        $this->view->assign('event', $event);
    }

}
