<?php
namespace NextCode\Inc\Fileds\Icon;
defined( 'ABSPATH' ) || exit;

use \NextCode\Inc\Fileds as Fileds;

use \NextCode\Inc\Setup\Ncode_common as Ncode_common;

Class Ncode_Icon Extends Ncode_common{
    
    private $settings = [];
    private $key = '';
    private $option_key = '';
    private $option_data = [];

    private $args = [
        'id'    => '',
        'type'    => 'icon',
        'title'   => '',
        'desc'       => '',
        'default'    => [],
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
        $this->args['attr']['class'] = isset( $this->args['attr']['class'] ) ? 'ncode-icon-value '.$this->args['attr']['class'] : 'ncode-icon-value';
        $this->args['attr']['value'] = isset( $this->args['attr']['value'] ) ? $this->args['attr']['value'] : $this->args['default'];
        $this->args['button_title'] = isset( $this->args['button_title'] ) ? $this->args['button_title'] : 'Add Icom';
        $this->args['remove_title'] = isset( $this->args['remove_title'] ) ? $this->args['remove_title'] : 'Remove Icom';
       
        $name = $this->args['id'];
        $id = $this->args['id'];
        if( isset($this->option_data[$this->key][$name]) ){
            $this->args['attr']['value'] = $this->option_data[$this->key][$name];
        }
        $this->args['default'] = $this->args['attr']['value'];
        
        $hidden = ( empty( $this->args['attr']['value'] ) ) ? ' hidden' : '';
        $nonce  = wp_create_nonce( 'ncode_icon_nonce' );

        $repeater = $this->args['repeater'] ?? false;
        if($repeater){
            $r_name =  $this->args['attr']['name'] ?? '';
            if( !empty($r_name) ){
                $this->args['attr']['name'] = $r_name;
            }
        } else{
            $this->args['attr']['name'] =  $this->args['id'];
        }

        
        $this->enqueue();
        // code here
        extract( $this->args );
        include ( __DIR__ . '/templates.php');
    }

    public function enqueue(){
       
        add_action( 'admin_footer', array( &$this, 'add_footer_modal_icon' ) );
        add_action( 'customize_controls_print_footer_scripts', array( &$this, 'add_footer_modal_icon' ) );

    }

    public function add_footer_modal_icon() {
        include ( __DIR__ . '/icons-modal.php');
    }
    
    /*
    ** Render css
    */
    public function css_render($output, $value, $fileds= []){
        $selector = isset( $output['selector'] ) ? $output['selector'] : '';
        $render = isset( $output['render'] ) ? $output['render'] : '';
        $selectors = isset( $output['selectors'] ) ? $output['selectors'] : '';
        $css_render = "";

        if( empty($render) || is_array($value) ){
           return;
        }

        if( is_array($selector) && !empty($selector) ){
            foreach($selector as $vs){
                if( empty($vs) ){
                    continue;
                }
                $css_render .= "$vs { $render:$value; }";
            }
        }else{
            $css_render .= "$selector { $render:$value; }";
        }
        
        if( !empty($selectors) && is_array($selectors) ){
            foreach($selectors as $ck=>$cv){
                if( strstr($cv, "{{VALUE}}") ){
                    $value_data = str_replace( "{{VALUE}}" , $value, $cv);
                    $css_render .= "$ck { $value_data }";
                }else{
                    $css_render .= "$ck { $cv:$value; }";
                }
               
            }
        }

        return $css_render;
    }

    
	public static function instance(){
		if (!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
	}
}