
<?php 
    $attribute = '';
    foreach( $attr as $k=>$v){
        if( empty($k) ){
            continue;
        }
        if( $k == 'name'){  
            if( $repeater ){
                $v = $array_dec.$v;
            } else{
                $v = $array_dec.'['.$v.']';
            }
        }
        $attribute .= $k.'="'.$v.'" ';
    }
   
?>
<div class="ncode-gallery-options" data-id="ncode-gallery-<?php _e( esc_attr($id));?>">
    <input <?php _e($attribute);?> />
    <button data-id="<?php _e( esc_attr($id));?>" data-title="<?php _e( esc_attr($title));?>" class="nxsubmit-box ncode-button"  type="button"> <?php _e($add_title);?></button>
    <button data-id="<?php _e( esc_attr($id));?>" class="nxsubmit-box ncode-edit-gallery nxedit-button <?php echo (empty($attr['value'])) ? 'hidden-removebutton' : '';?>"  type="button"> <?php _e($edit_title);?></button>
    <button data-id="<?php _e( esc_attr($id));?>" class="nxsubmit-box ncode-clear-gallery nxremove-button <?php echo (empty($attr['value'])) ? 'hidden-removebutton' : '';?>"  type="button"> <?php _e($clear_title);?></button>
    <?php if( $preview ){?>
        <ul>
            <?php
            if ( ! empty( $attr['value'] ) ) {
                $values = explode( ',', $attr['value'] );
                foreach ( $values as $id ) {
                  $attachment = wp_get_attachment_image_src( $id, 'thumbnail' );
                  if( isset($attachment[0]) ){
                    echo '<li><img src="'. esc_url( $attachment[0] ) .'" /></li>';
                  }
                }
              }
            ?>
        </ul>
    <?php }?>
</div>
<?php if( !empty($desc) ){?>  
    <div class="input-details"> <?php _e($desc, 'nextcode');?> </div>
<?php }?>


       
