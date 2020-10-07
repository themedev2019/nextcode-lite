<section class="nextcode-section <?php echo esc_attr($this->args['display_style']);?>-display <?php echo esc_attr($this->args['theme']);?>-mode <?php echo esc_attr($this->args['framework_class']);?>" >
    <form name="nextcode-submit-form" method="post" class="nextcode-submit-admin" data-nonce="<?php echo wp_create_nonce( $this->options_key );?>" data-keys="<?php echo esc_attr($this->options_key);?>">
        <div class="nextcode-content">
            <div class="nextcode-nav-menu">
                <ul class="nav-setting">
                    <li class="logo_area">
                        <?php if( !empty($this->args['framework_logo']) ){?>
                            <img src="<?php _e( esc_url($this->args['framework_logo']));?>" alt=""/>
                        <?php }?> 
                    </li>
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
                <h1> <?php echo esc_html__( $this->args['framework_title'], 'nextcode');?></h1>

                <button type="submit" class="nxbutton submit-button right-submit" name="nextcode-submit"><?php echo esc_html__('Save all changes', 'nextcode');?></button>

                <div class="message-view hide-message"></div>
                
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
                                                $type = $f['type'] ?? '';
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
                                                        $type = $f['type'] ?? '';
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

                <div class="submit-section">
                    <button type="button" class="nxbutton reset-button" data-nonce="<?php echo wp_create_nonce( 'ncode_backup_nonce' );?>" data-unique="<?php echo esc_attr($this->options_key);?>" name="nextcode-reset"><?php echo esc_html__('Reset All Options', 'nextcode');?></button>
                    <button type="submit" class="nxbutton submit-button" name="nextcode-submit"><?php echo esc_html__('Save all changes', 'nextcode');?></button>
                </div> 

            </div>
        </div>
    </form>
</section>
