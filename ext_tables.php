<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

// TYPOSCRIPT
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript',
    'HISODAT: Base Application');

// REGISTER PLUGINS
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'ADWLM.' . $_EXTKEY,
    'Sources',
    'HISODAT: Sources'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'ADWLM.' . $_EXTKEY,
    'Registers',
    'HISODAT: Registers'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'ADWLM.' . $_EXTKEY,
    'Search',
    'HISODAT: Search'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'ADWLM.' . $_EXTKEY,
    'Resolver',
    'HISODAT: URI Resolver'
);

// FLEXFORMS FOR PLUGINS
$TCA['tt_content']['types']['list']['subtypes_addlist']['hisodat_sources'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('hisodat_sources', 'FILE:EXT:' . $_EXTKEY . '/Configuration/Flexforms/SourcesPlugin.xml');

$TCA['tt_content']['types']['list']['subtypes_addlist']['hisodat_search'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('hisodat_search', 'FILE:EXT:' . $_EXTKEY . '/Configuration/Flexforms/SearchPlugin.xml');

$TCA['tt_content']['types']['list']['subtypes_addlist']['hisodat_registers'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('hisodat_registers', 'FILE:EXT:' . $_EXTKEY . '/Configuration/Flexforms/RegistersPlugin.xml');

// TABLE CONFIGURATION

// SOURCES
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hisodat_domain_model_sources', 'EXT:hisodat/Resources/Private/Language/locallang_csh_tx_hisodat_domain_model_sources.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hisodat_domain_model_sources');

// DATERANGES
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hisodat_domain_model_dateranges', 'EXT:hisodat/Resources/Private/Language/locallang_csh_tx_hisodat_domain_model_dateranges.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hisodat_domain_model_dateranges');

// PERSONS
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hisodat_domain_model_persons', 'EXT:hisodat/Resources/Private/Language/locallang_csh_tx_hisodat_domain_model_persons.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hisodat_domain_model_persons');

// EVENTS
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hisodat_domain_model_events', 'EXT:hisodat/Resources/Private/Language/locallang_csh_tx_hisodat_domain_model_events.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hisodat_domain_model_events');

// LOCALITIES
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hisodat_domain_model_localities', 'EXT:hisodat/Resources/Private/Language/locallang_csh_tx_hisodat_domain_model_localities.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hisodat_domain_model_localities');

// ENTITIES
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hisodat_domain_model_entities', 'EXT:hisodat/Resources/Private/Language/locallang_csh_tx_hisodat_domain_model_entities.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hisodat_domain_model_entities');

// ARCHIVES
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hisodat_domain_model_archives', 'EXT:hisodat/Resources/Private/Language/locallang_csh_tx_hisodat_domain_model_archives.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hisodat_domain_model_archives');

// ROLES
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hisodat_domain_model_roles', 'EXT:hisodat/Resources/Private/Language/locallang_csh_tx_hisodat_domain_model_roles.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hisodat_domain_model_roles');

// KEYWORDS
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hisodat_domain_model_keywords', 'EXT:hisodat/Resources/Private/Language/locallang_csh_tx_hisodat_domain_model_keywords.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hisodat_domain_model_keywords');

// RELATIONS
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hisodat_domain_model_relations', 'EXT:hisodat/Resources/Private/Language/locallang_csh_tx_hisodat_domain_model_relations.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hisodat_domain_model_relations');

// GEODATA
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hisodat_domain_model_geodata', 'EXT:hisodat/Resources/Private/Language/locallang_csh_tx_hisodat_domain_model_geodata.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hisodat_domain_model_geodata');
