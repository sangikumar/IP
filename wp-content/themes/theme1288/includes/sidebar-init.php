<?php
function elegance_widgets_init() {

	// Sidebar Widget
	// Location: the sidebar
	register_sidebar(array(
		'name'					=> 'Sidebar',
		'id' 						=> 'main-sidebar',
		'description'   => __( 'Located at the right side of pages.'),
		'before_widget' => '<div id="%2$s" class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	
	// Content Widget Left
	// Location: left side
	register_sidebar(array(
		'name'					=> 'Content Widget Left',
		'id' 						=> 'content-widget-left',
		'description'   => __( 'Located at the left side of content.'),
		'before_widget' => '<div id="%2$s" class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
	
	// Content Widget Right
	// Location: right side
	register_sidebar(array(
		'name'					=> 'Content Widget Right',
		'id' 						=> 'content-widget-right',
		'description'   => __( 'Located at the right side of content.'),
		'before_widget' => '<div id="%2$s" class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));

	// Footer Widget Title
	// Location: at the top of the footer, above the copyright
	register_sidebar(array(
		'name'					=> 'Footer Widget Title',
		'id' 						=> 'footer-sidebar',
		'description'   => __( 'Located at the bottom of pages.'),
		'before_widget' => '<div id="%1$s" class="widget-area">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
	
	// Footer Widget - 1 
	// Location: at the top of the footer, above the copyright
	register_sidebar(array(
		'name'					=> 'Footer Widget - 1',
		'id' 						=> 'footer-sidebar-1',
		'description'   => __( 'Located at the bottom of pages.'),
		'before_widget' => '<div id="%1$s" class="widget-area">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
	
	// Footer Widget - 2 
	// Location: at the top of the footer, above the copyright
	register_sidebar(array(
		'name'					=> 'Footer Widget - 2',
		'id' 						=> 'footer-sidebar-2',
		'description'   => __( 'Located at the bottom of pages.'),
		'before_widget' => '<div id="%1$s" class="widget-area">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
	
	// Footer Widget - 3 
	// Location: at the top of the footer, above the copyright
	register_sidebar(array(
		'name'					=> 'Footer Widget - 3',
		'id' 						=> 'footer-sidebar-3',
		'description'   => __( 'Located at the bottom of pages.'),
		'before_widget' => '<div id="%1$s" class="widget-area">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
	
	// Footer Widget - 4 
	// Location: at the top of the footer, above the copyright
	register_sidebar(array(
		'name'					=> 'Footer Widget - 4',
		'id' 						=> 'footer-sidebar-4',
		'description'   => __( 'Located at the bottom of pages.'),
		'before_widget' => '<div id="%1$s" class="widget-area">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));

}
/** Register sidebars by running elegance_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'elegance_widgets_init' );
?>