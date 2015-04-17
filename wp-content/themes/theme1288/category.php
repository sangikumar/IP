<?php get_header(); ?>

<div id="content">
	<div class="indent">
  	<h1 class="extra"><?php printf( __( 'Category Archives: %s' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?></h1>
		<?php echo category_description(); /* displays the category's description from the Wordpress admin */ ?>
    
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
        <?php echo '<div class="featured-thumbnail">'; the_post_thumbnail(); echo '</div>'; ?>
        <div class="post-content">
          <div class="excerpt"><?php $excerpt = get_the_excerpt(); echo my_string_limit_words($excerpt,85);?></div>
          <div class="post-info">
             <div class="link-1"><a href="<?php the_permalink() ?>">More</a></div>
             <div class="comments"><?php comments_popup_link('No comments', 'One comment', '% comments', 'comments-link', 'Comments are closed'); ?></div>
          </div>
        </div>
      </article>
    <?php endwhile; else: ?>
      <div class="no-results">
        <p><strong>There has been an error.</strong></p>
        <p>We apologize for any inconvenience, please <a href="<?php bloginfo('url'); ?>/" title="<?php bloginfo('description'); ?>">return to the home page</a> or use the search form below.</p>
        <?php get_search_form(); /* outputs the default Wordpress search form */ ?>
      </div><!--noResults-->
    <?php endif; ?>
      
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
  </div>
	
</div><!--#content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>