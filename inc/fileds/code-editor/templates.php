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
<button type="button" class="ncode-copy-code-button">Click to copy</button>
<textarea <?php _e($attribute);?> data-editor="<?php echo esc_attr( json_encode( $settings ) ); ?>"><?php _e($default);?></textarea>
<?php if( !empty($desc) ){?>  
    <div class="input-details"> <?php _e($desc, 'nextcode');?> </div>
<?php }?>