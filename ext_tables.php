<?php

t3lib_div::loadTCA('tt_content');

$TCA['tt_content']['ctrl']['enablecolumns']['tx_bbusercontentaccess_fe_user'] = 'tx_bbusercontentaccess_fe_user';

$tempColumns = array (
    'tx_bbusercontentaccess_fe_user' => array (
        'exclude' => 0,
        'label' => 'LLL:EXT:bb_user_content_access/locallang_db.xml:tt_content.tx_bbusercontentaccess_fe_user',
        'config' => array (
            'type' => 'select',
            'size' => 5,
            'items' => array (
            	array('LLL:EXT:bb_user_content_access/locallang_db.xml:tt_content.tx_bbusercontentaccess_fe_user_all','-1'),
            	array('LLL:EXT:bb_user_content_access/locallang_db.xml:tt_content.tx_bbusercontentaccess_fe_user_user','--div--'),
            ),
            'default' => '-1',
            'exclusiveKeys' => '-1',
            'maxitems' => 20,
						'foreign_table' => 'fe_users',
						'foreign_table_where' => 'AND fe_users.disable = 0 AND (fe_users.starttime = 0 OR (fe_users.starttime < NOW() AND fe_users.endtime > NOW())) ORDER BY fe_users.username',
        )
    ),
);

t3lib_extMgm::addTCAcolumns('tt_content',$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes('tt_content','tx_bbusercontentaccess_fe_user;;;;1-1-1','','after:fe_group');

?>