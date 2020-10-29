<?php
namespace NextCode\Inc\Fileds;
defined( 'ABSPATH' ) || exit;

use \NextCode\Inc\Setup\Ncode_common as Ncode_common;

Class Ncode_Load extends Ncode_common{
    
    public $params = [];

    public $key = '';

	public function add( $load, $f ) {
        
        switch($load){
            // loas code editor fileds
            case 'codeeditor':
            case 'code-editor':
            case 'code_editor':
                return Code_Editor\Ncode_Code_Editor::instance()->render($f, $this->params, $this->key );
            break;

            case 'text':
                return Text\Ncode_Text::instance()->render($f, $this->params, $this->key );
            break;

            case 'heading':
                return Heading\Ncode_Heading::instance()->render($f, $this->params, $this->key );
            break;

            case 'content':
                return Content\Ncode_Content::instance()->render($f, $this->params, $this->key );
            break;

            case 'select':
                return Select\Ncode_Select::instance()->render($f, $this->params, $this->key );
            break;

            case 'upload':
                return Upload\Ncode_Upload::instance()->render($f, $this->params, $this->key );
            break;

            case 'media':
                return Media\Ncode_Media::instance()->render($f, $this->params, $this->key );
            break;

            case 'gallery':
                return Gallery\Ncode_Gallery::instance()->render($f, $this->params, $this->key );
            break;

            case 'switcher':
                return Switcher\Ncode_Switcher::instance()->render($f, $this->params, $this->key );
            break;

            case 'textarea':
                return Textarea\Ncode_Textarea::instance()->render($f, $this->params, $this->key );
            break;

            case 'repeater':
                return Repeater\Ncode_Repeater::instance()->render($f, $this->params, $this->key );
            break;

            case 'group':
                return Group\Ncode_Group::instance()->render($f, $this->params, $this->key );
            break;

            case 'icon':
                return Icon\Ncode_Icon::instance()->render($f, $this->params, $this->key );
            break;

            case 'imageselect':
            case 'image-select':
            case 'image_select':
                return Image_Select\Ncode_Image_Select::instance()->render($f, $this->params, $this->key );
            break;

            case 'checkbox':
                return Checkbox\Ncode_Checkbox::instance()->render($f, $this->params, $this->key );
            break;

            case 'radio':
                $f['multiple'] = false;
                return Checkbox\Ncode_Checkbox::instance()->render($f, $this->params, $this->key );
            break;

            case 'fieldset':
                return Fieldset\Ncode_Fieldset::instance()->render($f, $this->params, $this->key );
            break;

            case 'order':
            case 'ordering':
            case 'sortable':
                return Sortable\Ncode_Sortable::instance()->render($f, $this->params, $this->key );
            break;

            case 'position':
            case 'lister':
            case 'sorter':
                return Sorter\Ncode_Sorter::instance()->render($f, $this->params, $this->key );
            break;

            case 'range':
            case 'slider':
                return Slider\Ncode_Slider::instance()->render($f, $this->params, $this->key );
            break;

            case 'number':
                return Number\Ncode_Number::instance()->render($f, $this->params, $this->key );
            break;

            case 'spinner':
                return Spinner\Ncode_Spinner::instance()->render($f, $this->params, $this->key );
            break;

            case 'dimensions':
            case 'dimension':
            case 'spacing':
            case 'margin':
            case 'padding':
                return Dimensions\Ncode_Dimensions::instance()->render($f, $this->params, $this->key );
            break;

            case 'choose':
                return Choose\Ncode_Choose::instance()->render($f, $this->params, $this->key );
            break;

            case 'color':
                return Color\Ncode_Color::instance()->render($f, $this->params, $this->key );
            break;

            case 'tab':
            case 'tabbed':
            case 'tabs':
                return Tabs\Ncode_Tabs::instance()->render($f, $this->params, $this->key );
            break;

            case 'date':
            case 'dates':
            case 'time':
                return Date\Ncode_Date::instance()->render($f, $this->params, $this->key );
            break;

            case 'borders':
            case 'border':
            case 'border-radius':
                return Border\Ncode_Border::instance()->render($f, $this->params, $this->key );
            break;

            case 'shadow':
            case 'box-shadow':
            case 'box_shadow':
                return Box_Shadow\Ncode_Box_Shadow::instance()->render($f, $this->params, $this->key );
            break;

            case 'background':
            case 'gradient':
                return Background\Ncode_Background::instance()->render($f, $this->params, $this->key );
            break;
            
            case 'font':
            case 'typography':
                return Typography\Ncode_Typography::instance()->render($f, $this->params, $this->key );
            break;

            case 'accordion':
                return Accordion\Ncode_Accordion::instance()->render($f, $this->params, $this->key );
            break;

            case 'backup':
                return Backup\Ncode_Backup::instance()->render($f, $this->params, $this->key );
            break;

            case 'editor':
            case 'wp-editor':
            case 'wp_editor':
                return Wp_Editor\Ncode_Wp_Editor::instance()->render($f, $this->params, $this->key );
            break;

            case 'link':
                return Link\Ncode_Link::instance()->render($f, $this->params, $this->key );
            break;

        }
	}
}
