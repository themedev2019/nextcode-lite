<?php
defined( 'ABSPATH' ) || exit;

use \NextCode\Inc\Setup as Setup;
use \NextCode\Inc\Fileds as Fileds;

//option load
use \NextCode\Inc\Setup\Ncode_Create_Option as Ncode_Options;

Class NCOPT{

    public static function init() {

        // Init action
        do_action( 'ncode_init' );
  
        add_action( 'after_setup_theme', array( 'NCOPT', 'render' ) );
        add_action( 'switch_theme', array( 'NCOPT', 'render' ) );
        
        add_action( 'admin_enqueue_scripts', array( 'NCOPT', 'enqueue_admin' ) );
        //front-end
        add_action( 'wp_enqueue_scripts', array( 'NCOPT', 'enqueue_front' ) );
        add_action( 'wp_enqueue_scripts', array( 'NCOPT', 'typography_enqueue' ), 80 );
        add_action( 'wp_head', array( 'NCOPT', 'add_custom_css' ), 80 );
  
      }

    // admin option 
    public static function create_admin($key, $arg = []){
        Ncode_Options::instance()->admin_option($key, $arg );
    }

    // custom posttype
    public static function create_posttype($key, $arg = []){
        Ncode_Options::instance()->custom_posttype($key, $arg );
    }

    // custom posttype
    public static function create_submenu_posttype($key, $arg = []){
        Ncode_Options::instance()->custom_sub_posttype($key, $arg );
    }


    // taxonomy
    public static function create_taxonomy($key,$arg = []){
        Ncode_Options::instance()->create_taxonomy($key, $arg );
    }

    // metabox
    public static function create_metabox($key, $arg = []){
        Ncode_Options::instance()->create_metabox($key, $arg );
    }

    // profiles
    public static function create_profile($key, $arg = []){
        Ncode_Options::instance()->create_profile_data($key, $arg );
    }

    // nav
    public static function create_nav($key, $arg = []){
        Ncode_Options::instance()->create_nav_data($key, $arg );
    }

    // widgets
    public static function create_widget($key, $arg = []){
        Ncode_Options::instance()->create_widget_data($key, $arg );
    }

    // shortcode
    public static function create_shortcode($key, $arg = []){
        Ncode_Options::instance()->create_shortcode_data($key, $arg );
    }

    // metabox
    public static function create_commentMetabox($key, $arg = []){
        Ncode_Options::instance()->create_comment_metabox($key, $arg );
    }

    // load section 
    public static function create_section($key, $arg = []){
        Ncode_Options::instance()->section($key, $arg );
    }


    // load field 
    public static function create_field($key, $arg = []){
        Ncode_Options::instance()->field($key, $arg );
    }


    public static function get_option($key, $params = '', $default = ''){
        $settings = get_option($key, []);
        if( !empty($params) ){
            $value = isset($settings[$params]) ? $settings[$params] : '';
        }
        
    }

    public static function render(){
        Ncode_Options::instance()->framework_render();

        do_action( 'ncode_loaded' );
    }

    
    public static function enqueue_admin(){
        Ncode_Options::instance()->render_script_admin();
        
    }

    public static function enqueue_front(){
        Ncode_Options::instance()->render_script_public();
    }

    public static function add_custom_css(){
        Ncode_Options::instance()->render_custom_css();
    }

    public static function typography_enqueue(){
        Ncode_Options::instance()->render_typography_enqueue();
    }

    public static function auto_load( $dir, $noload = [], $ext = ['php', 'PHP']){
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST, 
            RecursiveIteratorIterator::CATCH_GET_CHILD
        );
        foreach($iterator as $file) {
            if( is_file($file->getPathname()) ){
                $fl = pathinfo($file->getPathname());
                if( isset($fl['extension']) && in_array($fl['extension'], $ext) && !in_array($fl['basename'], $noload) ){
                    include_once $file->getPathname();
                }
            }
        }
    }

}

if( !function_exists('ncode_get_options') ){
    function ncode_get_options( $key = '', $args = [], $default = '' ){
        if( empty($key) || $key == ''){
            return;
        }
        $value = get_option( $key );
        if( (!isset($value) || $value == '') ){
            return $default;
        }

        if( !empty($args) && is_array( $args ) ){
            foreach( $args as $v){
                $value = ($value[$v]) ?? $default;
            }
        }
        return $value;
    }
}

if( !function_exists('ncode_get_post_meta') ){
    function ncode_get_post_meta( $id, $key = '', $args = [], $default = '' ){
        if( empty($key) || $key == ''){
            return;
        }
        $value = get_post_meta($id, $key, true);
        if( (!isset($value) || $value == '') ){
            return $default;
        }

        if( !empty($args) && is_array( $args ) ){
            foreach( $args as $v){
                $value = ($value[$v]) ?? $default;
            }
        }
        return $value;
    }
}

if( !function_exists('ncode_get_user_meta') ){
    function ncode_get_user_meta( $id, $key = '', $args = [], $default = '' ){
        if( empty($key) || $key == ''){
            return;
        }
        $value = get_user_meta($id, $key, true);
        if( (!isset($value) || $value == '') ){
            return $default;
        }

        if( !empty($args) && is_array( $args ) ){
            foreach( $args as $v){
                $value = ($value[$v]) ?? $default;
            }
        }
        return $value;
    }
}

if( !function_exists('ncode_get_term_meta') ){
    function ncode_get_term_meta( $id, $key = '', $args = [], $default = '' ){
        if( empty($key) || $key == ''){
            return;
        }
        $value = get_term_meta($id, $key, true );
        if( (!isset($value) || $value == '') ){
            return $default;
        }

        if( !empty($args) && is_array( $args ) ){
            foreach( $args as $v){
                $value = ($value[$v]) ?? $default;
            }
        }
        return $value;
    }
}

if( !function_exists('ncode_get_comment_meta') ){
    function ncode_get_comment_meta( $id, $key = '', $args = [], $default = '' ){
        if( empty($key) || $key == ''){
            return;
        }
        $value = get_comment_meta($id, $key, true );
        if( (!isset($value) || $value == '') ){
            return $default;
        }

        if( !empty($args) && is_array( $args ) ){
            foreach( $args as $v){
                $value = ($value[$v]) ?? $default;
            }
        }
        return $value;
    }
}

NCOPT::init();