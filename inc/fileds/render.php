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
		$this->key = trim($key);

		$f_id = isset($f['id']) ? $f['id'] : ''; 
		$f_type = isset($f['type']) ? trim($f['type']) : '';
		if( empty($f_type) ){
			return;
		}
		$f = self::_remove_white($f);
		// load class
		parent::add( $f_type, $f);
	}

	private static function _remove_white($f){
		foreach($f as $k=>$v){
			if(is_array($v)){
				$f[trim($k)] = self::_remove_white($v);
			}else{
				$f[trim($k)] = trim($v);
			}
		}
		return $f;
	}
}
