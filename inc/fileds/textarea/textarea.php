<?php
namespace NextCode\Inc\Fileds\Textarea;
defined( 'ABSPATH' ) || exit;

use \NextCode\Inc\Setup\Ncode_common as Ncode_common;

Class Ncode_Textarea Extends Ncode_common{

    private $arg = [
        'id'    => '',
        'type'    => 'textrea',
        'title'   => '',
        'desc'       => '',
        'default'    => '',
        'attr' => [],
        'action' => [],
    ];
    private static $instance;


    public function render( $params, $setting = [] , $key = '' ){
         
        $this->key = $key;
        $this->settings = $setting;

        $this->option_key = isset($setting['options_key']) ? $setting['options_key'] : '';
        $this->option_type = isset($setting['options_type']) ? $setting['options_type'] : 'options';
        $this->options_ids = isset($setting['options_ids']) ? $setting['options_ids'] : 0;

        $this->option_data = $this->_get_options( $this->option_key, $this->option_type, $this->options_ids);
        $array_dec = isset($setting['options_array']) ? $setting['options_array'] : 'options['.$this->key.']';
        // code here
        
        $this->args = $params;
        $this->args['attr']['id'] = isset( $this->args['attr']['id'] ) ? $this->args['attr']['id'] : $this->args['id'];
        $this->args['attr']['class'] = isset( $this->args['attr']['class'] ) ? 'nxinput-box intextarea '.$this->args['attr']['class'] : 'nxinput-box intextarea';
        $this->args['default'] = isset( $this->args['default'] ) ? $this->args['default'] : '';
        
        $name = $this->args['id'];
        $id = $this->args['id'];
        if( isset($this->option_data[$this->key][$name]) ){
            $this->args['default'] = $this->option_data[$this->key][$name];
        }

        $repeater = $this->args['repeater'] ?? false;
        if($repeater){
            $r_name =  $this->args['attr']['name'] ?? '';
            if( !empty($r_name) ){
                $this->args['attr']['name'] = $r_name;
            }
        } else{
            $this->args['attr']['name'] =  $this->args['id'];
        }
        
        // load js / css
        $this->enqueue();
        extract( $this->args );
        include ( __DIR__ . '/templates.php');
    }

    public function enqueue(){

    }
    
	public static function instance(){
		if (!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
	}
}