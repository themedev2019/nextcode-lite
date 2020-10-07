<?php
namespace NextCode\Inc\Fileds\Sortable;
defined( 'ABSPATH' ) || exit;

use \NextCode\Inc\Fileds as Fileds;

use \NextCode\Inc\Setup\Ncode_common as Ncode_common;

Class Ncode_Sortable Extends Ncode_common{

    private $settings = [];
    private $key = '';
    private $option_key = '';
    private $option_data = [];

    private $args = [
        'id'    => '',
        'type'    => 'sortable',
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
        $this->args['nasted'] = isset( $this->args['nasted'] ) ? true : false;
        
        $name = $this->args['id'];
        $id = $this->args['id'];

        if( isset($this->option_data[$this->key][$name]) ){
            $this->args['default'] = $this->option_data[$this->key][$name];
        }

        if( !empty($this->args['default']) ){
            $columnData = array_column($this->args['fields'], 'id');
            $dvalue = [];
            foreach( $this->args['default'] as $k=>$v){
                $key = array_search($k, $columnData);
                if( $key !== false){
                    $dvalue[] = ($this->args['fields'][$key]) ?? [];
                }
            }
            if( !empty($dvalue) && sizeof($dvalue) > 0 ){
                $this->args['fields'] = $dvalue;
            }
           
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