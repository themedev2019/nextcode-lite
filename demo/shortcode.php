<?php
NCOPT::create_shortcode( 
	'ncode_shortcode_1', 
	[
		'title'       => 'Next Shortcode',
		'classname'   => '',
		'description' => 'A description for widget example 1',
		//'callback' => 'ncode_shortcode_example_callback', // callback function 
		'fields' => [

			[
				'id'    => 'menu_icon',
				'type'    => 'icon',
				'title'   => esc_html__( 'Icons', 'text-domain' ),
				'default'    => '',
			
			],

			[
				'id'    => 'menu_text',
				'type'    => 'text',
				'title'   => esc_html__( 'Name', 'text-domain' ),
				'desc'       => esc_html__( 'Set your Location. Example: Bedford Square', 'text-domain' ),
				'default'    => '',
			
			],
			[
				'id' => 'reitem',
				'type'  => 'repeater',
				'title' => 'Group',
				'content' => 'Group',
				'fields' => [
					[
						'id' => 'relink',
						'type'  => 'text',
						'title' => 'Link 2',
					],
				
				],
				'title_field' => 'relink',
			],

		],
		'params' => [ 'class' => 'custom-class', 'button-id' => ''],
		'form' => [ 'action' => '', 'id' => 'course-search', 'method' => 'POST'],
		'submit' => [ 'name' => 'submit-application', 'type' => 'button', 'value' => 'Apply Now'],
	]
);

/*
// group
NCOPT::create_shortcode( 
	'ncode_shortcode_1', 
	[
		'title'       => 'Next Shortcode',
		'classname'   => '',
		'description' => 'A description for widget example 1',
		//'callback' => 'ncode_shortcode_example_callback', // callback function 

		'params' => [ 'class' => 'custom-class', 'button-id' => ''],
		'form' => [ 'action' => '', 'id' => 'course-search'],
		'submit' => [ 'name' => 'submit-application', 'type' => 'submit', 'value' => 'Apply Now'],
	]
);

NCOPT::create_section(
    'ncode_shortcode_1',
    [
        'id'    => 'general_college1',
        'title'   => esc_html__( 'General', 'nextland' ),
        'icon'     => 'icon icon-pencil',
        'priority'     => 1,
        'fields' => [
           
            [
                'id'    => 'college_id',
                'type'    => 'text',
                'title'   => esc_html__( 'ID', 'nextland' ),
                'desc'       => esc_html__( 'Set College ID. Example: 10002020', 'nextland' ),
                'default'    => '',
                'attr' => [
                    'placeholder' => '10002020',
                ],
            ],

            [
                'id'    => 'college_unions',
                'type'    => 'link',
                'title'   => esc_html__( 'Student Unions', 'nextland' ),
                'default'    => '',
                'desc'       => esc_html__( 'Set Student Unions Website. Example: https//:www.example.gov.uk', 'nextland' ),
                
                'attr' => [
                    'placeholder' => 'http://www.example.org.uk/',
                ],
            ],

        ]
    ]
);
*/