<?php
namespace NextCode\Inc\Fileds\Group;
defined( 'ABSPATH' ) || exit;

use \NextCode\Inc\Fileds as Fileds;

use \NextCode\Inc\Setup\Ncode_common as Ncode_common;

Class Ncode_Group Extends Ncode_common{

    private $settings = [];
    private $key = '';
    private $option_key = '';
    private $option_data = [];

    private $args = [
        'id'    => '',
        'type'    => 'group',
        'title'   => '',
        'desc'       => '',
        'default'    => [],
        'action' => [],
        'fields' => [],
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

        $this->args['fields'] = isset( $this->args['fields'] ) ? $this->args['fields'] : [];
        $this->args['default'] = isset( $this->args['default'] ) ? $this->args['default'] : [];
        $this->args['title_field'] = isset( $this->args['title_field'] ) ? $this->args['title_field'] : 'sl';
        $this->args['nasted'] = isset( $this->args['nasted'] ) ? true : false;
        
        $default = isset($this->args['fields']) ? $this->args['fields'] : [];
        $dvalue = [];
        foreach($default as $v){
            $id = $v['id'] ?? '';
            $dvalue[$id] = '';
        }
        
        if( empty($this->args['default']) ){
            $this->args['default'] =[ $dvalue ];
        }
        
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

        // group name
        if( $repeater ){
            $group_name = isset( $this->args['group_name'] ) ? $this->args['group_name'] : '';
            $group_data = isset( $this->args['group_data'] ) ? $this->args['group_data'] : '';
            if( !empty( $group_name ) ){
                $this->args['group_name'] = $array_dec.$group_name;
                $this->args['group_data'] = $array_dec.$group_data;
            }
        } else {
            $this->args['group_name'] = $array_dec."[$id]";
            $this->args['group_data'] = $array_dec."[$id]";
        }
        // load js / css
        $this->enqueue();

        extract( $this->args );
        include ( __DIR__ . '/templates.php');
    }

    public function enqueue(){
        
    }
    
	public static function instance(){
		if (!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
	}
}