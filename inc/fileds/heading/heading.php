<?php
namespace NextCode\Inc\Fileds\Heading;
defined( 'ABSPATH' ) || exit;

use \NextCode\Inc\Setup\Ncode_common as Ncode_common;

Class Ncode_Heading Extends Ncode_common{

    private $settings = [];
    private $key = '';
    private $option_key = '';
    private $option_data = [];

    private $args = [
        'id'    => '',
        'type'    => 'heading',
        'content'   => '',
        'sub_content'   => '',
        'tag'       => '',
        'attr' => [],
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
        $content = isset($this->args['content']) ? $this->args['content'] : '';
        $sub_content = isset($this->args['sub_content']) ? $this->args['sub_content'] : '';
        $id = $this->args['id'];
        
        // load js / css
        $this->enqueue();
        
       // target toggle
       $target_toggle = isset( $this->args['target_toggle'] ) ? $this->args['target_toggle'] : '';
       $target_field = isset( $target_toggle['field'] ) ? $target_toggle['field'] : '';
       $target_condition = isset( $target_toggle['condition'] ) ? $target_toggle['condition'] : '==';
       $target_value = isset( $target_toggle['value'] ) ? $target_toggle['value'] : '';
       
       $check_value = $this->target_toggle($this->args, $this->settings, $this->key);
       // parent_filed 
       $pr_field = $this->pre_field($this->args);

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