<?php 
namespace NextCode\Inc\Setup;
defined( 'ABSPATH' ) || exit;

use \NextCode\Ncode_Plugin as Ncode_Plugin;
use \NextCode\Inc\Fileds as Fileds;

class Ncode_common
{
	public $plugin_path;

	public $plugin_url;

	public $plugin_dir;

	public $plugin;

	public $version;


	public function __construct() {
		$this->plugin_path = Ncode_Plugin::plugin_url();
		$this->plugin_url  = Ncode_Plugin::plugin_url();
		$this->plugin_dir  = Ncode_Plugin::plugin_dir();
		$this->plugin      = Ncode_Plugin::plugin_file();
		$this->version     = self::_version();
	}
	
  public static function _plugin_path(){
		return Ncode_Plugin::plugin_url();
	}

	public static function _plugin_url(){
		return Ncode_Plugin::plugin_url();
	}

	public static function _plugin_dir(){
		return Ncode_Plugin::plugin_dir();
	}

	public static function _plugin(){
		return Ncode_Plugin::plugin_file();
	}

	public static function _version(){
		
		if( $_SERVER['HTTP_HOST'] == 'localhost'){
			return time();
		}else{
			return Ncode_Plugin::version();
		}
	}

 public function _get_options($meta_key, $type = 'option', $meta_id = 0){
    if( $type == 'option' || $type == 'options' ){
      $data = get_option( $meta_key, []);
    } else if( $type == 'post' || $type == 'posts' ){
      $data = get_post_meta($meta_id, $meta_key, true);
    } else if( $type == 'user' || $type == 'users' ){
      $data = get_user_meta($meta_id, $meta_key, true);
    } else if( $type == 'term' || $type == 'terms'){
      $data = get_term_meta($meta_id, $meta_key, true);
    } else if( $type == 'comment' || $type == 'comments'){
      $data = get_comment_meta($meta_id, $meta_key, true);
    } else{
      $data = get_option( $meta_key, []);
    }
    return $data;
 }

	public function condition_check( $target_value, $target_condition, $getvalue){
		if( in_array($target_condition, ['==', '=', '===']) ){
			return ( $target_value == $getvalue) ? 'yes' : 'no';
		} else if( in_array($target_condition, ['!=', '!', '<>', '!==']) ){
			return ( $target_value != $getvalue) ? 'yes' : 'no';
		} else if( in_array($target_condition, ['<']) ){
			return ( $target_value < $getvalue) ? 'yes' : 'no';
		} else if( in_array($target_condition, ['<=']) ){
			return ( $target_value <= $getvalue) ? 'yes' : 'no';
		} else if( in_array($target_condition, ['>']) ){
			return ( $target_value > $getvalue) ? 'yes' : 'no';
		} else if( in_array($target_condition, ['>=']) ){
			return ( $target_value >= $getvalue) ? 'yes' : 'no';
		} else if( in_array($target_condition, ['<=>']) ){
			return ( $target_value <=> $getvalue) ? 'yes' : 'no';
		}else{
			return 'no';
		}
		
	}

	public function set_output( $sections ){
      if( empty($sections)){
          return;
      }
      $sec = [];
      
      foreach($sections as $k=>$v){
          if( !isset($v['fields']) || empty($v['fields']) ){
              continue;
          }
          $fields = $v['fields'];
          foreach($fields as $fd){
              if( isset($fd['output']) && !empty($fd['output']) ){
                  $id = $fd['id'];
                  $sec[$k][$id]['type'] = ($fd['type']) ? $fd['type'] : '';
                  $sec[$k][$id]['output'] = $fd['output'];
              } else{
                if( !is_array($fd) || empty($fd) || !isset($fd['type']) || empty($fd['type']) ){
                  continue;
                }
                $type = ($fd['type']) ?? ''; 
                if( in_array( $type, ['accordion', 'tab', 'tabbed', 'tabs', 'fieldset', 'repeater', 'group'])  ){
                  $res = $this->self_output($fd);
                  if( is_array($res) && !empty($res) ){
                      foreach($res as $kk=>$vv){
                        foreach($vv as $d){
                          if( empty($d) ){
                              continue;
                          }
                          if( isset($d['output']) && !empty($d['output']) ){
                              $id = $d['id'];
                              $sec[$k][$kk][$id]['type'] = ($d['type']) ? $d['type'] : '';
                              $sec[$k][$kk][$id]['output'] = $d['output'];
                          }
                        }
                        
                      }
                  }
                }
                
              }
          }
      }
    return $sec;
  }

