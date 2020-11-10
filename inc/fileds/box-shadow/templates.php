<?php
 $name = "[$id]";
 if($repeater){
    $name = ($this->args['attr']['name']) ?? '';
 }
?>
<div class="ncode-popup-option ncode-shadow-option" >
     <div class="border-style">
         <?php
         $typeValue = ($this->args['default']['type']) ?? '';
         $select['id'] = $id.'-type';
         $select['type'] = 'select';
         $select['attr']['name'] = $name."[type]";
         $select['attr']['nxtarget-toggle'] = ".nxtarget-toggle-boxshadow__".$id;
         $select['attr']['nxtarget-value'] = "no-shadow";
         $select['attr']['nxtarget-condition'] = "!=";
         $select['default'] = $typeValue;
         $select['repeater'] = true;
         $select['options'] = apply_filters( 'ncode_fields_shadow_type', [
             'default' => esc_html__( 'Default', 'nextcode' ),
             'no-shadow' => esc_html__( 'None', 'nextcode' ),
             'outline' => esc_html__( 'Outline', 'nextcode' ),
             'inset' => esc_html__( 'Inset', 'nextcode' ),
         ]);
         ?>
         <div class="border-type">
            <label for="<?php _e($id.'-type');?>" class="ncode-dimension-label"><?php _e('Type', 'nextcode');?></label>
            <?php
            $this->render_filed_data($select, $this->settings, $this->key,  true);
            ?>
            
        </div>
        <?php
         $colorvalue = ($this->args['default']['color']) ?? '';
         $color = array(
            'id'      => $id.'-color',
            'type'    => 'color',
            'title'   => 'Color',
            'default' => $colorvalue,
            'attr' => [
                'name' => $name."[color]"
            ],
            'repeater' => true
         );
        ?>
        <div class="border-color nxtarget-toggle-boxshadow__<?php echo esc_attr($id);?>">
            <label for="<?php _e($id.'-color');?>" class="ncode-dimension-label"><?php _e('Color', 'nextcode');?></label>     
            <?php
            $this->render_filed_data($color, $this->settings, $this->key,  true);
            ?>
             
        </div>
        <button type="button" class="border-color iconbutton nxtarget-toggle-boxshadow__<?php echo esc_attr($id);?>">
            <i class="far fa-edit"></i>
        </button>
    </div>
    <div class="border-width-options ">
        <div class="npopup-content">
            <?php
            $typeArry = apply_filters( 'ncode_fields_shadow_options', [
                'horizontal' => esc_html__( 'Horizontal', 'nextcode' ),
                'vertical' => esc_html__( 'Vertical', 'nextcode' ),
                'blur' => esc_html__( 'Blur', 'nextcode' ),
                'spread' => esc_html__( 'Spread', 'nextcode' ),
            ]);
            foreach($typeArry as $k=>$v){
            ?>
            <div class="border-width nxtarget-toggle-boxshadow__<?php echo esc_attr($id);?>">
                <label class="ncode-dimension-label"><?php _e($v, 'nextcode');?></label>
                <?php
                $value = ($this->args['default'][$k]) ?? '';
                $array = array(
                'id'      => $id.'-'.$k,
                'type'    => 'slider',
                'title'   => $v,
                'default' => $value,
                'attr' => [
                    'name' => $name."[$k]"
                ],
                'repeater' => true
                );
                $this->render_filed_data($array, $this->settings, $this->key,  true);
                ?>
            </div>
            <?php }?>
        
        </div>
    </div>
     
</div>

<?php if( !empty($desc) ){?>  
    <div class="input-details"> <?php _e($desc, 'nextcode');?> </div>
<?php }?>
       
