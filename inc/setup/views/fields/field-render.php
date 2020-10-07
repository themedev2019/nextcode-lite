<div class="ncode-section <?php if(!empty($pr_field)){ _e('ncode-section-parent');} ?> ncode-<?php _e($type);?> ncode-<?php echo esc_attr($id);?> <?php if( !empty($target_toggle)){ _e('ncopt-depend-hidden');} if($check_value == 'yes'){_e(' ncopt-depend-visible');}?>" <?php if( !empty($target_toggle)){?> data-controller="<?php _e(esc_attr($target_field));?>" data-condition="<?php _e(esc_attr($target_condition));?>" data-value="<?php _e(esc_attr($target_value));?>" <?php }?> > 
                                                
    <?php if( !empty($title) ){?> 
        <div class="ncode-headline">   
            <h4> <?php _e($title, 'nextcode');?> </h4>
        </div>
    <?php }?>

    <div class="ncode-fileds">
        <?php
        \NextCode\Inc\Fileds\Ncode_Render::instance()->_init( $this->argm, $this->setti, $this->ky);
        ?>
    </div>
</div>