<?php

	$functions_path = TEMPLATEPATH . '/functions/';
	$includes_path = TEMPLATEPATH . '/includes/';
	
	
	//Theme Options
	require_once $functions_path . 'admin-options.php';
	
	//Loading jQuery and Scripts
	require_once $includes_path . 'theme-scripts.php';
	
	//Widget and Sidebar
	require_once $includes_path . 'sidebar-init.php';
	
	require_once $includes_path . 'register-widgets.php';
	
	
	//Additional function
	require_once $includes_path . 'theme-function.php';
	
	//Theme init
	require_once $includes_path . 'theme-init.php';
	
	//Shortcodes
	require_once $includes_path . 'theme_shortcodes/shortcodes.php';
	
	

	
	
	
	
	// removes detailed login error information for security
	add_filter('login_errors',create_function('$a', "return null;"));
	
	// Removes Trackbacks from the comment cout
	add_filter('get_comments_number', 'comment_count', 0);
	function comment_count( $count ) {
		if ( ! is_admin() ) {
			global $id;
			$comments_by_type = &separate_comments(get_comments('status=approve&post_id=' . $id));
			return count($comments_by_type['comment']);
		} else {
			return $count;
		}
	}

	
	
	
	
	
	
	
	
	
	// custom excerpt ellipses for 2.9+
	function custom_excerpt_more($more) {
		return 'Read More &raquo;';
	}
	add_filter('excerpt_more', 'custom_excerpt_more');
	// no more jumping for read more link
	function no_more_jumping($post) {
		return '&nbsp;<a href="'.get_permalink($post->ID).'" class="read-more">'.'Continue Reading'.'</a>';
	}
	add_filter('excerpt_more', 'no_more_jumping');
	
	
	// category id in body and post class
	function category_id_class($classes) {
		global $post;
		foreach((get_the_category($post->ID)) as $category)
			$classes [] = 'cat-' . $category->cat_ID . '-id';
			return $classes;
	}
	
	add_filter('post_class', 'category_id_class');
	add_filter('body_class', 'category_id_class');

	
	
	// Theme Options
	function mytheme_add_admin() {
	 
	global $themename, $shortname, $options;
	 
	if ( $_GET['page'] == basename(__FILE__) ) {
	 
		if ( 'save' == $_REQUEST['action'] ) {
	 
			foreach ($options as $value) {
			update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
	 
	foreach ($options as $value) {
		if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }
		header("Location: admin.php?page=functions.php&saved=true");
	die;
	 
	} 
	else if( 'reset' == $_REQUEST['action'] ) {
	 
		foreach ($options as $value) {
			delete_option( $value['id'] ); }
	 
		header("Location: admin.php?page=functions.php&reset=true");
	die;
	 
	}
	}
	 
	add_menu_page($themename, $themename, 'administrator', basename(__FILE__), 'mytheme_admin');
	}
	
	function mytheme_add_init() {
	
	$file_dir=get_bloginfo('template_directory');
	wp_enqueue_style("functions", $file_dir."/functions/functions.css", false, "1.0", "all");
	wp_enqueue_script("rm_script", $file_dir."/functions/rm_script.js", false, "1.0");
	
	}
	function mytheme_admin() {
	 
	global $themename, $shortname, $options;
	$i=0;
	 
	if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
	if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
	 
	?>

<div class="wrap rm_wrap">
<h2><?php echo $themename; ?> Settings</h2>
<div class="rm_opts">
<form method="post">
  <?php foreach ($options as $value) {
	switch ( $value['type'] ) {
	 
	case "open":
	?>
  <?php break;
	 
	case "close":
	?>
  </div>
  </div>
  <br />
  <?php break;
	 
	case "title":
	?>
  <p>To easily use the <?php echo $themename;?> theme, you can use the menu below.</p>
  <?php break;
	 
	case 'text':
	?>
  <div class="rm_input rm_text">
    <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
    <input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id'])  ); } else { echo $value['std']; } ?>" />
    <small><?php echo $value['desc']; ?></small>
    <div class="clearfix"></div>
  </div>
  <?php
	break;
	 
	case 'textarea':
	?>
  <div class="rm_input rm_textarea">
    <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
    <textarea name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id']) ); } else { echo $value['std']; } ?>
</textarea>
    <small><?php echo $value['desc']; ?></small>
    <div class="clearfix"></div>
  </div>
  <?php
	break;
	 
	case 'select':
	?>
  <div class="rm_input rm_select">
    <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
    <select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
      <?php foreach ($value['options'] as $option) { ?>
      <option <?php if (get_settings( $value['id'] ) == $option) { echo 'selected="selected"'; } ?>><?php echo $option; ?></option>
      <?php } ?>
    </select>
    <small><?php echo $value['desc']; ?></small>
    <div class="clearfix"></div>
  </div>
  <?php
	break;
	 
	case "checkbox":
	?>
  <div class="rm_input rm_checkbox">
    <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
    <?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
    <input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
    <small><?php echo $value['desc']; ?></small>
    <div class="clearfix"></div>
  </div>
  <?php break; 
	case "section":
	
	$i++;
	
	?>
  <div class="rm_section">
  <div class="rm_title">
    <h3><img src="<?php bloginfo('template_directory')?>/functions/images/trans.png" class="inactive" alt="""><?php echo $value['name']; ?></h3>
    <span class="submit">
    <input name="save<?php echo $i; ?>" type="submit" value="Save changes" />
    </span>
    <div class="clearfix"></div>
  </div>
  <div class="rm_options">
  <?php break;
	 
	}
	}
	?>
  <input type="hidden" name="action" value="save" />
</form>
<form method="post">
  <p class="submit">
    <input name="reset" type="submit" value="Reset" />
    <input type="hidden" name="action" value="reset" />
  </p>
</form>
</div>
<?php
	}
	?>
<?php
	add_action('admin_init', 'mytheme_add_init');
	add_action('admin_menu', 'mytheme_add_admin');
	
	
	
?>
