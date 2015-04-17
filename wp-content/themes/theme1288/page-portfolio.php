<?php
/**
 * Template Name: Partners
 */

get_header(); ?>

	<?php include_once (TEMPLATEPATH . '/title.php');?>   
   <?php $values = get_post_custom_values("category-include"); $cat=$values[0];  ?>
   <?php global $more;	$more = 0;?>
   <?php $wp_query = new WP_Query(); ?>
   <?php $catinclude = 'portfoliocat='. $cat ;?>
   <?php $wp_query->query("post_type=portfolio" . '&' . $catinclude .' &paged='.$paged.'&showposts=9'); ?>
   <?php get_template_part( 'loop', 'portfolio' );?>

<?php get_footer(); ?>
