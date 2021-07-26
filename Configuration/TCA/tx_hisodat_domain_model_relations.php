<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

return array(
    'ctrl' => array(
        'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations',
        'label' => 'relation_type',
#        'label_userFunc' => 'ADWLM\Hisodat\Utility\Backend\LabelUtility->relationsLabel',
        'dividers2tabs' => true,
        'type' => 'relation_type',
        'default_sortby' => 'ORDER BY relation_type',
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
        'iconfile' => 'EXT:hisodat/Resources/Public/Icons/tx_hisodat_domain_model_relations.png',
    ),
    'interface' => array(
        'showRecordFieldList' => '
            sys_language_uid,
            l10n_parent,
            l10n_diffsource,
            persistent_identifier,
            relation_type,
            role,
            date_range,
            geodata,
            source,
            person,
            entity,
            locality,
            event,
            source_symmetric,
            person_symmetric,
            entity_symmetric,
            locality_symmetric,
            event_symmetric,
            description
        ',
    ),
    'types' => array(
        '0' => array('showitem' => 'relation_type'),
        // a source relates to a person at a specific time at a specific locality/geodata during a specific event
        '10' => array(
            'showitem' => '
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.div1,
                relation_type,
                persistent_identifier,
                role,
                date_range,
                source,
                person,
                locality,
                geodata,
                event,
                description,
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model.language,
                sys_language_uid,
                l10n_parent,
                l10n_diffsource,
        '
        ),
        // a source relates to a locality at a specific time during a specific event
        '20' => array(
            'showitem' => '
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.div1,
                relation_type,
                persistent_identifier,
                role,
                date_range,
                source,
                locality,
                geodata,
                event,
                description,
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model.language,
                sys_language_uid,
                l10n_parent,
                l10n_diffsource,
        '
        ),
        // a source relates to an entitiy at a specific time at a specific locality/geodata during a specific event
        '30' => array(
            'showitem' => '
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.div1,
                relation_type,
                persistent_identifier,
                role,
                date_range,
                source,
                entity,
                locality,
                geodata,
                event,
                description,
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model.language,
                sys_language_uid,
                l10n_parent,
                l10n_diffsource,
        '
        ),
        // a source relates to an event at a specific time at a specific locality/geodata
        '40' => array(
            'showitem' => '
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.div1,
                relation_type,
                persistent_identifier,
                role,
                date_range,
                source,
                event,
                locality,
                geodata,
                description,
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model.language,
                sys_language_uid,
                l10n_parent,
                l10n_diffsource,
        '
        ),
        // a source relates to a source at a specific time at a specific locality/geodata during a specific event
        '50' => array(
            'showitem' => '
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.div1,
                relation_type,
                persistent_identifier,
                role,
                date_range,
                source,
                source_symmetric,
                locality,
                geodata,
                event,
                description,
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model.language,
                sys_language_uid,
                l10n_parent,
                l10n_diffsource,
        '
        ),
        // a person relates to a locality at a specific time during a specific event (drawn from a source)
        '110' => array(
            'showitem' => '
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.div1,
                relation_type,
                persistent_identifier,
                role,
                date_range,
                person,
                locality,
                geodata,
                event,
                source,
                description,
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model.language,
                sys_language_uid,
                l10n_parent,
                l10n_diffsource,
        '
        ),
        // a person relates to an entitiy at a specific time at a specific locality/geodata during a specific event (drawn from a source)
        '120' => array(
            'showitem' => '
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.div1,
                relation_type,
                persistent_identifier,
                role,
                date_range,
                person,
                entity,
                locality,
                geodata,
                event,
                source,
                description,
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model.language,
                sys_language_uid,
                l10n_parent,
                l10n_diffsource,
        '
        ),
        // a person relates to an event at a specific time at a specific locality/geodata (drawn from a source)
        '130' => array(
            'showitem' => '
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.div1,
                relation_type,
                persistent_identifier,
                role,
                date_range,
                person,
                event,
                locality,
                geodata,
                source,
                description,
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model.language,
                sys_language_uid,
                l10n_parent,
                l10n_diffsource,
        '
        ),
        // a person relates to a person at a specific time at a specific locality/geodata during a specific event (drawn from a source)
        '140' => array(
            'showitem' => '
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.div1,
                relation_type,
                persistent_identifier,
                role,
                date_range,
                person,
                person_symmetric,
                locality,
                geodata,
                event,
                source,
                description,
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model.language,
                sys_language_uid,
                l10n_parent,
                l10n_diffsource,
        '
        ),
        // a locality relates to an entitiy at a specific time during a specific event (drawn from a source)
        '210' => array(
            'showitem' => '
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.div1,
                relation_type,
                persistent_identifier,
                role,
                date_range,
                locality,
                geodata,
                entity,
                event,
                source,
                description,
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model.language,
                sys_language_uid,
                l10n_parent,
                l10n_diffsource,
        '
        ),
        // a locality relates to an event at a specific time (drawn from a source)
        '220' => array(
            'showitem' => '
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.div1,
                relation_type,
                persistent_identifier,
                role,
                date_range,
                locality,
                geodata,
                event,
                source,
                description,
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model.language,
                sys_language_uid,
                l10n_parent,
                l10n_diffsource,
        '
        ),
        // a locality relates to another locality at a specific time during a specific event (drawn from a source)
        '230' => array(
            'showitem' => '
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.div1,
                relation_type,
                persistent_identifier,
                role,
                locality,
                locality_symmetric,
                geodata,
                event,
                source,
                description,
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model.language,
                sys_language_uid,
                l10n_parent,
                l10n_diffsource,
        '
        ),
        // an entity relates to an event at a specific time at a specific locality/geodata (drawn from a source)
        '310' => array(
            'showitem' => '
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.div1,
                relation_type,
                persistent_identifier,
                role,
                date_range,
                entity,
                event,
                locality,
                geodata,
                source,
                description,
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model.language,
                sys_language_uid,
                l10n_parent,
                l10n_diffsource,
        '
        ),
        // an entity relates to another entitiy at a specific time at a specific locality/geodata during a specific event (drawn from a source)
        '320' => array(
            'showitem' => '
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.div1,
                relation_type,
                persistent_identifier,
                role,
                date_range,
                entity,
                entity_symmetric,
                locality,
                geodata,
                event,
                source,
                description,
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model.language,
                sys_language_uid,
                l10n_parent,
                l10n_diffsource,
        '
        ),
        // an event relates to another event at a specific time at a specific locality/geodata (drawn from a source)
        '410' => array(
            'showitem' => '
            --div--;LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.div1,
                relation_type,
                persistent_identifier,
                role,
                date_range,
                event,
                event_symmetric,
                locality,
                geodata,
                source,
                description,
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
                'foreign_table' => 'tx_hisodat_domain_model_relations',
                'foreign_table_where' => 'AND tx_hisodat_domain_model_relations.uid=###REC_FIELD_l10n_parent### AND tx_hisodat_domain_model_relations.sys_language_uid IN (-1,0)',
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
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.persistent_identifier',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,unique'
            )
        ),
        'relation_type' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.relation_type',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => array(
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.relation_type.I.10',
                        '10'
                    ),
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.relation_type.I.20',
                        '20'
                    ),
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.relation_type.I.30',
                        '30'
                    ),
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.relation_type.I.40',
                        '40'
                    ),
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.relation_type.I.50',
                        '50'
                    ),
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.relation_type.I.110',
                        '110'
                    ),
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.relation_type.I.120',
                        '120'
                    ),
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.relation_type.I.130',
                        '130'
                    ),
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.relation_type.I.140',
                        '140'
                    ),
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.relation_type.I.210',
                        '210'
                    ),
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.relation_type.I.220',
                        '220'
                    ),
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.relation_type.I.230',
                        '230'
                    ),
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.relation_type.I.310',
                        '310'
                    ),
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.relation_type.I.320',
                        '320'
                    ),
                    array(
                        'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.relation_type.I.410',
                        '410'
                    ),
                ),
                'size' => 1,
                'maxitems' => 1,
                'eval' => 'required',
