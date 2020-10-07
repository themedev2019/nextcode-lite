<?php 
    $attribute = '';
    $name_data = ($attr['name']) ?? '';
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
            $name_data = $v;
        }
        $attribute .= $k.'="'.$v.'" ';
    }
   
?>
<div class="ncode-number-options">
    <input <?php _e($attribute);?>/> 
    <?php if( !empty($unit) ) {?>
        <span class="unit-data"><?php _e($unit);?></span>
    <?php }?>
</div>

<?php if( !empty($desc) ){?>  
    <div class="input-details"> <?php _e($desc, 'nextcode');?> </div>
<?php }?>
       
