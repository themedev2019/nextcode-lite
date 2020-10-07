<?php
namespace NextCode\Inc\Fileds\Border;
defined( 'ABSPATH' ) || exit;

use \NextCode\Inc\Fileds as Fileds;

use \NextCode\Inc\Setup\Ncode_common as Ncode_common;

Class Ncode_Border Extends Ncode_common{

    private $settings = [];
    private $key = '';
    private $option_key = '';
    private $option_data = [];

    private $args = [
        'id'    => '',
        'type'    => 'border',
        'title'   => '',
        'desc'       => '',
        'default'    => '',
        'attr' => [],
        'action' => [],
    ];

    private $dimensions = [
        'top'       => 'TOP',
        'right'     => 'RIGHT',
        'bottom'    => 'BOTTOM',
        'left'      => 'LEFT',
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
        $this->args['type'] = 'dimensions';
        $this->args['attr']['id'] = isset( $this->args['attr']['id'] ) ? $this->args['attr']['id'] : $this->args['id'];
        $this->args['default'] = isset( $this->args['default'] ) ? $this->args['default'] : '';
        $this->args['allowed_dimensions'] = isset( $this->args['allowed_dimensions'] ) ? $this->args['allowed_dimensions'] : 'all';
        $this->args['dimensions'] = isset( $this->args['dimensions'] ) ? $this->args['dimensions'] : $this->dimensions;
        $this->args['size_units'] = isset( $this->args['size_units'] ) ? $this->args['size_units'] : ['px', '%', 'em'];
        
        if( empty($this->args['dimensions']) || !is_array($this->args['dimensions']) ){
            $this->args['dimensions'] = $this->dimensions;
        }
        
        $name = $this->args['id'];
        $id = $this->args['id'];
        if( isset($this->option_data[$this->key][$name]) ){
            $this->args['default'] = $this->option_data[$this->key][$name];
        }
 
        $radius_options = ($this->args['radius_options']) ?? true;

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
        $style = ($value['style']) ?? '';
        $top = ($value['top']) ?? '';
        $right = ($value['right']) ?? '';
        $bottom = ($value['bottom']) ?? '';
        $left = ($value['left']) ?? '';
        $unit = ($value['unit']) ?? 'px';
        $radius_top = ($value['radius_top']) ?? '';
        $radius_right = ($value['radius_right']) ?? '';
        $radius_bottom = ($value['radius_bottom']) ?? '';
        $radius_left = ($value['radius_left']) ?? '';

        $render_css = '';
        if( !empty($color) ){
            $render_css .= "border-color: $color;";
        }
        if( !empty($style) ){
            $render_css .= "border-style: $style;";
        }
        if( !empty($top) ){
            $render_css .= "border-top-width: $top$unit;";
        }
        if( !empty($right) ){
            $render_css .= "border-right-width: $right$unit;";
        }
        if( !empty($bottom) ){
            $render_css .= "border-bottom-width: $bottom$unit;";
        }
        if( !empty($left) ){
            $render_css .= "border-left-width: $left$unit;";
        }
        if( !empty($radius_top) ){
            $render_css .= "border-top-left-radius: $radius_top$unit;";
        }
        if( !empty($radius_right) ){
            $render_css .= "border-top-right-radius: $radius_right$unit;";
        }
        if( !empty($radius_bottom) ){
            $render_css .= "border-bottom-right-radius: $radius_bottom$unit;";
        }
        if( !empty($radius_left) ){
            $render_css .= "border-bottom-left-radius: $radius_left$unit;";
        }

        if( is_array($selector) && !empty($selector) ){
            foreach($selector as $vs){
                if( empty($vs) ){
                    continue;
                }
                $css_render .= "$vs {";    
                $css_render .= $render_css;
                $css_render .= "}";
            }
        }else{
            $css_render .= "$selector {";
            $css_render .= $render_css;  
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