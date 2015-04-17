<?php
/**
 * Template Name: Partners Full
 */

get_header(); ?>

	<?php include_once (TEMPLATEPATH . '/title.php');?>   
   <?php global $more;	$more = 0;?>
   <?php $wp_query = new WP_Query(); ?>
   <?php $wp_query->query("post_type=portfolio&paged=".$paged.'&showposts=9'); ?>
   <?php get_template_part( 'loop', 'portfolio' );?>

<?php get_footer(); ?>
