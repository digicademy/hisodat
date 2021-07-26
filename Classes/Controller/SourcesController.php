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

use TYPO3\CMS\Core\Cache\CacheFactory;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use ADWLM\Hisodat\Utility\Frontend\Search;
use ADWLM\Hisodat\Utility\Frontend\Pagination;

use TYPO3\CMS\Extbase\Annotation as Extbase;

class SourcesController extends CommonController
{

    /**
     * Repository for sources
     *
     * @var \ADWLM\Hisodat\Domain\Repository\SourcesRepository
     */
    protected $sourcesRepository;

    /**
     * Repository for archives
     *
     * @var \ADWLM\Hisodat\Domain\Repository\ArchivesRepository
     */
    protected $archivesRepository;

    /**
     * Repository for roles
     *
     * @var \ADWLM\Hisodat\Domain\Repository\RolesRepository
     */
    protected $rolesRepository;

    /**
     * Repository for keywords
     *
     * @var \ADWLM\Hisodat\Domain\Repository\KeywordsRepository
     */
    protected $keywordsRepository;

    /**
     * Cache instance
     *
     * @var \TYPO3\CMS\Core\Cache\Frontend\AbstractFrontend
     */
    protected $cache;


    /* CONSTRUCTOR & CACHE */


    /**
     * Use constructor DI and not @inject because it's best
     * @see: https://gist.github.com/NamelessCoder/3b2e5931a6c1af19f9c3f8b46e74f837
     *
     * @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
     * @param \ADWLM\Hisodat\Domain\Repository\SourcesRepository             $sourcesRepository
     * @param \ADWLM\Hisodat\Domain\Repository\ArchivesRepository            $archivesRepository
     * @param \ADWLM\Hisodat\Domain\Repository\RolesRepository               $rolesRepository
     * @param \ADWLM\Hisodat\Domain\Repository\KeywordsRepository            $keywordsRepository
     */
    public function __construct(
        \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager,
        \ADWLM\Hisodat\Domain\Repository\SourcesRepository $sourcesRepository,
        \ADWLM\Hisodat\Domain\Repository\ArchivesRepository $archivesRepository,
        \ADWLM\Hisodat\Domain\Repository\RolesRepository $rolesRepository,
        \ADWLM\Hisodat\Domain\Repository\KeywordsRepository $keywordsRepository
    )
    {
        parent::__construct($configurationManager);
        $this->sourcesRepository = $sourcesRepository;
        $this->archivesRepository = $archivesRepository;
        $this->rolesRepository = $rolesRepository;
        $this->keywordsRepository = $keywordsRepository;
        $this->initializeCache();
    }

    /**
     * Initializes the uid cache for the show action.
     */
    protected function initializeCache()
    {
        try {
            $this->cache = GeneralUtility::makeInstance(CacheManager::class)->getCache('tx_hisodat_uidcache');
        } catch (NoSuchCacheException $e) {
            $this->cache = GeneralUtility::makeInstance(CacheManager::class)->create(
                'tx_hisodat_uidcache',
                $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['tx_hisodat_uidcache']['frontend'],
                $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['tx_hisodat_uidcache']['backend'],
                $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['tx_hisodat_uidcache']['options']
            );
        }
    }


    /* INITIALIZE */


    /**
     * Initialization of general controller settings and arguments.
     */
    public function initializeAction()
    {

        // merge incoming arguments with plugin settings
        $arguments = $this->request->getArguments();
        if ($arguments['orderBy'] > 0) {
            $this->settings['orderBy'] = (int)$arguments['orderBy'];
        }
        if ($arguments['ascDesc'] > 0) {
            $this->settings['ascDesc'] = (int)$arguments['ascDesc'];
        }
        if ($arguments['itemsPerPage'] > 0 && $arguments['itemsPerPage'] < 101) {
            $this->settings['itemsPerPage'] = (int)$arguments['itemsPerPage'];
        }

        // transfer pagination values into settings and arguments
        if ($arguments['currentPage'] > 0) {
            $this->request->setArgument('@widget_0', array('currentPage' => (int)$arguments['currentPage']));
            $this->settings['pagination']['currentPage'] = (int)$arguments['currentPage'];
            $this->settings['pagination']['lowerValue'] = (($this->settings['pagination']['currentPage'] - 1) * $this->settings['itemsPerPage']) + 1;
        } else {
            $this->settings['pagination']['currentPage'] = 1;
            $this->settings['pagination']['lowerValue'] = 1;
        }
        // the case when upperValue is greater than total has to be dealt with in each action since the total count of displayed items is needed for the calculation
        $this->settings['pagination']['upperValue'] = ($this->settings['pagination']['lowerValue'] + $this->settings['itemsPerPage']) - 1;

        // if querystring argument exists, convert it back to original search request arguments
        if ($this->request->hasArgument('query')) {
            $queryComponents = Search::querystringToArguments($arguments['query']);
        }

        if (!empty($queryComponents)) {
            foreach ($queryComponents as $key => $value) {
                $this->request->setArgument($key, $value);
            }
        }

    }


