<?php get_header(); ?>

   <div class="col-1">

      <?php if ( ! dynamic_sidebar( 'Content Widget Left' ) ) : ?>

         <!--Widgetized Content-->

      <?php endif ?>

   </div>

   

   <div class="col-2">

      <?php if ( ! dynamic_sidebar( 'Content Widget Right' ) ) : ?>

         <!--Widgetized Content-->

      <?php endif ?>

   </div>
<?php
	//echo do_shortcode('[print_thumbnail_slider]'); 
//echo do_shortcode('[print_responsive_thumbnail_slider]'); 
	?>
   

<?php get_footer(); ?>

