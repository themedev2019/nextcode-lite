
<div class="ncode-popup-option ncode-border-option">
     <div class="border-style">
         <?php
         $value = ($this->args['default']['style']) ?? '';
         $select['id'] = $id.'-style';
         $select['type'] = 'select';
         $select['attr']['name'] = "[$id][style]";
         $select['attr']['nxtarget-toggle'] = ".nxtarget-toggle-border";
         $select['attr']['nxtarget-value'] = "none";
         $select['attr']['nxtarget-condition'] = "!=";
         $select['default'] = $value;
         $select['repeater'] = true;
         $select['options'] = apply_filters( 'ncode_fields_border_style', [
             'none' => esc_html__( 'None', 'nextcode' ),
             'solid' => esc_html__( 'Solid', 'nextcode' ),
             'double' => esc_html__( 'Double', 'nextcode' ),
             'dotted' => esc_html__( 'Dotted', 'nextcode' ),
             'dashed' => esc_html__( 'Dashed', 'nextcode' ),
             'groove' => esc_html__( 'Groove', 'nextcode' ),
         ]);
         ?>
         <div class="border-type">
            <label for="<?php _e($id.'-style');?>" class="ncode-dimension-label"><?php _e('Style', 'nextcode');?></label>
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
                'name' => "[$id][color]"
            ],
            'repeater' => true
         );
        ?>
        <div class="border-color nxtarget-toggle-border">
            <label for="<?php _e($id.'-color');?>" class="ncode-dimension-label"><?php _e('Color', 'nextcode');?></label>     
            
            <?php
            $this->render_filed_data($color, $this->settings, $this->key,  true);
            ?> 
        </div>
        <button type="button" class="border-color iconbutton nxtarget-toggle-border">
            <i class="far fa-edit"></i>
        </button>
    </div>
    <div class="border-width-options">
         <div class="npopup-content">
            <div class="border-width nxtarget-toggle-border">
                <label class="ncode-dimension-label"><?php _e('Width', 'nextcode');?></label>
                <?php
                $this->render_filed_data($this->args, $this->settings, $this->key,  true);
                ?>
            </div>
            <?php if($radius_options){?>
            <div class="border-width radius nxtarget-toggle-border">
                <label class="ncode-dimension-label"><?php _e('Radius [<small>PX</small>]', 'nextcode');?></label>
                <?php
                $this->args['dimensions'] = apply_filters( 'ncode_fields_border_radius_dimensions', array(
                    'radius_top'       => 'TOP',
                    'radius_right'     => 'RIGHT',
                    'radius_bottom'    => 'BOTTOM',
                    'radius_left'      => 'LEFT',
                ));
                $this->args['allowed_dimensions'] = 'all';
                $this->args['size_units'] = '';
                $this->render_filed_data($this->args, $this->settings, $this->key,  true);
                ?>
            </div>
            <?php }?>
        </div>
    </div>
     
</div>

<?php if( !empty($desc) ){?>  
    <div class="input-details"> <?php _e($desc, 'nextcode');?> </div>
<?php }?>
       