  private function self_output($fd){
    
    $arr = [];

    $type = ($fd['type']) ?? ''; 
    $id = ($fd['id']) ?? ''; 
    if( in_array( $type, ['accordion'])  ){
       $array = ($fd['accordions']) ?? '';
       if( !empty($array) && !empty($id) ){
          
          foreach($array as $k=>$v){
            $fileds = ($v['fields']) ?? '';
            if( empty($fileds) ){
              continue;
            }
            foreach($fileds as $vv){
              if( isset($vv['output']) && !empty($vv['output']) ){
                $arr[$id] = $fileds;
              }
            }
            
          }
       }
    }

    if( in_array( $type, ['tab', 'tabbed', 'tabs'])  ){
      $array = ($fd['tabs']) ?? '';
      if( !empty($array) && !empty($id) ){
         
         foreach($array as $k=>$v){
           $fileds = ($v['fields']) ?? '';
           if( empty($fileds) ){
             continue;
           }
           foreach($fileds as $vv){
             if( isset($vv['output']) && !empty($vv['output']) ){
               $arr[$id] = $fileds;
             }
           }
           
         }
      }
    }

    if( in_array( $type, ['fieldset', 'repeater', 'group'])  ){
      $fileds = ($fd['fields']) ?? '';
      if( !empty($fileds) ){
        foreach($fileds as $vv){
          if( isset($vv['output']) && !empty($vv['output']) ){
            $arr[$id] = $fileds;
          }
        }
      }
    }
    
    return $arr;
    
  }

  public function set_action( $sections ){
        if( empty($sections)){
            return;
        }
        $sec = [];
        foreach($sections as $k=>$v){
            
            if( !isset($v['fields']) || empty($v['fields']) ){
                continue;
            }
            $fields = $v['fields'];
            foreach($fields as $fd){
                if( isset($fd['action']) && !empty($fd['action']) ){
                    foreach( $fd['action'] as $ff){
                        if( empty($ff) ){
                            continue;
                        }
                        $sec[$k][] = $ff;
                    }
                }
            }
        }
        return $sec;
  }

  public function set_fields( $sections ){
        if( empty($sections)){
            return;
        }
        $sec = [];
        foreach($sections as $k=>$v){
            if( empty($k) || !isset($v['title']) || empty($v['title'])){
                continue;
            }
            
            if( isset($v['parent']) ){
               continue;
            }
            
            $fields = isset($v['fields']) ? $v['fields'] : [];
            $fields_set = isset($this->fields[$k]) ? $this->fields[$k] : '';
            if( !empty($fields_set) ){
                $fields[] = $fields_set;
            }
            $sec[$k] = [
                'title' => $v['title'],
                'icon' => $v['icon'],
                'priority' => $v['priority'],
                'fields' => $fields,
            ];
            
            if( isset($v['sub_sections']) && !empty($v['sub_sections'])){
                foreach($v['sub_sections'] as $kk=>$vv){
                    if( empty($kk) || !isset($vv['title']) || empty($vv['title'])){
                      continue;
                    }

                    $fields_sub = isset($vv['fields']) ? $vv['fields'] : [];
                    $fields_set1 = isset($this->fields[$kk]) ? $this->fields[$kk] : '';
                    if( !empty($fields_set1) ){
                        $fields_sub[] = $fields_set1;
                    }
                    $sec[$kk] = [
                        'title' => $vv['title'],
                        'icon' => $vv['icon'],
                        'priority' => $vv['priority'],
                        'fields' => $fields_sub,
                    ];
                }
            }
            

        }
        return wp_list_sort( $sec, array( 'priority' => 'ASC' ), 'ASC', true );
  }

