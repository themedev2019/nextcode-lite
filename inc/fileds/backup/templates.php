<div class="ncode-backup-options">
    <div class="backup-options">
        <h4> <?php _e('Data Import: ', 'nextcode');?> </h4>
        <textarea name="ncode_import_data" class="ncode-import-data" placeholder="Paste json data"></textarea>
        <button type="type" class="button button-primary ncode-import" data-unique="<?php echo esc_attr( $unique );?>" data-nonce="<?php echo esc_attr( $nonce ) ?>"><?php echo esc_html__( 'Import', 'ncode' ) ?></button>
        <div class="input-details"> <?php _e('Copy data from json files & Paste here. After that click import button.', 'nextcode');?> </div>
        </br>
    </div>
    <div class="backup-options">
        <h4> <?php _e('Data Export: ', 'nextcode');?> </h4>
        <textarea readonly="readonly" class="ncode-export-data"><?php echo esc_attr( json_encode( get_option( $unique ) ) );?></textarea>
        <a href="<?php echo esc_url( $export ); ?>" class="button button-primary ncode-export" target="_blank"><?php echo esc_html__( 'Export and Download Backup', 'nextcode' ) ?></a>
     </br>
    </div>
    <div class="backup-options">
        <h4> <?php _e('Data Reset: ', 'nextcode');?> </h4>
        <button type="type" class="button ncode-warning-primary ncode-reset" value="reset" data-unique="<?php echo esc_attr( $unique );?>" data-nonce="<?php echo esc_attr( $nonce ) ?>"><?php echo esc_html__( 'Reset All Options', 'ncode' ) ?></button>
        <div class="input-details"> <?php _e('Pleae make sure are you want to reset all options data.', 'nextcode');?> </div>
    </div>
    <div class="backup-options">
        <h4> <?php _e('Restore Data Download: ', 'nextcode');?> </h4>
        <div class="input-details"> <?php _e('You can download you previous data.', 'nextcode');?> </div>
        <ul class="back-restore">
            <?php
            if( !empty($reset) ){
                $reset = array_reverse($reset);
                $m = 0;
                foreach( $reset as $r){
                    if($m > 13){
                       continue; 
                    }
                    $exportRe = add_query_arg( array( 'action' => 'ncode-restore', 'unique' => $unique, 'time' => $r, 'nonce' => $nonce ), admin_url( 'admin-ajax.php' ) );
                    echo '<li> <a href="'. esc_url($exportRe).'">'. gmdate("d M, Y H:i:s", $r) .'</a> </li>';
                $m++;
                }
            }?>
        </ul>
    </div>
</div>

       
