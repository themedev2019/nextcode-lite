<?php 
    if( $repeater ){
        $name = $array_dec.$name_date;
    } else{
        $name = $array_dec.'['.$name_date.']';
    }
?>

<div class="ncode-date-option nx-flatpickr" data-settings='<?php _e(json_encode($settings));?>'>
    <input type="text" name="<?php _e( esc_attr($name) );?>" value="<?php _e($default);?>" class="nxinput-box" id="<?php _e( esc_attr($id) );?>" placeholder="Select Date.." data-input>
    <a class="input-button opend" title="toggle" data-toggle>
        <i class="far fa-calendar-alt"></i>
    </a>
    <a class="input-button closeb" title="clear" data-clear>
        <i class="far fa-calendar-times"></i>
    </a>
</div>

<?php if( !empty($desc) ){?>  
    <div class="input-details"> <?php _e($desc, 'nextcode');?> </div>
<?php }?>
       
