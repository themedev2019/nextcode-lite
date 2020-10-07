<?php
namespace NextCode\Inc\Fileds\Code_Editor;
defined( 'ABSPATH' ) || exit;

use \NextCode\Inc\Fileds as Fileds;

use \NextCode\Inc\Setup\Ncode_common as Ncode_common;

Class Ncode_Code_Editor Extends Ncode_common{
    
    private $settings = [];
    private $key = '';
    private $option_key = '';
    private $option_data = [];

    private $args = [
        'id'    => '',
        'type'    => 'code-editor',
        'title'   => '',
        'desc'       => '',
        'default'    => '',
        'action' => [],
        'fields' => [],
    ];
    private static $instance;

    public $version_nx = '5.41.0';
    public $cdn_url = 'https://cdn.jsdelivr.net/npm/codemirror@';


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
        $this->args['attr']['class'] = isset( $this->args['attr']['class'] ) ? 'nxinput-box intextarea nx-codeeditor '.$this->args['attr']['class'] : 'nxinput-box intextarea nx-codeeditor';
        $this->args['default'] = isset( $this->args['default'] ) ? $this->args['default'] : '';
        $this->args['settings'] = isset( $this->args['settings'] ) ? $this->args['settings'] : '';
        $this->args['attr']['data-depend-id'] = $this->args['id'];
        
        $name = $this->args['id'];
        $id = $this->args['id'];
        if( isset($this->option_data[$this->key][$name]) ){
            $this->args['default'] = $this->option_data[$this->key][$name];
        }

        $default_settings = array(
            'tabSize'       => 4,
            'lineNumbers'   => true,
            'theme'         => 'default',
            'mode'          => 'htmlmixed',
            'cdnURL'        => $this->cdn_url . $this->version_nx,
          );
    
        $settings = ( ! empty( $this->args['settings'] ) ) ? $this->args['settings'] : array();
        $this->args['settings'] = wp_parse_args( $settings, $default_settings );

        $repeater = $this->args['repeater'] ?? false;
        if($repeater){
            $r_name =  $this->args['attr']['name'] ?? '';
            if( !empty($r_name) ){
                $this->args['attr']['name'] = $r_name;
            }
        } else{
            $this->args['attr']['name'] =  $this->args['id'];
        }

       
        $this->enqueue();
        // code here
        extract( $this->args );
        include ( __DIR__ . '/templates.php');
    }

    public function enqueue(){
       
        wp_enqueue_script('ncode-code_editor');
        wp_enqueue_script('ncode-code_editor_css');
        wp_enqueue_style('ncode-code_editor');

    }

    
	public static function instance(){
		if (!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
	}
}