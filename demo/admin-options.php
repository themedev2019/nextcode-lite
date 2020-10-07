<?php
// admin options
NCOPT::create_option(
    'demo',
    [
        'framework_title' => esc_html__('Demo NextCode', 'nextcode'),
        'framework_class' => '',
        'options_key' => 'demo_key',
        'menu_title' => esc_html__('Demo NextCode', 'nextcode'),
        'menu_slug'  => 'demo',
        'menu_type'  => 'menu',
        'menu_capability' => 'manage_options',
        'menu_icon' => null,
        'menu_position' => 32,

        'display_style' => 'top',
        'theme' => 'white',

    ]
);


NCOPT::create_section(
    'demo',
    [
        'id'    => 'test_section',
        'title'   => esc_html__( 'Test', 'nextcode' ),
        'icon'     => 'icon icon-picture',
        'priority'     => 7,
        'fields' => [
            [
                'id'    => 'follow_data1',
                'type'    => 'group',
                'title'   => esc_html__( 'Follow Data', 'nextcode' ),
                'fields' => [
                   
                    [
                        'id' => 'linkgroup',
                        'type'  => 'text',
                        'title' => 'Link',
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
                            [
                                'id' => 'icons',
                                'type'  => 'icon',
                                'title' => 'Icons',
                            ],
                           
                        ],
                        'title_field' => 'relink',
                    ],
                ],
                'title_field' => 'linkgroup',
                'default'    => [
                    [
                        'linkgroup' => 'https://www.facebook.com',
                    ],
                    [
                        'linkgroup' => 'https://www.twitter.com',
                    ]
                ],
                
            ],
            array(
                'id'     => 'opt-fieldset-1',
                'type'   => 'fieldset',
                'title'  => 'Fieldset',
                'fields' => array(
                    array(
                        'id'    => 'opt-text',
                        'type'  => 'text',
                        'title' => 'Text',
                    ),
                    array(
                        'id'    => 'opt-color',
                        'type'  => 'textarea',
                        'title' => 'Details',
                    ),
                    array(
                        'id'    => 'opt-switcher',
                        'type'  => 'switcher',
                        'title' => 'Switcher',
                    ),
                ),
            ),
            array(
                'id'        => 'opt-sportable-1',
                'type'      => 'sortable',
                'title'     => 'Sortable',
                'fields'    => array(
  
                  array(
                    'id'    => 'text-1',
                    'type'  => 'text',
                    'title' => 'Text 1'
                  ),
  
                  array(
                    'id'    => 'text-2',
                    'type'  => 'text',
                    'title' => 'Text 2'
                  ),
  
                ),
            ),
            array(
                'id'             => 'opt-sorter-2',
                'type'           => 'sorter',
                'title'          => 'Sorter',
                'default'        => array(
                  'enabled'      => array(
                    'option-1'   => 'Option 1',
                    'option-2'   => 'Option 2',
                    'option-3'   => 'Option 3',
                  ),
                  'disabled'     => array(
                    'option-4'   => 'Option 4',
                    'option-5'   => 'Option 5',
                  ),
                ),
                'enabled_title'  => 'Activated',
                'disabled_title' => 'Deativated',
            ),

            array(
                'id'           => 'opt-select-2',
                'type'         => 'select',
                'title'        => 'Select',
                'placeholder'  => 'Select an option',
                'multiple' => true,
                'chosen' => true,
                'ajax' => false,
                'options'      => array(
                  'Group 1'    => array(
                    'option-1' => 'Option 1',
                    'option-2' => 'Option 2',
                    'option-3' => 'Option 3',
                  ),
                  'Group 2'    => array(
                    'option-4' => 'Option 4',
                    'option-5' => 'Option 5',
                    'option-6' => 'Option 6',
                  ),
                ),
                'default'      => array( 'option-2', 'option-5' ),
                'query_args' => [],
                'query_value' => ''
            ),
            
            array(
                'id'      => 'opt-slider-3',
                'type'    => 'slider',
                'title'   => 'Slider',
                'min'     => 50,
                'max'     => 500,
                'step'    => 5,
                'unit'    => '%',
                'default' => 25,
            ),
            array(
                'id'      => 'opt-slider-4',
                'type'    => 'number',
                'title'   => 'Number',
                'min'     => 50,
                'max'     => 500,
                'step'    => 5,
                'unit'    => 'px',
                'default' => 25,
            ),

            array(
                'id'      => 'opt-spinner-3',
                'type'    => 'spinner',
                'title'   => 'Spinner',
                'min'     => 0,
                'max'     => 100,
                'step'    => 10,
                'unit'    => 'px',
                'default' => 25,
            ),
           
            array(
                'id'          => 'opt-spacing-4',
                'type'        => 'dimensions',
                'title'       => 'Spacing - dimensions',
                'output' => [
                    'selector' => '.menubar .bar-style',
                    'render' => 'margin',
                    'selectors' => [ //set css out selectors for multiple
                        '.menubar .bar-style' => 'margin'
                    ],
                ],
                'default'     => array(
                    'top'       => '10',
                    'right'     => '20',
                    'bottom'    => '10',
                    'left'      => '20',
                    'unit'      => '%',
                ),
                'size_units' => [ 'px', '%', 'em' ],
                'dimensions'     => array(
                  'top'       => 'TOP',
                  'right'     => 'RIGHT',
                  'bottom'    => 'BOTTOM',
                  'left'      => 'LEFT',
                ),
                'allowed_dimensions' => ['top','bottom']
            ),
            array(
                'id'      => 'opt-choose-0',
                'type'    => 'choose',
                'title'   => 'Choose',
                'options'		 => [
					'left'		 => [
						'title'	 =>esc_html__( 'Left', 'nextcode' ),
						'icon'	 => 'fa fa-align-left',
					],
					'center'	 => [
						'title'	 =>esc_html__( 'Center', 'nextcode' ),
						'icon'	 => 'fa fa-align-center',
					],
					'right'		 => [
						'title'	 =>esc_html__( 'Right', 'nextcode' ),
						'icon'	 => 'fa fa-align-right',
					],
					'justify'	 => [
						'title'	 =>esc_html__( 'Justified', 'nextcode' ),
						'icon'	 => 'fa fa-align-justify',
					],
				],
				'default'		 => 'center',
                
            ),
            array(
                'id'      => 'opt-color-0',
                'type'    => 'color',
                'title'   => 'Color',
                'default' => '#ffbc00'
            ),

            array(
                'id'            => 'opt-tabbed-2',
                'type'          => 'tabs',
                'title'         => 'Tabbed',
                'tabs'          => array(
                  array(
                    'title'     => 'Tab 1',
                    'icon'      => 'fa fa-heart',
                    'fields'    => array(
                        array(
                            'id'    => 'opt-text-1',
                            'type'  => 'text',
                            'title' => 'Text 1',
                        ),
                        array(
                            'id'    => 'opt-text-2',
                            'type'  => 'text',
                            'title' => 'Text 2',
                        ),
                    )
                  ),
                  array(
                    'title'     => 'Tab 2',
                    'icon'      => 'fa fa-star',
                    'fields'    => array(
                        array(
                            'id'    => 'opt-color-1',
                            'type'  => 'color',
                            'title' => 'Color 1',
                        ),
                        array(
                            'id'    => 'opt-color-2',
                            'type'  => 'color',
                            'title' => 'Color 2',
                        ),
                    )
                  ),
                ),

                'default'       => array(
                  'opt-text-1'  => 'This is text 1 value',
                  'opt-text-2'  => 'This is text 2 value',
                  'opt-color-1' => '#555',
                  'opt-color-2' => '#999',
                )
            ),
           
            array(
                'id'       => 'opt-date-3',
                'type'     => 'date',
                'title'    => 'Date 2',
                'date_format' => 'Y-m-d',
                //'alt_format' => 'D-M-Y',
                 //'enable_time' => true,
                 //'no_calendar' => false,
                 //'default' => '2016-10-10',
                //'min_date' => '2016-10-10', // "today"
                //'min_time' => '2016-10-10', // "today", new Date().fp_incr(14)
                //'mode' => 'multiple', // multiple, range
            ),
            array(
                'id'          => 'opt-border-4',
                'type'        => 'border',
                'title'       => 'Border',
                'output' => [
                    'selector' => '.menubar .bar-style',
                    'render' => 'margin',
                    'selectors' => [ //set css out selectors for multiple
                        '.menubar .bar-style' => 'margin'
                    ],
                ],
                'default'     => array(
                    'top'       => '10',
                    'right'     => '20',
                    'bottom'    => '10',
                    'left'      => '20',
                    'unit'      => '%',
                ),
                'size_units' => [ 'px', '%', 'em' ],
                'dimensions'     => array(
                  'top'       => 'TOP',
                  'right'     => 'RIGHT',
                  'bottom'    => 'BOTTOM',
                  'left'      => 'LEFT',
                ),
                'allowed_dimensions' => ['top','bottom'],
                'radius_options' => true
            ),
            array(
                'id'       => 'opt-shadow-3',
                'type'     => 'shadow',
                'title'    => 'Shadow 2',
                'default' => [
                    'color' => '',
                    'horizontal' => '',
                    'vertical' => '',
                    'blur' => '10',
                    'spread' => '',
                    'type' => 'no-shadow',
                ],
                'output' => [
                    'selector' => '.menubar .bar-style',
                    
                ],
                
            ),
            array(
                'id'       => 'opt-back-3',
                'type'     => 'background',
                'title'    => 'Background',
                'default' => [
                    'color' => '',
                    'location' => '0',
                    'color2' => '',
                    'location2' => '',
                    'angle' => '0',
                    'type' => 'linear',
                    'position' => '',
                    'image' => '',
                ],
                'output' => [
                    'selector' => '.menubar .bar-style',
                    
                ],
                
            ),

            array(
                'id'      => 'opt-typography-2',
                'type'    => 'typography',
                'title'   => 'Typography',
                'default' => array(
                    'font-family' => '',
                    'color' => '',
                    'font-size' => '',
                    'font-weight' => '',
                    'text-transform' => '',
                    'font-style' => '',
                    'text-decoration' => '',
                    'line-height' => '',
                    'letter-spacing' => '',
                    'word-spacing' => '',
                    'text-align' => '',
                    'text-index' => '',
                    'font-variant' => '',
                ),
            ),
            array(
                'id'           => 'opt-upload-2',
                'type'         => 'upload',
                'title'        => 'Upload',
                'placeholder'  => 'http://',
                'button_title' => 'Add Image',
                'remove_title' => 'Remove Image',
              ),
            array(
                'id'           => 'opt-medai-2',
                'type'         => 'media',
                'title'        => 'Media',
                'placeholder'  => 'http://',
                'button_icon' => 'fas fa-cloud-upload-alt',
                'remove_icon' => 'fas fa-trash-restore',
                'preview' => false,
                'default' => [
                    'url' => '',
                    'id' => ''
                ]
            ),
            
            array(
                'id'          => 'opt-gallery-3',
                'type'        => 'gallery',
                'title'       => 'Gallery',
                'add_title'   => 'Add',
                'edit_title'  => 'Edit',
                'clear_title' => 'Remove',
            ),
            array(
                'id'            => 'opt-accordion-2',
                'type'          => 'accordion',
                'title'         => 'Accordion',
                'accordions'          => array(
                  array(
                    'title'     => 'Tab 1',
                    'fields'    => array(
                        array(
                            'id'    => 'opt-text-1',
                            'type'  => 'text',
                            'title' => 'Text 1',
                        ),
                        array(
                            'id'    => 'opt-text-2',
                            'type'  => 'text',
                            'title' => 'Text 2',
                        ),
                    )
                  ),
                  array(
                    'title'     => 'Tab 2',
                    'fields'    => array(
                        array(
                            'id'    => 'opt-color-1',
                            'type'  => 'color',
                            'title' => 'Color 1',
                        ),
                        array(
                            'id'    => 'opt-color-2',
                            'type'  => 'color',
                            'title' => 'Color 2',
                        ),
                    )
                  ),
                ),

                'default'       => array(
                  'opt-text-1'  => 'This is text 1 value',
                  'opt-text-2'  => 'This is text 2 value',
                  'opt-color-1' => '#555',
                  'opt-color-2' => '#999',
                )
            ),
        ]
    ]
);



