<?php
namespace NextCode\Inc\Fileds\Box_Shadow;
defined( 'ABSPATH' ) || exit;

use \NextCode\Inc\Fileds as Fileds;

use \NextCode\Inc\Setup\Ncode_common as Ncode_common;

Class Ncode_Box_Shadow Extends Ncode_common{

    private $settings = [];
    private $key = '';
    private $option_key = '';
    private $option_data = [];

    private $args = [
        'id'    => '',
        'type'    => 'box_shadow',
        'title'   => '',
        'desc'       => '',
        'default'    => '',
        'attr' => [],
        'action' => [],
    ];

    private $default = [
        'color' => '#333',
        'horizontal' => '0',
        'vertical' => '0',
        'blur' => '10',
        'spread' => '0',
        'type' => 'no-shadow',
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
        $this->args['default'] = isset( $this->args['default'] ) ? $this->args['default'] : $this->default;
        
        $name = $this->args['id'];
        $id = $this->args['id'];
        if( isset($this->option_data[$this->key][$name]) ){
            $this->args['default'] = $this->option_data[$this->key][$name];
        }

        $repeater = ($this->args['repeater']) ?? false;
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

    /*
    ** Render css
    */
    public function css_render($output, $value, $fileds= []){
        $selector = isset( $output['selector'] ) ? $output['selector'] : '';
        $render = isset( $output['render'] ) ? $output['render'] : '';
        $selectors = isset( $output['selectors'] ) ? $output['selectors'] : '';
        $css_render = "";
        
        $color = ($value['color']) ?? '';
        $type = ($value['type']) ?? '';
        $horizontal = ($value['horizontal']) ?? '0';
        $vertical = ($value['vertical']) ?? '0';
        $blur = ($value['blur']) ?? '0';
        $spread = ($value['spread']) ?? '0';
       
        $render_css = ''.$horizontal.'px '.$horizontal.'px '.$blur.'px '.$spread.'px '.$color.' '.$type;
        $render = !empty($render) ? $render : 'box-shadow';

        if( is_array($selector) && !empty($selector) ){
            foreach($selector as $vs){
                if( empty($vs) ){
                    continue;
                }
                $css_render .= "$vs { ";    
                $css_render .= "$render:". $render_css.";";
                $css_render .= "-webkit-$render:". $render_css.";";
                $css_render .= "}";
            }
        }else{
            $css_render .= "$selector { ";
            $css_render .= "$render:".$render_css.";";  
            $css_render .= "-webkit-$render:".$render_css.";";  
            $css_render .= "}";
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