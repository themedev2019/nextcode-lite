<div class="ncode-nxadd-accordion ncode-accordion-<?php _e(esc_attr($id));?>" data-id="ncode-accordion-<?php _e(esc_attr($id));?>">     
    <?php 
    if( !empty($accordions) ){
        foreach($accordions as $k=>$v){
            $title = ($v['title']) ?? 'Tab '.$k;
            $fields = ($v['fields']) ?? [];
    ?> 
        <div class="nx-card-header">
            <div class="nx-click-collapse ">
                <div class="ncode-header-title ">
                    <?php _e($title, 'nextcode');?>
                </div>
                <div class="ncode-header-icon ">
                    <span class="fas fa-angle-right"></span>
                </div>
            </div>
            <div class="nx-click-collapse-content">               
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
                        <div class="tabs-fields-action">
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
        </div>
        
    <?php }
    }?>
</div>
    
<?php if( !empty($desc) ){?>  
    <div class="input-details"> <?php _e($desc, 'nextcode');?> </div>
<?php }?>
       
