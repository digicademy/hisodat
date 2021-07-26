CREATE TABLE tx_hisodat_domain_model_archives (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    persistent_identifier varchar(255) DEFAULT '' NOT NULL,
    name varchar(255) DEFAULT '' NOT NULL,
    name_variants varchar(255) DEFAULT '' NOT NULL,
    description text NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

    t3_origuid int(11) DEFAULT '0' NOT NULL,
    t3ver_oid int(11) DEFAULT '0' NOT NULL,
    t3ver_id int(11) DEFAULT '0' NOT NULL,
    t3ver_wsid int(11) DEFAULT '0' NOT NULL,
    t3ver_label varchar(255) DEFAULT '' NOT NULL,
    t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_stage int(11) DEFAULT '0' NOT NULL,
    t3ver_count int(11) DEFAULT '0' NOT NULL,
    t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
    t3ver_move_id int(11) DEFAULT '0' NOT NULL,

    sys_language_uid int(11) DEFAULT '0' NOT NULL,
    l10n_parent int(11) DEFAULT '0' NOT NULL,
    l10n_diffsource mediumblob,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY t3ver_oid (t3ver_oid,t3ver_wsid),

    KEY persistent_identifier (persistent_identifier),
    KEY name (name),
    KEY name_variants (name)

) ENGINE=MyISAM;


CREATE TABLE tx_hisodat_domain_model_sources (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    persistent_identifier varchar(255) DEFAULT '' NOT NULL,
    identifier varchar(255) DEFAULT '' NOT NULL,
    title varchar(255) DEFAULT '' NOT NULL,
    abstract text NOT NULL,
    description text NOT NULL,
    incipit text NOT NULL,
    transcription text NOT NULL,
    verso_note varchar(255) DEFAULT '' NOT NULL,
    translation text NOT NULL,
    summary text NOT NULL,
    commentary text NOT NULL,
    annotations text NOT NULL,
    footnotes text NOT NULL,
    literature text NOT NULL,
    signature varchar(255) DEFAULT '' NOT NULL,
    signature_addition varchar(255) DEFAULT '' NOT NULL,
    archival_history text NOT NULL,
    images tinyblob NOT NULL,
    editor int(11) unsigned DEFAULT '0' NOT NULL,
    editor_comments text NOT NULL,

    date_range int(11) unsigned DEFAULT '0',
    archive int(11) unsigned DEFAULT '0' NOT NULL,
    relations int(11) unsigned DEFAULT '0' NOT NULL,
    keywords int(11) unsigned DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
    sorting int(11) unsigned DEFAULT '0' NOT NULL,

    t3_origuid int(11) DEFAULT '0' NOT NULL,
    t3ver_oid int(11) DEFAULT '0' NOT NULL,
    t3ver_id int(11) DEFAULT '0' NOT NULL,
    t3ver_wsid int(11) DEFAULT '0' NOT NULL,
    t3ver_label varchar(255) DEFAULT '' NOT NULL,
    t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_stage int(11) DEFAULT '0' NOT NULL,
    t3ver_count int(11) DEFAULT '0' NOT NULL,
    t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
    t3ver_move_id int(11) DEFAULT '0' NOT NULL,

    sys_language_uid int(11) DEFAULT '0' NOT NULL,
    l10n_parent int(11) DEFAULT '0' NOT NULL,
    l10n_diffsource mediumblob,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY t3ver_oid (t3ver_oid,t3ver_wsid),

    KEY archive (archive),
    KEY identifier (identifier),
    KEY persistent_identifier (persistent_identifier),
    KEY signature (signature),
    KEY signature_addition (signature_addition),

    FULLTEXT sources (persistent_identifier,identifier,title,abstract,description,incipit,transcription,verso_note,translation,summary,commentary,annotations,footnotes,literature,signature,archival_history)

) ENGINE=MyISAM;