  public function set_tabs( $sections ){
        if( empty($sections)){
            return;
        }
        $sec = [];
        foreach($sections as $k=>$v){
            if( empty($k) || !isset($v['title']) || empty($v['title'])){
                continue;
            }
            if( isset($v['parent']) ){
                continue;
            }
            $sec[$k] = [
                'title' => $v['title'],
                'icon' => $v['icon'],
                'priority' => $v['priority'],
            ];
        }
        return wp_list_sort( $sec, array( 'priority' => 'ASC' ), 'ASC', true );
  }
  public function set_section( $sections ){
        if( empty($sections)){
            return;
        }
        $sec = [];
        foreach($sections as $k=>$v){
            if( empty($k) || !isset($v['title']) || empty($v['title'])){
                continue;
            }
            $sec[$k] = $v['title'];
        }
        return $sec;
  }

  public function set_sub_section( $sections ){
    if( empty($sections)){
        return;
    }
    
    $sec = [];
    foreach($sections as $k=>$v){
        if( empty($k) || !isset($v['sub_sections']) || empty($v['sub_sections'])){
            continue;
        }
        $sec[$k] = $v['sub_sections'];
    }
    return $sec;
}

  public $setti = [];
  public $optkey = [];
  public $optType = [];
  public $optIds = 0;
  public $optdat = [];
  public $argm = [];

  public function target_toggle( $params = [], $setting = [], $key = '' ){
      $this->ky = $key;
      $this->setti = $setting;
      $this->argm = $params;
      
      $this->optkey = isset($setting['options_key']) ? $setting['options_key'] : '';
      $this->optType = isset($setting['options_type']) ? $setting['options_type'] : 'options';
      $this->optIds = isset($setting['options_ids']) ? $setting['options_ids'] : 0;

      $this->optdat = $this->_get_options( $this->optkey, $this->optType, $this->optIds);

      // target toggle
      $target_toggle = isset( $this->argm['target_toggle'] ) ? $this->argm['target_toggle'] : '';
      $target_section = isset( $target_toggle['section'] ) ? $target_toggle['section'] : '';
      $target_field = isset( $target_toggle['field'] ) ? $target_toggle['field'] : '';
      $target_condition = isset( $target_toggle['condition'] ) ? $target_toggle['condition'] : '==';
      $target_value = isset( $target_toggle['value'] ) ? $target_toggle['value'] : '';
      
      $check_value = 'no';
      if( !empty($target_toggle) ){
          $main_array = isset($this->setti['sections'][$target_section]['fields']) ? $this->setti['sections'][$target_section]['fields'] : [];
          $search = array_search($target_field, array_column($main_array, 'id', 'default'));
          if( is_array($search) ){
              $search = isset($search[$target_field]) ? $search[$target_field] : '';
          }
          if( !empty($this->optdat) ){
              $getvalue = isset($this->optdat[$target_section][$target_field]) ? $this->optdat[$target_section][$target_field] : '';
          }else{
              $getvalue = $search;
          }
          $check_value =  $this->condition_check($target_value, $target_condition, $getvalue);
      }
      return $check_value;
  }

  public function pre_field( $params = [] ){
      return $params['parent_filed'] ?? '';
  }

  public function render_filed_data( $params = [], $setting = [], $key = '', $blank = false){
      
      $this->ky = $key;
      $this->setti = $setting;
      $this->argm = $params;

      $target_toggle = isset( $this->argm['target_toggle'] ) ? $this->argm['target_toggle'] : '';
      $target_section = isset( $target_toggle['section'] ) ? $target_toggle['section'] : '';
      $target_field = isset( $target_toggle['field'] ) ? $target_toggle['field'] : '';
      $target_condition = isset( $target_toggle['condition'] ) ? $target_toggle['condition'] : '==';
      $target_value = isset( $target_toggle['value'] ) ? $target_toggle['value'] : '';
      
      $check_value = $this->target_toggle($this->argm, $this->setti, $this->ky);
      // parent_filed 
      $pr_field = $this->pre_field( $this->argm );
      $title = $this->argm['title'] ?? '';
      $type = $this->argm['type'] ?? '';
      $id = $this->argm['id'] ?? '';

      if($blank){
          include ( __DIR__ . '/views/fields/field-render-blank.php');
      }else {
          include ( __DIR__ . '/views/fields/field-render.php');
      }
      
  }

