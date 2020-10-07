<?php 
    $attribute = '';
    foreach( $attr as $k=>$v){
        if( empty($k) ){
            continue;
        }
        if( $k == 'name'){
            
            if( $repeater ){
                $v = $array_dec.$v.'[url]';
            } else{
                $v = $array_dec.'['.$v.'][url]';
            }
        }
        $attribute .= $k.'="'.$v.'" ';
    }
    
?>

<div class="ncode-popup-option ncode-link-option">
    <div class="border-style">
        <input <?php _e($attribute);?> />
        <button type="button" class="border-color iconbutton">
            <i class="far fa-edit"></i>
        </button>
    </div>
    <div class="border-width-options ">
        <div class="npopup-content">
            <div class="border-width">
                <?php
                $new = ($this->args['default']['new-window']) ?? '';
                $window = array(
                    'id'      => $id.'-window',
                    'type'    => 'checkbox',
                    'title'   => 'Open in new window',
                    'default' => $new,
                    'attr' => [
                        'name' => "[$id][new-window]"
                    ],
                    'repeater' => true,
                    'multiple' => false,
                    'options' => [
                        'yes' => 'Open in new window'
                    ]
                );
                
                $this->render_filed_data($window, $this->settings, $this->key,  true);
                ?> 
            </div>
            <div class="border-width">
                <?php
                $follow = ($this->args['default']['no-follow']) ?? '';
                $followarr = array(
                    'id'      => $id.'-follow',
                    'type'    => 'checkbox',
                    'title'   => 'Add nofollow',
                    'default' => $follow,
                    'attr' => [
                        'name' => "[$id][no-follow]"
                    ],
                    'repeater' => true,
                    'multiple' => false,
                    'options' => [
                        'yes' => 'Add nofollow'
                    ]
                );
                
                $this->render_filed_data($followarr, $this->settings, $this->key,  true);
                ?> 
            </div>
        </div>
    </div>
</div>
<?php if( !empty($desc) ){?>  
    <div class="input-details"> <?php _e($desc, 'nextcode');?> </div>
<?php }?>
       
