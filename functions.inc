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
* Load the plugin configuration
*/
METATAGS_loadConfig();

/**
* Include metatags config file
*/
require_once __DIR__ . '/metatags.php';
if (is_file(__DIR__ . '/config.php')) {
    // Include custom config overrides
    include_once __DIR__ . '/config.php';
}

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
*   Upgrade the plugin
*
*   @return boolean     TRUE (= success)
*/
function plugin_upgrade_metatags()
{
    require_once __DIR__ . '/upgrade.inc.php';
    return METATAGS_do_upgrade();
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

    $encoding = COM_getEncodingt();

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
function DEPRECATE_METATAGS_getStaticpage($id) {
	global $_CONF, $_TABLES, $_SP_CONF, $_METATAGS_CONF;

	$retval = '';

	$sql = "SELECT sp_content, sp_php "
		 . "FROM {$_TABLES['staticpage']} "
		 . "WHERE " . SP_getPerms()
		 . " AND (sp_id = '" . DB_escapeString($id) . "') ";

	$result = DB_query($sql);

	if (!DB_error() AND (DB_numRows($result) == 1)) {
		$A = DB_fetchArray($result);
		$sp_content = $A['sp_content'];
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
*   Set template variables
*   This function is used to create meta tags based on the current template.
*
*   @param  string  $templatename   Template Name
*   @param  object  $template       Template (not used)
*   @return void
*/
function plugin_templateSetVars_metatags($templatename, &$template)
{
    global $_CONF, $_TABLES, $_METATAGS_CONF;

    // If not displaying an article, or not configured to add the
    // author metatag, just return
    if (!$_METATAGS_CONF['add_author'] ||
        ($templatename != 'featuredarticle' && $templatename != 'article')) {
        return;
    }

    // Get the article ID from the URL.
	$uri = strtolower(COM_getCurrentURL());
    if ($_CONF['url_rewrite']) {
        preg_match("|article\.php/(.*)(/print)?$|i", $uri, $match);
    } else {
        preg_match("|article\.php\?story=(.*)(&mode=print)?$|i", $uri, $match);
    }
    $id = '';
    if (isset($match[1])) {
        $id = COM_applyFilter($match[1]);
        if ($id == '') {
            return;     // no article ID found
        }
    }
    // Get the author information for the tag. Prefer the attribution_author,
    // if set, falling back to the submitting author.
    $sql = "SELECT uid, attribution_author
            FROM {$_TABLES['stories']}
            WHERE (sid = '" . DB_escapeString($id) . "')";
    $result = DB_query($sql);
    if (!DB_error() AND (DB_numRows($result) == 1)) {
        $A = DB_fetchArray($result, false);
        $author = !empty($A['attribution_author']) ? $A['attribution_author'] :
            COM_getDisplayName($A['uid']);

        if (!empty($author)) { 
            $out = outputHandler::getInstance();
            // Add the meta tag as "low", which is higher than the global
            // default author.
            $out->addMeta('name', 'author', $author, HEADER_PRIO_LOW);
        }
    }
    return;
}


/**
*   Add code to the HTML header.
*   This function is called for every page load, so borrow it to add
*   global default metatags. Tags are added to the outputHandler with a
*   verylow priority so setTemplateVars and autotags can override them.
*
*   @return string  Header code to add, nothing in this case
*/
function plugin_getheadercode_metatags()
{
    global $_TABLES, $_METATAGS_CONF;

    $out = outputHandler::getInstance();
    // Protect against running before plugin is updated
    if (is_array($_METATAGS_CONF['defaults'])) {
        foreach ($_METATAGS_CONF['defaults'] as $name=>$value) {
            if (!empty($value)) {
                $out->addMeta('name', $name, $value, HEADER_PRIO_VERYLOW);
            }
        }
    }
    return '';      // Doesn't actually return a value
}


/**
*   Implements the [meta:] autotag.
*
*   @param  string  $op         Operation to perform
*   @param  string  $content    Page content
*   @param  array   $autotag    Autotag information
*   @return string      Modified content
*/
function plugin_autotags_metatags($op, $content = '', $autotag = '')
{
    global $_CONF, $_METATAGS_CONF, $LANG_METATAGS;

    static $tokens = NULL;
    if ($tokens === NULL) {
        $tokens = array_keys($_METATAGS_CONF['replace']);
    }
    switch ($op) {
    case 'tagname':
        return $_METATAGS_CONF['tagname'];
    case 'tagusage':
        return;
    case 'desc':
        return $LANG_METATAGS['desc_meta'];
    case 'parse':
        $key = strtolower($autotag['parm1']);
        $value = trim($autotag['parm2']);
        if (in_array($key, $tokens) && ($value != '')) {
            $out = outputHandler::getInstance();
            $out->addMeta('name', $_METATAGS_CONF['replace'][$key],
                    $value, HEADER_PRIO_NORMAL);
        }
        // Let editors see the autotag but hide them for non-editors,
        // if so configured
        if ($_METATAGS_CONF['show_editor'] == false || !SEC_hasRights('story.edit')) {
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
?>
