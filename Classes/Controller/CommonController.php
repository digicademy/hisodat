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

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Validation\Error;
use ADWLM\Hisodat\Utility\Frontend\Page;

/**
 * Controller that implements some generic functionality like validation routines and common settings
 */
class CommonController extends ActionController
{

    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     */
    protected $configurationManager;

    /**
     * Use constructor DI and not @inject because it's best
     * @see: https://gist.github.com/NamelessCoder/3b2e5931a6c1af19f9c3f8b46e74f837
     *
     * @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
     */
    public function __construct(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager)
    {
        parent::__construct();
        $this->configurationManager = $configurationManager;
    }

    /**
     * @see https://gist.github.com/849247
     * @see \TYPO3\CMS\Extbase\Mvc\Controller\ActionController::callActionMethod()
     */
    protected function callActionMethod()
    {
        $this->validateAll();
        $this->initializeCommonSettings();
        parent::callActionMethod();
    }

    /* VALIDATION */
    protected function validateAll()
    {
        $classSchema = $this->reflectionService->getClassSchema(get_class($this));
        $methodProperties = $classSchema->getMethod($this->actionMethodName);
        $methodTagsValues = $methodProperties['tags'];

        if (isset($methodTagsValues['validateAll'])) {
            foreach ($methodTagsValues['validateAll'] as $validateAll) {

                preg_match('/\(.*\)/', $validateAll, $matches);
                $options = preg_replace('/\(|\)/', '', $matches[0]);
                $validatorString = preg_split('/\(.*\)/', $validateAll);
                $split = preg_split('/\s+/', $validatorString[0]);

                $arguments = array();
                foreach ($split as $part) {
                    if (substr($part, 0, 1) === '$') {
                        $arguments[] = $this->arguments->getArgument(substr($part, 1));
                    } else {
                        if (substr($part, 0, 1) === '\\') {
                            $validatorClass = substr($part, 1);
                        }
                    }
                }

                $argumentValues = array();
                foreach ($arguments as $argument) {
                    $argumentNames[] = $argument->getName();
                    $argumentValues[] = $argument->getValue();
                }

                if ($options) {
                    $optionValues = GeneralUtility::trimExplode(',', $options, 1);
                    foreach ($optionValues as $value) {
                        $namesValues = GeneralUtility::trimExplode('=', $value, 1);
                        $argumentValues['options'][$namesValues[0]] = $namesValues[1];
                    }
                }

                $validator = $this->objectManager->get($validatorClass);
                $validateAllResult = call_user_func_array(array($validator, 'isValidAll'), $argumentValues['options']);
                $validationResult = $this->arguments->validate();

                $shouldCallErrorAction = false;
                foreach ($validateAllResult->getErrors() as $error) {
                    if ($error instanceof Error) {
                        $shouldCallErrorAction = true;
                    }
                    foreach ($argumentNames as $argumentName) {
                        $validationResult->forProperty($argumentName)->addError($error);
                    }
                }

                if ($shouldCallErrorAction === true) {
                    $referringRequest = $this->request->getReferringRequest();
                    if ($referringRequest !== null) {
                        $originalRequest = clone $this->request;
                        $this->request->setOriginalRequest($originalRequest);
                        $this->request->setOriginalRequestMappingResults($validationResult);
                        $this->forward(
                            $referringRequest->getControllerActionName(),
                            $referringRequest->getControllerName(),
                            $referringRequest->getControllerExtensionName(),
                            $referringRequest->getArguments()
                        );
                    }
                }
            }
        }
    }

    /* SETTINGS */

