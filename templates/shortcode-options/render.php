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
        
        <div class="nextcode-content-area">
            <div class="settings-content">
                <div id="<?php echo esc_attr($this->shortcode);?>" class="ncode-tabs-<?php echo esc_attr($this->shortcode);?> active">
                    <?php 
                    $fields = $this->args['fields'];
                    
                    if( !empty($fields) ){
                        
                        foreach($fields as $f){
                            $f_type = isset($f['type']) ? $f['type'] : '';
                            if( empty($f_type) || in_array($f_type, ['icon', 'icons']) ){
                                continue;
                            }

                            $id = $f['id'] ?? '';
                            $type = $f['type'] ?? '';

                            $default = isset($settings[$id]) ? $settings[$id] : '';
                            if( !empty($default) ){
                                $f['default'] = $default;
                            }

                            $f['repeater'] = true;
                            
                            $f['attr']['name'] = "[$id]";
                            $f['attr']['id'] = $id;

                            if(in_array( $type, ['group', 'repeater']) ){
                                $f['nasted_parent'] = $id;
                                $f['group_name'] = "[$id]";
                                $f['group_data'] = "[$id]";
                                $f['nasted'] = true;
                            }

                            
                           $this->render_data($f, $this->args, $this->shortcode, false);

                        }
                    }
                    ?>
                </div>
                   
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