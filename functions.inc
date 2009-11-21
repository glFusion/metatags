<?php
// +--------------------------------------------------------------------------+
// | Meta Tags Plugin for glFusion                                            |
// +--------------------------------------------------------------------------+
// | functions.inc                                                            |
// |                                                                          |
// | glFusion Plugin API functions and support functions                      |
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

/**
* Language file Include
*/
$langfile = $_CONF['path']. 'plugins/metatags/language/'.$_CONF['language'] . '.php';
clearstatcache();
if (file_exists($langfile)) {
	include_once $langfile;
} else {
	include_once $_CONF['path'] . 'plugins/metatags/language/english.php';
}

/**
* Include metatags config file
*/
require_once $_CONF['path'] . 'plugins/metatags/metatags.php';

/**
* Load the plugin configuration
*/
METATAGS_loadConfig();

// +---------------------------------------------------------------------------+
// | glFusion Plugin API Implementations                                       |
// +---------------------------------------------------------------------------+

/**
* Returns the version for this plugin
*
* @return string VersionNo
*/
function plugin_chkVersion_metatags() {
	global $_METATAGS_CONF;

	return $_METATAGS_CONF['pi_version'];
}

/**
* Upgrade the plugin
*
* Universal Plugin:  modify/uncomment use it
*
* @return   boolean TRUE (= success)
*/
function plugin_upgrade_metatags() {
	global $_CONF, $_TABLES, $_METATAGS_CONF;

	$result = DB_query("SELECT pi_version FROM {$_TABLES['plugins']} WHERE (pi_name = 'metatags')");
	$A = DB_fetchArray($result);
	$pi_version = $A['pi_version'];		// Version info stored in database

	// Do upgrading

	switch ($pi_version) {
		case '1.0.0':
		case '1.0.1':
		case '1.0.2':
		case '1.0.3':
		    $c = config::get_instance();
			$c->add('sp_php', false, 'select', 0, 0, 1, 30, TRUE, 'metatags');
        	$c->add('replace', array('key' => 'keywords','keywords' => 'keywords','desc' => 'description','description' => 'description','au' => 'author','author' => 'author','gen' => 'generator','generator' => 'generator','robots' => 'robots',), '*text', 0, 0, NULL, 20, TRUE, 'metatags');
        	$c->add('show_editor', false, 'select', 0, 0, 1, 40, TRUE, 'metatags');
        case '1.0.4' :
            // no db / config changes
        default :
            break;
	}

	// Update plugin info

	$result = DB_query("UPDATE {$_TABLES['plugins']} SET pi_version = '".$_METATAGS_CONF['pi_version']."' WHERE (pi_name = 'metatags')");
	COM_errorLog(ucfirst("metatags") . " plugin was successfully updated to version {$_METATAGS_CONF['pi_version']}.");

	return TRUE;
}


/**
* Loads config infor with config.class.php
*/
function METATAGS_loadConfig() {
	global $_CONF, $_METATAGS_CONF;

	require_once $_CONF['path_system'] . 'classes/config.class.php';
	$config = config::get_instance();
	if ($config->group_exists('metatags')) {
		$temp = $config->get_config('metatags');
		if (is_array($temp) AND (count($temp) > 0)) {
		    if ( is_array($_METATAGS_CONF ) ) {
			    $_METATAGS_CONF = array_merge($_METATAGS_CONF, $temp);
			} else {
			    $_METATAGS_CONF = $temp;
			}
		}
	}
}

/**
* Returns a string escaped for HTML output
*/
function METATAGS_esc($str) {

	$str = str_replace(
		array('&lt;', '&gt;', '&amp;', '&quot;', '&#039;'),
		array(   '<',    '>',     '&',      '"',      "'"),
		$str
	);

    $encoding = METATAGS_getEncodingt();

	return htmlspecialchars($str, ENT_QUOTES, $encoding);
}

/**
* Returns a lang var
*/
function METATAGS_str($index, $noesc = FALSE) {
	global $LANG_METATAGS;

	if (isset($LANG_METATAGS[$index])) {
		if ($noesc) {
			return $LANG_METATAGS[$index];
		} else {
			return METATAGS_esc($LANG_METATAGS[$index]);
		}
	} else {
		COM_errorLog('METATAGS_str: undefined index: "' . $index . '"');
		return '(undefined)';
	}
}

/**
* Return the content of a static page WITHOUT replacing autotags
* Code taken from SP_render_content()
*
* @param  id  string  staticpage id
* @return     string  page content
*/
function METATAGS_getStaticpage($id) {
	global $_CONF, $_TABLES, $_SP_CONF, $_METATAGS_CONF;

	$retval = '';

	$sql = "SELECT sp_content, sp_php "
		 . "FROM {$_TABLES['staticpage']} "
		 . "WHERE " . SP_getPerms()
		 . " AND (sp_id = '" . addslashes($id) . "') ";

	$result = DB_query($sql);

	if (!DB_error() AND (DB_numRows($result) == 1)) {
		$A = DB_fetchArray($result);
		$sp_content = stripslashes($A['sp_content']);
		$sp_php     = $A['sp_php'];

		if ($_METATAGS_CONF['sp_php']) {
			if ($_SP_CONF['allow_php'] == 1) {
				// Check for type (ie html or php)
				if ($sp_php == 1) {
					$retval = @eval($sp_content);
				} else if ($sp_php == 2) {
					ob_start();
					@eval($sp_content);
					$retval = ob_get_contents();
					ob_end_clean();
				} else {
					$retval = $sp_content;
				}
			} else {
				if ($sp_php != 0) {
					COM_errorLog ("PHP in static pages is disabled.  Can not display page '$id'.", 1);
				} else {
					$retval = $sp_content;
				}
			}
		} else {
			$retval = $sp_content;
		}
	}

	return $retval;
}

