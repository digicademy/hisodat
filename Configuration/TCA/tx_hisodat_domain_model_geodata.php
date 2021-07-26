<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

return array(
    'ctrl' => array(
        'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_geodata',
        'label' => 'x',
        'label_alt' => 'y,z',
        'label_alt_force' => 1,
        'default_sortby' => 'ORDER BY parent_record',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => true,
        'versioningWS' => true,
        'origUid' => 't3_origuid',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden',
        ),
        'searchFields' => 'x,y,z',
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('hisodat') . 'Resources/Public/Icons/tx_hisodat_domain_model_geodata.png'
    ),
    'interface' => array(
        'showRecordFieldList' => '
            sys_language_uid,
            l10n_parent,
            l10n_diffsource,
            hidden,
            parent_record,
            ident,
            label,
            certainty,
            x,
            y,
            z
        ',
    ),
    'types' => array(
        '1' => array(
            'showitem' => '
            sys_language_uid,
            l10n_parent,
            l10n_diffsource,
            hidden,
            parent_record,
            label,
            certainty,
            x,
            y,
            z
        '
        ),
    ),
    'palettes' => array(
        '1' => array('showitem' => ''),
    ),
    'columns' => array(
        'sys_language_uid' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => array(
                    array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
                    array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
                ),
            ),
        ),
        'l10n_parent' => array(
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => array(
                    array('', 0),
                ),
                'foreign_table' => 'tx_hisodat_domain_model_geodata',
                'foreign_table_where' => 'AND tx_hisodat_domain_model_geodata.pid=###CURRENT_PID### AND tx_hisodat_domain_model_geodata.sys_language_uid IN (-1,0)',
            ),
        ),
        'l10n_diffsource' => array(
            'config' => array(
                'type' => 'passthrough',
            ),
        ),
        't3ver_label' => array(
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            )
        ),
        'hidden' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
            'config' => array(
                'type' => 'check',
            ),
        ),
        'label' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_geodata.label',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ),
        ),
        'certainty' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_geodata.certainty',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,int',
            ),
        ),
        'x' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_geodata.x',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => '0.00000000000000',
            ),
        ),
        'y' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_geodata.y',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => '0.00000000000000',
            ),
        ),
        'z' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_geodata.z',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => '0.00000000000000',
            ),
        ),
        'parent_record' => array(
            'config' => array(
                'type' => 'passthrough',
            ),
        ),
        'ident' => array(
            'config' => array(
                'type' => 'passthrough',
            ),
        ),
        'sorting' => array(
            'config' => array(
                'type' => 'passthrough',
            ),
        ),
    ),
);
