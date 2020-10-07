<?php 
    $attribute = '';
    foreach( $attr as $k=>$v){
        if( empty($k) ){
            continue;
        }
        if( $k == 'name'){
            if( $repeater ){
                $v = $array_dec.$v;
            } else{
                $v = $array_dec.'['.$v.']';
            }
        }
        $attribute .= $k.'="'.$v.'" ';
    }
?>
<div class="ncode-icon-select ncode-icon-<?php _e( esc_attr($id) );?>">
    <span class="ncode-icon-preview<?php echo  esc_attr( $hidden )  ?>"><i class="<?php echo esc_attr( $default )  ?>"></i></span>
    <a href="#" class="button button-primary ncode-icon-add" data-id="<?php _e( esc_attr($id) );?>" data-nonce="<?php echo esc_attr( $nonce ); ?>"><?php echo wp_kses_post( $button_title ) ?></a>
    <a href="#" class="button ncode-warning-primary ncode-icon-remove<?php echo esc_attr( $hidden )  ?>"><?php echo wp_kses_post( $remove_title ) ?></a>
    <input type="text" <?php _e($attribute);?> />
</div>