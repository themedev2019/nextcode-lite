<?php
namespace NextCode\Inc\Fileds\Typography;
defined( 'ABSPATH' ) || exit;

use \NextCode\Inc\Fileds as Fileds;

use \NextCode\Inc\Setup\Ncode_common as Ncode_common;

Class Ncode_Typography Extends Ncode_common{

    private $settings = [];
    private $key = '';
    private $option_key = '';
    private $option_data = [];

    private $fonts = [];

    private $args = [
        'id'    => '',
        'type'    => 'typography',
        'title'   => '',
        'desc'       => '',
        'default'    => '',
        'attr' => [],
        'action' => [],
    ];

    private $default = [
        'font-family' => '',
        'color' => '',
        'font-size' => '',
        'font-weight' => '',
        'text-transform' => '',
        'font-style' => '',
        'text-decoration' => '',
        'line-height' => '',
        'letter-spacing' => '',
        'word-spacing' => '',
        'text-align' => 'left',
        'text-index' => '',
        'font-variant' => '',
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

        if ( ! wp_script_is( 'ncode-webfontloader' ) ) {

            include ( __DIR__ . '/font/google-fonts.php');

            wp_enqueue_script( 'ncode-webfontloader', 'https://cdn.jsdelivr.net/npm/webfontloader@1.6.28/webfontloader.min.js', array( 'ncode' ), '1.6.28', true );
    
            $fonts = array();
    
            $customfont = apply_filters( 'ncode_field_typography_customwebfonts', array() );
    
            if ( ! empty( $customfont ) ) {
              $fonts['custom'] = array(
                'label' => esc_html__( 'Custom Web Fonts', 'ncode' ),
                'fonts' => $customfont
              );
            }
    
            $fonts['safe'] = array(
              'label' => esc_html__( 'Safe Web Fonts', 'ncode' ),
              'fonts' => apply_filters( 'ncode_field_typography_safewebfonts', array(
                'Arial',
                'Arial Black',
                'Helvetica',
                'Times New Roman',
                'Courier New',
                'Tahoma',
                'Verdana',
                'Impact',
                'Trebuchet MS',
                'Comic Sans MS',
                'Lucida Console',
                'Lucida Sans Unicode',
                'Georgia, serif',
                'Palatino Linotype'
              )
            ) );
            $font_gool =  array_keys(ncode_get_google_fonts());
            $fonts['google'] = array(
                'label' => esc_html__( 'Google Web Fonts', 'ncode' ),
                'fonts' => apply_filters( 'ncode_field_typography_googlewebfonts', $font_gool
                ) 
           );

           if( !empty($fonts) ){
               $font_dat = [];
                foreach($fonts as $v){
                    $lavel = ($v['label']) ?? '';
                    $fonts = ($v['fonts']) ?? [];
                    $fon_value = array_values($fonts);
                    $com = array_combine($fonts, $fon_value);
                    if( !empty($lavel) && !empty($fonts) ){
                        $font_dat[$lavel] = $com;
                    } else{
                        $font_dat[] = $com;
                    }
                }

                $this->fonts = $font_dat;
           }

           
        }

        $fontsall =  add_filter('ncode_fields_typography_fontfamily', function( $arr ){
            return array_merge($arr, $this->fonts); 
        }, 99, 1);

        return $this->fonts;
    }
    

    public function options(){
       return apply_filters( 'ncode_fields_typography_options', [
            'font-family' => ['type' => 'select2', 'title' => 'Font Family', 'options' => $this->font_family() ],
            'font-size' => ['type' => 'slider', 'title' => 'Font Size - px'],
            'text-align' => ['type' => 'choose', 'title' =>  'Align', 'options' => $this->text_align()],
            'font-weight' => ['type' => 'select', 'title' => 'Weight', 'options' => $this->font_weight() ],
            'text-transform' => ['type' => 'select', 'title' => 'Transform', 'options' => $this->text_transform() ],
            'font-style' => ['type' => 'select', 'title' => 'Font Style', 'options' => $this->font_style()],
            'text-decoration' => ['type' => 'select', 'title' => 'Decoration', 'options' => $this->text_decoration()],
            'line-height' => ['type' => 'slider', 'title' => 'Line Height - px'],
            'letter-spacing' => ['type' => 'slider', 'title' => 'Letter Spacing - px'],
            'word-spacing' => ['type' => 'slider', 'title' => 'Word Spacing - px'],
            //'text-index' => ['type' => 'slider', 'title' => 'Text Index'],
            //'font-variant' => ['type' => 'select', 'title' => 'Font Variant', 'options' => $this->font_variant()],
        ]);
    }

    public function font_family(){
        return apply_filters( 'ncode_fields_typography_fontfamily', [
            'inherit' => esc_html__( 'Default', 'nextcode' ),
            'Arial, Helvetica, sans-serif' => 'Arial',
            "'Arial Black', Gadget, sans-serif" => 'Arial Black' ,
            "'Comic Sans MS', cursive, sans-serif" => 'Comic Sans MS',
            'Impact, Charcoal, sans-serif' => 'Charcoal',
            "'Lucida Sans Unicode', 'Lucida Grande', sans-serif" => 'Lucida Sans Unicode',
            'Tahoma, Geneva, sans-serif' => 'Tahoma',
            "'Trebuchet MS', Helvetica, sans-serif'" => 'Helvetica',
            'Verdana, Geneva, sans-serif' => 'Verdana',
            "'Courier New', Courier, monospace" => 'Courier',
            "'Lucida Console', Monaco, monospace" => 'Lucida',
            'Georgia, serif' => 'Georgia',
            'Palatino Linotype' => 'Palatino Linotype'
         ]);
    }

    public function text_transform(){
        return apply_filters( 'ncode_fields_typography_texttransform', [
            ''       => esc_html__( 'Default', 'nextcode' ),
            'capitalize' => esc_html__( 'Capitalize', 'nextcode' ),
            'uppercase'  => esc_html__( 'Uppercase', 'nextcode' ),
            'lowercase'  => esc_html__( 'Lowercase', 'nextcode' ),
            'none'  => esc_html__( 'Normal', 'nextcode' )
         ]);
    }

    public function font_weight(){
        return apply_filters( 'ncode_fields_typography_fontweight', [
            ''       => esc_html__( 'Default', 'nextcode' ),
            '100' => esc_html__( '100', 'nextcode' ),
            '200'  => esc_html__( '200', 'nextcode' ),
            '300'  => esc_html__( '300', 'nextcode' ),
            '400'  => esc_html__( '400', 'nextcode' ),
            '500'  => esc_html__( '500', 'nextcode' ),
            '600'  => esc_html__( '600', 'nextcode' ),
            '700'  => esc_html__( '700', 'nextcode' ),
            '800'  => esc_html__( '800', 'nextcode' ),
            '900'  => esc_html__( '900', 'nextcode' ),
            'normal'  => esc_html__( 'Normal', 'nextcode' ),
            'bold'  => esc_html__( 'Bold', 'nextcode' ),
         ]);
    }

    public function font_style(){
        return apply_filters( 'ncode_fields_typography_fontstyle', [
            ''       => esc_html__( 'Default', 'nextcode' ),
            'normal' => esc_html__( 'Normal', 'nextcode' ),
            'italic' => esc_html__( 'Italic', 'nextcode' ),
            'oblique' => esc_html__( 'Oblique', 'nextcode' ),
         ]);
    }

    public function text_decoration(){
        return apply_filters( 'ncode_fields_typography_textdecoration', [
            'none'               => esc_html__( 'None', 'nextcode' ),
            'underline'          => esc_html__( 'Solid', 'nextcode' ),
            'underline double'   => esc_html__( 'Double', 'nextcode' ),
            'underline dotted'   => esc_html__( 'Dotted', 'nextcode' ),
            'underline dashed'   => esc_html__( 'Dashed', 'nextcode' ),
            'underline wavy'     => esc_html__( 'Wavy', 'nextcode' ),
            'underline overline' => esc_html__( 'Overline', 'nextcode' ),
            'line-through'       => esc_html__( 'Line-through', 'nextcode' )
         ]);
    }

    public function font_variant(){
        return apply_filters( 'ncode_fields_typography_fontvariant', [
            'normal' => esc_html__( 'Normal', 'nextcode' ),
            'small-caps' => esc_html__( 'Small Caps', 'nextcode' ),
            'all-small-caps' => esc_html__( 'All Small Caps', 'nextcode' ),
         ]);
    }

    public function text_align(){
        return apply_filters( 'ncode_fields_typography_textalign', [
            'left'		 => [
                'title'	 =>esc_html__( 'Left', 'nextcode' ),
                'icon'	 => 'fa fa-align-left',
            ],
            'center'	 => [
                'title'	 =>esc_html__( 'Center', 'nextcode' ),
                'icon'	 => 'fa fa-align-center',
            ],
            'right'		 => [
                'title'	 =>esc_html__( 'Right', 'nextcode' ),
                'icon'	 => 'fa fa-align-right',
            ],
            'justify'	 => [
                'title'	 =>esc_html__( 'Justified', 'nextcode' ),
                'icon'	 => 'fa fa-align-justify',
            ],
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

        $render = '';
        foreach($value as $k=>$v){
            if( empty($v) || $v == ''){
                continue;
            }
            $ex = '';
            if( in_array($k, apply_filters( 'ncode_fields_typography_render_units', ['line-height', 'font-size', 'letter-spacing', 'word-spacing']) ) ){
                $ex = 'px';
            }
            $render .=  "$k: $v$ex;";
        }

        if( is_array($selector) && !empty($selector) ){
            foreach($selector as $vs){
                if( empty($vs) ){
                    continue;
                }
                $css_render .= "$vs { $render }";
            }
        }else{
            $css_render .= "$selector { $render }";
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