<?php
// +--------------------------------------------------------------------------+
// | MetaTags Plugin for glFusion                                             |
// +--------------------------------------------------------------------------+
// | install_defaults.php                                                     |
// |                                                                          |
// | Plugin Configuration                                                     |
// +--------------------------------------------------------------------------+
// | $Id::                                                                   $|
// +--------------------------------------------------------------------------+
// | Copyright (C) 2009 by the following authors:                             |
// |                                                                          |
// | Mark R. Evans          mark AT glfusion DOT org                          |
// |                                                                          |
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
    die ('This file can not be used on its own.');
}

/**
* Metatags default settings
*
* Initial Installation Defaults used when loading the online configuration
* records.  These settings are only used during the initial installation
* and not referenced any more once the plugin is installed
*
*/
global $_METATAGS_DEFAULT;

$_METATAGS_DEFAULT = array();

// Whether to execute PHP in staticpages.  TRUE = execute, FALSE = otherwise
// @since v1.0.3
$_METATAGS_DEFAULT['sp_php'] = FALSE;

/**
* Initialize Metatags plugin configuration
*
* Creates the database entries for the configuation if they don't already
* exist.  Initial values will be taken from $_METATAGS_DEFAULT
* if available (e.g. from an old config.php), uses $_METATAGS_DEFAULT
* otherwise.
*
* @return   boolean     TRUE: success; FALSE: an error occurred
*
*/
function plugin_initconfig_metatags() {
    global $_METATAGS_CONF, $_METATAGS_DEFAULT;

    if (is_array($_METATAGS_CONF) AND (count($_METATAGS_CONF) > 1)) {
        $_METATAGS_DEFAULT = array_merge($_METATAGS_DEFAULT, $_METATAGS_CONF);
    }

	$me = 'metatags';
    $c = config::get_instance();
    if (!$c->group_exists($me)) {

        $c->add('sg_main', NULL, 'subgroup', 0, 0, NULL, 0, TRUE, $me);
        $c->add('fs_main', NULL, 'fieldset', 0, 0, NULL, 0, TRUE, $me);
		$c->add('tagname', 'meta', 'text', 0, 0, NULL, 10, TRUE, $me);
		$c->add('replace', array('key' => 'keywords','keywords' => 'keywords','desc' => 'description','description' => 'description',), '*text', 0, 0, NULL, 20, TRUE, $me);
		$c->add('sp_php', false, 'select', 0, 0, 1, 30, TRUE, $me);
        $c->add('fs_default', NULL, 'fieldset', 0, 1, NULL, 0, TRUE, $me);
		$c->add('keywords', NULL, 'text', 0, 0, NULL, 10, TRUE, $me);
		$c->add('description', NULL, 'text', 0, 0, NULL, 12, TRUE, $me);
    }

    return TRUE;
}
?>