
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
        <button type="button" class="border-color iconbutton">
            <i class="far fa-edit"></i>
        </button>
    </div>
    <div class="border-width-options">  
        <div class="npopup-content">
            <?php
            foreach($this->options() as $k=>$v){
                $type = ($v['type']) ?? 'slider';
                
                $type = ($type == 'select2') ? 'select' : $type;
            ?>
            <div class="<?php echo ( !in_array($type, ['slider', 'dimensions']) ) ? 'border-type' : 'border-width';?>">
                <label class="ncode-dimension-label"><?php echo esc_html__( ($v['title']) ?? '', 'nextcode');?></label>
                <?php
                $value = ($this->args['default'][$k]) ?? '';
                $array = [
                'id'      => $id.'-'.$k,
                'type'    => $type,
                'title'   => ($v['title']) ?? '',
                'default' => $value,
                'attr' => [
                    'name' => "[$id][$k]"
                ],
                'repeater' => true
                ];
                if( isset($v['options']) ){
                    $array['options'] = $v['options'];
                }
                if( $v['type'] == 'select2' ){
                    $array['chosen'] = true;
                }

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
       
