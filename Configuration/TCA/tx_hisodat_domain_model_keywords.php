<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

return array(
    'ctrl' => array(
        'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_keywords',
        'label' => 'name',
        'default_sortby' => 'ORDER BY name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
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
        'searchFields' => 'name, persistent_identifier, name_variants, description',
        'iconfile' => 'EXT:hisodat/Resources/Public/Icons/tx_hisodat_domain_model_keywords.png'
    ),
    'interface' => array(
        'showRecordFieldList' => '
            sys_language_uid,
            l10n_parent,
            l10n_diffsource,
            hidden,
            persistent_identifier,
            name,
            name_variants,
            description,
            keyword_type,
            parent_keyword,
            classification,
            see_other
        ',
    ),
    'types' => array(
        '1' => array(
            'showitem' => '
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_keywords.div1,
               hidden,
               persistent_identifier,
               name,
               name_variants,
               description,
               parent_keyword,
               keyword_type,
               classification,
               see_other,
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
                ),
            ),
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
                'foreign_table' => 'tx_hisodat_domain_model_keywords',
                'foreign_table_where' => 'AND tx_hisodat_domain_model_keywords.pid=###CURRENT_PID### AND tx_hisodat_domain_model_keywords.sys_language_uid IN (-1,0)',
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
                'size' => '30',
                'max' => '255',
            )
        ),
        'hidden' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
            'config' => array(
                'type' => 'check',
            ),
        ),
        'persistent_identifier' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_keywords.persistent_identifier',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,unique'
            )
        ),
        'name' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_keywords.name',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ),
        ),
        'name_variants' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_keywords.name_variants',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            )
        ),
        'description' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_keywords.description',
            'config' => array(
                'type' => 'text',
                'cols' => '30',
                'rows' => '5',
            ),
        ),
        'keyword_type' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_keywords.keyword_type',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectCheckBox',
                'items' => array(
                    array('LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_keywords.keyword_type.I.0', '0'),
                    array('LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_keywords.keyword_type.I.10', '10'),
                    array('LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_keywords.keyword_type.I.20', '20'),
                    array('LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_keywords.keyword_type.I.30', '30'),
                    array('LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_keywords.keyword_type.I.40', '40'),
                    array('LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_keywords.keyword_type.I.50', '50'),
                ),
                'size' => 5,
                'maxitems' => 5,
                'renderMode' => 'checkbox',
            ),
        ),
        'parent_keyword' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_keywords.parent_keyword',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_hisodat_domain_model_keywords',
                'foreign_table_where' => 'ORDER BY name',
                'items' => array(
                    array('', 0),
                ),
                'minitems' => 0,
                'maxitems' => 1,
                'fieldControl' => array(
                    'addRecord' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_tca_wizards.add',
                            'table' => 'tx_hisodat_domain_model_keywords',
                            'pid' => '###PAGE_TSCONFIG_IDLIST###',
                            'setValue' => 'prepend',
                        ),
                    ),
                    'editPopup' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_tca_wizards.edit',
                        ),
                    ),
                ),
            ),
        ),
        'classification' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_keywords.classification',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_hisodat_domain_model_keywords',
                'foreign_table_where' => 'ORDER BY name',
                'items' => array(
                    array('', 0),
                ),
                'minitems' => 0,
                'maxitems' => 1,
                'fieldControl' => array(
                    'addRecord' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_tca_wizards.add',
                            'table' => 'tx_hisodat_domain_model_keywords',
                            'pid' => '###PAGE_TSCONFIG_IDLIST###',
                            'setValue' => 'prepend',
                        ),
                    ),
                    'editPopup' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_tca_wizards.edit',
                        ),
                    ),
                ),
            ),
        ),
        'see_other' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_keywords.see_other',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_hisodat_domain_model_keywords',
                'foreign_table_where' => 'ORDER BY name',
                'items' => array(
                    array('', 0),
                ),
                'minitems' => 0,
                'maxitems' => 1,
                'fieldControl' => array(
                    'addRecord' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_tca_wizards.add',
                            'table' => 'tx_hisodat_domain_model_keywords',
                            'pid' => '###PAGE_TSCONFIG_IDLIST###',
                            'setValue' => 'prepend',
                        ),
                    ),
                    'editPopup' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_tca_wizards.edit',
                        ),
                    ),
                ),
            ),
        ),
    ),
);
