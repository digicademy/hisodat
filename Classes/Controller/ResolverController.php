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

class ResolverController extends CommonController
{

    /**
     * resolverService
     *
     * @var \ADWLM\Hisodat\Service\ResolverService
     */
    protected $resolverService;

    /**
     * Use constructor DI and not @inject because it's best
     * @see: https://gist.github.com/NamelessCoder/3b2e5931a6c1af19f9c3f8b46e74f837
     *
     * @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
     * @param \ADWLM\Hisodat\Service\ResolverService $resolverService
     */
    public function __construct(
        \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager,
        \ADWLM\Hisodat\Service\ResolverService $resolverService
    )
    {
        parent::__construct($configurationManager);
        $this->resolverService = $resolverService;
    }

    /**
     * Resolves and redirects incoming identifier to URL
     *
     * @param string $identifier
     *
     * @return void
     */
    public function resolveAction($identifier = '')
    {
        if ($identifier) {

            // get record for identifier
            $record = $this->resolverService->resolveIdentifierToRecord($identifier, $this->settings);

            // configure redirection by resolver plugin settings
            if ($record) {

                $recordClass = get_class($record);
                $recordType = substr($recordClass, strrpos($recordClass, '\\') + 1);

                // get the target pid from TS configuration
                $targetPid = $this->settings['recordMapping'][$recordType]['pidToPluginPidMapping'][$record->getPid()];

                // initialize new argument array with the record
                $arguments = array($this->settings['recordMapping'][$recordType]['recordArgumentName'] => $record);

                // merge possible arguments from the request (except identifier)
                $requestArguments = $this->request->getArguments();
                if (count($requestArguments) > 1) {
                    foreach ($requestArguments as $key => $value) {
                        if ($key == 'identifier') {
                            continue;
                        }
                        $arguments[$key] = $value;
                    }
                }

                // merge (and possibly override) additional arguments set from TypoScript
                $additionalArgumentConfiguration = $this->settings['recordMapping'][$recordType]['additionalArguments'];
                if ($additionalArgumentConfiguration) {
                    $entries = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode('|', $additionalArgumentConfiguration, 1);
                    foreach ($entries as $entry) {
                        $keyAndValue = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode('=', $entry, 1);
                        $additionalArguments[$keyAndValue[0]] = $keyAndValue[1];
                    }
                    \TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule($arguments, $additionalArguments);
                }

                // redirect to target
                if ($targetPid > 0 && is_array($arguments)) {

                    $uriBuilder = $this->controllerContext->getUriBuilder();
                    $uri = $uriBuilder->reset()
                        ->setTargetPageUid($targetPid)
                        ->setUseCacheHash(1)
                        ->uriFor(
                            $this->settings['recordMapping'][$recordType]['actionName'],
                            $arguments,
                            $this->settings['recordMapping'][$recordType]['controllerName'],
                            $this->settings['recordMapping'][$recordType]['extensionName'],
                            $this->settings['recordMapping'][$recordType]['pluginName']
                        );

                    $this->redirectToUri($uri);

                    // target page not found - throw 404 and exit
                } else {
                    $GLOBALS['TSFE']->pageNotFoundAndExit($this->entityNotFoundMessage);
                }

                // no record found - throw 404 and exit
            } else {
                $GLOBALS['TSFE']->pageNotFoundAndExit($this->entityNotFoundMessage);
            }

            // called with no identifier, throw 400 - Bad Request
        } else {
// TODO: setStatus method not there anymore in response object?
            $this->response->setStatus(400);
        }

    }

}
