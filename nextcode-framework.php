<?php
defined( 'ABSPATH' ) || exit;
/**
 * Plugin Name: nCode Options Framework - Lite
 * Description: The nCode is a best Options Framewok for Create Admin Options, Custom Posttype, Metabox, SubMenu, Nav Options, Profiles Options, Widgets, Shortcode, Comment Options, Texonomy Options etc.
 * Plugin URI: http://ddesks.com/ncode
 * Author: dDesks
 * Version: 1.0.0
 * Author URI: http://ddesks.com/
 *
 * Text Domain: nextcode
 *
 * @package nCode
 * @category Pro
 *
 * nCode is an Option Framework for Theme Builder.
 *
 * License:  GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

define( 'NEXTCODE_FILE_', __FILE__ );
define( 'NEXTCODE_URL', plugin_dir_url(NEXTCODE_FILE_) );
define( 'NEXTCODE_DIR', plugin_dir_path(NEXTCODE_FILE_) );

include 'loader.php'; 
include 'plugin.php';

// load plugin
add_action( 'plugins_loaded', function(){
	// load text domain
	load_plugin_textdomain( 'nextcode', false, basename( dirname( __FILE__ ) ) . '/languages'  );

	// load plugin instance
	\NextCode\Ncode_Plugin::instance()->init();
}, 150);




