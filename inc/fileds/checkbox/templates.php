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
<ul <?php _e($inline_class);?>>
    <?php
    $num = 1;
    foreach ( $options as $key => $option ) {
        if( is_array( $option ) && ! empty( $option )  ){
            echo '<li>';
                echo '<ul>';
                  echo '<li><strong>'. esc_attr( $key ) .'</strong></li>';
                    $n = 1;
                    foreach($option as $sub_key => $sub_value){
                        $checked = ( in_array( $sub_key, $value ) ) ? ' checked' : '';
                        echo '<li>';
                            echo '<label>';
                                echo '<input id="'. esc_attr( $id ) .'_'.$num.'_'.$n.'" value="'. esc_attr( $sub_key ) .'"'. $attribute . esc_attr( $checked ) .'/>';
                                echo '<span class="ncode-title">'. esc_attr( $sub_value ) .'</span>';
                            echo '</label>';
                        echo '</li>';
                        $n++;
                    }
                echo '</ul>';
            echo '</li>';

        }else {
            $checked = ( in_array( $key, $value ) ) ? ' checked' : '';
            echo '<li>';
                echo '<label>';
                    echo '<input id="'. esc_attr( $id ) .'_'.$num.'" value="'. esc_attr( $key ) .'"'. $attribute . esc_attr( $checked ) .'/>';
                    echo '<span class="ncode-title">'. esc_attr( $option ) .'</span>';
                echo '</label>';
            echo '</li>';
        }
        $num++;
      }
    ?>
</ul>

<?php if( !empty($desc) ){?>  
    <div class="input-details"> <?php _e($desc, 'nextcode');?> </div>
<?php }?>
       
