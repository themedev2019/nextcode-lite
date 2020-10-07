<?php
namespace NextCode\Inc\Fileds\Date;
defined( 'ABSPATH' ) || exit;

use \NextCode\Inc\Setup\Ncode_common as Ncode_common;

Class Ncode_Date Extends Ncode_common{

    private $settings = [];
    private $key = '';
    private $option_key = '';
    private $option_data = [];

    private $args = [
        'id'    => '',
        'type'    => 'date',
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
        $this->args['default'] = ($this->args['default']) ?? '';
        
        $this->args['settings']['wrap'] = true;
        if( isset( $this->args['enable_time']) ){
            $this->args['settings']['enableTime'] = ( $this->args['enable_time'] ) ?? false;
        }
        if( isset( $this->args['no_calendar']) ){
            $this->args['settings']['noCalendar'] = ( $this->args['no_calendar'] ) ?? false;
        }
        $this->args['settings']['dateFormat'] = ( $this->args['date_format'] ) ?? 'Y-m-d';

        if( isset( $this->args['alt_format']) ){
            $this->args['settings']['altFormat'] = ( $this->args['alt_format'] ) ?? 'Y-m-d';
        }

        if( isset( $this->args['min_date']) ){
            $this->args['settings']['minDate'] = ( $this->args['min_date'] ) ?? '';
        }

        if( isset( $this->args['max_date']) ){
            $this->args['settings']['maxDate'] = ( $this->args['max_date'] ) ?? '';
        }
        if( isset( $this->args['mode']) ){
            $this->args['settings']['mode'] = ( $this->args['mode'] ) ?? '';
        }
       
        if( isset( $this->args['min_time']) ){
            $this->args['settings']['minTime'] = ( $this->args['min_time'] ) ?? '';
        }

        if( isset( $this->args['max_time']) ){
            $this->args['settings']['maxTime'] = ( $this->args['max_time'] ) ?? '';
        }
        
        $name = $this->args['id'];
        $id = $this->args['id'];
        if( isset($this->option_data[$this->key][$name]) ){
            $this->args['default'] = $this->option_data[$this->key][$name];
        }
        $this->args['settings']['defaultDate'] = $this->args['default'];

        $name_date =  $this->args['id'];
        $repeater = $this->args['repeater'] ?? false;
        if($repeater){
            $r_name =  $this->args['attr']['name'] ?? '';
            if( !empty($r_name) ){
                $name_date = $r_name;
            }
        } 
    
        // load js / css
        $this->enqueue();
        extract( $this->args );
        include ( __DIR__ . '/templates.php');
    }

    public function enqueue(){
    // flatpickr
		wp_enqueue_style( 'nextcode-flatpickr' );
		wp_enqueue_script( 'nextcode-flatpickr' );	
    }
    
	public static function instance(){
		if (!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
	}
}