    /* LIST */


    /**
     * Displays a list of sources (cached).
     */
    public function listAction()
    {

        // find sources
        $sources = $this->sourcesRepository->findAllInPidsWithOrdering($this->settings);
        $this->view->assign('sources', $sources);

        // modifications to settings
        $this->settings['pagination']['total'] = $sources->count();
        if ($this->settings['pagination']['upperValue'] > $this->settings['pagination']['total']) {
            $this->settings['pagination']['upperValue'] = $this->settings['pagination']['total'];
        }
        $this->view->assign('settings', $this->settings);

        // assign current arguments
        $this->view->assign('arguments', $this->request->getArguments());

        // current settings
        $this->view->assign('settings', $this->settings);
    }


    /* SHOW */


    /**
     * Displays a single source (cached) with a pagination through the current set. To make the single view pagination as
     * efficient as possible, the uids of the current set are cached as CSV list in the current sorting order on first display
     * of a single source; using a cache prevents having to do a findAll on the sources repository with each display of a
     * single source.
     *
     * @param \ADWLM\Hisodat\Domain\Model\Sources $source
     */
    public function showAction(\ADWLM\Hisodat\Domain\Model\Sources $source)
    {

        // current source
        $this->view->assign('source', $source);

        // single view pagination is based on cached lists of uids
        $currentSorting = $this->settings['orderBy'] . $this->settings['ascDesc'];
        $currentIdentifier = sha1('tx_hisodat_' . $GLOBALS['TSFE']->id . '_' . $currentSorting);
        $sourceUid = $source->getUid();

        // test if there is a cache for the current sorting
        if ($uids = $this->cache->get($currentIdentifier)) {
            // yes, get pagination values
            $paginationValues = Pagination::getValuesFromCsv($sourceUid, $uids);
            // otherwise create a cache for the current sorting
        } else {
            // get all sources from repository
            $sources = $this->sourcesRepository->findAllInPidsWithOrdering($this->settings, true);
            if (count($sources) > 0) {
                // and collect their uids
                $uids = array();
                foreach ($sources as $source) {
                    $uids[] = $source['uid'];
                }
                $uids = implode(',', $uids);
                // write the cache
                $tags = array(0 => 'tx_hisodat_' . $GLOBALS['TSFE']->id . '_' . $currentIdentifier);
                $lifetime = 31536000;
                $this->cache->set($currentIdentifier, $uids, $tags, $lifetime);
            }
            // and get the pagination values
            $paginationValues = Pagination::getValuesFromCsv($sourceUid, $uids);
        }
        // set the pagination
        if (is_array($paginationValues)) {
            ArrayUtility::mergeRecursiveWithOverrule($this->settings['pagination'], $paginationValues);
        }

        // arguments
        $this->view->assign('arguments', $this->request->getArguments());

        // reassign the new settings
        $this->view->assign('settings', $this->settings);
    }


    /* SORT */


    /**
     * Sorts a list of sources (converts POSTed sorting arguments to GET and redirects to the calling action).
     * The "real" sorting happens in the sources repository according to the submitted arguments.
     */
    public function sortAction()
    {

        // get and clean current arguments
        $arguments = $this->request->getArguments();
        unset($arguments['submit']);
        if (array_key_exists('searchstrings', $arguments)) {
            unset($arguments['searchstrings']);
        }
        if (array_key_exists('keywords', $arguments)) {
            unset($arguments['keywords']);
        }
        if (array_key_exists('startDate', $arguments)) {
            unset($arguments['startDate']);
        }
        if (array_key_exists('endDate', $arguments)) {
            unset($arguments['endDate']);
        }
        if (array_key_exists('archives', $arguments)) {
            unset($arguments['archives']);
        }
        if (array_key_exists('signatures', $arguments)) {
            unset($arguments['signatures']);
        }
        if (array_key_exists('pages', $arguments)) {
            unset($arguments['pages']);
        }
        if (array_key_exists('onlyWithImages', $arguments)) {
            unset($arguments['onlyWithImages']);
        }

        // get current referrer
        $referrer = $this->request->getInternalArgument('__referrer');

        // redirect to the calling action using the referrer; the action will in turn consult the repository with new sorting settings
        $this->redirect($referrer['@action'], $referrer['@controller'], null, $arguments, $this->settings['targetPid']);
    }


