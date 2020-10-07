<?php 
    wp_editor($default, $id, $editor_settings);
?>

<?php if( !empty($desc) ){?>  
    <div class="input-details"> <?php _e($desc, 'nextcode');?> </div>
<?php }?>
       