/**
* Return <meta> tags
*/
function plugin_getheadercode_metatags() {
	global $_CONF, $_TABLES, $_METATAGS_CONF;

	$retval = '';
	$type   = '';

	// Check the current URL for ids
	$uri = strtolower(COM_getCurrentURL());

	if ($_CONF['url_rewrite']) {
		if (preg_match("|article\.php/(.*)(/print)?$|i", $uri, $match)) {
			$type = 'article';
		} else if (preg_match("|staticpages/index\.php/(.*)(/print)?$|i", $uri, $match)) {
			$type = 'staticpages';
		}
	} else {
		if (preg_match("|article\.php\?story=(.*)(&mode=print)?$|i", $uri, $match)) {
			$type = 'article';
		} else if (preg_match("|staticpages/index\.php\?page=(.*)(&disp_mode=print)?$|i", $uri, $match)) {
			$type = 'staticpages';
		}
	}

	$id = '';
	if (isset($match[1])) {
		$id = COM_applyFilter($match[1]);
		if ($id == '') {
			$type= '';
		}
	}

	// Retrieve the relevant content from DB
	$target = '';

	switch ($type) {
		case 'article':
			$sql = "SELECT introtext, bodytext "
				 . "FROM {$_TABLES['stories']} "
				 . "WHERE (sid = '" . addslashes($id) . "') "
				 . COM_getPermSQL('AND')
				 . COM_getTopicSQL('AND');
			$result = DB_query($sql);
			if (!DB_error() AND (DB_numRows($result) == 1)) {
				$A = DB_fetchArray($result);
				$target = stripslashes($A['introtext'] . ' ' . $A['bodytext']);
			}

			break;

		case 'staticpages':
			$target = METATAGS_getStaticpage($id);
			break;

		default:
			// Do nothing
			break;
	}

	$tags = array();

	// Check if the content has the autotag
	if ($target != '') {
		$autotag = '|\[' . preg_quote($_METATAGS_CONF['tagname'], '|')
				 . '\:([^\]]*)\]|i';
		$num    = preg_match_all($autotag, $target, $match);
		$tokens = array_keys($_METATAGS_CONF['replace']);

		if ($num > 0) {
			foreach ($match[1] as $m) {
				list($key, $value) = explode(' ', $m, 2);
				$key   = strtolower($key);
				$value = trim($value);
				if (in_array($key, $tokens) AND ($value != '')) {
					$tags[$_METATAGS_CONF['replace'][$key]] = $value;
				}
			}
		}
	}

	if (!isset($tags['keywords']) AND isset($_METATAGS_CONF['keywords'])) {
		$tags['keywords'] = $_METATAGS_CONF['keywords'];
	}

	if (!isset($tags['description']) AND isset($_METATAGS_CONF['description'])) {
		$tags['description'] = $_METATAGS_CONF['description'];
	}

	if (count($tags) > 0) {
		// Convert autotags into <meta> headers
		foreach ($tags as $key => $value) {
			$retval .= '<meta name="' . $key . '" content="'
					.  METATAGS_esc($value) . '"' . XHTML . '>' . LB;
		}
	}

	if ($retval != '') {
		$retval = LB . $retval;
	}

	return $retval;
}

/**
* Implements the [meta:] autotag.
*
*/
function plugin_autotags_metatags($op, $content = '', $autotag = '') {
	global $_CONF, $_METATAGS_CONF;

	if ($op == 'tagname' ) {
		return $_METATAGS_CONF['tagname'];
	} else if ($op == 'parse') {
		// Let editors see the autotag but hide them for non-editors, if configured
		if (!SEC_hasRights('story.edit') || $_METATAGS_CONF['show_editor'] == false) {
			$content = str_replace($autotag['tagstr'], '', $content);
		}

		return $content;
	}
}

/*
 * Return the metatags icon
 */
function plugin_geticon_metatags()
{
    global $_CONF, $_METATAGS_CONF;

    $retval = $_CONF['site_admin_url'].'/plugins/metatags/images/metatags.png';

    return $retval;
}

/*
 * Return a link to the help element for this configuration option
 *
 */

function plugin_getconfigelementhelp_metatags($element, $doclang )
{
    return array('http://www.glfusion.org/wiki/doku.php/metatags:start#configuration',2);
}

/**
* Returns encoding
*/
function METATAGS_getEncodingt() {
	global $_CONF, $LANG_CHARSET;

	static $encoding = null;

    $valid_charsets = array('iso-8859-1','iso-8859-15','utf-8','cp866','cp1251','cp1252','koi8-r','big5','gb2312','big5-hkscs','shift_jis sjis','euc-jp');

	if ($encoding === null) {
		if (isset($LANG_CHARSET)) {
			$encoding = $LANG_CHARSET;
		} else if (isset($_CONF['default_charset'])) {
			$encoding = $_CONF['default_charset'];
		} else {
			$encoding = 'iso-8859-1';
		}
	}

	$encoding = strtolower($encoding);

	if ( in_array($encoding,$valid_charsets) ) {
	    return $encoding;
	} else {
	    return 'iso-8859-1';
	}

	return $encoding;
}
?>