<?php
namespace NextCode;
defined( 'ABSPATH' ) || exit;

class Ncode_Loader{
    
	public static function _run() {
		spl_autoload_register( [ __CLASS__, '_autoload' ] );
    }
  
	private static function _autoload( $load ) {
        if ( 0 !== strpos( $load, __NAMESPACE__ ) ) {
            return;
        }
        
        $filename = strtolower(
            preg_replace(
                [ '/\b'.__NAMESPACE__.'\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/' ],
                [ '', '$1-$2', '-', DIRECTORY_SEPARATOR],
                $load
            )
        );

        $filename = str_replace('ncode-', '', $filename);

       $file = plugin_dir_path(__FILE__) . $filename . '.php';
        if ( file_exists( $file ) ) {
           require_once( $file );
        }
    }
}
