<?php
// +--------------------------------------------------------------------------+
// | Meta Tags Plugin for glFusion                                            |
// +--------------------------------------------------------------------------+
// | english_utf-8.php                                                        |
// |                                                                          |
// | English language file (UTF-8)                                            |
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

$LANG_METATAGS = array(
    'plugin'            => 'metatagy',
	'admin'		        => 'Metatagy',
	'desc_meta'         => 'Umístí klíčová slova do meta tagů v hlavičce HTML. {<a href="http://www.glfusion.org/wiki/doku.php/metatags:start" target="_blank">options</a>}',
);

// Localization of the Admin Configuration UI
$LANG_configsections['metatags'] = array(
    'label' => 'Metatagy',
    'title' => 'Konfigurace metatagů'
);

$LANG_confignames['metatags'] = array(
    'tagname'     => 'Jméno autotagu',
    'replace'     => 'Nahradit',
    'description' => 'Výchozí popis',
    'show_editor' => 'Zobrazit autotagy pro editory obsahu',
    'add_author'  => 'Automaticky přidat jméno autora článku',
    'defaults'    => 'Default Meta Name Tags',
);

$LANG_configsubgroups['metatags'] = array(
    'sg_main' => 'Hlavní nastavení'
);

$LANG_fs['metatags'] = array(
    'fs_main'       => 'Hlavní nastavení metatagů',
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['metatags'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => TRUE, 'False' => FALSE),
    9 => array('Forward to page' => 'položka', 'Display List' => 'seznam', 'Display Home' => 'domovská stránka', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3),
);
?>