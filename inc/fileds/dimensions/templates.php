
<div class="ncode-dimensions-options ">
     <ul>
     <?php 
     $active = '';
     $type = 'active';
     foreach( $dimensions as $k=>$v){
        $hiddenClass = '';
        if( $repeater ){
            $name_ren = $array_dec.$name_dimention."[$k]";
        } else{
            $name_ren = $array_dec.'['.$name_dimention.']'."[$k]";
        }
        $value = ($this->args['default'][$k]) ?? '';
        
        if( $allowed_dimensions != 'all' && !in_array($k, $allowed_dimensions) ){
            $hiddenClass = 'readonly';
        } else {
            // button status
            if($active != $value){
                $active = $value;
                $type = '';
            }else{
                $type = 'active';
            }
        }

        ?>
        <li>
            <input id="dimention_<?php _e($id.'_'.$k);?>" <?php _e($hiddenClass);?> class="ncode-dimension-input" type="number" value="<?php _e($value);?>" name="<?php _e(esc_attr($name_ren));?>" data-setting="<?php _e($k);?>" placeholder="">
            <label for="dimention_<?php _e($id.'_'.$k);?>" class="ncode-dimension-label"><?php _e($v, 'nextcode');?></label>
        </li>
        <?php
     }
     if( !empty($size_units) && is_array($size_units) ){
       
        if( $repeater ){
            $name_unit = $array_dec.$name_dimention."[unit]";
        } else{
            $name_unit = $array_dec.'['.$name_dimention.']'."[unit]";
        }
        $value_unit = ($this->args['default']['unit']) ?? '';
        ?>
        <li>
            <select class="dimention-unit" name="<?php _e(esc_attr($name_unit));?>">
                <?php
                foreach( $size_units as $si){
                   ?>
                    <option value="<?php _e($si);?>" <?php echo ($si == $value_unit) ? 'selected' : '';?> ><?php _e($si);?></option>
                   <?php
                }
                ?>
            </select>
            <label for="dimention_<?php _e($id.'_');?>unit" class="ncode-dimension-label"><?php _e('Unit', 'nextcode');?></label>
        </li>
        <?php
     }
     ?>
    <li>
        <button type="button" class="dimention-button <?php _e($type);?>"><i class="fas fa-link"></i></button>
    </li>
     </ul>
</div>

<?php if( !empty($desc) ){?>  
    <div class="input-details"> <?php _e($desc, 'nextcode');?> </div>
<?php }?>
       