  public static function field_data_options( $type = '', $term = false, $query_args = array() ) {

      $options = array();
      $array_search = false;

      // sanitize type name
      if ( in_array( $type, array( 'page', 'pages' ) ) ) {
        $option = 'page';
      } else if ( in_array( $type, array( 'post', 'posts' ) ) ) {
        $option = 'post';
      } else if ( in_array( $type, array( 'category', 'categories' ) ) ) {
        $option = 'category';
      } else if ( in_array( $type, array( 'tag', 'tags' ) ) ) {
        $option = 'post_tag';
      } else if ( in_array( $type, array( 'menu', 'menus' ) ) ) {
        $option = 'nav_menu';
      } else {
        $option  = '';
      }

      // switch type
      switch( $type ) {

        case 'page':
        case 'pages':
        case 'post':
        case 'posts':

          if ( ! empty( $term ) ) {

            $query             = new \WP_Query( wp_parse_args( $query_args, array(
              's'              => $term,
              'post_type'      => $option,
              'post_status'    => 'publish',
              'posts_per_page' => -1,
            ) ) );

          } else {

            $query          = new \WP_Query( wp_parse_args( $query_args, array(
              'post_type'   => $option,
              'post_status' => 'publish',
              'posts_per_page' => -1,
            ) ) );

          }

          if ( ! is_wp_error( $query ) && ! empty( $query->posts ) ) {
            foreach ( $query->posts as $item ) {
              $options[$item->ID] = $item->post_title;
            }
          }

        break;

        case 'category':
        case 'categories':
        case 'tag':
        case 'tags':
        case 'menu':
        case 'menus':

          if ( ! empty( $term ) ) {

            $query         = new \WP_Term_Query( wp_parse_args( $query_args, array(
              'search'     => $term,
              'taxonomy'   => $option,
              'hide_empty' => false,
              'number'     => 25,
            ) ) );

          } else {

            $query         = new \WP_Term_Query( wp_parse_args( $query_args, array(
              'taxonomy'   => $option,
              'hide_empty' => false,
            ) ) );

          }

          if ( ! is_wp_error( $query ) && ! empty( $query->terms ) ) {
            foreach ( $query->terms as $item ) {
              $options[$item->term_id] = $item->name;
            }
          }

        break;

        case 'user':
        case 'users':

          if ( ! empty( $term ) ) {

            $query      = new \WP_User_Query( array(
              'search'  => '*'. $term .'*',
              'number'  => 25,
              'orderby' => 'title',
              'order'   => 'ASC',
              'fields'  => array( 'display_name', 'ID' )
            ) );

          } else {

            $query = new \WP_User_Query( array( 'fields' => array( 'display_name', 'ID' ) ) );

          }

          if ( ! is_wp_error( $query ) && ! empty( $query->get_results() ) ) {
            foreach ( $query->get_results() as $item ) {
              $options[$item->ID] = $item->display_name;
            }
          }

        break;

        case 'sidebar':
        case 'sidebars':

          global $wp_registered_sidebars;

          if ( ! empty( $wp_registered_sidebars ) ) {
            foreach ( $wp_registered_sidebars as $sidebar ) {
              $options[$sidebar['id']] = $sidebar['name'];
            }
          }

          $array_search = true;

        break;

        case 'role':
        case 'roles':

          global $wp_roles;

          if ( ! empty( $wp_roles ) ) {
            if ( ! empty( $wp_roles->roles ) ) {
              foreach ( $wp_roles->roles as $role_key => $role_value ) {
                $options[$role_key] = $role_value['name'];
              }
            }
          }

          $array_search = true;

        break;

        case 'post_type':
        case 'post_types':

          $post_types = get_post_types( array( 'show_in_nav_menus' => true ), 'objects' );

          if ( ! is_wp_error( $post_types ) && ! empty( $post_types ) ) {
            foreach ( $post_types as $post_type ) {
              $options[$post_type->name] = $post_type->labels->name;
            }
          }

          $array_search = true;

        break;

        default:

          if ( function_exists( $type ) ) {
            if ( ! empty( $term ) ) {
              $options = call_user_func( $type, $query_args );
            } else {
              $options = call_user_func( $type, $term, $query_args );
            }
          }

        break;

      }

      // Array search by "term"
      if ( ! empty( $term ) && ! empty( $options ) && ! empty( $array_search ) ) {
        $options = preg_grep( '/'. $term .'/i', $options );
      }

      // Make multidimensional array for ajax search
      if ( ! empty( $term ) && ! empty( $options ) ) {
        $arr = array();
        foreach ( $options as $option_key => $option_value ) {
          $arr[] = array( 'value' => $option_key, 'text' => $option_value );
        }
        $options = $arr;
      }

      return $options;

  }

