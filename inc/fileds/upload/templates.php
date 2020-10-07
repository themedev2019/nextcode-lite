
<?php 
    $attribute = '';
    foreach( $attr as $k=>$v){
        if( empty($k) ){
            continue;
        }
        if( $k == 'name'){  
            if( $repeater ){
                $v = $array_dec.$v.'[url]';
            } else{
                $v = $array_dec.'['.$v.'][url]';
            }
        }
        $attribute .= $k.'="'.$v.'" ';
    }
    if( $repeater ){
        $name_hidden = $array_dec.$attr['name'].'[id]';
    } else{
        $name_hidden = $array_dec.'['.$name.'][id]';
    }
?>
<input <?php _e($attribute);?> />
<input id="<?php _e( esc_attr($id));?>_id" class="nxinput-box" type="hidden" name="<?php _e($name_hidden);?>" value="<?php _e($hidden_id);?>" />
<button id="<?php _e( esc_attr($id));?>_button" data-id="<?php _e( esc_attr($id));?>" data-title="<?php _e( esc_attr($title));?>" class="nxsubmit-box ncode-files-uploder"  type="button"> <?php _e($button_title);?></button>
<button id="<?php _e( esc_attr($id));?>_button_remove" data-id="<?php _e( esc_attr($id));?>" class="nxsubmit-box nxremove-button <?php echo (empty($hidden_id)) ? 'hidden-removebutton' : '';?>"  type="button"> <?php _e($remove_title);?></button>
<?php if( $preview ){?>
<img <?php if( empty($attr['value']) ){?> style="display:none;" <?php }?> src="<?php echo esc_url($attr['value']);?>" alt="" class="preview-logo" id="<?php _e( esc_attr($id));?>_pre">
<?php }?>
<?php if( !empty($desc) ){?>  
    <div class="input-details"> <?php _e($desc, 'nextcode');?> </div>
<?php }?>


       
