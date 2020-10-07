<?php
namespace NextCode\Inc\Fileds;
defined( 'ABSPATH' ) || exit;

Class Ncode_Render extends Ncode_Load{
    
    private static $instance;

	public static function instance(){
		if (!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
	}

	public function _init( $f, $args = [],  $key = '') {
		$this->params = $args;
		$this->key = $key;

		$f_id = isset($f['id']) ? $f['id'] : ''; 
		$f_type = isset($f['type']) ? $f['type'] : '';
		if( empty($f_type) ){
			return;
		}
		// load class
		parent::add( $f_type, $f);
	}
}
