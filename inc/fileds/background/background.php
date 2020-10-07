<?php
namespace NextCode\Inc\Fileds\Background;
defined( 'ABSPATH' ) || exit;

use \NextCode\Inc\Fileds as Fileds;

use \NextCode\Inc\Setup\Ncode_common as Ncode_common;

Class Ncode_Background Extends Ncode_common{

    private $settings = [];
    private $key = '';
    private $option_key = '';
    private $option_data = [];

    private $args = [
        'id'    => '',
        'type'    => 'background',
        'title'   => '',
        'desc'       => '',
        'default'    => '',
        'attr' => [],
        'action' => [],
    ];

    private $default = [
        'bgtype' => 'classic',
        'color' => '',
        'location' => '0',
        'color2' => '',
        'location2' => '',
        'angle' => '0',
        'type' => 'linear',
        'position' => 'center center',
        'image' => '',
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
        
        $this->args['background_image'] = isset( $this->args['background_image'] ) ? $this->args['background_image'] : true;
        $this->args['background_gradient'] = isset( $this->args['background_gradient'] ) ? $this->args['background_gradient'] : true;
        
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
    
    public function image_position(){
        return apply_filters( 'ncode_fields_background_position', [
            'center center' => esc_html__( 'Center Center', 'nextcode' ),
            'center left' => esc_html__(  'Center Left', 'nextcode' ),
            'center right' => esc_html__( 'Center Right', 'nextcode' ),
            'top center' => esc_html__( 'Top Center', 'nextcode' ),
            'top left' => esc_html__( 'Top Left', 'nextcode' ),
            'top right' => esc_html__( 'Top Right', 'nextcode' ),
            'bottom center' => esc_html__( 'Bottom Center', 'nextcode' ),
            'bottom left' => esc_html__( 'Bottom Left', 'nextcode' ),
            'bottom right' => esc_html__( 'Bottom Right', 'nextcode' ),
        ]);
    }

    public function image_attachment(){
        return apply_filters( 'ncode_fields_background_attachment', [
            '' => esc_html__( 'Default', 'nextcode' ),
            'scroll' => esc_html__( 'Scroll', 'nextcode' ),
            'fixed' => esc_html__( 'Fixed', 'nextcode' ),
        ]);
    }

    public function image_repeat(){
        return apply_filters( 'ncode_fields_background_repeat', [
            'no-repeat' => esc_html__( 'No-repeat', 'nextcode' ),
            'repeat' => esc_html__( 'Repeat', 'nextcode' ),
            'repeat-x' => esc_html__( 'Repeat-x', 'nextcode' ),
            'repeat-y' => esc_html__( 'Repeat-y', 'nextcode' ),
        ]);
    }

    public function image_size(){
        return apply_filters( 'ncode_fields_background_size', [
            '' => esc_html__( 'Default', 'nextcode' ),
            'auto' => esc_html__( 'Auto', 'nextcode' ),
            'cover' => esc_html__( 'Cover', 'nextcode' ),
            'contain' => esc_html__( 'Contain', 'nextcode' ),
        ]);
    }

    
    /*
    ** Render css
    */
    public function css_render($output, $value, $fileds= []){
        $selector = isset( $output['selector'] ) ? $output['selector'] : '';
        $render = isset( $output['render'] ) ? $output['render'] : '';
        $selectors = isset( $output['selectors'] ) ? $output['selectors'] : '';
        $css_render = "";

        $type = ($value['bgtype']) ?? 'classic';
        $color = ($value['color']) ?? '';
        $image = ($value['image']['url']) ?? '';

        if( $type == 'classic'){
            // background color
            if( !empty($color) ){
                if( !empty($render) ){
                    $bd_property = 'background';
                } else{
                    $bd_property = 'background-color';
                }
                if( is_array($selector) && !empty($selector) ){
                    foreach($selector as $vs){
                        if( empty($vs) ){
                            continue;
                        }
                        $css_render .= "$vs { $bd_property:$color; }";
                    }
                }else{
                    $css_render .= "$selector { $bd_property:$color; }";
                }
            }

            // background image
            if( !empty($image) ){
                if( !empty($render) ){
                    $bd_property = 'background';
                } else{
                    $bd_property = 'background-image';
                }
                
                $position = ($value['image']['position']) ?? '';
                $attachment = ($value['image']['attachment']) ?? '';
                $repeat = ($value['image']['repeat']) ?? '';
                $size = ($value['image']['size']) ?? '';

                if( is_array($selector) && !empty($selector) ){
                    foreach($selector as $vs){
                        if( empty($vs) ){
                            continue;
                        }
                        $css_render .= "$vs { $bd_property: url($image); ";

                        if( !empty($position) ){
                            $css_render .= "background-position: $position;";
                        }
                        if( !empty($attachment) ){
                            $css_render .= "background-attachment: $attachment;";
                        }
                        if( !empty($repeat) ){
                            $css_render .= "background-repeat: $repeat;";
                        }
                        if( !empty($size) ){
                            $css_render .= "background-size: $size;";
                        }
                        $css_render .= "}";
                    }
                }else{
                    $css_render .= "$selector { $bd_property: url($image); ";

                    if( !empty($position) ){
                        $css_render .= "background-position: $position;";
                    }
                    if( !empty($attachment) ){
                        $css_render .= "background-attachment: $attachment;";
                    }
                    if( !empty($repeat) ){
                        $css_render .= "background-repeat: $repeat;";
                    }
                    if( !empty($size) ){
                        $css_render .= "background-size: $size;";
                    }
                    $css_render .= "}";
                }
            }

        } else if( $type == 'gradient') {
            $location = ($value['location']) ?? '';
            $color2 = ($value['color2']) ?? '';
            $location2 = ($value['location2']) ?? '';
            $angle = ($value['angle']) ?? '0';
            $angle .= 'deg';
            $type = ($value['type']) ?? 'linear';
            $position = ($value['position']) ?? '';

            if( is_array($selector) && !empty($selector) ){
                foreach($selector as $vs){
                    if( empty($vs) ){
                        continue;
                    }
                    if($type == 'linear'){
                        $css_render .= "$vs { background-color: transparent; background-image: linear-gradient($angle, $color $location%, $color2 $location2%); }";
                    } else{
                        $css_render .= "$vs { background-color: transparent; background-image: radial-gradient(at $position, $color $location%, $color2 $location2%); }";
                    }
                    
                }
            }else{
                if($type == 'linear'){
                    $css_render .= "$selector { background-color: transparent; background-image: linear-gradient($angle, $color $location%, $color2 $location2%); }";
                } else{
                    $css_render .= "$selector { background-color: transparent; background-image: radial-gradient(at $position, $color $location%, $color2 $location2%); }";
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