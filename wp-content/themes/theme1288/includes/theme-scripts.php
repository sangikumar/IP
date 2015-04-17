<?php
function my_script() {
	if (!is_admin()) {
		wp_deregister_script('jquery');
		wp_register_script('jquery', get_bloginfo('template_url').'/js/jquery-1.5.1.min.js', false, '1.5.1');
		wp_enqueue_script('jquery');

		wp_enqueue_script('superfish', get_bloginfo('template_url').'/js/superfish.js', array('jquery'), '1.4.8');
		wp_enqueue_script('prettyPhoto', get_bloginfo('template_url').'/js/jquery.prettyPhoto.js', array('jquery'), '3.0.3');
		wp_enqueue_script('nivo', get_bloginfo('template_url').'/js/jquery.nivo.slider.pack.js', array('jquery'), '2.4');
		wp_enqueue_script('loader', get_bloginfo('template_url').'/js/jquery.loader.js', array('jquery'), '1.0');
		wp_enqueue_script('cufon_yui', get_bloginfo('template_url').'/js/cufon-yui.js', array('jquery'), '1.09i');
		wp_enqueue_script('Swis721', get_bloginfo('template_url').'/js/Swis721_Lt_BT_400.font.js', array('jquery'), '1.0');
		wp_enqueue_script('Swis721 italic', get_bloginfo('template_url').'/js/Swis721_Lt_BT_italic_400.font.js', array('jquery'), '1.0');
		wp_enqueue_script('cufon_replace', get_bloginfo('template_url').'/js/cufon-replace.js', array('jquery'), '1.0');
	}
}
add_action('init', 'my_script');
?>