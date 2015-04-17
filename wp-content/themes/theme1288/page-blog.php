<?php
/**
 * Template Name: Blog
 */

get_header(); ?>
<div id="content">
  
  <h1 class="extra"><?php the_title(); ?></h1>
  
  <?php
  $temp = $wp_query;
  $wp_query= null;
  $wp_query = new WP_Query();
  $wp_query->query('showposts=5'.'&paged='.$paged);
  ?>
	<?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
        <?php echo '<div class="featured-thumbnail">'; the_post_thumbnail(); echo '</div>'; ?>
        <div class="post-content">
          <div class="excerpt"><?php $excerpt = get_the_excerpt(); echo my_string_limit_words($excerpt,80);?></div>
          <div class="post-info">
             <div class="link-1"><a href="<?php the_permalink() ?>">More</a></div>
             <div class="comments"><?php comments_popup_link('No comments', 'One comment', '% comments', 'comments-link', 'Comments are closed'); ?></div>
          </div>
        </div>
    </article>
    
  <?php endwhile; ?>
  
  <?php if ( $wp_query->max_num_pages > 1 ) : ?>
    <nav class="oldernewer">
      <div class="older">
        <?php next_posts_link('&laquo; Older Entries') ?>
      </div><!--.older-->
      <div class="newer">
        <?php previous_posts_link('Newer Entries &raquo;') ?>
      </div><!--.newer-->
    </nav><!--.oldernewer-->
  <?php endif; ?>
  
  <?php $wp_query = null; $wp_query = $temp;?>

</div><!--#content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
