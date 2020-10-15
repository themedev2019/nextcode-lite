<?php 
namespace NextCode\Inc\Setup\Modules;
defined( 'ABSPATH' ) || exit;

use \NextCode\Inc\Setup\Ncode_common as Ncode_common;

Class Ncode_Shortcode extends Ncode_common{

    public $shortcode = 'nextcode-shortcodes';
    public $callback = '';
    public $options_key = 'nextcode-shortcodes-keys';
    
    public $sections = [];
    public $sub_sections = [];
    public $fields = [];

    public $pre_tabs     = [];
    public $pre_fields   = [];
    public $pre_sections = [];
    public $pre_subsections = [];
    public $pre_actions = [];
    public $set_outputs = [];

    public $args = [

        // theme setup
        'theme' => 'white', // white, dark
        'display_style' => 'top', // top, left

        'title'       => '',
        'classname'   => '',
        'description' => '',
        'width'       => '',
        'class'       => '',
        'fields'      => [],
        'params'      => [],
        'multistep'      => false,
       
    ];

   
    public function __construct($key, $params ){
       
        // set args
        if( isset($params['options'])  ){
            $this->args = apply_filters("ncode_{$key}_args_shortcode", wp_parse_args($params['options'], $this->args), $this);
        } 
        
        // section
        if( isset($params['sections']) ){
            $this->sections = apply_filters("ncode_{$key}_sections_shortcode", $params['sections'], $this);
        }
        // sub section
        if( isset($params['sub_sections']) ){
            $this->sub_sections = apply_filters("ncode_{$key}_sub_sections", $params['sub_sections'], $this);
        }
        // fields
        if( isset($this->args['fields']) ){
            $this->fields = apply_filters("ncode_{$key}_fields_shortcode", $this->args['fields'], $this);
        }
        
        // set menu key
        $this->shortcode = !empty($key) ? $key : '';
        $this->options_key = $key;
        
        $this->callback = isset($this->args['callback']) ? $this->args['callback'] : '';
        $this->params = isset($this->args['params']) ? $this->args['params'] : [];
        $this->form = isset($this->args['form']) ? $this->args['form'] : [];
        $this->submit = isset($this->args['submit']) ? $this->args['submit'] : ['name' => 'submit-application', 'type' => 'button', 'value' => 'Apply Now'];
        $this->multistep = isset($this->args['multistep']) ? $this->args['multistep'] : false;
        if($this->multistep){
            $this->args['classname'] .= ' nxmultistep-form';
            $this->submit['class'] = 'nxmulti-step-submit';
        }

        $this->args['options_type'] = 'shortcode';
        $this->args['options_key'] = $this->options_key;
        $this->args['callback'] = $this->callback;
        $this->args['sub_sections'] = $this->sub_sections;
        $this->args['sections'] = $this->sections;
        $this->args['fields'] = $this->fields;

       
        // extraparans
        $this->pre_sections = $this->set_section($this->sections);
        $this->pre_subsections = $this->set_sub_section($this->sections);
        $this->pre_tabs = apply_filters("ncode_{$key}_tabs_shortcode", $this->set_tabs($this->sections) );
        $this->pre_fields = apply_filters("ncode_{$key}_pre_fields_shortcode", $this->set_fields($this->sections) );
        
        if( empty($this->pre_tabs) && !empty($this->args['fields']) ){
            $this->args['options_array'] = $this->shortcode;
        }
        // render shortcode
        add_shortcode( $this->shortcode, [ &$this, '_render_shortcode'] );
    }

    public static function instance( $key, $params = array() ) {
        if( empty($key) ){
            return;
        }
        return new self( $key, $params );
    }


    public function _render_shortcode( $atts , $content = null ) {
        $settings = [];

        $atts = apply_filters( "ncode_{$this->shortcode}_render_before_shortcode", $atts, $this);

        $atts = shortcode_atts(
            $this->params, $atts, $this->shortcode 
        );
       
        ob_start();
        
        do_action( "ncode_{$this->shortcode}_render_before_shortcode", $atts, $this );

        if( !empty($this->pre_tabs) && empty($this->args['fields']) ){
            include ( NEXTCODE_DIR . 'templates/shortcode-options/render-group.php');
        }else{
            include ( NEXTCODE_DIR . 'templates/shortcode-options/render.php');
        }
        
        do_action( "ncode_{$this->shortcode}_render_after_shortcode", $atts, $this );

        $content = ob_get_contents();
        ob_end_clean();

        if ( !is_admin() ) {

            if( empty($this->callback) ){
                return $content;
            } else {
                
                call_user_func( $this->callback, $content, $this->args, $this->shortcode );

            }
        } 
        return;
        
    }
   
    public function render_data($f, $args, $shortcode, $staus  ){
       return Ncode_common::self_class()->render_filed_data($f, $args, $shortcode, $staus);
    }

}