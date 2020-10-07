<?php if( $background_image ){?>
<div class="ncode-popup-option ncode-background-option" >
    <div class="border-style" style="margin-bottom: 10px;">
        <?php
         $imagevalue['id'] = ($this->args['default']['image']['id']) ?? '';
         $imagevalue['url'] = ($this->args['default']['image']['url']) ?? '';
         $image = array(
            'id'      => $id.'-image',
            'type'    => 'media',
            'title'   => 'Image',
            'default' => $imagevalue,
            'attr' => [
                'name' => "[$id][image]",
            ],
            'repeater' => true,
            'preview' => true
         );
        ?>
        <div class="border-color">
            <label for="<?php _e($id.'-image');?>" class="ncode-dimension-label"><?php _e('Bg Image', 'nextcode');?></label>     
            <?php
            $this->render_filed_data($image, $this->settings, $this->key,  true);
            ?>
             
        </div>
        <button type="button" class="border-color iconbutton">
            <i class="far fa-edit"></i>
        </button>
    </div>
    <div class="border-width-options">
        <div class="npopup-content">
        <?php
            $typeImage = apply_filters( 'ncode_fields_background_image_options', [
                'position' => ['type' => 'select', 'name' => esc_html__( 'Position', 'nextcode' ), 'options' => $this->image_position()],
                'attachment' => ['type' => 'select', 'name' => esc_html__( 'Attachment', 'nextcode' ), 'options' => $this->image_attachment()],
                'repeat' => ['type' => 'select', 'name' => esc_html__( 'Repeat', 'nextcode' ), 'options' => $this->image_repeat()],
                'size' => ['type' => 'select', 'name' => esc_html__( 'Size', 'nextcode' ), 'options' => $this->image_size()],
            ]);
            foreach($typeImage as $k=>$v){
                $options = ($v['options']) ?? [];
                $name = ($v['name']) ?? '';
                $value = ($this->args['default']['image'][$k]) ?? '';
                $posi_i['id'] = $id.'-image-'.$k;
                $posi_i['type'] = ($v['type']) ?? '';
                $posi_i['attr']['name'] = "[$id][image][$k]";
                $posi_i['default'] = $value;
                $posi_i['repeater'] = true;
                $posi_i['options'] = $options;
                ?>
                <div class="border-type ">
                    <label for="<?php _e($id.'-image-'.$k);?>" class="ncode-dimension-label"><?php _e($name, 'nextcode');?></label>
                    <?php
                    $this->render_filed_data($posi_i, $this->settings, $this->key,  true);
                    ?>
                    
                </div>
            <?php }?>
        </div>
    </div>
</div>
<?php }?>

