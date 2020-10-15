<?php 
namespace NextCode\Inc\Setup;
defined( 'ABSPATH' ) || exit;

Class Ncode_Create_Option{
    
    public static $options = [
        'admin_options'       => [],
        'custom_postype'   => [],
        'custom_submenu'   => [],
        'customize_options'   => [],
        'metabox_options'     => [],
        'navmenu_options'    => [],
        'profile_options'     => [],
        'taxonomy_options'    => [],
        'widget_options'      => [],
        'comment_options'     => [],
        'shortcode_options'   => [],

    ];

    public static $css = '';

    public static $webfonts = [];
    public static $subsets  = [];

    public static $params = [
        'admin_options' => [],
        'custom_postype' => [],
        'custom_submenu' => [],
        'taxonomy_options' => [],
        'metabox_options' => [],
        'profile_options' => [],
        'navmenu_options' => [],
        'widget_options' => [],
        'shortcode_options' => [],
        'comment_options' => [],
    ];

    private static $instance;

    public static function instance(){
		if (!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }

   
    public function admin_option( $key, $args ){
        self::$options['admin_options'][$key] = $args;
    }

    public function custom_posttype( $key, $args ){
        self::$options['custom_postype'][$key] = $args;
    }

    public function custom_sub_posttype( $key, $args ){
        self::$options['custom_submenu'][$key] = $args;
    }

    public function create_taxonomy( $key, $args ){
        self::$options['taxonomy_options'][$key] = $args;
    }

    public function create_metabox( $key, $args ){
        self::$options['metabox_options'][$key] = $args;
    }

    public function create_profile_data( $key, $args ){
        self::$options['profile_options'][$key] = $args;
    }

    public function create_nav_data( $key, $args ){
        self::$options['navmenu_options'][$key] = $args;
    }

    public function create_widget_data( $key, $args ){
        self::$options['widget_options'][$key] = $args;
    }

    public function create_shortcode_data( $key, $args ){
        self::$options['shortcode_options'][$key] = $args;
    }

    public function create_comment_metabox( $key, $args ){
        self::$options['comment_options'][$key] = $args;
    }

    public function section( $key, $args ){
        $id = isset($args['id']) ? $args['id'] : '';
        if( empty($id) ){
            return;
        }
        $parent = isset($args['parent']) ? true : false;
        if($parent){
            $subid = isset($args['id']) ? $args['id'] : '';
            if( empty($subid) ){
                return;
            }
            $parent_id = $args['parent'];
            if( isset(self::$params[$key]['sections'][$parent_id]) ){
                self::$params[$key]['sections'][$parent_id]['sub_sections'][$subid] = $args;
            }else{
                self::$params[$key]['sub_sections'][$parent_id][] = $args;
            }
        }else{
            self::$params[$key]['sections'][$id] = $args;
        }
        
    }

    public function field( $key, $args ){
        $parent = isset($args['parent_section']) ? true : false;
        if($parent){
            $id = isset($args['parent_section']) ? $args['parent_section'] : '';
            if( empty($id) ){
                return;
            }
            
            if( isset(self::$params[$key]['sections'][$id]) ){
                self::$params[$key]['sections'][$id]['fields'][] = $args;
            } else {
                self::$params[$key]['fields'][$id][] = $args;
            }
        }
    }


    public static function framework_render(){
        // setup admin
        $adminOption = isset( self::$options['admin_options'] ) ? self::$options['admin_options'] : [];
        foreach( $adminOption as $k=>$v){
            if( empty($v) || !class_exists( __NAMESPACE__ .'\Modules\Ncode_Admin') ){
                continue;
            }
        
            self::$params[$k]['options'] = $v;
           
            if( !empty(self::$params) ){
                $data = isset( self::$params[$k] ) ? self::$params[$k] : '';
                if( !empty($data) && is_array($data) ){
                    Modules\Ncode_Admin::instance($k, $data);
                }
            }

        }

        // custom posttype
        $custom_postype = isset( self::$options['custom_postype'] ) ? self::$options['custom_postype'] : [];
        foreach( $custom_postype as $k=>$v){
            if( empty($v) || !class_exists( __NAMESPACE__ .'\Modules\Ncode_Posttype') ){
                 continue;
            }
         
            self::$params[$k]['options'] = $v;
            
            if( !empty(self::$params) ){
                 $data = isset( self::$params[$k] ) ? self::$params[$k] : '';
                 if( !empty($data) && is_array($data) ){
                     Modules\Ncode_Posttype::instance($k, $data);
                 }
            }
 
        }

        // custom sub menu posttype
        $custom_submenu = isset( self::$options['custom_submenu'] ) ? self::$options['custom_submenu'] : [];
        foreach( $custom_submenu as $k=>$v){
            if( empty($v) || !class_exists( __NAMESPACE__ .'\Modules\Ncode_Submenu') ){
                 continue;
            }
         
            self::$params[$k]['options'] = $v;
            
            if( !empty(self::$params) ){
                 $data = isset( self::$params[$k] ) ? self::$params[$k] : '';
                 if( !empty($data) && is_array($data) ){
                     Modules\Ncode_Submenu::instance($k, $data);
                 }
            }
 
        }
       
        // taxonomy options
        $taxonomy_options = isset( self::$options['taxonomy_options'] ) ? self::$options['taxonomy_options'] : [];
        foreach( $taxonomy_options as $k=>$v){
            if( empty($v) || !class_exists( __NAMESPACE__ .'\Modules\Ncode_Taxonomy') ){
                 continue;
            }
         
            self::$params[$k]['options'] = $v;
            
            if( !empty(self::$params) ){
                 $data = isset( self::$params[$k] ) ? self::$params[$k] : '';
                 if( !empty($data) && is_array($data) ){
                     Modules\Ncode_Taxonomy::instance($k, $data);
                 }
            }
 
        }
        
        // metabox options
        $metabox_options = isset( self::$options['metabox_options'] ) ? self::$options['metabox_options'] : [];
        foreach( $metabox_options as $k=>$v){
            if( empty($v) || !class_exists( __NAMESPACE__ .'\Modules\Ncode_Metabox') ){
                 continue;
            }
         
            self::$params[$k]['options'] = $v;
            
            if( !empty(self::$params) ){
                 $data = isset( self::$params[$k] ) ? self::$params[$k] : '';
                 if( !empty($data) && is_array($data) ){
                     Modules\Ncode_Metabox::instance($k, $data);
                 }
            }
 
        }

        // profiles options
        $profile_options = isset( self::$options['profile_options'] ) ? self::$options['profile_options'] : [];
        foreach( $profile_options as $k=>$v){
            if( empty($v) || !class_exists( __NAMESPACE__ .'\Modules\Ncode_Profiles') ){
                 continue;
            }
         
            self::$params[$k]['options'] = $v;
            
            if( !empty(self::$params) ){
                 $data = isset( self::$params[$k] ) ? self::$params[$k] : '';
                 if( !empty($data) && is_array($data) ){
                     Modules\Ncode_Profiles::instance($k, $data);
                 }
            }
 
        }

        // nav menu
        $nav_options = isset( self::$options['navmenu_options'] ) ? self::$options['navmenu_options'] : [];
        foreach( $nav_options as $k=>$v){
            if( empty($v) || !class_exists( __NAMESPACE__ .'\Modules\Ncode_Navs') ){
                 continue;
            }
         
            self::$params[$k]['options'] = $v;
            
            if( !empty(self::$params) ){
                 $data = isset( self::$params[$k] ) ? self::$params[$k] : '';
                 if( !empty($data) && is_array($data) ){
                     Modules\Ncode_Navs::instance($k, $data);
                 }
            }
 
        }

        // widgets
        $wp_widget_factory = new \WP_Widget_Factory();
        if( class_exists( '\WP_Widget_Factory' ) ){
            $widgets_options = isset( self::$options['widget_options'] ) ? self::$options['widget_options'] : [];
            foreach( $widgets_options as $k=>$v){
                if( empty($v) || !class_exists( __NAMESPACE__ .'\Modules\Ncode_Widgets') ){
                     continue;
                }
             
                self::$params[$k]['options'] = $v;
                
                if( !empty(self::$params) ){
                     $data = isset( self::$params[$k] ) ? self::$params[$k] : '';
                     if( !empty($data) && is_array($data) ){
                    
                         $wp_widget_factory->register( Modules\Ncode_Widgets::instance($k, $data) );
                     }
                }
     
            }
        }
        
         // shortcode options
        
         $shortcode_options = isset( self::$options['shortcode_options'] ) ? self::$options['shortcode_options'] : [];
         if( !empty($shortcode_options) && sizeof($shortcode_options) > 0){
            add_action( 'wp_enqueue_scripts', array( self::instance(), 'render_script_global' ) );
         }
         foreach( $shortcode_options as $k=>$v){
             if( empty($v) || !class_exists( __NAMESPACE__ .'\Modules\Ncode_Shortcode') ){
                  continue;
             }
             
            self::$params[$k]['options'] = $v;
        
            if( !empty(self::$params) ){
                $data = isset( self::$params[$k] ) ? self::$params[$k] : '';
                if( !empty($data) && is_array($data) ){
                    Modules\Ncode_Shortcode::instance($k, $data);
                }
            }
  
         }

        // comment metabox options
        $comment_options = isset( self::$options['comment_options'] ) ? self::$options['comment_options'] : [];
        foreach( $comment_options as $k=>$v){
            if( empty($v) || !class_exists( __NAMESPACE__ .'\Modules\Ncode_Comment') ){
                 continue;
            }
         
            self::$params[$k]['options'] = $v;
            
            if( !empty(self::$params) ){
                 $data = isset( self::$params[$k] ) ? self::$params[$k] : '';
                 if( !empty($data) && is_array($data) ){
                     Modules\Ncode_Comment::instance($k, $data);
                 }
            }
 
        }



    }

    public static function render_script_admin(){
        
        $enque = ['profile', 'nav-menus', 'widgets', 'post', 'page', 'comment'];
        foreach(self::$options as $k=>$v){
            if( empty($v) ){
                continue;
            }
            
            $menu_data = array_keys($v);
            foreach($menu_data as $v){
                $enque[] = 'toplevel_page_'.$v;
                $enque[] = $v;
            }
        }

        if( isset($_GET['post_type']) ){
            $posttype = sanitize_text_field($_GET['post_type']);
            $enque[] = 'edit-'.$posttype;
            $enque[] = $posttype;
            $pages = isset($_GET['page']) ? sanitize_text_field($_GET['page']) : '';
            if( !empty($pages) ){
                $enque[] = $posttype.'_page_'.$pages;
            }
        }
        if( isset($_GET['taxonomy']) ){
            $taxonomy = sanitize_text_field($_GET['taxonomy']);
            $enque[] = 'edit-'.$taxonomy;
        }
        
        global $post;
        if( isset($post->post_type) ){
            $enque[] = $post->post_type;
        }
        $screen = get_current_screen();
        
		if(  in_array($screen->id, $enque)){			
			self::instance()->render_script_global();
        }

        do_action( 'ncode_enqueue_admin' );
    }

    public function render_script_global(){
        // upload media button
        wp_enqueue_script( 'jquery' );
        wp_enqueue_media();
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_enqueue_style('thickbox');

        // load laibray
        wp_enqueue_script( 'jquery-ui-sortable' );
        
        wp_enqueue_script('nx-repeater');
        wp_enqueue_script('nx-icons');
        wp_enqueue_script('nx-code');
        wp_enqueue_script('nx-multistep');

        // select2
        wp_enqueue_script('nextcode-select2');
        wp_enqueue_style('nextcode-select2');
    
        // theme js / css
        wp_enqueue_style('nextcode-style');
        wp_enqueue_script('nextcode-js');
        

            // Font awesome 4 and 5 loader
        $min = '.min';
        if ( apply_filters( 'ncode_fa4', false ) ) {
            wp_enqueue_style( 'ncode-fa', 'https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome'. $min .'.css', array(), '4.7.0', 'all' );
        } else {
            wp_enqueue_style( 'ncode-fa5', 'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.13.0/css/all'. $min .'.css', array(), '5.13.0', 'all' );
            wp_enqueue_style( 'ncode-fa5-v4-shims', 'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.13.0/css/v4-shims'. $min .'.css', array(), '5.13.0', 'all' );
        }
    }

    
    public static function render_script_public(){
        // Font awesome 4 and 5 loader
        $min = '.min';
        if ( apply_filters( 'ncode_fa4', false ) ) {
            wp_enqueue_style( 'ncode-fa', 'https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome'. $min .'.css', array(), '4.7.0', 'all' );
        } else {
            wp_enqueue_style( 'ncode-fa5', 'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.13.0/css/all'. $min .'.css', array(), '5.13.0', 'all' );
            wp_enqueue_style( 'ncode-fa5-v4-shims', 'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.13.0/css/v4-shims'. $min .'.css', array(), '5.13.0', 'all' );
        }
        
        wp_enqueue_style('nextcode-public');

        do_action( 'ncode_enqueue_public' );
    }

    public static function render_custom_css(){
        
        if ( ! empty( self::$css ) ) {
            echo '<style type="text/css">'. wp_strip_all_tags( self::$css ) .'</style>';
        }
    }

    public static function render_typography_enqueue(){
        if( ! empty( self::$webfonts ) ) {

            if( ! empty( self::$webfonts['enqueue'] ) ) {
    
              $api    = '//fonts.googleapis.com/css';
              $query  = array( 'family' => implode( '%7C', self::$webfonts['enqueue'] ), 'display' => 'swap' );
              $handle = 'ncode-google-web-fonts';
    
              if( ! empty( self::$subsets ) ) {
                $query['subset'] = implode( ',', self::$subsets );
              }
    
              wp_enqueue_style( $handle, esc_url( add_query_arg( $query, $api ) ), array(), null );
    
            } else {
    
              wp_enqueue_script( 'ncode-google-web-fonts', esc_url( '//ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js' ), array(), null );
              wp_localize_script( 'ncode-google-web-fonts', 'WebFontConfig', array( 'google' => array( 'families' => array_values( self::$webfonts['async'] ) ) ) );
    
            }
    
        }
    }

}