<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

// unserializing the configuration so we can use it here
$EXTCONF = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['hisodat']);

// CONFIGURE PLUGINS
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'ADWLM.' . $_EXTKEY,
    'Sources',
    array(
        'Sources' => 'list, show, sort',
    ),
    array(
        'Sources' => 'sort',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'ADWLM.' . $_EXTKEY,
    'Registers',
    array(
        'Registers' => 'list, search',
        'Persons' => 'show',
        'Localities' => 'show',
        'Entities' => 'show',
        'Events' => 'show',
        'Archives' => 'show',
        'Keywords' => 'show',
    ),
    array(
        'Registers' => 'search',
        'Persons' => '',
        'Localities' => '',
        'Entities' => '',
        'Events' => '',
        'Archives' => '',
        'Keywords' => '',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'ADWLM.' . $_EXTKEY,
    'Search',
    array(
        'Sources' => 'searchform, searchresult, searchdetails, sort, customSearchResult, customSearchDetails',
    ),
    array(
        'Sources' => 'searchform, searchresult, searchdetails, sort, customSearchResult, customSearchDetails',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'ADWLM.' . $_EXTKEY,
    'Resolver',
    array(
        'Resolver' => 'resolve',
    ),
    array(
        'Resolver' => 'resolve',
    )
);

// set the pid lists for the foreign_where clauses
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('
    tx_hisodat.ARCHIVES_PIDLIST = ' . $EXTCONF['ARCHIVES_PIDLIST'] . '
    tx_hisodat.KEYWORDS_PIDLIST = ' . $EXTCONF['KEYWORDS_PIDLIST'] . '
    tx_hisodat.PERSONS_PIDLIST = ' . $EXTCONF['PERSONS_PIDLIST'] . '
    tx_hisodat.LOCALITIES_PIDLIST = ' . $EXTCONF['LOCALITIES_PIDLIST'] . '
    tx_hisodat.SOURCES_PIDLIST = ' . $EXTCONF['SOURCES_PIDLIST'] . '
    tx_hisodat.ENTITIES_PIDLIST = ' . $EXTCONF['ENTITIES_PIDLIST'] . '
    tx_hisodat.EVENTS_PIDLIST = ' . $EXTCONF['EVENTS_PIDLIST'] . '
    tx_hisodat.MM_PID = ' . $EXTCONF['MM_PID'] . '
    <INCLUDE_TYPOSCRIPT: source="FILE:EXT:hisodat/Configuration/TSConfig/setup.txt">
');

// BACKEND RELATED
if (TYPO3_MODE == 'BE') {
    // register tcemain hooks
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] =
        'ADWLM\Hisodat\Hooks\Backend\DataHandler';
}

// register cache: setup taken from http://docs.typo3.org/typo3cms/CoreApiReference/CachingFramework/Developer/Index.html
if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['tx_hisodat_uidcache'])) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['tx_hisodat_uidcache'] = array();
}

if (!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['tx_hisodat_uidcache']['frontend'])) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['tx_hisodat_uidcache']['frontend'] = 'TYPO3\\CMS\\Core\\Cache\\Frontend\\StringFrontend';
}
