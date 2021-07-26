<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

return array(
    'ctrl' => array(
        'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_roles',
        'label' => 'name',
        'default_sortby' => 'ORDER BY name',
        'dividers2tabs' => true,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'origUid' => 't3_origuid',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden'
        ),
        'searchFields' => 'name',
        'iconfile' => 'EXT:hisodat/Resources/Public/Icons/tx_hisodat_domain_model_roles.png'
    ),
    'interface' => array(
        'showRecordFieldList' => '
            sys_language_uid,
            l10n_parent,
            l10n_diffsource,
            name,
            description,
            role_type
        ',
    ),
    'types' => array(
        '1' => array(
            'showitem' => '
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_roles.div1,
                persistent_identifier,
                name,
                name_variants,
                description,
                role_type,
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model.language,
                sys_language_uid,
                l10n_parent,
                l10n_diffsource,
        '
        ),
    ),
    'palettes' => array(
        '1' => array('showitem' => ''),
    ),
    'columns' => array(
        'sys_language_uid' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => array(
                    array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages', -1),
                    array('LLL:EXT:lang/locallang_general.php:LGL.default_value', 0)
                )
            )
        ),
        'l10n_parent' => array(
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l10n_parent',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => array(
                    array('', 0),
                ),
                'foreign_table' => 'tx_hisodat_domain_model_roles',
                'foreign_table_where' => 'AND tx_hisodat_domain_model_roles.uid=###REC_FIELD_l10n_parent### AND tx_hisodat_domain_model_roles.sys_language_uid IN (-1,0)',
            )
        ),
        'l10n_diffsource' => array(
            'config' => array(
                'type' => 'passthrough'
            )
        ),
        't3ver_label' => array(
            'displayCond' => 'FIELD:t3ver_label:REQ:true',
            'label' => 'LLL:EXT:lang/locallang_general.php:LGL.versionLabel',
            'config' => array(
                'type' => 'none',
                'cols' => 27
            )
        ),
        'hidden' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
            'config' => array(
                'type' => 'check'
            )
        ),
        'persistent_identifier' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_roles.persistent_identifier',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,unique'
            )
        ),
        'role_type' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_roles.role_type',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectCheckBox',
                'items' => array(
//                    array('LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_roles.role_type.I.0', '0'),
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_roles.role_type.I.10',
                        '10'
                    ),
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_roles.role_type.I.20',
                        '20'
                    ),
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_roles.role_type.I.30',
                        '30'
                    ),
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_roles.role_type.I.40',
                        '40'
                    ),
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_roles.role_type.I.50',
                        '50'
                    ),
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_roles.role_type.I.110',
                        '110'
                    ),
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_roles.role_type.I.120',
                        '120'
                    ),
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_roles.role_type.I.130',
                        '130'
                    ),
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_roles.role_type.I.140',
                        '140'
                    ),
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_roles.role_type.I.210',
                        '210'
                    ),
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_roles.role_type.I.220',
                        '220'
                    ),
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_roles.role_type.I.230',
                        '230'
                    ),
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_roles.role_type.I.310',
                        '310'
                    ),
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_roles.role_type.I.320',
                        '320'
                    ),
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_roles.role_type.I.410',
                        '410'
                    ),
                ),
                'size' => 5,
                'maxitems' => 15,
            ),
        ),
        'name' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_roles.name',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            )
        ),
        'name_variants' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_roles.name_variants',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            )
        ),
        'description' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_roles.description',
            'config' => array(
                'type' => 'text',
                'cols' => '25',
                'rows' => '5',
            ),
        ),
    ),
);