  public static function field_query_data( $type, $values ) {

      $options = array();

      if ( ! empty( $values ) && is_array( $values ) ) {

        foreach ( $values as $value ) {

          switch( $type ) {

            case 'post':
            case 'posts':
            case 'page':
            case 'pages':

              $title = get_the_title( $value );

              if ( ! is_wp_error( $title ) && ! empty( $title ) ) {
                $options[$value] = $title;
              }

            break;

            case 'category':
            case 'categories':
            case 'tag':
            case 'tags':
            case 'menu':
            case 'menus':

              $term = get_term( $value );

              if ( ! is_wp_error( $term ) && ! empty( $term ) ) {
                $options[$value] = $term->name;
              }

            break;

            case 'user':
            case 'users':

              $user = get_user_by( 'id', $value );

              if ( ! is_wp_error( $user ) && ! empty( $user ) ) {
                $options[$value] = $user->display_name;
              }

            break;

            case 'sidebar':
            case 'sidebars':

              global $wp_registered_sidebars;

              if ( ! empty( $wp_registered_sidebars[$value] ) ) {
                $options[$value] = $wp_registered_sidebars[$value]['name'];
              }

            break;

            case 'role':
            case 'roles':

              global $wp_roles;

              if ( ! empty( $wp_roles ) && ! empty( $wp_roles->roles ) && ! empty( $wp_roles->roles[$value] ) ) {
                $options[$value] = $wp_roles->roles[$value]['name'];
              }

            break;

            case 'post_type':
            case 'post_types':

                $post_types = get_post_types( array( 'show_in_nav_menus' => true ) );

                if ( ! is_wp_error( $post_types ) && ! empty( $post_types ) && ! empty( $post_types[$value] ) ) {
                  $options[$value] = ucfirst( $value );
                }

            break;

            default:

              if ( function_exists( $type .'_title' ) ) {
                $options[$value] = call_user_func( $type .'_title', $value );
              } else {
                $options[$value] = ucfirst( $value );
              }

            break;

          }

        }

      }

      return $options;

  }
  
  public function _render_css( $settings, $set_outputs, $fileds = []){
    $css_render = "";
  
    $settings = apply_filters( 'ncode_fields_css_settings_before', $settings);
    $set_outputs = apply_filters( 'ncode_fields_css_output_before', $set_outputs, $settings);
    
    if( !empty($set_outputs) ){
        foreach($set_outputs as $k=>$va){
            if( empty($va)){
                continue;
            }
            foreach($va as $k1=>$v){
              if( empty($v) ){
                continue;
              }
              $type = ($v['type']) ?? '';
              if( !empty($type) ){
                $output = ($v['output']) ?? '';
                $value = ($settings[$k][$k1]) ?? '';
                if( empty($type) || empty( $output) || empty($value) ){
                   continue;
                }
                $selector = isset( $output['selector'] ) ? $output['selector'] : '';
                $render = isset( $output['render'] ) ? $output['render'] : '';
                $selectors = isset( $output['selectors'] ) ? $output['selectors'] : '';
                $css_render .= self::multiple_render_css($type, $output, $value, $fileds);
              } else {
                foreach($v as $kk=>$vv){
                    $id = ($vv['id']) ?? '';
                    $type = ($vv['type']) ?? '';
                    $output = ($vv['output']) ?? '';
                    $value = isset($settings[$k][$k1][$kk]) ? $settings[$k][$k1][$kk] : '';
                    if( empty($type) || empty( $output) || empty($value) ){
                      continue;
                    }
                    $selector = isset( $output['selector'] ) ? $output['selector'] : '';
                    $render = isset( $output['render'] ) ? $output['render'] : '';
                    $selectors = isset( $output['selectors'] ) ? $output['selectors'] : '';
                    $css_render .= self::multiple_render_css($type, $output, $value, $fileds);
                }
              }
            }
        }
    }
    $output_data = apply_filters( 'ncode_fields_css_render_before', $css_render);
    return $output_data;
  }

