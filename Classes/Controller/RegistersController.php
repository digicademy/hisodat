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

class RegistersController extends CommonController
{

    /**
     * Archives repository
     *
     * @var \ADWLM\Hisodat\Domain\Repository\ArchivesRepository
     */
    protected $archivesRepository;

    /**
     * Persons repository
     *
     * @var \ADWLM\Hisodat\Domain\Repository\PersonsRepository
     */
    protected $personsRepository;

    /**
     * Localities repository
     *
     * @var \ADWLM\Hisodat\Domain\Repository\LocalitiesRepository
     */
    protected $localitiesRepository;

    /**
     * Entities repository
     *
     * @var \ADWLM\Hisodat\Domain\Repository\EntitiesRepository
     */
    protected $entitiesRepository;

    /**
     * Events repository
     *
     * @var \ADWLM\Hisodat\Domain\Repository\EventsRepository
     */
    protected $eventsRepository;

    /**
     * Keywords repository
     *
     * @var \ADWLM\Hisodat\Domain\Repository\KeywordsRepository
     */
    protected $keywordsRepository;

    /**
     * Use constructor DI and not @inject because it's best
     * @see: https://gist.github.com/NamelessCoder/3b2e5931a6c1af19f9c3f8b46e74f837
     *
     * @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
     * @param \ADWLM\Hisodat\Domain\Repository\ArchivesRepository $archivesRepository
     * @param \ADWLM\Hisodat\Domain\Repository\PersonsRepository $personsRepository
     * @param \ADWLM\Hisodat\Domain\Repository\LocalitiesRepository $localitiesRepository
     * @param \ADWLM\Hisodat\Domain\Repository\EntitiesRepository $entitiesRepository
     * @param \ADWLM\Hisodat\Domain\Repository\EventsRepository $eventsRepository
     * @param \ADWLM\Hisodat\Domain\Repository\KeywordsRepository $keywordsRepository
     */
    public function __construct(
        \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager,
        \ADWLM\Hisodat\Domain\Repository\ArchivesRepository $archivesRepository,
        \ADWLM\Hisodat\Domain\Repository\PersonsRepository $personsRepository,
        \ADWLM\Hisodat\Domain\Repository\LocalitiesRepository $localitiesRepository,
        \ADWLM\Hisodat\Domain\Repository\EntitiesRepository $entitiesRepository,
        \ADWLM\Hisodat\Domain\Repository\EventsRepository $eventsRepository,
        \ADWLM\Hisodat\Domain\Repository\KeywordsRepository $keywordsRepository
    )
    {
        parent::__construct($configurationManager);
        $this->archivesRepository = $archivesRepository;
        $this->personsRepository = $personsRepository;
        $this->localitiesRepository = $localitiesRepository;
        $this->entitiesRepository = $entitiesRepository;
        $this->eventsRepository = $eventsRepository;
        $this->keywordsRepository = $keywordsRepository;
    }

    /**
     * @param string $searchstring
     * @validate $searchstring regularExpression(regularExpression="/^[\.\,\"\'\-\p{L}\p{M}\p{N}\p{Sk}\s]*$/u"), stringLength(minimum=3)
     */
    public function searchAction($searchstring)
    {
        $arguments = $this->request->getArguments();
        $arguments['filters']['search']['searchstring'] = $searchstring;
        $this->forward('list', null, null, $arguments);
    }

    /**
     * Fetches and displays objects for the current register depending on mode setting in the plugin flexform
     */
    public function listAction()
    {

        // get current arguments
        $arguments = $this->request->getArguments();

        // alphabet filter settings
        if (!$arguments['filters']['alphabet']['letterRange']) {
            $arguments['filters']['alphabet']['letterRange'] = $this->settings['filters']['alphabet']['defaultLetterRange'];
        }
        // unset default letter range if all letters should be shown
        if ((int)$arguments['filters']['alphabet']['showAll'] === 1) {
            unset($arguments['filters']['alphabet']['letterRange']);
        }

        // determine the register mode
        ($arguments['mode'] > 0) ? $mode = (int)$arguments['mode'] : $mode = $this->settings['mode'];

        switch ($mode) {

            case 10:
                if (is_array($arguments['filters'])) {
                    $entries = $this->personsRepository->findByFilters(
                        $this->settings,
                        $this->settings['recordPids']['persons'],
                        $arguments['filters']
                    );
                } else {
                    $entries = $this->personsRepository->findAllInPids($this->settings['recordPids']['persons']);
                }
                break;

            case 20:
                if (is_array($arguments['filters'])) {
                    $entries = $this->localitiesRepository->findByFilters(
                        $this->settings,
                        $this->settings['recordPids']['localities'],
                        $arguments['filters']
                    );
                } else {
                    $entries = $this->localitiesRepository->findAllInPids(
                        $this->settings['recordPids']['localities'],
                        'name'
                    );
                }
                break;

            case 30:
                if (is_array($arguments['filters'])) {
                    $entries = $this->entitiesRepository->findByFilters(
                        $this->settings,
                        $this->settings['recordPids']['entities'],
                        $arguments['filters']
                    );
                } else {
                    $entries = $this->entitiesRepository->findAllInPids(
                        $this->settings['recordPids']['entities'],
                        'name'
                    );
                }
                break;

            case 40:
                if (is_array($arguments['filters'])) {
                    $entries = $this->eventsRepository->findByFilters(
                        $this->settings,
                        $this->settings['recordPids']['events'],
                        $arguments['filters']
                    );
                } else {
                    $entries = $this->eventsRepository->findAllInPids(
                        $this->settings['recordPids']['events'],
                        'name'
                    );
                }
                break;

            case 50:
                if (is_array($arguments['filters'])) {
                    $entries = $this->archivesRepository->findByFilters(
                        $this->settings,
                        $this->settings['recordPids']['archives'],
                        $arguments['filters']
                    );
                } else {
                    $entries = $this->archivesRepository->findAllInPids($this->settings['recordPids']['archives']);
                }
                break;

            case 60:
                if (is_array($arguments['filters'])) {
                    $entries = $this->keywordsRepository->findByFilters(
                        $this->settings,
                        $this->settings['recordPids']['keywords'],
                        $arguments['filters']
                    );
                } else {
                    $entries = $this->keywordsRepository->findAllInPids($this->settings['recordPids']['keywords']);
                }
                break;

            default:
                throw new \TYPO3\CMS\Core\Error\Exception('Invalid value for mode.', 1367309728);
                break;
        }

        // assign resulting entries
        $this->view->assign('entries', $entries);

        // assign current arguments
        $this->view->assign('arguments', $arguments);

        // reassign settings
        $this->view->assign('settings', $this->settings);
    }
}
