<?php
// +--------------------------------------------------------------------------+
// | Meta Tags Plugin for glFusion                                            |
// +--------------------------------------------------------------------------+
// | english.php                                                              |
// |                                                                          |
// | English language file                                                    |
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
    'plugin'            => 'Metatags',
	'admin'		        => 'Metatags',
);

// Localization of the Admin Configuration UI
$LANG_configsections['metatags'] = array(
    'label' => 'Metatags',
    'title' => 'Metatags Instellingen'
);

$LANG_confignames['metatags'] = array(
	'tagname'     => 'Autotag naam',
	'replace'     => 'Vervang',
	'keywords'    => 'Standaard sleutelwoorden (comma gescheiden)',
	'description' => 'Standaard beschrijving',
);

$LANG_configsubgroups['metatags'] = array(
    'sg_main' => 'Hoofd Instellingen'
);

$LANG_fs['metatags'] = array(
    'fs_main'        => 'Metatags Hoofd Instellingen',
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['metatags'] = array(
    0 => array('Ja' => 1, 'Nee' => 0),
    1 => array('Ja' => TRUE, 'Nee' => FALSE),
    9 => array('Ga naar pagina' => 'item', 'Toon Lijst' => 'list', 'Toon Startpagina' => 'home', 'Toon Beheerpagina' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3),
);
?>