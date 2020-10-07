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
<div class="ncode-color-options" id="ncode-color-<?php _e($id);?>">
    <input <?php _e($attribute);?>/>
    <div class="ncode-render-color" data-color="<?php _e(trim($default));?>" data-id="ncode-color-<?php _e($id);?>">

    </div> 
</div>

<?php if( !empty($desc) ){?>  
    <div class="input-details"> <?php _e($desc, 'nextcode');?> </div>
<?php }?>
       
