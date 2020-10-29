<div class="ncode-sorter-content ncode-sorter-<?php _e(esc_attr($id));?>" >     
    <?php
    if( !empty($default)){
        $i = 0;
        foreach( $default as $k=>$v){
            $titlename = ($this->args[$k.'_title']) ?? $k;
        
            if( $repeater ){
                $name_data = $array_dec.$attr['name']."[$k]";
            } else{
                $name_data = $array_dec.'['.$attr['name'].']'."[$k]";
            }
            ?>
            <div class="sorter-section ncode-sortable-content" data-id="ncode-sorter-<?php _e(esc_attr($id));?>_<?php _e($k);?>">
                <?php if( !empty($titlename) ){?> <div class="fileds-headline"> <?php _e($titlename);?> </div><?php }?>
                <ul class="ncode-sorter option-<?php _e($k);?>">

                    <?php
                    if( !empty($v) && is_array($v)){
                        foreach($v as $kk=>$vv){
                            $namesub = $name_data."[$kk]";
                            ?>
                            <li>
                                <input type="hidden" name="<?php _e( esc_attr($namesub));?>" value="<?php _e($vv);?>">
                                <label> <?php _e($vv);?></label>
                            </li>
                            <?php
                        }
                    }else{
                        ?>
                        <li>
                            <input type="hidden" name="<?php _e( esc_attr($name_data));?>" value="<?php _e($v);?>">
                            <label> <?php _e($v);?></label>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <?php
            $i++; 
        }
    }
    ?> 
</div>
    
<?php if( !empty($desc) ){?>  
    <div class="input-details"> <?php _e($desc, 'nextcode');?> </div>
<?php }?>
       
