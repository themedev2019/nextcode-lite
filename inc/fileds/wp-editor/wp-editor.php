<?php
namespace NextCode\Inc\Fileds\Wp_Editor;
defined( 'ABSPATH' ) || exit;

use \NextCode\Inc\Setup\Ncode_common as Ncode_common;

Class Ncode_Wp_Editor Extends Ncode_common{

    private $arg = [
        'id'    => '',
        'type'    => 'wp_editor',
        'title'   => '',
        'desc'       => '',
        'default'    => '',
        'attr' => [],
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
        $this->args['default'] = isset( $this->args['default'] ) ? $this->args['default'] : '';
        
        $editor_settings['tinymce'] = isset( $this->args['tinymce'] ) ? $this->args['tinymce'] : false;
        $editor_settings['quicktags'] = isset( $this->args['quicktags'] ) ? $this->args['quicktags'] : false;
        $editor_settings['media_buttons'] = isset( $this->args['media_buttons'] ) ? $this->args['media_buttons'] : false;
        $editor_settings['textarea_rows'] = 10;
        
        $name = $this->args['id'];
        $id = $this->args['id'];
        if( isset($this->option_data[$this->key][$name]) ){
            $this->args['default'] = $this->option_data[$this->key][$name];
        }

        $repeater = $this->args['repeater'] ?? false;
        if($repeater){
            $r_name =  $this->args['attr']['name'] ?? '';
            if( !empty($r_name) ){
                $this->args['attr']['name'] = $r_name;
            }
        } else{
            $this->args['attr']['name'] =  $this->args['id'];
        }

        $name_data = $this->args['attr']['name'];
        if( $repeater ){
            $editor_settings['textarea_name'] = $array_dec.$name_data;
        } else{
            $editor_settings['textarea_name'] = $array_dec.'['.$name_data.']';
        }
        
        // load js / css
        $this->enqueue();
        extract( $this->args );
        include ( __DIR__ . '/templates.php');
    }

    public function enqueue(){
        if ( $this->ncode_wp_editor_api() && function_exists( 'wp_enqueue_editor' ) ) {
            wp_enqueue_editor();
            $this->setup_editor_settings();
            add_action( 'print_default_editor_scripts', array( &$this, 'setup_media_buttons' ) );
        }
    }
    
    public function ncode_wp_editor_api(){
        global $wp_version;
        return version_compare( $wp_version, '4.8', '>=' );
    }

    public function setup_editor_settings() {

        if ( $this->ncode_wp_editor_api() && class_exists( '\_WP_Editors') ) {
  
          $defaults = apply_filters( 'ncode_wp_editor', [
                'tinymce' => [
                    'wp_skip_init' => true
                ],
           ]);
  
          $setup = \_WP_Editors::parse_settings( 'ncode_wp_editor', $defaults );
  
          \_WP_Editors::editor_settings( 'ncode_wp_editor', $setup );
  
        }
  
    }

    public function setup_media_buttons() {

        ob_start();
        echo '<div class="wp-media-buttons">';
            do_action( 'media_buttons' );
        echo '</div>';

        $media_buttons = ob_get_clean();

        echo '<script type="text/javascript">';
            echo 'var ncode_media_buttons = '. json_encode( $media_buttons ) .';';
        echo '</script>';
  
    }

	public static function instance(){
		if (!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
	}
}