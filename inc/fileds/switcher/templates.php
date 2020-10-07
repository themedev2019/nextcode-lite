<?php               
    if( $repeater ){
        $name_data = $array_dec.$name;
    } else{
        $name_data = $array_dec.'['.$id.']';
    }
?>
<div class="nx-switch">
    <input type="checkbox" name="<?php _e( esc_attr($name_data) );?>" <?php echo ($default == $return_value)  ? 'checked' : ''; ?> class="nextcode-switch-input ncopt-depend-toggle" value="<?php _e( esc_attr($return_value) );?>" id="<?php _e( esc_attr($id) );?>"/>
    <label class="nextcode-checkbox-switch" for="<?php _e( esc_attr($id) );?>">
        <span class="nextcode-label-switch" data-active="<?php _e( esc_attr($label_on) );?>" data-inactive="<?php _e( esc_attr($label_off) );?>"></span>
    </label>
</div>
<?php if( !empty($desc) ){?>  
    <div class="input-details"> <?php _e($desc, 'nextcode');?> </div>
<?php }?>
