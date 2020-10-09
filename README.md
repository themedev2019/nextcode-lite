# NextCode Lite
NextCode s a best Options Framewok for Create Admin Options, Custom Posttype, Metabox, SubMenu, Nav Options, Profiles Options, Widgets, Shortcode, Comment Options, Texonomy Options etc. A Simple and Lightweight WordPress Option Framework for Themes and Plugins. Built in Object Oriented Programming paradigm with high number of custom fields and tons of options. Allows you to bring custom admin, metabox, taxonomy and customize settings to all of your pages, posts and categories. It's highly modern and advanced framework.
# Contents
<ul>
  <li><a href="#demo">Demo</a></li>
  <li><a href="#installation">Installation</a></li>
  <li><a href="#quick-start">Quick Start</a></li>
  <li><a href="#documentation">Documentation</a></li>
  <li><a href="#free-vs-premium">Free vs Premium</a></li>
  <li><a href="#support">Support</a></li>
  <li><a href="#release-notes">Release Notes</a></li>
  <li><a href="#license">License</a></li>
</ul>

# Demo
<p>For usage and examples, have a look at <g-emoji class="g-emoji" alias="rocket" fallback-src="https://github.githubassets.com/images/icons/emoji/unicode/1f680.png">🚀</g-emoji> <a href="http://nextcode.themedev.net/" rel="nofollow">online demo</a></p>

# Quick Start
<p>Open your current theme <strong>functions.php</strong> file and paste this code.</p>
<pre>
// load NextCode Fremwrok
if( did_action('nextcode/loaded') ){
	// load framework
	include_once( NEXTCODE_DIR . 'inc/ncode.php' );

	// your options code here

	NCOPT::create_admin(
		'admin_option', // id must be unque
		[
			'framework_title' => esc_html__('Demo NextCode', 'nextcode'),
			'framework_class' => '', // custom class
			'framework_logo' => '', // logo url here
			
			'options_key' => 'admin_options_key',
			'menu_title' => esc_html__('Demo NextCode', 'nextcode'),
			'menu_slug'  => 'admin_options',
			'menu_type'  => 'menu',
			'menu_capability' => 'manage_options',
			'menu_icon' => null,
			'menu_position' => 32,

			'display_style' => 'left', // left, top
			'theme' => 'white', // white, dark

		]
	);

	
	NCOPT::create_section(
		'admin_option', // admin key
		[
			'id'    => 'general',
			'title'   => esc_html__( 'General', 'text-domain' ),
			'icon'     => 'icon icon-pencil',
			'priority'     => 1,
			'fields' => [
			
				[
					'id'    => 'site_name_heading',
					'type'    => 'heading',
					'content'   => esc_html__( 'General options settings', 'text-domain' ),
					'sub_content'   => esc_html__( 'Set your general theme options and control theme settings.', 'text-domain' ),
				],
		
				[
					'id'    => 'site_name',
					'type'    => 'text',
					'title'   => esc_html__( 'Site title', 'text-domain' ),
					'desc'       => esc_html__( 'Set your websites name. Which you want to set title.', 'text-domain' ),
					'default'    => get_option('blogname'),
					'attr' => [
						'class' => '',
						'placeholder' => 'Site name...',
					],
					'action' => [
						[
							'type' => 'option', // option, post, user, term
							'key' => 'blogname', // option key, post meta key, user meta key, terms key
							'id' => '', // post id, user id, terms id
							'target_value' => [ // set target field
								'section' => 'general', // set section id
								'field' => 'site_name' // set fileds id
							], 
						]
					],
				
				],
				
				[
					'id'    => 'site_details',
					'type'    => 'text',
					'title'   => esc_html__( 'Tagline', 'text-domain' ),
					'desc'       => esc_html__( 'Set your websites Tagline. Which you want to set Tagline.', 'text-domain' ),
					'default'    => get_option('blogdescription'),
					'attr' => [
						'class' => '',
						'placeholder' => 'Site name...',
					],
					'action' => [
						[
							'type' => 'option', // option, post, user, terms
							'key' => 'blogdescription', // option key, post meta key, user meta key, terms key
							'id' => '', // post id, user id, terms id
							'target_value' => [ // set target field
								'section' => 'general', // set section id
								'field' => 'site_details', // set fileds id
							], 
						]
					],
				
				],
			
				[
					'id'    => 'frontpage',
					'type'    => 'select',
					'title'   => esc_html__( 'Frontpage Settings', 'text-domain' ),
					'desc'       => esc_html__( 'Select which page to display on your Frontpage. If left blank the Blog will be displayed.', 'text-domain' ),
					'default'    => get_option('page_on_front'),
					'options' => 'page',
					
				],
				
				[
					'id'    => 'logo_image',
					'type'    => 'upload',
					'title'   => esc_html__( 'Logo', 'text-domain' ),
					'desc'       => esc_html__( 'Upload a logo image, or enter the URL or ID of an image if its already uploaded. The themes default logo gets applied if the input field is left blank.', 'text-domain' ),
					'default'    => get_option('general_main_logo'),
					'preview' => true,
					'action' => [
						[
							'type' => 'option', // option, post, user, terms
							'key' => 'general_main_logo', // option key, post meta key, user meta key, terms key
							'id' => '', // post id, user id, terms id
							'target_value' => [ // set target field
								'section' => 'general', // set section id
								'field' => 'logo_image', // set fileds id
							], 
						]
					],
				],
				[
					'id'    => 'favicon_image',
					'type'    => 'upload',
					'title'   => esc_html__( 'Favicon', 'text-domain' ),
					'desc'       => esc_html__( 'Specify a favicon for your site. Accepted formats: .ico, .png, .gif', 'text-domain' ),
					'default'    => [
						'url' => '',
						'id' => ''
					],
					
					'preview' => true,
					'action' => [
						[
							'type' => 'option', // option, post, user, terms
							'key' => 'site_icon', // option key, post meta key, user meta key, terms key
							'id' => '', // post id, user id, terms id
							'target_value' => [ // set target field
								'section' => 'general', // set section id
								'field' => 'favicon_image_id', // set fileds id
							], 
						]
					],
				],

			]
		]
	);
}
</pre>

# Documentation
<p>For documentation and examples, have a look at <g-emoji class="g-emoji" alias="rocket" fallback-src="https://github.githubassets.com/images/icons/emoji/unicode/1f680.png">🚀</g-emoji> <a href="https://themedev.net/docs-html/next-code.html" rel="nofollow">Docs</a></p>