    /* SEARCH */


    /**
     * Displays searchforms for objects. Depending on the searchmode, a different template is used.
     * The searchmode can also be switched by the searchMode argument in the template.
     */
    public function searchformAction()
    {
        if ($this->request->hasArgument('searchMode')) {
            $searchMode = $this->request->getArgument('searchMode');
        } else {
            $searchMode = $this->settings['searchMode'];
        }
        switch ($searchMode) {
            case 10:
                $this->forward('quicksearchform', null, null, $this->request->getArguments());
                break;

            case 20:
                $this->forward('expertsearchform', null, null, $this->request->getArguments());
                break;

            default:
                $this->forward('quicksearchform', null, null, $this->request->getArguments());
                break;
        }
    }

    /**
     * Displays the quicksearch form.
     */
    public function quicksearchformAction()
    {
        // current arguments
        $this->view->assign('arguments', $this->request->getArguments());

        // current settings
        $this->view->assign('settings', $this->settings);
    }


    /**
     * Displays the expert searchform
     */
    public function expertsearchformAction()
    {
        // assign current arguments
        $this->view->assign('arguments', $this->request->getArguments());

        // current settings
        $this->view->assign('settings', $this->settings);

        // archives
        $this->view->assign('archives',
            $this->archivesRepository->findAllInPids($this->settings['recordPids']['archives']));

        // keywords
        $this->view->assign('keywords',
            $this->keywordsRepository->findAllInPidsWithTypes($this->settings['recordPids']['keywords'],
                array(0 => 0, 1 => 40)));

        // roles
        $roles = $this->rolesRepository->findAllInPidsWithTypes($this->settings['recordPids']['roles'], 0);
        if ($roles) {
            $this->view->assign('roles', array_merge(array(0 => ''), $roles->toArray()));
        }
    }


    /**
     * Performs a combined search on the sources repository possibly using a fulltext index.
     *
     * @param \array   $searchstrings
     * @param \array   $keywords
     * @param \string  $startDate
     * @param \string  $endDate
     * @param \array   $pages
     * @param \string  $signatures
     * @param \array   $archives
     * @param \boolean $onlyWithImages
     *
     * @validate $searchstrings \ADWLM\Hisodat\Domain\Validator\SearchstringsValidator(regularExpression = "/^[\.\,\"\'\-\*\p{L}\p{M}\p{N}\p{Sk}\s]*$/u", allowEmpty = TRUE, minLength = 3)
     * @validate $keywords \ADWLM\Hisodat\Domain\Validator\ArrayValuesValidator(type = digit)
     * @Extbase\Validate("\ADWLM\Hisodat\Domain\Validator\DateRangeValidator", options={"minDate": 800, "maxDate": 1600}", param="startDate")
     * @Extbase\Validate("\ADWLM\Hisodat\Domain\Validator\DateRangeValidator", options={"minDate": 800, "maxDate": 1600}, param="endDate")
     * @validate $pages \ADWLM\Hisodat\Domain\Validator\ArrayValuesValidator(type = digit)
     * @validate $signatures regularExpression(regularExpression="/^[\.\,\"\'\-\p{L}\p{M}\p{N}\p{Sk}\s]*$/u")
     * @validate $archives \ADWLM\Hisodat\Domain\Validator\ArrayValuesValidator(type = digit)
     * @validate $onlyWithImages \ADWLM\Hisodat\Domain\Validator\TrueOrEmptyValidator
     */
    public function searchresultAction(
        $searchstrings = array(),
        $keywords = array(),
        $startDate = '',
        $endDate = '',
        $pages = array(),
        $signatures = '',
        $archives = array(),
        $onlyWithImages = NULL
    ) {

        // set arguments for search
        $queryArguments = array(
            'searchstrings' => $searchstrings,
            'keywords' => $keywords,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'pages' => $pages,
            'signatures' => $signatures,
            'archives' => $archives,
            'onlyWithImages' => $onlyWithImages,
        );

        // perform raw fulltext query and - if sources are found - fetch objects by uids
        $start = microtime(true);
        $searchresult = $this->sourcesRepository->findByFulltext($queryArguments, $this->settings);
        if ($searchresult) {
            $sources = $this->sourcesRepository->findByUids(implode(',', $searchresult), $this->settings);
        }
        $end = microtime(true);

        // assign sources
        $this->view->assign('sources', $sources);

        // initialize and assign $searchData array that contains meta information for the view
        $searchData = array();
        $searchData['querytime'] = $end - $start;
        $searchData['searchwords'] = Search::collectSearchwords($searchstrings);
        $searchData['total'] = count($searchresult);
        $this->view->assign('searchData', $searchData);

        // and assign arguments to view
        $this->request->setArgument('query', Search::argumentsToQuerystring($queryArguments));
        $this->view->assign('arguments', $this->request->getArguments());

        // assign modified settings
        $this->settings['pagination']['total'] = count($searchresult);
        if ($this->settings['pagination']['upperValue'] > $this->settings['pagination']['total']) {
            $this->settings['pagination']['upperValue'] = $this->settings['pagination']['total'];
        }
        $this->view->assign('settings', $this->settings);
    }


