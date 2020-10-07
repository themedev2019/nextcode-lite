       
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
<select <?php _e($attribute);?> >
    <?php
        if( !empty($options) ){
            foreach($options as $k1=>$v1){
                if( !empty($v1) && is_array($v1) ){
                    echo '<optgroup label="'. esc_html($k1, 'nextcode') .'">';
                    foreach($v1 as $kk=>$vv){
                        $selected = ( in_array( $kk, $value ) ) ? ' selected' : '';
                        ?>
                           <option value="<?php _e($kk);?>" <?php _e($selected);?>><?php _e($vv, 'nextcode');?></option> 
                        <?php
                    }
                    echo '</optgroup>';
                }else{
                    $selected = ( in_array( $k1, $value ) ) ? ' selected' : '';
                ?>
                    <option value="<?php _e($k1);?>" <?php _e($selected);?> ><?php _e($v1, 'nextcode');?></option>
                <?php
                }
            }
        }
    ?>
</select>
<?php if( !empty($desc) ){?>  
    <div class="input-details"> <?php _e($desc, 'nextcode');?> </div>
<?php }?>
       
