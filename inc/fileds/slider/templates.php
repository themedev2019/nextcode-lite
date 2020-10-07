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
    $data = '{';
    if( !empty($min) ){
        $data .= 'minVal: '.$min.',';
    }
    if( !empty($max) ){
        $data .= 'maxVal: '.$max.',';
    }
    if( !empty($step) ){
        $data .= 'grid: '.$step.',';
    }
    if( !empty($default) ){
        $data .= 'startAt: '.$default.',';
    }
    $data .= "rangeColor:'rgb(113 110 110)'}";
?>
<div class="ncode-slider-options">
    <div id="ncode_slider_<?php _e( esc_attr($id) );?>" class="ncode-slider" data-property="<?php _e($data)?>"></div>
    <span id="ncode_slider_<?php _e( esc_attr($id) );?>_val" class="ncode-slider-span ncopt-depend-toggle">
        <input <?php _e($attribute);?> class="ncode-slider-val"/> 
        <?php if( !empty($unit) ) {?>
            <span class="unit-data"><?php _e($unit);?></span>
        <?php }?>
    </span>
</div>

<?php if( !empty($desc) ){?>  
    <div class="input-details"> <?php _e($desc, 'nextcode');?> </div>
<?php }?>
       