    /**
     * Displays a single match from a searchresult. Has to do the fulltext query again for singleview pagination.
     * Therefore arguments need to be validated just like with the searchresult action.
     *
     * @param \ADWLM\Hisodat\Domain\Model\Sources  $source
     * @param \array                               $searchstrings
     * @param \array                               $keywords
     * @param \string                              $startDate
     * @param \string                              $endDate
     * @param \array                               $pages
     * @param \string                              $signatures
     * @param \array                               $archives
     * @param \boolean                             $onlyWithImages
     *
     * @validate $searchstrings \ADWLM\Hisodat\Domain\Validator\SearchstringsValidator(regularExpression = "/^[\.\,\"\'\-\*\p{L}\p{M}\p{N}\p{Sk}\s]*$/u", allowEmpty = TRUE, minLength = 3)
     * @validate $keywords \ADWLM\Hisodat\Domain\Validator\ArrayValuesValidator(type = digit)
     * @Extbase\Validate("\ADWLM\Hisodat\Domain\Validator\DateRangeValidator", options={"minDate": 800, "maxDate": 1600}", param="startDate")
     * @Extbase\Validate("\ADWLM\Hisodat\Domain\Validator\DateRangeValidator", options={"minDate": 800, "maxDate": 1600}, param="endDate")
     * @validate $pages \ADWLM\Hisodat\Domain\Validator\ArrayValuesValidator(type = digit)
     * @validate $signatures regularExpression(regularExpression="/^[\.\,\"\'\-\p{L}\p{M}\p{N}\p{Sk}\s]*$/u")
     * @validate $archives \ADWLM\Hisodat\Domain\Validator\ArrayValuesValidator(type = digit)
     * @validate $onlyWithImages \ADWLM\Hisodat\Domain\Validator\TrueOrEmptyValidator
     *
     * @return string The rendered view
     */
    public function searchdetailsAction(
        \ADWLM\Hisodat\Domain\Model\Sources $source,
        $searchstrings = array(),
        $keywords = array(),
        $startDate = '',
        $endDate = '',
        $pages = array(),
        $signatures = '',
        $archives = array(),
        $onlyWithImages = NULL
    ) {

        // get request arguments
        $arguments = $this->request->getArguments();

        // get searchresult again for singleview pagination
        $start = microtime(true);
        $searchresult = $this->sourcesRepository->findByFulltext($arguments, $this->settings);
        $end = microtime(true);

        $searchData = array();
        $searchData['querytime'] = $end - $start;
        $searchData['searchwords'] = Search::collectSearchwords($searchstrings);
        $searchData['total'] = count($searchresult);
        $this->view->assign('searchData', $searchData);

        // current source
        $this->view->assign('source', $source);

        // arguments
        $this->view->assign('arguments', $arguments);

        // reassign settings
        $paginationValues = Pagination::getValuesFromCsv($source->getUid(),
            implode(',', $searchresult));
        if (is_array($paginationValues)) {
            $this->settings['pagination'] = $this->settings['pagination'] + $paginationValues;
        }
        $this->view->assign('settings', $this->settings);
    }
}
