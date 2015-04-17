<?php

add_action( 'after_setup_theme', 'my_setup' );

if ( ! function_exists( 'my_setup' ) ):

function my_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	if ( function_exists( 'add_theme_support' ) ) { // Added in 2.9
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 204, 141, true ); // Normal post thumbnails
		add_image_size( 'slider-post-thumbnail', 318, 275, true ); // Slider Thumbnail
		add_image_size( 'portfolio-post-thumbnail', 290, 150, true ); // Portfolio Thumbnail
		add_image_size( 'small-post-thumbnail', 100, 100, true ); // Small Thumbnail
	}

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// custom menu support
	add_theme_support( 'menus' );
	if ( function_exists( 'register_nav_menus' ) ) {
	  	register_nav_menus(
	  		array(
	  		  'header_menu' => 'Header Menu',
	  		  'footer_menu' => 'Footer Menu'
	  		)
	  	);
	}
}
endif;


/* Slider */
function my_post_type_slider() {
	register_post_type( 'slider',
                array( 
				'label' => __('Slider'), 
				'public' => true, 
				'show_ui' => true,
				'show_in_nav_menus' => false,
				'menu_position' => 5,
				'supports' => array(
						'title',
						'custom-fields',
            'thumbnail')
					) 
				);
}

add_action('init', 'my_post_type_slider');



/* Partners */
function my_post_type_portfolio() {
	register_post_type( 'portfolio',
                array( 
				'label' => __('Partners'), 
				'public' => true, 
				'show_ui' => true,
				'show_in_nav_menus' => true,
				'rewrite' => true,
				'hierarchical' => true,
				'menu_position' => 5,
				'supports' => array(
						'title',
						'editor',
						'thumbnail',
						'excerpt',
						'custom-fields',
						'revisions')
					) 
				);
	register_taxonomy('portfoliocat', 'portfolio', array('hierarchical' => true, 'label' => 'Partners Categories', 'singular_name' => 'Category'));
}

add_action('init', 'my_post_type_portfolio');



/* FAQ */
function phi_post_type_faq() {
	register_post_type('faq', 
				array(
				'label' => __('FAQ'),
				'singular_label' => __('FAQ'),
				'public' => true,
				'show_ui' => true,
				'_builtin' => false, // It's a custom post type, not built in
				'_edit_link' => 'post.php?post=%d',
				'capability_type' => 'post',
				'hierarchical' => false,
				'rewrite' => array("slug" => "faq"), // Permalinks
				'query_var' => "faq", // This goes to the WP_Query schema
				'supports' => array('title','author','thumbnail', 'editor' ,'excerpt'/*,'custom-fields'*/),
				'menu_position' => 5,
				'publicly_queryable' => true,
				'exclude_from_search' => false,
				));

	register_taxonomy("faq_categories", 
				array("faq"), 
				array("hierarchical" => true, 
						"label" => "FAQ Categories", 
						"singular_label" => "FAQ Category",
						"rewrite" => true,
						"show_ui" => true,));
}
add_action('init', 'phi_post_type_faq');



?>