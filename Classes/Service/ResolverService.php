<?php
namespace ADWLM\Hisodat\Service;

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

use TYPO3\CMS\Extbase\Exception;

class ResolverService implements \TYPO3\CMS\Core\SingletonInterface
{

    /**
     * Object manager
     *
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $objectManager;

    /**
     * Repository for sources
     *
     * @var \ADWLM\Hisodat\Domain\Repository\SourcesRepository
     */
    protected $sourcesRepository;

    /**
     * Repository for persons
     *
     * @var \ADWLM\Hisodat\Domain\Repository\PersonsRepository
     */
    protected $personsRepository;

    /**
     * Repository for localities
     *
     * @var \ADWLM\Hisodat\Domain\Repository\LocalitiesRepository
     */
    protected $localitiesRepository;

    /**
     * Repository for entities
     *
     * @var \ADWLM\Hisodat\Domain\Repository\EntitiesRepository
     */
    protected $entitiesRepository;

    /**
     * Repository for events
     *
     * @var \ADWLM\Hisodat\Domain\Repository\EventsRepository
     */
    protected $eventsRepository;

    /**
     * Use constructor DI and not @inject because it's best
     * @see: https://gist.github.com/NamelessCoder/3b2e5931a6c1af19f9c3f8b46e74f837
     *
     * @param \TYPO3\CMS\Extbase\Object\ObjectManager               $objectManager
     * @param \ADWLM\Hisodat\Domain\Repository\ArchivesRepository   $archivesRepository
     * @param \ADWLM\Hisodat\Domain\Repository\SourcesRepository    $sourcesRepository
     * @param \ADWLM\Hisodat\Domain\Repository\PersonsRepository    $personsRepository
     * @param \ADWLM\Hisodat\Domain\Repository\LocalitiesRepository $localitiesRepository
     * @param \ADWLM\Hisodat\Domain\Repository\EntitiesRepository   $entitiesRepository
     * @param \ADWLM\Hisodat\Domain\Repository\EventsRepository     $eventsRepository
     * @param \ADWLM\Hisodat\Domain\Repository\KeywordsRepository   $keywordsRepository
     */
    public function __construct(
        \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager,
        \ADWLM\Hisodat\Domain\Repository\ArchivesRepository $archivesRepository,
        \ADWLM\Hisodat\Domain\Repository\SourcesRepository $sourcesRepository,
        \ADWLM\Hisodat\Domain\Repository\PersonsRepository $personsRepository,
        \ADWLM\Hisodat\Domain\Repository\LocalitiesRepository $localitiesRepository,
        \ADWLM\Hisodat\Domain\Repository\EntitiesRepository $entitiesRepository,
        \ADWLM\Hisodat\Domain\Repository\EventsRepository $eventsRepository,
        \ADWLM\Hisodat\Domain\Repository\KeywordsRepository $keywordsRepository
    ) {
        $this->objectManager = $objectManager;
        $this->archivesRepository = $archivesRepository;
        $this->sourcesRepository = $sourcesRepository;
        $this->personsRepository = $personsRepository;
        $this->localitiesRepository = $localitiesRepository;
        $this->entitiesRepository = $entitiesRepository;
        $this->eventsRepository = $eventsRepository;
        $this->keywordsRepository = $keywordsRepository;
    }

    /**
     * Resolves incoming identifier to record. The property name for
     * the identifier is settable by TypoScript.
     *
     * @param string $identifier
     * @param array  $settings
     *
     * @return mixed
     *
     */
    public function resolveIdentifierToRecord($identifier, $settings)
    {

        $record = null;

        foreach ($settings['recordIdentification'] as $key => $value) {
            $objectName = ucfirst($key);
            if ($record === null && $settings['recordIdentification'][$objectName]['enable'] == 1) {
                $repositoryName = lcfirst($key) . 'Repository';
                $recordIdentifierMethod = $this->setIdentifierMethod($objectName, $settings);
                $result = $this->$repositoryName->$recordIdentifierMethod($identifier);
                if ($result) {
                    $record = $result->getFirst();
                }
            }
        }

        return $record;
    }

    /**
     * Resolves incoming identifier to plugin url for redirection
     *
     * @param integer $recordPid
     * @param integer $pluginPid
     *
     * @return string
     *
     */
    public function resolveRecordToUri($recordPid, $pluginPid)
    {
        $pluginUrl = '';

        return $pluginUrl;
    }

    /**
     * Sets a magic findBy method for a configured property.
     *
     * @param string $objectName
     * @param array  $settings
     *
     * @throws \TYPO3\CMS\Extbase\Exception
     *
     * @return string
     */
    protected function setIdentifierMethod($objectName, $settings)
    {

        $recordIdentifierMethod = 'findByPersistentIdentifier';
        $className = 'ADWLM\Hisodat\Domain\Model\\' . ucfirst($objectName);

        if ($settings['recordIdentification'][$objectName]['identifierProperty']) {
            $identifierProperty = $settings['recordIdentification'][$objectName]['identifierProperty'];
            if ($settings['recordIdentification'][$objectName]['className']) {
                $className = $settings['recordIdentification'][$objectName]['className'];
            }
            $object = $this->objectManager->get($className);
            if (property_exists($object, $identifierProperty)) {
                $recordIdentifierMethod = 'findBy' . ucfirst($identifierProperty);
            } else {
                throw new Exception('Misconfiguration in resolver\'s TypoScript. Identifier property ' . htmlspecialchars($identifierProperty) . ' does not exist for object.',
                    1456642836);
            }
        }

        return $recordIdentifierMethod;
    }

}
