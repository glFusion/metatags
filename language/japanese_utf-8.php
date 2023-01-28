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

if (!defined ('GVERSION')) {
    die ('This file cannot be used on its own.');
}

###############################################################################

$LANG_METATAGS = array(
    'plugin' => 'メタタグ',
    'admin' => 'メタタグ',
    'desc_meta' => 'Places the keywords into the meta tags in the HTML header. {<a href="http://www.glfusion.org/wiki/doku.php/metatags:start" target="_blank">options</a>}'
);

// Localization of the Admin Configuration UI
$LANG_configsections['metatags'] = array(
    'label' => 'メタタグ',
    'title' => 'メタタグの設定'
);

$LANG_confignames['metatags'] = array(
    'tagname' => '自動タグ名',
    'replace' => '置換ルール',
    'description' => 'descriptionの初期値',
    'show_editor' => 'Display autotags for content edtiors',
    'add_author'  => 'Add article author name autmatically',
    'defaults'    => 'Default Meta Name Tags',
    'def_props'   => 'Default Meta Property Tags',
);

$LANG_configsubgroups['metatags'] = array(
    'sg_main' => '主要設定'
);

$LANG_fs['metatags'] = array(
    'fs_main' => 'メタタグの主要設定'
);

$LANG_configSelect['metatags'] = array(
    0 => array(1 => 'はい', 0 => 'いいえ'),
    1 => array(TRUE => 'はい', FALSE => 'いいえ'),
);
