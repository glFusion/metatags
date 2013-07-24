<?php
// +--------------------------------------------------------------------------+
// | Meta Tags Plugin for glFusion                                            |
// +--------------------------------------------------------------------------+
// | metatags.php                                                             |
// |                                                                          |
// | Plugin configuration                                                     |
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

$_METATAGS_CONF = array();

// Plugin info

$_METATAGS_CONF['pi_name']          = 'metatags';
$_METATAGS_CONF['pi_display_name']  = 'MetaTags';
$_METATAGS_CONF['pi_version']       = '1.0.7';
$_METATAGS_CONF['gl_version']       = '1.3.0';
$_METATAGS_CONF['pi_url']           = 'http://www.glfusion.org/';
?>