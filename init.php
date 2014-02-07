<?php
/*
Plugin Name: Alternate Theme Selector
Plugin URI: http://imperativeideas.com
Description: Configure alternate themes for older browsers
Author: Imperative Ideas
Author URI: http://www.imperativeideas.com
Version: 1.1.2
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    die;
}

// Add some global locations
define('ATS_VERSION', '1.1.1');
define('ATS_NAME', 'Alternate Theme Selector');
define('ATS_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('ATS_PLUGIN_URL', plugin_dir_url(__FILE__));
define('USER_AGENT', $_SERVER['HTTP_USER_AGENT']);

// Get the list of installed themes
$themelist = wp_get_themes();
$themes = array();
foreach ($themelist as $key => $object) {
    $themes[$key] = $object->name;
}

//Set up a Redux administrative interface

// Check for the plugin and if it doesn't exist, include the plugin's version of the framework
if (!class_exists('ReduxFramework') && file_exists(ATS_PLUGIN_PATH . '/ReduxFramework/ReduxCore/framework.php')) {
    require_once(ATS_PLUGIN_PATH . '/ReduxFramework/ReduxCore/framework.php');
}

// Then get our options file for this plugin
if (!isset($redux_demo) && file_exists(ATS_PLUGIN_PATH . '/library/options.php')) {
    require_once(ATS_PLUGIN_PATH . '/library/options.php');
}

// Fetch the switching logic
require_once "library/themeswitch.php";