CREATE TABLE tx_hisodat_domain_model_keywords (
    uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    persistent_identifier varchar(255) DEFAULT '' NOT NULL,
    name varchar(255) DEFAULT '' NOT NULL,
    name_variants varchar(255) DEFAULT '' NOT NULL,
    description text NOT NULL,
    keyword_type varchar(20) DEFAULT '' NOT NULL,

    parent_keyword int(11) unsigned DEFAULT '0' NOT NULL,
    classification int(11) unsigned DEFAULT '0' NOT NULL,
    see_other int(11) unsigned DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,

    t3_origuid int(11) DEFAULT '0' NOT NULL,
    t3ver_oid int(11) DEFAULT '0' NOT NULL,
    t3ver_id int(11) DEFAULT '0' NOT NULL,
    t3ver_wsid int(11) DEFAULT '0' NOT NULL,
    t3ver_label varchar(255) DEFAULT '' NOT NULL,
    t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_stage int(11) DEFAULT '0' NOT NULL,
    t3ver_count int(11) DEFAULT '0' NOT NULL,
    t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
    t3ver_move_id int(11) DEFAULT '0' NOT NULL,

    sys_language_uid int(11) DEFAULT '0' NOT NULL,
    l10n_parent int(11) DEFAULT '0' NOT NULL,
    l10n_diffsource mediumblob,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY t3ver_oid (t3ver_oid,t3ver_wsid),

    KEY persistent_identifier (persistent_identifier),
    KEY name (name),
    KEY name_variants (name_variants),
    KEY parent_keyword (parent_keyword),
    KEY classification (classification),
    KEY see_other (see_other),
    KEY keyword_type (keyword_type)

) ENGINE=MyISAM;


CREATE TABLE tx_hisodat_domain_model_roles (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    persistent_identifier varchar(255) DEFAULT '' NOT NULL,
    role_type varchar(255) DEFAULT '' NOT NULL,
    name varchar(255) DEFAULT '' NOT NULL,
    name_variants varchar(255) DEFAULT '' NOT NULL,
    description text NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,

    t3_origuid int(11) DEFAULT '0' NOT NULL,
    t3ver_oid int(11) DEFAULT '0' NOT NULL,
    t3ver_id int(11) DEFAULT '0' NOT NULL,
    t3ver_wsid int(11) DEFAULT '0' NOT NULL,
    t3ver_label varchar(255) DEFAULT '' NOT NULL,
    t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_stage int(11) DEFAULT '0' NOT NULL,
    t3ver_count int(11) DEFAULT '0' NOT NULL,
    t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
    t3ver_move_id int(11) DEFAULT '0' NOT NULL,

    sys_language_uid int(11) DEFAULT '0' NOT NULL,
    l10n_parent int(11) DEFAULT '0' NOT NULL,
    l10n_diffsource mediumblob,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY t3ver_oid (t3ver_oid,t3ver_wsid),

    KEY persistent_identifier (persistent_identifier),
    KEY name_variants (name_variants),
    KEY name (name),
    KEY role_type (role_type)

) ENGINE=MyISAM;


CREATE TABLE tx_hisodat_domain_model_persons (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    persistent_identifier varchar(255) DEFAULT '' NOT NULL,
    gender tinyint(4) DEFAULT '0' NOT NULL,
    name varchar(255) DEFAULT '' NOT NULL,
    name_variants text NOT NULL,
    titles varchar(255) DEFAULT '' NOT NULL,
    description text NOT NULL,
    images tinyblob NOT NULL,

    date_range int(11) unsigned DEFAULT '0',
    relations int(11) unsigned DEFAULT '0' NOT NULL,
    keywords int(11) unsigned DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

    t3_origuid int(11) DEFAULT '0' NOT NULL,
    t3ver_oid int(11) DEFAULT '0' NOT NULL,
    t3ver_id int(11) DEFAULT '0' NOT NULL,
    t3ver_wsid int(11) DEFAULT '0' NOT NULL,
    t3ver_label varchar(255) DEFAULT '' NOT NULL,
    t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_stage int(11) DEFAULT '0' NOT NULL,
    t3ver_count int(11) DEFAULT '0' NOT NULL,
    t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
    t3ver_move_id int(11) DEFAULT '0' NOT NULL,

    sys_language_uid int(11) DEFAULT '0' NOT NULL,
    l10n_parent int(11) DEFAULT '0' NOT NULL,
    l10n_diffsource mediumblob,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY t3ver_oid (t3ver_oid,t3ver_wsid),

    INDEX persistent_identifier (persistent_identifier),
    FULLTEXT names (name,name_variants),
    FULLTEXT persons (name,name_variants,titles,description)

) ENGINE=MyISAM;


