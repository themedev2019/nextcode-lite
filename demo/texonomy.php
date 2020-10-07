<?php

// create texnomony 
NCOPT::create_taxonomy(
    'nxsubject', // texonomy id - (must be unique)
    [ 
        'post_type' => ['nextcourse'], // support posttype - supprt multiple custom posttype
        'taxonomy_meta_key' => 'nxsubject_keys',
        'css_render' => 'nextland-custom', // css render - handle name

        // texonomy data
        'hierarchical' => true,
        'labels' => [
            'name' => 'Subjects',
            'singular_name' => 'Subjects',
            'search_items' =>  'Search Subjects',
            'all_items' => 'All Subjects',
            'parent_item' => 'Parent Subjects',
            'parent_item_colon' => 'Parent Subjects:',
            'edit_item' => 'Edit Subjects',
            'update_item' => 'Update Subjects',
            'add_new_item' => 'Add New Subjects',
            'new_item_name' => 'New Subjects',
            'menu_name' => 'Subjects',
        ],
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => [ 'slug' => 'nx-subjects' ],
        
    ]
);
NCOPT::create_taxonomy(
    'nxcollege', // texonomy id - (must be unique)
    [ 
        'post_type' => ['nextcourse'], // support posttype - supprt multiple custom posttype
        'taxonomy_meta_key' => 'nxcollege_keys',
        'css_render' => 'nextland-custom', // css render - handle name

        // texonomy data
        'hierarchical' => true,
        'labels' => [
            'name' => 'Colleges',
            'singular_name' => 'Colleges',
            'search_items' =>  'Search Colleges',
            'all_items' => 'All Colleges',
            'parent_item' => 'Parent Colleges',
            'parent_item_colon' => 'Parent Colleges:',
            'edit_item' => 'Edit Colleges',
            'update_item' => 'Update Colleges',
            'add_new_item' => 'Add New Colleges',
            'new_item_name' => 'New Colleges',
            'menu_name' => 'Colleges',
        ],
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => [ 'slug' => 'nx-colleges' ],
        
    ]
);

NCOPT::create_section(
    'nxcollege',
    [
        'id'    => 'general_college',
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

NCOPT::create_section(
    'nxcollege',
    [
        'id'    => 'contact_college',
        'title'   => esc_html__( 'Contacts', 'nextland' ),
        'icon'     => 'icon icon-pencil',
        'priority'     => 1,
        'fields' => [
           
            [
                'id'    => 'college_phone',
                'type'    => 'text',
                'title'   => esc_html__( 'Telephone', 'nextland' ),
                'desc'       => esc_html__( 'Set College Telephone. Example: +6000000', 'nextland' ),
                'default'    => '',
                'attr' => [
                    'placeholder' => '+6000000',
                ],
            ],

            [
                'id'    => 'college_website',
                'type'    => 'link',
                'title'   => esc_html__( 'Website', 'nextland' ),
                'desc'       => esc_html__( 'Set College Website. Example: https//:www.example.gov.uk', 'nextland' ),
                'default'    => '',
                'attr' => [
                    'placeholder' => 'Enter website link',
                ],
            ],
           
            [
                'id'    => 'college_address',
                'type'    => 'textarea',
                'title'   => esc_html__( 'Address', 'nextland' ),
                'desc'       => esc_html__( 'Set College Address. Example: 36-37, Bedford Square, London, WC1B 3ES', 'nextland' ),
                'default'    => '',
                'attr' => [
                    'placeholder' => 'Enter address',
                ],
            ],
        ]
    ]
);