<?php 
namespace NextCode\Inc\Setup\Modules;
defined( 'ABSPATH' ) || exit;

use \NextCode\Inc\Setup\Ncode_common as Ncode_common;

Class Ncode_Admin extends Ncode_common{
    
    public $options_key = '__nextcode_options';
    public $menu_slug = 'nextcode';

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

        // framework title
        'framework_title'         => 'NextCode Framework <small>by ThemeDev</small>',
        'framework_class'         => '',
        'framework_logo'         => '',
        'options_key'             => '__nextcode_options',
        'css_render'             => 'nextcode-public',
  
        // menu settings
        'menu_title'              => 'NextCode',
        'menu_slug'               => 'nextcode',
        'menu_type'               => 'menu',
        'menu_capability'         => 'manage_options',
        'menu_icon'               => 'dashicons-admin-generic',
        'menu_position'           => 6,
        'menu_hidden'             => false,
        'menu_parent'             => '',
        'sub_menu_title'          => '',

        // options
        'show_sub_menu'          => true,
        'enqueue_load_global'    => false,
        'plugin_action_links'    => true,

        // footer
        'footer_text'             => '',
        'footer_after'            => '',
        'footer_credit'           => '',
  
        // theme
        'theme'                   => 'white', // dark, white
        'display_style'           => 'left', // top, left
  
        // external default values
        'external'                => [],
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
            $this->args = apply_filters("ncode_{$key}_args", wp_parse_args($params['options'], $this->args), $this);
        } 
        
        // section
        if( isset($params['sections']) ){
            $this->sections = apply_filters("ncode_{$key}_sections", $params['sections'], $this);
        }
        // sub section
        if( isset($params['sub_sections']) ){
            $this->sub_sections = apply_filters("ncode_{$key}_sub_sections", $params['sub_sections'], $this);
        }
        // fields
        if( isset($params['fields']) ){
            $this->fields = apply_filters("ncode_{$key}_fields", $params['fields'], $this);
        }
        // set key
        $this->options_key = !empty($this->args['options_key']) ? $this->args['options_key'] : $key;
        $this->args['options_type'] = 'options';

        // set menu key
        $this->menu_slug = !empty($key) ? $key : $this->args['menu_slug'];
        
        $this->args['options_key'] = $this->options_key;
        $this->args['sections'] = $this->sections;
        $this->args['sub_sections'] = $this->sub_sections;
        $this->args['fields'] = $this->fields;

        $this->pre_sections = $this->set_section($this->sections);
        $this->pre_subsections = $this->set_sub_section($this->sections);
        $this->pre_tabs = apply_filters("ncode_{$key}_tabs", $this->set_tabs($this->sections) );
        $this->pre_fields = apply_filters("ncode_{$key}_pre_fields", $this->set_fields($this->sections) );
        $this->pre_actions = apply_filters("ncode_{$key}_actions", $this->set_action($this->pre_fields) );
        $this->set_outputs = apply_filters("ncode_{$key}_outputs", $this->set_output($this->pre_fields) );

        // admin admin menu
       add_action( 'admin_menu', [ &$this, '_admin_menu']);

       add_filter( 'admin_footer_text', [ &$this, 'add_admin_footer_text' ] );

       if( $this->args['plugin_action_links']){
            add_filter( 'plugin_action_links_' . plugin_basename(NEXTCODE_FILE_), [ $this , '_action_links'] );
       }

    }

    public static function instance( $key, $params = array() ) {
        if( empty($key) ){
            return;
        }
        return new self( $key, $params );
    }

    public function _admin_menu( ){
       
        extract( $this->args );
        if ( $menu_type === 'submenu' ) {
            $menu_page = call_user_func( 
                'add_submenu_page',
                $menu_parent, 
                esc_attr( $menu_title ), 
                esc_attr( $menu_title ), 
                $menu_capability, 
                $this->menu_slug, 
                [ $this, 'render_admin_panel' ] 
            );

        } else {
            $menu_page = call_user_func( 
                'add_menu_page', 
                esc_attr( $menu_title ), 
                esc_attr( $menu_title ), 
                $menu_capability, 
                $this->menu_slug, 
                [ $this, 'render_admin_panel' ], 
                $menu_icon, 
                $menu_position 
            );

            // if sub menu title
            if ( ! empty( $sub_menu_title ) ) {
                call_user_func( 
                    'add_submenu_page', 
                    $this->menu_slug, 
                    esc_attr( $sub_menu_title ), 
                    esc_attr( $sub_menu_title ), 
                    $menu_capability, 
                    $this->menu_slug, 
                    [ $this, 'render_admin_panel']
                );
            }

            if ( ! empty( $this->args['show_sub_menu'] ) && is_array($this->pre_tabs) && count( $this->pre_tabs ) > 1 ) {

                // create submenus
                foreach ( $this->pre_tabs as $k=>$section ) {
                  call_user_func( 
                      'add_submenu_page', 
                      $this->menu_slug, 
                      esc_attr( $section['title'] ),  
                      esc_attr( $section['title'] ), 
                      $menu_capability, 
                      $this->menu_slug .'#ntab='. sanitize_title( $k ), 
                      '__return_null' );
                }
      
                remove_submenu_page( $this->menu_slug, $this->menu_slug );
      
              }
      
              if ( ! empty( $menu_hidden ) ) {
                remove_menu_page( $this->menu_slug );
              }

        }
    }

    public function _action_links($links){
        $links[] = '<a href="' . admin_url( 'admin.php?page='.$this->menu_slug ).'"> <b>'. __('Settings', 'nextcode').'</b></a>';
		return $links;
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
         
        $settings = apply_filters( "ncode_{$this->menu_slug}_save_before", $settings, $this);

        do_action( "ncode_{$this->menu_slug}_save_before", $settings, $this);

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
                            update_term_meta($meta_id, $meta_key, $meta_value);
                        }
                    }

                }
            }

            wp_send_json_success( ['success' => esc_html__( 'Successfully saved', 'nextcode' )]);
        }

        do_action( "ncode_{$this->menu_slug}_save_after", $settings, $this);

        wp_send_json_error( ['error' => esc_html__( 'Already saved.', 'nextcode' )]);

    }

    public function add_admin_footer_text() {
        $screen = get_current_screen();
        if( in_array($screen->id, [ 'toplevel_page_'.$this->menu_slug, $this->menu_slug ])){				
                
            $default = 'Thank you for creating with <a href="https://themedev.net/" target="_blank"><strong>ThemeDev</strong></a>';
            echo ( ! empty( $this->args['footer_credit'] ) ) ? wp_kses_post( $this->args['footer_credit'] ) : $default;
        }
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