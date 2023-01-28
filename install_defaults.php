<?php
/**
 * Configuration Defaults for the Metatags plugin for glFusion.
 * Based on the Meta Tags Plugin for Geeklog CMS.
 *
 * @author      Mark R. Evans <mark AT glfusion DOT org>
 * @copyright   Copyright (c) 2009-2022 Mark R. Evans <mark AT glfusion DOT org>
 * @copyright   Copyright (c) 2009 mystral-kk <geeklog AT mystral-kk DOT net>
 * @package     metatags
 * @version     v1.2.0
 * @license     http://opensource.org/licenses/gpl-2.0.php
 *              GNU Public License v2 or later
 * @filesource
 */
if (!defined ('GVERSION')) {
    die ('This file can not be used on its own.');
}

/** @var global config data */
global $metaConfigData;
$metaConfigData = array(
    array(
        'name' => 'sg_main',
        'default_value' => NULL,
        'type' => 'subgroup',
        'subgroup' => 0,
        'fieldset' => 0,
        'selection_array' => NULL,
        'sort' => 0,
        'set' => true,
        'group' => 'metatags',
    ),
    array(
        'name' => 'fs_main',
        'default_value' => NULL,
        'type' => 'fieldset',
        'subgroup' => 0,
        'fieldset' => 0,
        'selection_array' => NULL,
        'sort' => 0,
        'set' => true,
        'group' => 'metatags',
    ),
    array(
        'name' => 'tagname',        // autotag name
        'default_value' => 'meta',
        'type' => 'text',
        'subgroup' => 0,
        'fieldset' => 0,
        'selection_array' => 0,
        'sort' => 10,
        'set' => true,
        'group' => 'metatags',
    ),
    array(
        'name' => 'replace',        // allow short names in autotags
        'default_value' => array(
            'key'       => 'keywords',
            'keywords'  => 'keywords',
            'desc'      => 'description',
            'description' => 'description',
            'au'        => 'author',
            'author'    => 'author',
            'gen'       => 'generator',
            'generator' => 'generator',
            'robots'    => 'robots',
        ),
        'type' => '*text',
        'subgroup' => 0,
        'fieldset' => 0,
        'selection_array' => 0,
        'sort' => 20,
        'set' => true,
        'group' => 'metatags',
    ),
    array(
        'name' => 'show_editor',    // show tags to editors in rendered contents?
        'default_value' => false,
        'type' => 'select',
        'subgroup' => 0,
        'fieldset' => 0,
        'selection_array' => 0,
        'sort' => 30,
        'set' => true,
        'group' => 'metatags',
    ),
    array(
        'name' => 'add_author',     // True to add article author automatically
        'default_value' => false,
        'type' => 'select',
        'subgroup' => 0,
        'fieldset' => 0,
        'selection_array' => 0,
        'sort' => 40,
        'set' => true,
        'group' => 'metatags',
    ),
    array(
        'name' => 'defaults',
        'default_value' => array(),
        'type' => '*text',
        'subgroup' => 0,
        'fieldset' => 0,
        'selection_array' => 0,
        'sort' => 50,
        'set' => true,
        'group' => 'metatags',
    ),
    array(
        'name' => 'def_props',
        'default_value' => array(),
        'type' => '*text',
        'subgroup' => 0,
        'fieldset' => 0,
        'selection_array' => 0,
        'sort' => 60,
        'set' => true,
        'group' => 'metatags',
    ),
);


/**
 * Initialize Metatags plugin configuration.
 *
 * @return  boolean     True on success, False on error (not used)
 */
function plugin_initconfig_metatags()
{
    global $metaConfigData;

    $c = config::get_instance();
    if (!$c->group_exists('metatags')) {
        USES_lib_install();
        foreach ($metaConfigData AS $cfgItem) {
            _addConfigItem($cfgItem);
        }
    } else {
        Log::system(Log::ERROR, 'initconfig error: Metatags config group already exists');
    }
    return true;
}
