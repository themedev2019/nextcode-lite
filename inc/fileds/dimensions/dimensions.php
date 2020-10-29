<?php
namespace NextCode\Inc\Fileds\Dimensions;
defined( 'ABSPATH' ) || exit;

use \NextCode\Inc\Setup\Ncode_common as Ncode_common;

Class Ncode_Dimensions Extends Ncode_common{

    private $settings = [];
    private $key = '';
    private $option_key = '';
    private $option_data = [];

    private $args = [
        'id'    => '',
        'type'    => 'dimensions',
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
        $this->args['attr']['type'] = 'number';
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

        $name_dimention =  $this->args['id'];
        $repeater = $this->args['repeater'] ?? false;
        if($repeater){
            $r_name =  $this->args['attr']['name'] ?? '';
            if( !empty($r_name) ){
               $name_dimention = $r_name;
            }
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
        
        $top = ($value['top']) ?? '';
        $right = ($value['right']) ?? '';
        $bottom = ($value['bottom']) ?? '';
        $left = ($value['left']) ?? '';
        $unit = ($value['unit']) ?? '';
        
        $render_css = '';
        if( $top != '' || $right != '' || $bottom != '' || $left != ''){
            $render_css = ''.$top.$unit.' '.$right.$unit.' '.$bottom.$unit.' '.$left.$unit;
        } else{
            return;
        }
        
        
        $render = !empty($render) ? $render : 'color';
        if( is_array($selector) && !empty($selector) ){
            foreach($selector as $vs){
                if( empty($vs) ){
                    continue;
                }
                $css_render .= "$vs { $render:$render_css; }";
            }
        }else{
            $css_render .= "$selector { $render:$render_css; }";
        }

        if( !empty($selectors) && is_array($selectors) ){
            foreach($selectors as $ck=>$cv){
                if( strstr($cv, "{{TOP}}") || strstr($cv, "{{LEFT}}") || strstr($cv, "{{RIGHT}}") || strstr($cv, "{{BOTTOM}}")){
                    $value_data = str_replace( ["{{TOP}}", "{{RIGHT}}", "{{BOTTOM}}", "{{LEFT}}"], [$top, $right, $bottom, $left], $cv);
                    $value_data = str_replace( ["{{UNIT}}"], [$unit], $value_data);
                    
                    $css_render .= "$ck { $value_data }";
                }else{
                    $css_render .= "$ck { $cv:$render_css; }";
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