#                'itemsProcFunc' => 'ADWLM\Hisodat\Utility\Backend\ItemUtility->possibleItemsForRelation',
            )
        ),
        'description' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.description',
            'config' => array(
                'type' => 'text',
                'cols' => '30',
                'rows' => '5',
                'eval' => 'trim'
            )
        ),
        'source' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.source',
            'config' => array(
                'type' => 'group',
                'allowed' => 'tx_hisodat_domain_model_sources',
                // prevent http://wiki.typo3.org/Exception/CMS/1353170925
                'foreign_table' => 'tx_hisodat_domain_model_sources',
                'internal_type' => 'db',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'suggestOptions' => array(
                    'default' => array(
                        'pidList' => '###CURRENT_PID###',
                    ),
                ),
                'fieldControl' => array(
                    'editPopup' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_tca_wizards.edit',
                        ),
                    ),
                    'listModule' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_tca_wizards.list',
                            'table' => 'tx_hisodat_domain_model_sources',
                            'pid' => '###CURRENT_PID###',
                        ),
                    ),
                ),
            ),
        ),
        'person' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.person',
            'config' => array(
                'type' => 'group',
                'allowed' => 'tx_hisodat_domain_model_persons',
                // prevent http://wiki.typo3.org/Exception/CMS/1353170925
                'foreign_table' => 'tx_hisodat_domain_model_persons',
                'internal_type' => 'db',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'suggestOptions' => array(
                    'default' => array(
                        'pidList' => '###CURRENT_PID###',
                    ),
                ),
                'fieldControl' => array(
                    'editPopup' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_tca_wizards.edit',
                        ),
                    ),
                    'listModule' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_tca_wizards.list',
                            'table' => 'tx_hisodat_domain_model_persons',
                            'pid' => '###CURRENT_PID###',
                        ),
                    ),
                ),
            ),
        ),
        'entity' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.entity',
            'config' => array(
                'type' => 'group',
                'allowed' => 'tx_hisodat_domain_model_entities',
                // prevent http://wiki.typo3.org/Exception/CMS/1353170925
                'foreign_table' => 'tx_hisodat_domain_model_entities',
                'internal_type' => 'db',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'suggestOptions' => array(
                    'default' => array(
                        'pidList' => '###CURRENT_PID###',
                    ),
                ),
                'fieldControl' => array(
                    'editPopup' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_tca_wizards.edit',
                        ),
                    ),
                    'listModule' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_tca_wizards.list',
                            'table' => 'tx_hisodat_domain_model_entities',
                            'pid' => '###CURRENT_PID###',
                        ),
                    ),
                ),
            ),
        ),
        'locality' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.locality',
            'config' => array(
                'type' => 'group',
                'allowed' => 'tx_hisodat_domain_model_localities',
                // prevent http://wiki.typo3.org/Exception/CMS/1353170925
                'foreign_table' => 'tx_hisodat_domain_model_localities',
                'internal_type' => 'db',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'suggestOptions' => array(
                    'default' => array(
                        'pidList' => '###CURRENT_PID###',
                    ),
                ),
                'fieldControl' => array(
                    'editPopup' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_tca_wizards.edit',
                        ),
                    ),
                    'listModule' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_tca_wizards.list',
                            'table' => 'tx_hisodat_domain_model_localities',
                            'pid' => '###CURRENT_PID###',
                        ),
                    ),
                ),
            ),
        ),
        'event' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.event',
            'config' => array(
                'type' => 'group',
                'allowed' => 'tx_hisodat_domain_model_events',
                // prevent http://wiki.typo3.org/Exception/CMS/1353170925
                'foreign_table' => 'tx_hisodat_domain_model_events',
                'internal_type' => 'db',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'suggestOptions' => array(
                    'default' => array(
                        'pidList' => '###CURRENT_PID###',
                    ),
                ),
                'fieldControl' => array(
                    'editPopup' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_tca_wizards.edit',
                        ),
                    ),
                    'listModule' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_tca_wizards.list',
                            'table' => 'tx_hisodat_domain_model_events',
                            'pid' => '###CURRENT_PID###',
                        ),
                    ),
                ),
            ),
        ),
        'source_symmetric' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.source_symmetric',
            'config' => array(
                'type' => 'group',
                'allowed' => 'tx_hisodat_domain_model_sources',
                // prevent http://wiki.typo3.org/Exception/CMS/1353170925
                'foreign_table' => 'tx_hisodat_domain_model_sources',
                'internal_type' => 'db',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'suggestOptions' => array(
                    'default' => array(
                        'pidList' => '###CURRENT_PID###',
                    ),
                ),
                'fieldControl' => array(
                    'editPopup' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_tca_wizards.edit',
                        ),
                    ),
                    'listModule' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_tca_wizards.list',
                            'table' => 'tx_hisodat_domain_model_sources',
                            'pid' => '###CURRENT_PID###',
                        ),
                    ),
                ),
            ),
        ),
        'person_symmetric' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.person_symmetric',
            'config' => array(
                'type' => 'group',
                'allowed' => 'tx_hisodat_domain_model_persons',
                // prevent http://wiki.typo3.org/Exception/CMS/1353170925
                'foreign_table' => 'tx_hisodat_domain_model_persons',
                'internal_type' => 'db',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'suggestOptions' => array(
                    'default' => array(
                        'pidList' => '###CURRENT_PID###',
                    ),
                ),
                'fieldControl' => array(
                    'editPopup' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_tca_wizards.edit',
                        ),
                    ),
                    'listModule' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_tca_wizards.list',
                            'table' => 'tx_hisodat_domain_model_persons',
                            'pid' => '###CURRENT_PID###',
                        ),
                    ),
                ),
            ),
        ),
        'locality_symmetric' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.locality_symmetric',
            'config' => array(
                'type' => 'group',
                'allowed' => 'tx_hisodat_domain_model_localities',
                // prevent http://wiki.typo3.org/Exception/CMS/1353170925
                'foreign_table' => 'tx_hisodat_domain_model_localities',
                'internal_type' => 'db',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'suggestOptions' => array(
                    'default' => array(
                        'pidList' => '###CURRENT_PID###',
                    ),
                ),
                'fieldControl' => array(
                    'editPopup' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_tca_wizards.edit',
                        ),
                    ),
                    'listModule' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_tca_wizards.list',
                            'table' => 'tx_hisodat_domain_model_localities',
                            'pid' => '###CURRENT_PID###',
                        ),
                    ),
                ),
            ),
        ),
        'entity_symmetric' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.entity_symmetric',
            'config' => array(
                'type' => 'group',
                'allowed' => 'tx_hisodat_domain_model_entities',
                // prevent http://wiki.typo3.org/Exception/CMS/1353170925
                'foreign_table' => 'tx_hisodat_domain_model_entities',
                'internal_type' => 'db',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'suggestOptions' => array(
                    'default' => array(
                        'pidList' => '###CURRENT_PID###',
                    ),
                ),
                'fieldControl' => array(
                    'editPopup' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_tca_wizards.edit',
                        ),
                    ),
                    'listModule' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_tca_wizards.list',
                            'table' => 'tx_hisodat_domain_model_entity',
                            'pid' => '###CURRENT_PID###',
                        ),
                    ),
                ),
            ),
        ),
        'event_symmetric' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.event_symmetric',
            'config' => array(
                'type' => 'group',
                'allowed' => 'tx_hisodat_domain_model_events',
                // prevent http://wiki.typo3.org/Exception/CMS/1353170925
                'foreign_table' => 'tx_hisodat_domain_model_events',
                'internal_type' => 'db',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'suggestOptions' => array(
                    'default' => array(
                        'pidList' => '###CURRENT_PID###',
                    ),
                ),
                'fieldControl' => array(
                    'editPopup' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_tca_wizards.edit',
                        ),
                    ),
                    'listModule' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_tca_wizards.list',
                            'table' => 'tx_hisodat_domain_model_events',
                            'pid' => '###CURRENT_PID###',
                        ),
                    ),
                ),
            ),
        ),
        'role' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.role',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_hisodat_domain_model_roles',
                'foreign_table_where' => 'AND tx_hisodat_domain_model_roles.pid IN (###PAGE_TSCONFIG_IDLIST###) AND (FIND_IN_SET(###REC_FIELD_relation_type###,tx_hisodat_domain_model_roles.role_type) OR tx_hisodat_domain_model_roles.role_type=0) ORDER BY tx_hisodat_domain_model_roles.name',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'items' => array(
                    array('', 0),
                ),
                'fieldControl' => array(
                    'editPopup' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_tca_wizards.edit',
                        ),
                    ),
                    'listModule' => array(
                        'disabled' => false,
                        'options' => array(
                            'title' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_tca_wizards.list',
                            'table' => 'tx_hisodat_domain_model_roles',
                            'pid' => '###CURRENT_PID###',
                        ),
                    ),
                ),
            ),
        ),
        'date_range' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_relations.date_range',
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
        'geodata' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:hisodat/Resources/Private/Language/locallang_db.xml:tx_hisodat_domain_model_localities.geodata',
            'config' => array(
                'type' => 'inline',
                'foreign_field' => 'parent_record',
                'foreign_table_field' => 'ident',
                'foreign_table' => 'tx_hisodat_domain_model_geodata',
                'foreign_sortby' => 'sorting',
                'minitems' => 0,
                'maxitems' => 9999,
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
    ),
);
