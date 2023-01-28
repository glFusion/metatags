<?php
/**
 * Apply updates to Birthdays during development.
 * Calls METATAGS_upgrade() with "ignore_errors" set so repeated SQL statements
 * won't cause functions to abort.
 *
 * @author      Lee Garner <lee@leegarner.com>
 * @copyright   Copyright (c) 2018 Lee Garner <lee@leegarner.com>
 * @package     metatags
 * @version     v1.2.0
 * @since       v1.2.0
 * @license     http://opensource.org/licenses/gpl-2.0.php
 *              GNU Public License v2 or later
 * @filesource
 */

require_once '../../../lib-common.php';

if (!SEC_inGroup('Root')) {
    // Someone is trying to illegally access this page
    COM_accessLog("Someone has tried to access the Birthdays Development Code Upgrade Routine without proper permissions.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: " . $_SERVER['REMOTE_ADDR']);
    COM_404();
    exit;
}

require_once $_CONF['path'] . 'plugins/metatags/upgrade.inc.php';
if (function_exists('CACHE_clear')) {
    CACHE_clear();
}

// Force the plugin version to the previous version and do the upgrade
$_PLUGIN_INFO['metatags']['pi_version'] = '1.1.0';
METATAGS_do_upgrade(true);

// need to clear the template cache so do it here
if (function_exists('CACHE_clear')) {
    CACHE_clear();
}
header('Location: '.$_CONF['site_admin_url'].'/plugins.php?msg=600');
exit;