  private static function multiple_render_css($type, $output,$value, $fileds){
    $css_render = "";
     switch($type){
         case 'background':
         case 'gradient':
           $css_render .= Fileds\Background\Ncode_Background::instance()->css_render($output, $value, $fileds);
         break;

         case 'color':
           $css_render .= Fileds\Color\Ncode_Color::instance()->css_render($output, $value, $fileds);
         break;

         case 'font':
         case 'typography':
           $css_render .= Fileds\Typography\Ncode_Typography::instance()->css_render($output, $value, $fileds);
         break;

         case 'borders':
         case 'border':
         case 'border-radius':
             $css_render .= Fileds\Border\Ncode_Border::instance()->css_render($output, $value, $fileds);
         break;

         case 'shadow':
         case 'box-shadow':
         case 'box_shadow':
             $css_render .= Fileds\Box_Shadow\Ncode_Box_Shadow::instance()->css_render($output, $value, $fileds);
         break;

         case 'dimensions':
         case 'dimension':
         case 'spacing':
         case 'margin':
         case 'padding':
             $css_render .= Fileds\Dimensions\Ncode_Dimensions::instance()->css_render($output, $value, $fileds);
         break;

         case 'choose':
           $css_render .= Fileds\Choose\Ncode_Choose::instance()->css_render($output, $value, $fileds);
         break;

         case 'range':
         case 'slider':
             $css_render .= Fileds\Slider\Ncode_Slider::instance()->css_render($output, $value, $fileds);
         break;

         case 'number':
             $css_render .= Fileds\Number\Ncode_Number::instance()->css_render($output, $value, $fileds);
         break;

         case 'spinner':
             $css_render .= Fileds\Spinner\Ncode_Spinner::instance()->css_render($output, $value, $fileds);
         break;

         case 'imageselect':
         case 'image-select':
         case 'image_select':
             $css_render .= Fileds\Image_Select\Ncode_Image_Select::instance()->css_render($output, $value, $fileds);
         break;

         case 'radio':
         case 'checkbox':
             $css_render .= Fileds\Checkbox\Ncode_Checkbox::instance()->css_render($output, $value, $fileds);
         break;

         case 'text':
             $css_render .= Fileds\Text\Ncode_Text::instance()->css_render($output, $value, $fileds);  
         break;

         case 'select':
             $css_render .= Fileds\Select\Ncode_Select::instance()->css_render($output, $value, $fileds); 
         break;

         case 'switcher':
             $css_render .= Fileds\Switcher\Ncode_Switcher::instance()->css_render($output, $value, $fileds);
         break;

         case 'icon':
             $css_render .= Fileds\Icon\Ncode_Icon::instance()->css_render($output, $value, $fileds); 
         break;

         case 'upload':
           $css_render .= Fileds\Upload\Ncode_Upload::instance()->css_render($output, $value, $fileds); 
         break;

         case 'media':
           $css_render .= Fileds\Media\Ncode_Media::instance()->css_render($output, $value, $fileds); 
         break;
     }

   return $css_render;
  }
    
  public static function sanitize($value, $senitize_func = 'sanitize_text_field'){
      $senitize_func = (in_array($senitize_func, [
              'sanitize_email', 
              'sanitize_file_name', 
              'sanitize_hex_color', 
              'sanitize_hex_color_no_hash', 
              'sanitize_html_class', 
              'sanitize_key', 
              'sanitize_meta', 
              'sanitize_mime_type',
              'sanitize_sql_orderby',
              'sanitize_option',
              'sanitize_text_field',
              'sanitize_title',
              'sanitize_title_for_query',
              'sanitize_title_with_dashes',
              'sanitize_user',
              'esc_url_raw',
              'wp_filter_nohtml_kses',
          ])) ? $senitize_func : 'sanitize_text_field';
      
      if(!is_array($value)){
          return $senitize_func($value);
      }else{
          return array_map(function($inner_value) use ($senitize_func){
              return self::sanitize($inner_value, $senitize_func);
          }, $value);
      }
  }

  private static $instance_self;

  public static function self_class(){
      if (!self::$instance_self){
              self::$instance_self = new self();
      }
      return self::$instance_self;
  }
  

}