<?php 
    $attribute = '';
    foreach( $attr as $k=>$v){
        if( empty($k) ){
            continue;
        }
        if( $k == 'name'){
            if( $repeater ){
                $v = $array_dec.$v.$extra;
            } else{
                $v = $array_dec.'['.$v.']'.$extra;
            }
        }
        $attribute .= $k.'="'.$v.'" ';
    }
    
?>
<div class="ncode--image-group" data-multiple="<?php _e( esc_attr( $multiple )); ?>">
    <?php
    $num = 1;
    foreach ( $options as $key => $option ) {

        $active  = ( in_array( $key, $value ) ) ? 'ncode--active' : '';
        $checked = ( in_array( $key, $value ) ) ? ' checked' : '';
        echo '<label for="'. esc_attr( $id ) .'_'.$num.'" class="'. esc_attr( $active ) .'">';
            echo '<input id="'. esc_attr( $id ) .'_'.$num.'" value="'. esc_attr( $key ) .'"'. $attribute . esc_attr( $checked ) .'/>';
            
            echo '<div class="ncode--image">';
                if( filter_var($option, FILTER_VALIDATE_URL) ){
                    echo '<img src="'. esc_url( $option ) .'" alt="img-'. esc_attr( $num ) .'" />';
                }else{
                    echo '<span class="ncode-title"> '.$option.' </span>';
                }
            echo '</div>';
        echo '</label>';
        $num++;
      }
    ?>
</div>

<?php if( !empty($desc) ){?>  
    <div class="input-details"> <?php _e($desc, 'nextcode');?> </div>
<?php }?>
       
