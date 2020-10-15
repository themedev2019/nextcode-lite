<section class="nextcode-section nextcode-section-metabox taxonomy nx-shortcode <?php echo esc_attr($this->args['display_style']);?>-display <?php echo esc_attr($this->args['theme']);?>-mode <?php echo esc_attr($this->args['classname']);?>" >
    <?php if( !empty($this->args['title']) ) { _e('<h2>');  _e($this->args['title'], 'next-course'); _e('</h2>'); }?>
    <?php if( !empty($this->args['description']) ) { _e('<p>');  _e($this->args['description'], 'next-course'); _e('</p>'); }?>
    
    <?php if( !empty($this->form) ){ 
        $attribute = '';
        foreach( $this->form as $k=>$v){
            if( empty($k) ){
                continue;
            }
            $attribute .= $k.'="'.$v.'" ';
        }
        ?>
    <form <?php _e($attribute);?>>
    <?php
    }?>    
    <div class="metabox-content">
        <div class="nextcode-nav-menu">
            <ul class="nav-setting">
            <?php 
                $i = 0;
                if( !empty($this->pre_tabs) ){
                    foreach($this->pre_tabs as $k=>$v){

                        $pre_section = ($this->pre_subsections[$k]) ?? '';
                        ?>
                        <li class="<?php echo (!empty($pre_section)) ? 'submenus ' : ''; echo ($i == 0) ? 'active' : '';?>"><a href="#ntab=<?php echo esc_attr($k);?>" id="nv-<?php echo esc_attr($k);?>" > <i class="<?php echo esc_attr($v['icon']);?>"></i> <?php echo esc_html__($v['title'], 'nextcode')?></a>
                        <?php
                        
                        if( !empty($pre_section) && is_array($pre_section) ){
                            ?>
                            <ul class="sub-sections">
                                <?php foreach($pre_section as $kk=>$vv){
                                    $parent = ($vv['parent']) ?? '';
                                    if($k != $parent){
                                        continue;
                                    }
                                    ?>
                                    <li class="<?php echo ($i == 0) ? 'active' : '';?>"><a href="#ntab=<?php echo esc_attr($k);?>/<?php echo esc_attr($kk);?>" id="nv-<?php echo esc_attr($k);?>" > <i class="<?php echo esc_attr($vv['icon']);?>"></i> <?php echo esc_html__($vv['title'], 'nextcode')?></a></li>                        
                                    <?php }?>
                            </ul>

                            <?php
                        }
                        ?>
                        </li>
                        <?php
                        $i++;
                    }

                }
                ?>
            </ul>
        </div>

        <div class="nextcode-content-area">

            <div class="settings-content">
                <?php
                    $i = 0;
                    if( !empty($this->pre_tabs) ){
                        foreach($this->pre_tabs as $k=>$v){
                            
                            ?>
                                <div id="<?php echo esc_attr($k);?>" class="ncode-tabs-<?php echo esc_attr($k);?> <?php echo ($i == 0) ? 'active' : '';?>">
                                    <?php 
                                    $fields = isset( $this->pre_fields[$k]['fields'] ) ? $this->pre_fields[$k]['fields'] : [];
                                    if( !empty($fields) ){
                                        
                                        foreach($fields as $f){
                                            $f_type = isset($f['type']) ? $f['type'] : '';
                                            if( empty($f_type) ){
                                                continue;
                                            }

                                            $id = $f['id'] ?? '';
                                            $type = $f['type'] ?? '';
                                            $default = isset($settings[$k][$id]) ? $settings[$k][$id] : '';
                                            if( !empty($default) ){
                                                $f['default'] = $default;
                                            }
                                            
                                            $this->render_filed_data($f, $this->args, $k, false);
                                        }
                                    }
                                    
                                    ?>
                                </div>
                            <?php
                            $pre_section = ($this->pre_subsections[$k]) ?? '';
                            
                            if( !empty($pre_section) && is_array($pre_section) ){

                                foreach($pre_section as $kk=>$vv){
                                    $parent = ($vv['parent']) ?? '';
                                    if($k != $parent){
                                        continue;
                                    }
                                    ?>
                                        <div id="<?php echo esc_attr($k);?>-<?php echo esc_attr($kk);?>" class="ncode-tabs-<?php echo esc_attr($k);?>-<?php echo esc_attr($kk);?>  <?php echo ($i == 0) ? 'active' : '';?>">
                                        <?php 
                                            $fields = isset( $vv['fields'] ) ? $vv['fields'] : [];
                                            if( !empty($fields) ){
                                                
                                                foreach($fields as $f){
                                                    $f_type = isset($f['type']) ? $f['type'] : '';
                                                    if( empty($f_type) ){
                                                        continue;
                                                    }
                                                    $id = $f['id'] ?? '';
                                                    $type = $f['type'] ?? '';
                                                    $default = isset($settings[$kk][$id]) ? $settings[$kk][$id] : '';
                                                    if( !empty($default) ){
                                                        $f['default'] = $default;
                                                    }
                                                    
                                                    $this->render_filed_data($f, $this->args, $kk, false);
                                                }
                                            }
                                            ?>
                                        </div>
                                    <?php
                                }
                                
                            }
                            $i++;
                        }

                    }
                ?>
            </div>

            <?php if( !empty($this->form) && !empty($this->submit) ){
                 $attribute = '';
                 foreach( $this->submit as $k=>$v){
                     if( empty($k) ){
                         continue;
                     }
                     $attribute .= $k.'="'.$v.'" ';
                 }
                 $html = isset($this->submit['value']) ? $this->submit['value'] : 'Submit';
                ?>
                <div class="submit-button-section">
                    <button <?php _e($attribute);?>><?php _e($html, 'nextcode');?></button>
                </div>
            <?php }?>
            
        </div>
    </div>
    <?php if( !empty($this->form) ){ echo '</form>';}?>
</section>