<?php 
namespace NextCode\Inc\Setup\Modules;
defined( 'ABSPATH' ) || exit;

use \NextCode\Inc\Setup\Ncode_common as Ncode_common;

Class Ncode_Submenu extends Ncode_common{

    public $options_key = '__nextcode_sub_options';
    public $menu_slug = 'nextcode-sub';
    public $suport_posttype = '';
    
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

        'post_type' => '', // support posttype
        'options_key'             => '__nextcode_sub_options',
        'css_render'             => 'nextcode-public',
  
        // menu settings
        'name' => 'Settings',
        'menu_capability' => 'manage_options',
        'theme' => 'white', // white, dark
        'display_style' => 'top', // top, left
        'framework_title' => '', // Name
        'framework_class' => '', // extra class

        // section data
        'sections'                => [],
        'sub_sections'            => [],
        'fields'                => [],
  
    ];

    public function __construct($key, $params ){
        // submit data
        add_action( 'wp_ajax_ncode-adminoptions', [ &$this, 'ncode_admin_ajax'] );
        add_action( 'wp_enqueue_scripts',  [ &$this, 'dynamic_style' ] );

        // set args
        if( isset($params['options'])  ){
            $this->args = apply_filters("ncode_{$key}_args_submenu", wp_parse_args($params['options'], $this->args), $this);
        } 
        
        // section
        if( isset($params['sections']) ){
            $this->sections = apply_filters("ncode_{$key}_sections_submenu", $params['sections'], $this);
        }
        // sub section
        if( isset($params['sub_sections']) ){
            $this->sub_sections = apply_filters("ncode_{$key}_sub_sections_submenu", $params['sub_sections'], $this);
        }
        // fields
        if( isset($params['fields']) ){
            $this->fields = apply_filters("ncode_{$key}_fields_submenu", $params['fields'], $this);
        }
        // set key
        $this->options_key = !empty($this->args['options_key']) ? $this->args['options_key'] : $key;
        $this->suport_posttype = isset($this->args['post_type']) ? $this->args['post_type'] : $this->suport_posttype;
        
        $this->args['framework_title'] = !empty($this->args['framework_title']) ? $this->args['framework_title'] : $this->args['name'];

        // set menu key
        $this->menu_slug = !empty($key) ? $key : '';

        $this->args['options_type'] = 'options';

        $this->args['options_key'] = $this->options_key;
        $this->args['sections'] = $this->sections;
        $this->args['sub_sections'] = $this->sub_sections;
        $this->args['fields'] = $this->fields;

        $this->pre_sections = $this->set_section($this->sections);
        $this->pre_subsections = $this->set_sub_section($this->sections);
        $this->pre_tabs = apply_filters("ncode_{$key}_tabs_submenu", $this->set_tabs($this->sections) );
        $this->pre_fields = apply_filters("ncode_{$key}_pre_fields_submenu", $this->set_fields($this->sections) );
        $this->pre_actions = apply_filters("ncode_{$key}_actions_submenu", $this->set_action($this->pre_fields) );
        $this->set_outputs = apply_filters("ncode_{$key}_outputs_submenu", $this->set_output($this->pre_fields) );
        // admin admin menu
       add_action( 'admin_menu', [ &$this, '_admin_menu']);

    }

    public static function instance( $key, $params = array() ) {
        if( empty($key) ){
            return;
        }
        return new self( $key, $params );
    }

    public function _admin_menu( ){
        
        add_submenu_page(
			'edit.php?post_type='.$this->suport_posttype,
			esc_html__( $this->args['name'], 'nextcode' ),
			esc_html__( $this->args['name'], 'nextcode' ),
			$this->args['menu_capability'],
			$this->menu_slug,
			[$this, 'render_admin_panel']
        );
        
    }

    public function render_admin_panel(){
        // include files
        include ( NEXTCODE_DIR . 'templates/admin-options/render.php');
    }

    public function ncode_admin_ajax(){
        $nonce  = ( ! empty( $_POST[ 'nonce' ] ) ) ? sanitize_text_field( wp_unslash( $_POST[ 'nonce' ] ) ) : '';
        $keys = ( ! empty( $_POST[ 'keys' ] ) ) ? sanitize_text_field( wp_unslash( $_POST[ 'keys' ] ) ) : '';
        $response   = ( ! empty( $_POST[ 'data' ] ) ) ? json_decode( wp_unslash( trim( $_POST['data'] ) ), true )  : array();
        
        if ( ! wp_verify_nonce( $nonce, $keys ) ) {
            wp_send_json_error( array( 'error' => esc_html__( 'Error: Nonce verification has failed. Please try again.', 'nextcode' ) ) );
        }
    
        if ( empty( $keys ) ) {
            wp_send_json_error( array( 'error' => esc_html__( 'Error: Options key could not valid.', 'nextcode' ) ) );
        }
   
        if ( empty( $response['options'] ) || ! is_array( $response['options'] ) ) {
            wp_send_json_error( array( 'error' => esc_html__( 'Error: Import data could not valid.', 'nextcode' ) ) );
        }

        $settings = isset($response['options']) ? $response['options'] : [];
        
        $settings = apply_filters( "ncode_{$this->menu_slug}_save_before_submenu", $settings, $this);

        do_action( "ncode_{$this->menu_slug}_save_before_submenu", $settings, $this);

        if( update_option($keys, $settings) ){
            
            // action setup data
            if( !empty($this->pre_actions) ){
                foreach($this->pre_actions as $k=>$va){

                    if( empty($va)){
                        continue;
                    }

                    foreach($va as $v){

                        if( empty($v) || !isset($v['type']) || empty($v['type']) ){
                            continue;
                        }
                        $type = $v['type'];
                        $meta_key = $v['key'];
                        $meta_id = isset($v['id']) ? $v['id'] : '';
                        if( isset($v['target_value']['section']) ){
                            $meta_vk_section = isset($v['target_value']['section']) ? $v['target_value']['section'] : '';
                            $meta_vk_field = isset($v['target_value']['field']) ? $v['target_value']['field'] : '';
                            $meta_value = isset($settings[$meta_vk_section][$meta_vk_field]) ? $settings[$meta_vk_section][$meta_vk_field] : '';
                        }else {
                            $meta_value = isset($v['target_value']) ? $v['target_value'] : ''; 
                        }
                        
                        if( $type == 'option' || $type == 'options' ){
                            update_option( $meta_key, $meta_value);
                        } else if( $type == 'post' || $type == 'posts' ){
                            update_post_meta($meta_id, $meta_key, $meta_value);
                        } else if( $type == 'user' || $type == 'users' ){
                            update_user_meta($meta_id, $meta_key, $meta_value);
                        } else if( $type == 'term' || $type == 'terms'){
                            update_user_meta($meta_id, $meta_key, $meta_value);
                        }
                    }

                }
            }

            wp_send_json_success( ['success' => esc_html__( 'Successfully saved', 'nextcode' )]);
        }

        do_action( "ncode_{$this->menu_slug}_save_after_submenu", $settings, $this);

        wp_send_json_error( ['error' => esc_html__( 'Already saved.', 'nextcode' )]);

    }

    //  render css
    public function dynamic_style(){
        // style option
        $settings = get_option($this->options_key, []);
        if( empty($settings) ){
            return;
        }
        $custom_css  = '';
        if( !empty($this->set_outputs) ){
            $custom_css = $this->_render_css($settings, $this->set_outputs, $this->pre_fields);
        }
           
        wp_add_inline_style( $this->args['css_render'], $custom_css );
   }
}