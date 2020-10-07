<?php
namespace NextCode;
defined( 'ABSPATH' ) || exit;

final class Ncode_Plugin{

    private static $instance;

    private $template;

    public function __construct(){
        Ncode_Loader::_run(); 
    }
    
    public static function version(){
        return '1.0.0';
    }
   
    public static function php_version(){
        return '5.6';
    }

    
	public static function plugin_file(){
		return NEXTCODE_FILE_;
	}
    
	public static function plugin_url(){
		return trailingslashit(plugin_dir_url( self::plugin_file() ));
	}

	
	public static function plugin_dir(){
		return trailingslashit(plugin_dir_path( self::plugin_file() ));
    }

	
	public static function inc_url(){
		return self::plugin_url() . 'inc/';
	}

	
	public static function inc_dir(){
		return self::plugin_dir() . 'inc/';
	}
    
    public function init(){   
       // call inc 
       Inc\Ncode_Load::instance()->_init();
    }

    public static function instance(){
        if ( is_null( self::$instance ) ){
            self::$instance = new self();
            do_action( 'nextcode/loaded' );
        }
        return self::$instance;
    }

}