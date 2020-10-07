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
<div class="ncode-choose-options">
    <?php
    $num = 1;
    foreach ( $options as $key => $option ) {
        $checked = ( $key == $default ) ? ' checked' : '';
        $name = ($option['title']) ?? '';
        $icon = ($option['icon']) ?? '';
        echo '<div class="choose-item">';
            echo '<input id="'. esc_attr( $id ) .'_'.$num.'" value="'. esc_attr( $key ) .'"'. $attribute . esc_attr( $checked ) .'/>';
            echo '<label for="'. esc_attr( $id ) .'_'.$num.'" data-title="'. esc_attr( $name ) .'">';
                echo '<i class="'. esc_attr( $icon ) .'" aria-hidden="true"></i>';
                echo '<span class="ncode-title">'. esc_attr( $name ) .'</span>';
            echo '</label>';
        echo '</div>';
        
        $num++;
      }
    ?>
</div>

<?php if( !empty($desc) ){?>  
    <div class="input-details"> <?php _e($desc, 'nextcode');?> </div>
<?php }?>
       
