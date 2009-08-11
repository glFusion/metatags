<?php
// +--------------------------------------------------------------------------+
// | Meta Tags Plugin for glFusion                                            |
// +--------------------------------------------------------------------------+
// | japanese_utf-8.php                                                       |
// |                                                                          |
// | Japanese Language File (UTF-8)                                           |
// +--------------------------------------------------------------------------+
// | $Id::                                                                   $|
// +--------------------------------------------------------------------------+
// | Based on the Meta Tags Plugin for Geeklog CMS                            |
// | Copyright (C) 2009 by the following authors:                             |
// |                                                                          |
// | mystral-kk             - geeklog AT mystral-kk DOT net                   |
// +--------------------------------------------------------------------------+
// |                                                                          |
// | This program is free software; you can redistribute it and/or            |
// | modify it under the terms of the GNU General Public License              |
// | as published by the Free Software Foundation; either version 2           |
// | of the License, or (at your option) any later version.                   |
// |                                                                          |
// | This program is distributed in the hope that it will be useful,          |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of           |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            |
// | GNU General Public License for more details.                             |
// |                                                                          |
// | You should have received a copy of the GNU General Public License        |
// | along with this program; if not, write to the Free Software Foundation,  |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.          |
// |                                                                          |
// +--------------------------------------------------------------------------+

// this file can't be used on its own
if (!defined ('GVERSION')) {
    die ('This file can not be used on its own.');
}

$LANG_METATAGS = array (
    'plugin'            => 'メタタグ',
	'admin'		        => 'メタタグ',
);

// Localization of the Admin Configuration UI
$LANG_configsections['metatags'] = array(
    'label' => $LANG_METATAGS['plugin'],
    'title' => $LANG_METATAGS['plugin'] . 'の設定',
);

$LANG_confignames['metatags'] = array(
	'tagname'     => '自動タグ名',
	'replace'     => '置換ルール',
	'keywords'    => 'keywordsの初期値（コンマで区切る）',
	'description' => 'descriptionの初期値',
	'sp_php'      => '静的ページでPHPを実行する',
	'show_editor' => 'Display autotags for content edtiors',
);

$LANG_configsubgroups['metatags'] = array(
    'sg_main' => '主要設定'
);

$LANG_fs['metatags'] = array(
    'fs_main'        => $LANG_METATAGS['plugin'] . 'の主要設定',
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['metatags'] = array(
    0 => array('はい' => 1, 'いいえ' => 0),
    1 => array('はい' => TRUE, 'いいえ' => FALSE),
    9 => array('Forward to page' => 'item', 'Display List' => 'list', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('アクセス不可' => 0, '表示' => 2, '表示・編集' => 3),
);
?>