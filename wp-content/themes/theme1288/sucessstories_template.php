<?php

/**

 * Template Name: Sucess Stories

 */



get_header(); ?>



	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

   	<?php the_content(); ?>

   <?php endwhile; ?>

<?php

	//echo do_shortcode('[print_thumbnail_slider]'); 

echo do_shortcode('[print_responsive_thumbnail_slider]'); 

	?>

<?php get_footer(); ?>

