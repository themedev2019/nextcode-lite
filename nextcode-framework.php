<?php
defined( 'ABSPATH' ) || exit;
/**
 * Plugin Name: NextCode
 * Description: The NextCode is an Option Framework for Theme Builder.
 * Plugin URI: https://nextcode.themedev.net/
 * Author: ThemeDev
 * Version: 1.0.4
 * Author URI: http://themedev.net
 *
 * Text Domain: nextcode
 *
 * @package NextCode
 * @category Pro
 *
 * NextCode is an Option Framework for Theme Builder.
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




