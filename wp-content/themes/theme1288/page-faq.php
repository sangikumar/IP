<?php
/**
 * Template Name: FAQ
 */

get_header(); ?>
  
  <h1><?php the_title(); ?></h1>
  
  <?php
  $temp = $wp_query;
  $wp_query= null;
  $wp_query = new WP_Query();
  $wp_query->query('post_type=faq&showposts=-1');
  ?>
  <dl class="faq_list">
	
<div style="height:400px;">&nbsp;</div>