    /**
     * Initializes some common settings for all controllers and plugins, namely the plugin uid,
     * the target and origin pids of links and the record pids. Allows override of empty Flexform values
     * from TypoScript (which TYPO3 wise is generally not the case if empty an field of the same name
     * exists in a Flexform structure (quite an inconvenient behaviour!)
     *
     * @return void
     */
    public function initializeCommonSettings()
    {

        // set uid of current content element (helpful in servin alternative content formats)
        $this->settings['pluginUid'] = $this->configurationManager->getContentObject()->data['uid'];

        // if no target pid is set for the plugin, take the current page
        if (!$this->settings['targetPid']) {
            $this->settings['targetPid'] = $GLOBALS['TSFE']->id;
        }

        // if no origin pid is set for the plugin, also take current page
        if (!$this->settings['originPid']) {
            $this->settings['originPid'] = $GLOBALS['TSFE']->id;
        }

        // flexform settings override TS settings
        if ($this->settings['FF']['recursive']) {
            $this->settings['recursive'] = $this->settings['FF']['recursive'];
        }
        unset($this->settings['FF']);

        // possibly override record pids from flexform
        if ($this->settings['recordPids']['FF']['sources']) {
            $this->settings['recordPids']['sources'] = $this->settings['recordPids']['FF']['sources'];
        }
        if ($this->settings['recordPids']['FF']['archives']) {
            $this->settings['recordPids']['archives'] = $this->settings['recordPids']['FF']['archives'];
        }
        if ($this->settings['recordPids']['FF']['persons']) {
            $this->settings['recordPids']['persons'] = $this->settings['recordPids']['FF']['persons'];
        }
        if ($this->settings['recordPids']['FF']['localities']) {
            $this->settings['recordPids']['localities'] = $this->settings['recordPids']['FF']['localities'];
        }
        if ($this->settings['recordPids']['FF']['entities']) {
            $this->settings['recordPids']['entities'] = $this->settings['recordPids']['FF']['entities'];
        }
        if ($this->settings['recordPids']['FF']['keywords']) {
            $this->settings['recordPids']['keywords'] = $this->settings['recordPids']['FF']['keywords'];
        }
        if ($this->settings['recordPids']['FF']['roles']) {
            $this->settings['recordPids']['roles'] = $this->settings['recordPids']['FF']['roles'];
        }
        if ($this->settings['recordPids']['FF']['events']) {
            $this->settings['recordPids']['events'] = $this->settings['recordPids']['FF']['events'];
        }
        unset($this->settings['recordPids']['FF']);

        // set storage pids of records, possibly recursive; if nothing is set in the configuration, take the current page as basis
        $this->settings['recordPids']['sources'] = Page::extendPidListByChildren($this->settings['recordPids']['sources'], $this->settings['recursive']);
        $this->settings['recordPids']['archives'] = Page::extendPidListByChildren($this->settings['recordPids']['archives'], $this->settings['recursive']);
        $this->settings['recordPids']['persons'] = Page::extendPidListByChildren($this->settings['recordPids']['persons'], $this->settings['recursive']);
        $this->settings['recordPids']['localities'] = Page::extendPidListByChildren($this->settings['recordPids']['localities'], $this->settings['recursive']);
        $this->settings['recordPids']['entities'] = Page::extendPidListByChildren($this->settings['recordPids']['entities'], $this->settings['recursive']);
        $this->settings['recordPids']['keywords'] = Page::extendPidListByChildren($this->settings['recordPids']['keywords'], $this->settings['recursive']);
        $this->settings['recordPids']['roles'] = Page::extendPidListByChildren($this->settings['recordPids']['roles'], $this->settings['recursive']);
        $this->settings['recordPids']['events'] = Page::extendPidListByChildren($this->settings['recordPids']['events'], $this->settings['recursive']);

        // still no value? take the current page as basis
        if (!$this->settings['recordPids']['sources']) {
            $this->settings['recordPids']['sources'] = $GLOBALS['TSFE']->id;
        }
        if (!$this->settings['recordPids']['archives']) {
            $this->settings['recordPids']['archives'] = $GLOBALS['TSFE']->id;
        }
        if (!$this->settings['recordPids']['persons']) {
            $this->settings['recordPids']['persons'] = $GLOBALS['TSFE']->id;
        }
        if (!$this->settings['recordPids']['localities']) {
            $this->settings['recordPids']['localities'] = $GLOBALS['TSFE']->id;
        }
        if (!$this->settings['recordPids']['entities']) {
            $this->settings['recordPids']['entities'] = $GLOBALS['TSFE']->id;
        }
        if (!$this->settings['recordPids']['keywords']) {
            $this->settings['recordPids']['keywords'] = $GLOBALS['TSFE']->id;
        }
        if (!$this->settings['recordPids']['roles']) {
            $this->settings['recordPids']['roles'] = $GLOBALS['TSFE']->id;
        }
        if (!$this->settings['recordPids']['events']) {
            $this->settings['recordPids']['events'] = $GLOBALS['TSFE']->id;
        }

        // possibly override register pids from flexform
        if ($this->settings['registerPids']['FF']['archives']) {
            $this->settings['registerPids']['archives'] = $this->settings['registerPids']['FF']['archives'];
        }
        if ($this->settings['registerPids']['FF']['persons']) {
            $this->settings['registerPids']['persons'] = $this->settings['registerPids']['FF']['persons'];
        }
        if ($this->settings['registerPids']['FF']['localities']) {
            $this->settings['registerPids']['localities'] = $this->settings['registerPids']['FF']['localities'];
        }
        if ($this->settings['registerPids']['FF']['entities']) {
            $this->settings['registerPids']['entities'] = $this->settings['registerPids']['FF']['entities'];
        }
        if ($this->settings['registerPids']['FF']['keywords']) {
            $this->settings['registerPids']['keywords'] = $this->settings['registerPids']['FF']['keywords'];
        }
        if ($this->settings['registerPids']['FF']['events']) {
            $this->settings['registerPids']['events'] = $this->settings['registerPids']['FF']['events'];
        }
        unset($this->settings['registerPids']['FF']);
    }

}
