      
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
<textarea <?php _e($attribute);?> ><?php _e($default);?></textarea>
<?php if( !empty($desc) ){?>  
    <div class="input-details"> <?php _e($desc, 'nextcode');?> </div>
<?php }?>
       
