<?php get_header(); ?>

   <div id="content" class="search">
     <h1 class="extra">Search results for: "<?php the_search_query(); ?>"</h1>
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
         <h2>No Results</h2>
         <p>Please feel free try again!</p>
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
   
   </div><!-- #content -->
   


<?php get_footer(); ?>
