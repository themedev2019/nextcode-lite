<div class="ncode-tabs-content ncode-tabs-<?php _e(esc_attr($id));?>" data-id="ncode-tabs-<?php _e(esc_attr($id));?>">     
    <ul class="nx-nav nx-nav-tabs ">
        <?php 
        if( !empty($tabs) ){
            foreach($tabs as $k=>$v){
                $title = ($v['title']) ?? 'Tab '.$k;
                $icon = ($v['icon']) ?? '';
        ?>
            <li class="nav-item">
                <a class="nx-tab nx-nav-link <?php echo ($k == 0) ? 'nx-active' : '';?>" href="#" nx-target="#content-<?php _e(esc_attr($id.'-'.$k));?>">
                    <?php if( !empty($icon) ){ echo '<i class="'.$icon.'"></i>';}?>
                    <?php _e($title, 'nextcode');?>
                </a>
            </li>
        <?php }
        }?>
    </ul>
    <div class="nx-tab-content">
        <?php 
        if( !empty($tabs) ){
            foreach($tabs as $k=>$v){
                $title = ($v['title']) ?? 'Tab '.$k;
                $fields = ($v['fields']) ?? [];
        ?>
            <div class="nx-tab-pane <?php echo ($k == 0) ? 'nx-show' : '';?>" id="content-<?php _e(esc_attr($id.'-'.$k));?>">
                <div class="ncode-fieldset-content tabs-content-data">
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
            </div>
       
        <?php }
        }?>
    </div>
           
</div>
    
<?php if( !empty($desc) ){?>  
    <div class="input-details"> <?php _e($desc, 'nextcode');?> </div>
<?php }?>
       