NCOPT::create_section(
    'demo',
    [
        'parent'    => 'test_section',
        'id'    => 'header_style',
        'title'   => esc_html__( 'Header Style', 'nextcode' ),
        'icon'     => 'icon icon-home',
        'priority' => 2,
        'fields' => [

        ]
    ]
);


// filed

NCOPT::create_field(
    'demo',
    [
        'parent_section'   => 'test',
        'id'    => 'dynaimc_fields',
        'type'    => 'text',
        'title'   => esc_html__( 'Dynamic Fields', 'nextcode' ),
        'desc'       => esc_html__( 'Set the Button text.', 'nextcode' ),
        'default'    => esc_html__( 'This is Title', 'nextcode' ),
    ]
);


NCOPT::create_section(
    'demo',
    [
        'id'    => 'custum_css2',
        'title'   => esc_html__( 'Custom Css', 'nextcode' ),
        'icon'     => 'icon icon-screen',
        'priority'     => 8,
        'fields' => [
            [
                'id'    => 'customcss_heading',
                'type'    => 'heading',
                'content'   => esc_html__( 'Custom settings', 'nextcode' ),
               
            ],
            [
                'id'    => 'custom_css_code',
                'type'    => 'code-editor',
                'title'   => esc_html__( 'Custom Css', 'nextcode' ),
                'desc'       => esc_html__( 'Write custom css here with css selector. this css will be applied in all pages and post', 'nextcode' ),
                'settings' => array(
                    'mode'        => 'css',
                    'theme'       => 'dracula',
                    'tabSize'     => 4,
                    'smartIndent' => true,
                    'autocorrect' => true,
                ),
            ],
            array(
                'id'            => 'opt-wp-editor-2',
                'type'          => 'wp_editor',
                'title'         => 'WP Editor with Custom Settings',
                'tinymce'       => true,
                'quicktags'     => true,
                'media_buttons' => true,
            ),

            
        ]
    ]
);



