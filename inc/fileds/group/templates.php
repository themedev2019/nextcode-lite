<div class="ncode_tabs_item ncode_group_item ncode-<?php _e(esc_attr($id));?>">
    <div data-group="<?php _e( $group_name );?>" data-group-config="<?php _e( $group_data );?>">
    <?php 
    
        if( !empty($default) ){
            $i = 0;
            foreach($default as $dv){
                ?>
                <div data-item  class="ncode_tabs_items group-items" id="ncode-group-<?php _e(esc_attr($id).'_'.$i);?>" data-id="ncode-group-<?php _e(esc_attr($id));?>_++">
                    <div class="ncode_tabs_items-heading group-items-heading">
                        <?php 
                        $title_data = 'Item - '. $i;
                        if( $title_field != 'sl'){
                            $title_data = isset($dv[$title_field]) ? $dv[$title_field] : $title_data;
                        }
                        ?>
                        <div class="ncode-header-icon "><span class="fas fa-angle-right"></span></div>
                        <div class="repeater-title">
                            <?php _e($title_data, 'nextcode');?>
                        </div>
                        <div class="tabs-remove-button">
                            <button data-delete type="button" class="followlink-btnRemove remove-buttons-link">X</button>
                        </div>
                    </div>
                    <div class="ncode_tabs_items_content group-items-content">
                        <?php
                        if( !empty($fields)){
                            
                            foreach( $fields as $v){
                                if( !isset($v['id']) ){
                                    continue;
                                }
                                $ids = $v['id'];
                                $type = $v['type'] ?? 'text';
                                $newkey = $id.'__'.$ids;
                                $v['id'] = $newkey.'__'.$i;

                                $dvlue = ($dv[$ids]) ?? '';
                                
                                if( isset($dv[$ids]) && is_array($dv[$ids]) ){
                                    $value = $dv[$ids];
                                }else{
                                    $value = $dvlue;
                                }
                               
                                $v['default'] = $value;
                                $v['attr']['name'] = "[$i][$ids]";
                                $v['attr']['data-name'] = "[++][$ids]";
                                $v['attr']['data-id'] = $newkey.'__++';

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
                                    $v['attr']['name'] = "[$m][$ids]";
                                    $v['attr']['data-name'] = "[++][$ids]";
                                }
                                
                                ?>
                                <div class="tabs-fields-action">
                                    <?php if( !empty($title) ){?> <div class="fileds-headline"> <?php _e($title);?> </div><?php }?>
                                    <?php
                                    
                                    $this->render_filed_data($v, $this->settings, $this->key,  true);
                                    ?>
                                </div>
                                <?php
                                
                            }
                        }
                        ?>
                    
                    </div>

                </div>
                <?php
                $i++;
            }
        }
        ?> 
    </div>
    <button data-create type="button" class="followlink-btnAdd add-buttons-link"><?php echo esc_html__('+ Add', 'nextcode'); ?></button>
   
</div>
<?php if( !empty($desc) ){?>  
    <div class="input-details"> <?php _e($desc, 'nextcode');?> </div>
<?php }?>
       