<div class="ncode-popup-option ncode-background-option" >
    
        <div class="border-style">
            <?php
            $colorvalue = ($this->args['default']['color']) ?? '';
            $color = array(
                'id'      => $id.'-color',
                'type'    => 'color',
                'title'   => 'Color',
                'default' => $colorvalue,
                'attr' => [
                    'name' => "[$id][color]"
                ],
                'repeater' => true
            );
            
           
            ?>
            <div class="border-color">
                <label for="<?php _e($id.'-color');?>" class="ncode-dimension-label"><?php _e('Color', 'nextcode');?></label>     
                <?php
                $this->render_filed_data($color, $this->settings, $this->key,  true);
                ?>
                
            </div>
            <?php 
            if( $background_gradient ){
            ?>
            <button type="button" class="border-color iconbutton">
                <i class="far fa-edit"></i>
            </button>
            <?php }?>
        </div>

        <?php  if( $background_gradient ){?>
        <div class="border-width-options">
            <div class="npopup-content">
            <?php
                $valueBg = ($this->args['default']['bgtype']) ?? 'classic';
                $bg['id'] = $id.'-bgtype';
                $bg['type'] = 'choose';
                $bg['attr']['name'] = "[$id][bgtype]";
                $bg['attr']['nxtarget-toggle'] = ".nxtarget-toggle-background";
                $bg['attr']['nxtarget-value'] = "gradient";
                $bg['attr']['nxtarget-condition'] = "==";
                $bg['default'] = $valueBg;
                $bg['repeater'] = true;
                $bg['options']	= [
                    'classic'		 => [
                        'title'	 => esc_html__( 'Classic', 'nextcode' ),
                        'icon'	 => 'fas fa-paint-brush',
                    ],
                    'gradient'	 => [
                        'title'	 =>esc_html__( 'Gradient', 'nextcode' ),
                        'icon'	 => 'fas fa-barcode',
                    ],
                ];
                ?>
                <div class="border-type">
                    <label for="<?php _e($id.'-bgtype');?>" class="ncode-dimension-label"><?php _e('Bacground Type', 'nextcode');?></label>
                    <?php
                    $this->render_filed_data($bg, $this->settings, $this->key,  true);
                    ?>
                    
                </div>
            <?php
            $typeArry = apply_filters( 'ncode_fields_background_options', [
                'location' => ['type' => 'slider', 'title' => esc_html__( 'Location', 'nextcode' )],
                'color2' => ['type' => 'color', 'title' => esc_html__( 'Second Color', 'nextcode' )],
                'location2' => ['type' => 'slider', 'title' => esc_html__( 'Location', 'nextcode' )],
                'angle' => ['type' => 'slider', 'title' => esc_html__( 'Angle', 'nextcode' )],
            ]);
            foreach($typeArry as $k=>$v){
            ?>
            <div class="<?php echo ($k == 'color2') ? 'border-type' : 'border-width';?> nxtarget-toggle-background">
                <label class="ncode-dimension-label"><?php _e(($v['title']) ?? '', 'nextcode');?></label>
                <?php
                $value = ($this->args['default'][$k]) ?? '';
                $array = array(
                    'id'      => $id.'-'.$k,
                    'type'    => ($v['type']) ?? '',
                    'title'   => ($v['title']) ?? '',
                    'default' => $value,
                    'attr' => [
                        'name' => "[$id][$k]"
                    ],
                    'repeater' => true
                );
                $this->render_filed_data($array, $this->settings, $this->key,  true);
                ?>
            </div>
            <?php }?>
                <?php
                $value = ($this->args['default']['type']) ?? '';
                $typarr['id'] = $id.'-type';
                $typarr['type'] = 'select';
                $typarr['attr']['name'] = "[$id][type]";
                $typarr['default'] = $value;
                $typarr['repeater'] = true;
                $typarr['options'] = apply_filters( 'ncode_fields_background_type', [
                    'linear' => esc_html__( 'Linear', 'nextcode' ),
                    'radial' => esc_html__( 'Radial', 'nextcode' ),
                ]);
                ?>
                <div class="border-type nxtarget-toggle-background">
                    <label for="<?php _e($id.'-type');?>" class="ncode-dimension-label"><?php _e('Type', 'nextcode');?></label>
                    <?php
                    $this->render_filed_data($typarr, $this->settings, $this->key,  true);
                    ?>
                    
                </div>
                <?php
                $value = ($this->args['default']['position']) ?? '';
                $posi['id'] = $id.'-position';
                $posi['type'] = 'select';
                $posi['attr']['name'] = "[$id][position]";
                $posi['default'] = $value;
                $posi['repeater'] = true;
                $posi['options'] = $this->image_position();
                ?>
                <div class="border-type nxtarget-toggle-background">
                    <label for="<?php _e($id.'-position');?>" class="ncode-dimension-label"><?php _e('Position', 'nextcode');?></label>
                    <?php
                    $this->render_filed_data($posi, $this->settings, $this->key,  true);
                    ?>
                    
                </div>
            </div>
        </div>
        <?php }?>
     
</div>

<?php if( !empty($desc) ){?>  
    <div class="input-details"> <?php _e($desc, 'nextcode');?> </div>
<?php }?>
       
