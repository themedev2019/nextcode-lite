<?php
namespace NextCode\Inc\Fileds\Gallery;
defined( 'ABSPATH' ) || exit;

use \NextCode\Inc\Setup\Ncode_common as Ncode_common;

Class Ncode_Gallery Extends Ncode_common{

    private $settings = [];
    private $key = '';
    private $option_key = '';
    private $option_data = [];

    private $arg = [
        'id'    => '',
        'type'    => 'gallery',
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
        $this->args['attr']['type'] = 'hidden';
        $this->args['default'] = ($this->args['default']) ?? '';
        $this->args['preview'] = ($this->args['preview']) ?? true;
        $this->args['attr']['value'] = isset( $this->args['attr']['value'] ) ? $this->args['attr']['value'] : $this->args['default'];
        $this->args['add_title'] = ($this->args['add_title']) ?? esc_html__('Upload', 'nextcode');
        $this->args['edit_title'] = ($this->args['edit_title']) ?? esc_html__('Edit', 'nextcode');
        $this->args['clear_title'] = ($this->args['clear_title']) ?? esc_html__('Remove', 'nextcode');
        
        $name = $this->args['id'];
        $id = $this->args['id'];

        if( isset($this->option_data[$this->key][$name]) ){
            $this->args['attr']['value'] = ($this->option_data[$this->key][$name]) ?? '';
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

    public function enqueue( ){
        // code
    }

	public static function instance(){
		if (!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
	}
}