CREATE TABLE tx_hisodat_domain_model_events (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    persistent_identifier varchar(255) DEFAULT '' NOT NULL,
    name varchar(255) DEFAULT '' NOT NULL,
    name_variants text NOT NULL,
    images tinyblob NOT NULL,
    description text NOT NULL,

    date_range int(11) unsigned DEFAULT '0',
    relations int(11) unsigned DEFAULT '0' NOT NULL,
    keywords int(11) unsigned DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

    t3_origuid int(11) DEFAULT '0' NOT NULL,
    t3ver_oid int(11) DEFAULT '0' NOT NULL,
    t3ver_id int(11) DEFAULT '0' NOT NULL,
    t3ver_wsid int(11) DEFAULT '0' NOT NULL,
    t3ver_label varchar(255) DEFAULT '' NOT NULL,
    t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_stage int(11) DEFAULT '0' NOT NULL,
    t3ver_count int(11) DEFAULT '0' NOT NULL,
    t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
    t3ver_move_id int(11) DEFAULT '0' NOT NULL,

    sys_language_uid int(11) DEFAULT '0' NOT NULL,
    l10n_parent int(11) DEFAULT '0' NOT NULL,
    l10n_diffsource mediumblob,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY t3ver_oid (t3ver_oid,t3ver_wsid),

    INDEX persistent_identifier (persistent_identifier),
    FULLTEXT names (name,name_variants),
    FULLTEXT events (name,name_variants,description)

) ENGINE=MyISAM;


CREATE TABLE tx_hisodat_domain_model_localities (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    persistent_identifier varchar(255) DEFAULT '' NOT NULL,
    name varchar(255) DEFAULT '' NOT NULL,
    name_variants text NOT NULL,
    description text NOT NULL,
    images tinyblob NOT NULL,

    date_range int(11) unsigned DEFAULT '0',
    geodata int(11) unsigned DEFAULT '0' NOT NULL,
    relations int(11) unsigned DEFAULT '0' NOT NULL,
    keywords int(11) unsigned DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

    t3_origuid int(11) DEFAULT '0' NOT NULL,
    t3ver_oid int(11) DEFAULT '0' NOT NULL,
    t3ver_id int(11) DEFAULT '0' NOT NULL,
    t3ver_wsid int(11) DEFAULT '0' NOT NULL,
    t3ver_label varchar(255) DEFAULT '' NOT NULL,
    t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_stage int(11) DEFAULT '0' NOT NULL,
    t3ver_count int(11) DEFAULT '0' NOT NULL,
    t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
    t3ver_move_id int(11) DEFAULT '0' NOT NULL,

    sys_language_uid int(11) DEFAULT '0' NOT NULL,
    l10n_parent int(11) DEFAULT '0' NOT NULL,
    l10n_diffsource mediumblob,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY t3ver_oid (t3ver_oid,t3ver_wsid),

    INDEX persistent_identifier (persistent_identifier),
    FULLTEXT names (name,name_variants),
    FULLTEXT localities (name,name_variants,description)

) ENGINE=MyISAM;


