<?php
/**
 * Upgrade routines for the Metatags plugin.
 *
 * @author      Lee Garner <lee@leegarner.com>
 * @copyright   Copyright (c) 2017-2022 Lee Garner <lee@leegarner.com>
 * @package     metatags
 * @version     v1.2.0
 * @license     http://opensource.org/licenses/gpl-2.0.php
 *              GNU Public License v2 or later
 * @filesource
 */

/** Include the default configuration values */
require_once __DIR__ . '/install_defaults.php';


/**
 * Perform the upgrade starting at the current version.
 *
 * @since   v0.4.0
 * @return  boolean     True for success, False on error
 */
function METATAGS_do_upgrade($dvlp=false)
{
    global $_CONF, $_TABLES, $_METATAGS_CONF, $_META_DEFAULTS, $_PLUGIN_INFO;

    $pi_name = $_METATAGS_CONF['pi_name'];
    if (isset($_PLUGIN_INFO[$pi_name])) {
        if (is_array($_PLUGIN_INFO[$pi_name])) {
            // glFusion >= 1.6.6
            $current_ver = $_PLUGIN_INFO[$pi_name]['pi_version'];
        } else {
            // legacy
            $current_ver = $_PLUGIN_INFO[$pi_name];
        }
    } else {
        return false;
    }

    // Get the config instance, several upgrades might need it
    $c = config::get_instance();

    // Do upgrading
    if (!COM_checkVersion($current_ver, '1.0.4')) {
        // upgrade to 1.0.4
        $current_ver = '1.0.4';
        if (!METATAGS_do_set_version($current_ver)) return false;
    }

    if (!COM_checkVersion($current_ver, '1.0.7')) {
        // upgrade to 1.0.7
        $current_ver = '1.0.7';
        $sql = "UPDATE {$_TABLES['groups']}
                SET grp_gl_core = 2
                WHERE grp_name='{$pi_name} Admin'";
        DB_query($sql,1);
        if (DB_error()) {
            COM_errorLog("SQL error updating Metatags to $current_ver: $sql");
            return false;
        }
        if (!METATAGS_do_set_version($current_ver)) return false;
    }

    if (!COM_checkVersion($current_ver, '1.1.0')) {
        // upgrade to 1.1.0
        $current_ver = '1.1.0';
        $defaults = array();
        if (!empty($_METATAGS_CONF['description'])) {
            $defaults['description'] = $_METATAGS_CONF['description'];
        }
        if (!empty($_METATAGS_CONF['keywords'])) {
            $defaults['keywords'] = $_METATAGS_CONF['keywords'];
        }
        $c->add('add_author', $_META_DEFAULTS['add_author'], 'select', 0, 0, 1, 50, TRUE, $pi_name);
        $c->add('defaults', $defaults, '*text', 0, 0, NULL, 60, TRUE, $pi_name);
        $c->del('description', $pi_name);
        $c->del('keywords', $pi_name);
        $c->del('sp_php', $pi_name);
        $c->del('fs_default', $pi_name);
        if (!METATAGS_do_set_version($current_ver)) return false;
    }

    // Update any configuration item changes
    USES_lib_install();
    global $metaConfigData;
    require_once __DIR__ . '/install_defaults.php';
    _update_config('metatags', $metaConfigData);

    CTL_clearCache($pi_name);
    COM_errorLog("Successfully updated the {$_METATAGS_CONF['pi_display_name']} Plugin", 1);
    return true;
}


/**
 * Update the plugin version number in the database.
 * Called at each version upgrade to keep up to date with
 * successful upgrades.
 *
 * @param   string  $ver    New version to set
 * @return  boolean         True on success, False on failure
 */
function METATAGS_do_set_version($ver)
{
    global $_TABLES, $_METATAGS_CONF;

    // now update the current version number.
    $sql = "UPDATE {$_TABLES['plugins']} SET
            pi_version = '{$_METATAGS_CONF['pi_version']}',
            pi_gl_version = '{$_METATAGS_CONF['gl_version']}',
            pi_homepage = '{$_METATAGS_CONF['pi_url']}'
        WHERE pi_name = '{$_METATAGS_CONF['pi_name']}'";

    $res = DB_query($sql, 1);
    if (DB_error()) {
        COM_errorLog("Error updating the {$_METATAGS_CONF['pi_display_name']} Plugin version",1);
        return false;
    } else {
        COM_errorLog("Updated the {$_METATAGS_CONF['pi_display_name']} Plugin version to $ver",1);
        return true;
    }
}
