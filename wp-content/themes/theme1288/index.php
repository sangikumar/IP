<?php get_header(); ?>
	<div id="content" class="grid_17 suffix_1">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header>
          <h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
          <div class="post-meta">
            <div class="fleft">Posted in: <?php the_category(', ') ?> | <time datetime="<?php the_time('Y-m-d\TH:i'); ?>"><?php the_time('F j, Y'); ?> at <?php the_time() ?></time> , by <?php the_author_posts_link() ?></div>
            <div class="fright"><?php comments_popup_link('No comments', 'One comment', '% comments', 'comments-link', 'Comments are closed'); ?></div>
          </div><!--.post-meta-->
        </header>
        <?php echo '<div class="featured-thumbnail">'; the_post_thumbnail(); echo '</div>'; ?>
        <div class="post-content">
          <div class="excerpt"><?php $excerpt = get_the_excerpt(); echo my_string_limit_words($excerpt,50);?></div>
          <a href="<?php the_permalink() ?>" class="button">Read more</a>
        </div>
        <footer>
          <?php the_tags('Tags: ', ', ', ''); ?> <?php edit_post_link('Edit', '', ''); ?>
        </footer>
      </article>
      
    <?php endwhile; else: ?>
      <div class="no-results">
        <p><strong>There has been an error.</strong></p>
        <p>We apologize for any inconvenience, please <a href="<?php bloginfo('url'); ?>/" title="<?php bloginfo('description'); ?>">return to the home page</a> or use the search form below.</p>
        <?php get_search_form(); ?> <!-- outputs the default Wordpress search form-->
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

	</div><!--#content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
