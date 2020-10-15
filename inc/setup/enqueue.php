<?php 
namespace NextCode\Inc\Setup;
defined( 'ABSPATH' ) || exit;

use \NextCode\Inc\Setup\Ncode_common as Ncode_common;

class Ncode_Enqueue extends Ncode_common
{
	private static $instance;

	public static function instance(){
		if (!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
	}

	public function _init() {
		// admin
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_admin' ) );

		//front-end
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_front' ) );
	}
	
	public function enqueue_admin() {
		// enqueue all our scripts
		wp_register_script( 'nx-icons', parent::_plugin_url() . 'assets/nx/nx-icons.js', [ 'jquery' ], parent::_version(), true );
		wp_register_script( 'nx-code', parent::_plugin_url() . 'assets/nx/nx-code.js', [ 'jquery' ], parent::_version(), true );
		wp_register_script( 'nx-repeater', parent::_plugin_url() . 'assets/nx/nx-repeater.js', ['nx-code'], parent::_version(), true );
		wp_register_script( 'nx-multistep', parent::_plugin_url() . 'assets/nx/nx-multistep.js', ['jquery'], parent::_version(), true );
		
		wp_register_style( 'nextcode-style', parent::_plugin_url() . 'assets/style.css', false, parent::_version() );
        wp_register_script( 'nextcode-js', parent::_plugin_url() . 'assets/script.js', [ 'jquery', 'media-upload', 'thickbox'], parent::_version(), true );
		wp_localize_script('nextcode-js', 'ncode_url', array( 'siteurl' => get_option('siteurl'), 'nonce' => wp_create_nonce( 'wp_rest' ), 'resturl' => get_rest_url(), 'ajax' => admin_url('admin-ajax.php') ));

		// select 2
		wp_register_style( 'nextcode-select2', parent::_plugin_url() . 'assets/select2/select2-min.css', false, parent::_version() );
        wp_register_script( 'nextcode-select2', parent::_plugin_url() . 'assets/select2/select2-min.js', [ 'jquery'], parent::_version(), true );
		
		//flatpickr
		wp_register_style( 'nextcode-flatpickr', parent::_plugin_url() . 'assets/flatpickr/flatpickr.min.css', false, parent::_version() );
        wp_register_script( 'nextcode-flatpickr', parent::_plugin_url() . 'assets/flatpickr/flatpickr.js', [ 'jquery'], parent::_version(), true );
		
		//slider
		wp_register_script( 'nextcode-dateformat', parent::_plugin_url() . 'assets/slider/formatDate.js', [ 'jquery'], parent::_version(), true );
		wp_register_style( 'nextcode-range-slider', parent::_plugin_url() . 'assets/slider/mb.slider.css', false, parent::_version() );
        wp_register_script( 'nextcode-range-slider', parent::_plugin_url() . 'assets/slider/jquery.mb.slider.js', [ 'jquery'], parent::_version(), true );
		
		// color picker
		wp_register_style( 'nextcode-color', parent::_plugin_url() . 'assets/color/nano.min.css', false, parent::_version() );
        wp_register_script( 'nextcode-color', parent::_plugin_url() . 'assets/color/pickr.min.js', [ 'jquery'], parent::_version(), true );
        wp_register_script( 'nextcode-color5', parent::_plugin_url() . 'assets/color/pickr.es5.min.js', [ 'jquery'], parent::_version(), true );
		
		 // code editor 
		 wp_register_script( 'ncode-code_editor', parent::_plugin_url() . 'assets/nx/code-editor/code-editor.js', [ 'jquery'], parent::_version(), true );
		 wp_register_script( 'ncode-code_editor_css', parent::_plugin_url() . 'assets/nx/code-editor/css-editor.js', [ 'jquery'], parent::_version() );
		 wp_register_style( 'ncode-code_editor', parent::_plugin_url() . 'assets/nx/code-editor/code-editor.css', false, parent::_version() );
		
	}

	public function enqueue_front(){
		wp_register_style( 'nextcode-public', parent::_plugin_url() . 'assets/public.css', false, parent::_version() );
        
	}
}