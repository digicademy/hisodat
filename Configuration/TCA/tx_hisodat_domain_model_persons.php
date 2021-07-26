<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

return array(
    'ctrl' => array(
        'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_persons',
        'label' => 'name',
        'label_alt' => 'name_variants',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'default_sortby' => 'ORDER BY name',
        'versioningWS' => true,
        'origUid' => 't3_origuid',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'dividers2tabs' => true,
        'enablecolumns' => array(
            'disabled' => 'hidden'
        ),
        'searchFields' => 'persistent_identifier,name,name_variants,titles',
        'iconfile' => 'EXT:hisodat/Resources/Public/Icons/tx_hisodat_domain_model_persons.png'
    ),
    'interface' => array(
        'showRecordFieldList' => '
            sys_language_uid,
            l10n_parent,
            l10n_diffsource,
            persistent_identifier,
            gender,
            name,
            name_variants,
            titles,
            description,
            images,
            date_range,
            relations,
            keywords
        ',
    ),
    'types' => array(
        '1' => array(
            'showitem' => '
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_persons.div1,
                hidden,
                persistent_identifier,
                name,
                name_variants,
                titles,
                gender,
                date_range,
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_persons.div2,
                relations,
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_persons.div3,
                keywords,
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_persons.div4,
                description,
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_persons.div5,
                images,
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model.language,
                sys_language_uid,
                l10n_parent,
                l10n_diffsource,
        ',
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
                'foreign_table' => 'tx_hisodat_domain_model_persons',
                'foreign_table_where' => 'AND tx_hisodat_domain_model_persons.uid=###REC_FIELD_l10n_parent### AND tx_hisodat_domain_model_persons.sys_language_uid IN (-1,0)',
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
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_persons.persistent_identifier',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,unique'
            )
        ),
        'gender' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_persons.gender',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => array(
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_persons.gender.I.1',
                        '1'
                    ),
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_persons.gender.I.2',
                        '2'
                    ),
                ),
                'eval' => 'required',
                'default' => '1',
            )
        ),
        'name' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_persons.name',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            )
        ),
        'name_variants' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_persons.name_variants',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            )
        ),
        'titles' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_persons.titles',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            )
        ),
        'description' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_persons.description',
            'config' => array(
                'type' => 'text',
                'enableRichtext' => true,
                'cols' => '30',
                'rows' => '5',
            )
        ),
        'images' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_persons.images',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('images', array(
                'appearance' => array(
                    'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference'
                ),
                'minitems' => 0,
                'maxitems' => 1,
                'overrideChildTca' => array(
                    'types' => array(
                        '0' => array(
                            'showitem' => '
                                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => array(
                            'showitem' => '
                                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                        ),
                    ),
                ),
            ),
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
        ),
        'date_range' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_localities.date_range',
            'config' => array(
                'type' => 'inline',
                'foreign_field' => 'parent_record',
                'foreign_table_field' => 'ident',
                'foreign_table' => 'tx_hisodat_domain_model_dateranges',
                'minitems' => 0,
                'maxitems' => 1,
                'appearance' => array(
                    'collapseAll' => 1,
                    'expandSingle' => 1,
                    'newRecordLinkPosition' => 'bottom',
                ),
                'behaviour' => array(
                    'disableMovingChildrenWithParent' => 1,
                ),
            )
        ),
        'relations' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_persons.relations',
            'config' => array(
                'type' => 'inline',
                'foreign_table' => 'tx_hisodat_domain_model_relations',
                'foreign_field' => 'person',
                'foreign_sortby' => 'person_sortby',
//                'foreign_label' => 'persons',
                'symmetric_field' => 'person_symmetric',
                'symmetric_sortby' => 'person_symmetric_sortby',
                'maxitems' => 9999,
                'appearance' => array(
                    'collapseAll' => 1,
                    'expandSingle' => 1,
                    'levelLinksPosition' => 'bottom',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ),
                'behaviour' => array(
                    'disableMovingChildrenWithParent' => 1,
                ),
            )
        ),
        'keywords' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_persons.keywords',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectTree',
                'foreign_table' => 'tx_hisodat_domain_model_keywords',
                'foreign_table_where' => 'AND tx_hisodat_domain_model_keywords.pid IN (###PAGE_TSCONFIG_IDLIST###) AND (FIND_IN_SET(\'0\', tx_hisodat_domain_model_keywords.keyword_type) OR FIND_IN_SET(\'10\', tx_hisodat_domain_model_keywords.keyword_type)) ORDER BY name',
                'renderMode' => 'tree',
                'treeConfig' => array(
                    'parentField' => 'parent_keyword',
                    'appearance' => array(
                        'nonSelectableLevels' => '0',
                        'expandAll' => false,
                        'showHeader' => true,
                    ),
                ),
                'MM' => 'tx_hisodat_keywords_mm',
                'MM_match_fields' => array(
                    'ident' => 'tx_hisodat_domain_model_persons',
                ),
                'size' => 20,
                'maxitems' => 99,
                'fieldControl' => array(
                    'addRecord' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_tca_wizards.add',
                            'table' => 'tx_hisodat_domain_model_keywords',
                            'pid' => '###CURRENT_PID###',
                            'setValue' => 'prepend',
                        ),
                    ),
                ),
            ),
        ),
    ),
);
