<?php
namespace NextCode\Inc;
defined( 'ABSPATH' ) || exit;

Class Ncode_Load
{
	private static $instance;

	public function _init() {        
		// load script - css
		Setup\Ncode_Enqueue::instance()->_init();
		
        if(current_user_can('manage_options')){

            add_filter( 'plugin_action_links_' . plugin_basename( \NextCode\Ncode_Plugin::plugin_file() ), [ $this , '_action_links'] );
            add_filter( 'plugin_row_meta', [ $this, '_plugin_row_meta'], 10, 2 );
            
             // proactive
             Proactive\Init::instance()->_init();
        }

        
        // load icons in modal
        add_action( 'wp_ajax_ncode-get-icons', [ $this, 'ncode_get_icons'] );
        add_action( 'wp_ajax_nopriv_ncode-get-icons', [ $this, 'ncode_get_icons'] );

        // export system
        add_action( 'wp_ajax_ncode-export', [ $this, 'ncode_export'] );

        add_action( 'wp_ajax_ncode-restore', [ $this, 'ncode_export'] );
        //import
        add_action( 'wp_ajax_ncode-import', [ $this, 'ncode_import_ajax'] );
        // reset
        add_action( 'wp_ajax_ncode-reset', [ $this, 'ncode_reset_ajax'] );
    }

    public function ncode_get_icons(){
       
        $nonce = ( ! empty( $_POST[ 'nonce' ] ) ) ? sanitize_text_field( wp_unslash( $_POST[ 'nonce' ] ) ) : '';

        if ( ! wp_verify_nonce( $nonce, 'ncode_icon_nonce' ) ) {
            wp_send_json_error( array( 'error' => esc_html__( 'Error: Nonce verification has failed. Please try again.', 'nextcode' ) ) );
        }

        ob_start();

        $icon_library = ( apply_filters( 'ncode_fa4', false ) ) ? 'fa4' : 'fa5';

        include ( self::_get_dir() . 'fileds/icon/files/'.$icon_library .'-icons.php');

        $icon_lists = apply_filters( 'ncode_field_icon_add_icons', ncode_get_default_icons() );

        if ( ! empty( $icon_lists ) ) {

            foreach ( $icon_lists as $list ) {
                if( !isset($list['icons']) || empty($list['icons']) ){
                    continue;
                }
                echo ( count( $icon_lists ) >= 2 ) ? '<div class="ncode-icon-title">'. esc_attr( $list['title'] ) .'</div>' : '';

                foreach ( $list['icons'] as $icon ) {
                    if( empty($icon) ){
                        continue;
                    }
                    echo '<i title="'. esc_attr( $icon ) .'" class="'. esc_attr( $icon ) .'"></i>';
                }

            }

        } else {

            echo '<div class="ncode-error-text">'. esc_html__( 'No data provided by developer', 'nextcode' ) .'</div>';

        }

        $content = ob_get_clean();

        wp_send_json_success( array( 'content' => $content ) );
    }

    // export 
    public function ncode_export() {

        $nonce  = ( ! empty( $_GET[ 'nonce' ] ) ) ? sanitize_text_field( wp_unslash( $_GET[ 'nonce' ] ) ) : '';
        $unique = ( ! empty( $_GET[ 'unique' ] ) ) ? sanitize_text_field( wp_unslash( $_GET[ 'unique' ] ) ) : '';
        $time = ( ! empty( $_GET[ 'time' ] ) ) ? sanitize_text_field( wp_unslash( $_GET[ 'time' ] ) ) : '';
    
        if ( ! wp_verify_nonce( $nonce, 'ncode_backup_nonce' ) ) {
          die( esc_html__( 'Error: Nonce verification has failed. Please try again.', 'nextcode' ) );
        }
    
        if ( empty( $unique ) ) {
          die( esc_html__( 'Error: Options key could not valid.', 'nextcode' ) );
        }
    
        // Export
        header('Content-Type: application/json');
        if( !empty($time) ){
            header('Content-disposition: attachment; filename=ncode-restore-'. gmdate( 'd-M-Y H:i:s', $time ) .'.json');
        }else{
            header('Content-disposition: attachment; filename=ncode-backup-'. gmdate( 'd-m-Y' ) .'.json');
        }
        header('Content-Transfer-Encoding: binary');
        header('Pragma: no-cache');
        header('Expires: 0');
    
        if( !empty($time) ){
            echo json_encode( get_option( $unique.$time ) );
        }else{
            echo json_encode( get_option( $unique ) );
        }
       
        die();
    
    }

    public function ncode_import_ajax() {

        $nonce  = ( ! empty( $_POST[ 'nonce' ] ) ) ? sanitize_text_field( wp_unslash( $_POST[ 'nonce' ] ) ) : '';
        $unique = ( ! empty( $_POST[ 'unique' ] ) ) ? sanitize_text_field( wp_unslash( $_POST[ 'unique' ] ) ) : '';
        $data   = ( ! empty( $_POST[ 'data' ] ) ) ? wp_kses_post_deep( json_decode( wp_unslash( trim( $_POST[ 'data' ] ) ), true ) ) : array();
    
        if ( ! wp_verify_nonce( $nonce, 'ncode_backup_nonce' ) ) {
          wp_send_json_error( array( 'error' => esc_html__( 'Error: Nonce verification has failed. Please try again.', 'nextcode' ) ) );
        }
    
        if ( empty( $unique ) ) {
          wp_send_json_error( array( 'error' => esc_html__( 'Error: Options key could not valid.', 'nextcode' ) ) );
        }
    
        if ( empty( $data ) || ! is_array( $data ) ) {
          wp_send_json_error( array( 'error' => esc_html__( 'Error: Import data could not valid.', 'nextcode' ) ) );
        }
    
        // Success
        $options = get_option($unique, []);
        $time = time();
        if( update_option($unique.$time, $options) ){
            
            update_option( $unique, $data );
            
            // ret reset
            $reset = get_option($unique.'_reset', []);
            $reset[] = $time;
            update_option($unique.'_reset', $reset);
        }
        wp_send_json_success();
    
      }

    
    public function ncode_reset_ajax() {

        $nonce  = ( ! empty( $_POST[ 'nonce' ] ) ) ? sanitize_text_field( wp_unslash( $_POST[ 'nonce' ] ) ) : '';
        $unique = ( ! empty( $_POST[ 'unique' ] ) ) ? sanitize_text_field( wp_unslash( $_POST[ 'unique' ] ) ) : '';
    
        if ( ! wp_verify_nonce( $nonce, 'ncode_backup_nonce' ) ) {
          wp_send_json_error( array( 'error' => esc_html__( 'Error: Nonce verification has failed. Please try again.', 'nextcode' ) ) );
        }
    
         // Success
         $options = get_option($unique, []);
         $time = time();
         if( update_option($unique.$time, $options) ){
             
             delete_option( $unique );
             
             // ret reset
             $reset = get_option($unique.'_reset', []);
             $reset[] = $time;
             update_option($unique.'_reset', $reset);
         }
        // Success
        
        wp_send_json_success( ['success' => esc_html__( 'Successfully reset all options', 'nextcode' )] );
    
    }

	public static function _get_url(){
        return \NextCode\Ncode_Plugin::inc_url();
    }
    public static function _get_dir(){
        return \NextCode\Ncode_Plugin::inc_dir();
    }

    public static function _version(){
        return \NextCode\Ncode_Plugin::version();
    }

    public function _action_links($links){
        //$links[] = '<a class="next-highlight-b" href="' . admin_url( 'admin.php?page=nextcode' ).'"> '. __('Settings', 'nextcode').'</a>';
		$links[] = '<a class="next-highlight-a" href="https://nextcode.themedev.net/pricing/" target="_blank"> '. __('Buy Now', 'nextcode').'</a>';
	    return $links;
    }

    public function _plugin_row_meta( $links, $file  ){
       if ( strpos( $file, plugin_basename( \NextCode\Ncode_Plugin::plugin_file() )) !== false ) {
            $new_links = array(
                'demo' => '<a class="next-highlight-b" href="https://nextcode.themedev.net/" target="_blank"><span class="dashicons dashicons-welcome-view-site"></span>'. __('Live Demo', 'nextcode').'</a>',
                'doc' => '<a class="next-highlight-b" href="https://themedev.net/docs-html/next-code.html" target="_blank"><span class="dashicons dashicons-media-document"></span>'. __('User Guideline', 'nextcode').'</a>',
                'support' => '<a class="next-highlight-b" href="http://support.themedev.net/" target="_blank"><span class="dashicons dashicons-editor-help"></span>'. __('Support', 'nextcode').'</a>'
            );

            $links = array_merge( $links, $new_links );
        }
        return $links;
    }

    public static function instance(){
		if (!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }
}

