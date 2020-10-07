<div class="ncode-fieldset-content ncode-fieldset-<?php _e(esc_attr($id));?>">     
    <?php
    if( !empty($fields)){
        $i = 0;
        foreach( $fields as $v){
            if( !isset($v['id']) ){
                continue;
            }
            $ids = $v['id'];
            $type = $v['type'] ?? 'text';
            $newkey = $id.'__'.$ids;
            $v['id'] = $newkey;

            $value = ($default[$ids]) ?? '';
            
            $v['default'] = $value;
            $v['attr']['name'] = "[$id][$ids]";
            $v['repeater'] = true;
            
            $type = ($v['type']) ?? '';
            $title = ($v['title']) ?? '';
            
            if(in_array( $type, ['group', 'repeater']) ){
                $v['nasted_parent'] = $ids;
                $v['group_name'] = "[$id][$i][$ids]";
                $v['group_data'] = "[$id][++][$ids]";
                $v['nasted'] = true;
            }

            // for nasted repeater
            if( $nasted ){
                $v['attr']['name'] = "[$id][$ids][$i]";
                $v['attr']['data-name'] = "[$id][$ids][++]";
            }
            
            ?>
            <div class="fieldset-section">
                <?php if( !empty($title) ){?> <div class="fileds-headline"> <?php _e($title);?> </div><?php }?>
                <?php
                
                $this->render_filed_data($v, $this->settings, $this->key,  true);
                ?>
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
       