CREATE TABLE tx_hisodat_domain_model_entities (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    persistent_identifier varchar(255) DEFAULT '' NOT NULL,
    name varchar(255) DEFAULT '' NOT NULL,
    name_variants text NOT NULL,
    description text NOT NULL,
    images tinyblob NOT NULL,

    date_range int(11) unsigned DEFAULT '0',
    relations int(11) unsigned DEFAULT '0' NOT NULL,
    keywords int(11) unsigned DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

    t3_origuid int(11) DEFAULT '0' NOT NULL,
    t3ver_oid int(11) DEFAULT '0' NOT NULL,
    t3ver_id int(11) DEFAULT '0' NOT NULL,
    t3ver_wsid int(11) DEFAULT '0' NOT NULL,
    t3ver_label varchar(255) DEFAULT '' NOT NULL,
    t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_stage int(11) DEFAULT '0' NOT NULL,
    t3ver_count int(11) DEFAULT '0' NOT NULL,
    t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
    t3ver_move_id int(11) DEFAULT '0' NOT NULL,

    sys_language_uid int(11) DEFAULT '0' NOT NULL,
    l10n_parent int(11) DEFAULT '0' NOT NULL,
    l10n_diffsource mediumblob,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY t3ver_oid (t3ver_oid,t3ver_wsid),

    INDEX persistent_identifier (persistent_identifier),
    FULLTEXT names (name,name_variants),
    FULLTEXT entities (name,name_variants,description)

) ENGINE=MyISAM;


CREATE TABLE tx_hisodat_domain_model_relations (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    persistent_identifier varchar(255) DEFAULT '' NOT NULL,
    relation_type int(11) unsigned DEFAULT '0' NOT NULL,
    certainty int(11) unsigned DEFAULT '0' NOT NULL,
    description text NOT NULL,

    role int(11) unsigned DEFAULT '0',
    date_range int(11) unsigned DEFAULT '0',
    geodata int(11) unsigned DEFAULT '0' NOT NULL,

    source int(11) unsigned DEFAULT '0',
    person int(11) unsigned DEFAULT '0',
    entity int(11) unsigned DEFAULT '0',
    locality int(11) unsigned DEFAULT '0',
    event int(11) unsigned DEFAULT '0',

    source_symmetric int(11) unsigned DEFAULT '0',
    person_symmetric int(11) unsigned DEFAULT '0',
    entity_symmetric int(11) unsigned DEFAULT '0',
    locality_symmetric int(11) unsigned DEFAULT '0',
    event_symmetric int(11) unsigned DEFAULT '0',

    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,

    source_sortby int(11) unsigned DEFAULT '0' NOT NULL,
    person_sortby int(11) unsigned DEFAULT '0' NOT NULL,
    entity_sortby int(11) unsigned DEFAULT '0' NOT NULL,
    locality_sortby int(11) unsigned DEFAULT '0' NOT NULL,
    event_sortby int(11) unsigned DEFAULT '0' NOT NULL,
    source_symmetric_sortby int(11) unsigned DEFAULT '0' NOT NULL,
    person_symmetric_sortby int(11) unsigned DEFAULT '0' NOT NULL,
    entity_symmetric_sortby int(11) unsigned DEFAULT '0' NOT NULL,
    locality_symmetric_sortby int(11) unsigned DEFAULT '0' NOT NULL,
    event_symmetric_sortby int(11) unsigned DEFAULT '0' NOT NULL,

    t3_origuid int(11) DEFAULT '0' NOT NULL,
    t3ver_oid int(11) DEFAULT '0' NOT NULL,
    t3ver_id int(11) DEFAULT '0' NOT NULL,
    t3ver_wsid int(11) DEFAULT '0' NOT NULL,
    t3ver_label varchar(255) DEFAULT '' NOT NULL,
    t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_stage int(11) DEFAULT '0' NOT NULL,
    t3ver_count int(11) DEFAULT '0' NOT NULL,
    t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
    t3ver_move_id int(11) DEFAULT '0' NOT NULL,

    sys_language_uid int(11) DEFAULT '0' NOT NULL,
    l10n_parent int(11) DEFAULT '0' NOT NULL,
    l10n_diffsource mediumblob,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY t3ver_oid (t3ver_oid,t3ver_wsid),

    KEY persistent_identifier (persistent_identifier),
    KEY relation_type (relation_type),
    KEY role (role),

    KEY source (source),
    KEY person (person),
    KEY entity (entity),
    KEY locality (locality),
    KEY event (event),

    KEY source_symmetric (source_symmetric),
    KEY person_symmetric (person_symmetric),
    KEY entity_symmetric (entity_symmetric),
    KEY locality_symmetric (locality_symmetric),
    KEY event_symmetric (event_symmetric)

) ENGINE=MyISAM;


