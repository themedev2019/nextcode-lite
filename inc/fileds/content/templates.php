<div class="heading-label ncode-contentdiv <?php _e(esc_attr($style));?>">
    <?php if( !empty($content) ){?>    
    <p> <?php _e($content, 'nextcode');?> </p>
    <?php }?>
    <?php if( !empty($sub_content) ){?>    
    <span> 
        <?php if($callback_type == 'code'){
            ?>
<pre v-pre data-lang="php"><code class="language-php">
<?php
_e($sub_content);
?>
</code></pre>
            <?php
        }else{
            _e($sub_content, 'nextcode');
        }
        ?>
    </span>
    <?php }?>
</div>