CREATE TABLE tx_hisodat_domain_model_dateranges (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    type int(11) unsigned DEFAULT '0' NOT NULL,
    certainty int(11) unsigned DEFAULT '0' NOT NULL,
    start_date char(10) DEFAULT '' NOT NULL,
    end_date char(10) DEFAULT '' NOT NULL,
    date_key varchar(255) DEFAULT '' NOT NULL,
    date_comment varchar(255) DEFAULT '' NOT NULL,

    parent_record int(11) DEFAULT '0' NOT NULL,
    ident varchar(50) DEFAULT '' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

    t3_origuid int(11) DEFAULT '0' NOT NULL,
    t3ver_oid int(11) DEFAULT '0' NOT NULL,
    t3ver_id int(11) DEFAULT '0' NOT NULL,
    t3ver_wsid int(11) DEFAULT '0' NOT NULL,
    t3ver_label varchar(255) DEFAULT '' NOT NULL,
    t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_stage int(11) DEFAULT '0' NOT NULL,
    t3ver_count int(11) DEFAULT '0' NOT NULL,
    t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
    t3ver_move_id int(11) DEFAULT '0' NOT NULL,

    sys_language_uid int(11) DEFAULT '0' NOT NULL,
    l10n_parent int(11) DEFAULT '0' NOT NULL,
    l10n_diffsource mediumblob,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY t3ver_oid (t3ver_oid,t3ver_wsid),

    KEY type (type),
    KEY parent_record (parent_record),
    KEY ident (ident),
    KEY dateranges_start_end (start_date,end_date),
    KEY dateranges_end_start (end_date,start_date)

) ENGINE=MyISAM;


CREATE TABLE tx_hisodat_domain_model_geodata (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    label varchar(255) DEFAULT '' NOT NULL,
    certainty int(11) unsigned DEFAULT '0' NOT NULL,
    x decimal(24,14) DEFAULT '0.00000000000000' NOT NULL,
    y decimal(24,14) DEFAULT '0.00000000000000' NOT NULL,
    z decimal(24,14) DEFAULT '0.00000000000000' NOT NULL,

    parent_record int(11) unsigned DEFAULT '0' NOT NULL,
    ident varchar(255) DEFAULT '' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
    deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
    hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
    sorting int(11) unsigned DEFAULT '0' NOT NULL,

    t3_origuid int(11) DEFAULT '0' NOT NULL,
    t3ver_oid int(11) DEFAULT '0' NOT NULL,
    t3ver_id int(11) DEFAULT '0' NOT NULL,
    t3ver_wsid int(11) DEFAULT '0' NOT NULL,
    t3ver_label varchar(255) DEFAULT '' NOT NULL,
    t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
    t3ver_stage int(11) DEFAULT '0' NOT NULL,
    t3ver_count int(11) DEFAULT '0' NOT NULL,
    t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
    t3ver_move_id int(11) DEFAULT '0' NOT NULL,

    sys_language_uid int(11) DEFAULT '0' NOT NULL,
    l10n_parent int(11) DEFAULT '0' NOT NULL,
    l10n_diffsource mediumblob,

    PRIMARY KEY (uid),
    KEY pid (pid),
    KEY t3ver_oid (t3ver_oid,t3ver_wsid),
    KEY language (l10n_parent,sys_language_uid),

    KEY parent_record (parent_record),
    KEY ident (ident)
);


CREATE TABLE tx_hisodat_keywords_mm (
    uid_local int(11) unsigned DEFAULT '0' NOT NULL,
    uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
    ident varchar(50) DEFAULT '' NOT NULL,
    sorting int(11) unsigned DEFAULT '0' NOT NULL,
    sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

    KEY uid_local (uid_local),
    KEY uid_foreign (uid_foreign)

) ENGINE=MyISAM;
