<?php
/**
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 */
?>


<?php if ( ! have_posts() ) : ?>
	<div id="post-0" class="post error404 not-found">
		<h1 class="entry-title"><?php _e( 'Not Found', 'my_framework' ); ?></h1>
		<div class="entry-content">
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'my_framework' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->
	</div><!-- #post-0 -->
<?php endif; ?>
<div id="gallery">
  <ul class="portfolio">
    <?php 
      $i=1;
      if ( have_posts() ) while ( have_posts() ) : the_post(); 
      if(($i%3) == 0){ $addclass = "nomargin";	}	
    ?>
    
    
    <?php
      $custom = get_post_custom($post->ID);
      $lightbox = $custom["lightbox-url"][0];
      
    ?>
    
      <li class="<?php echo $addclass; ?>">
      	<div class="title"><a href="<?php the_permalink(); ?>"><?php $title = the_title('','',FALSE); echo substr($title, 0, 40); ?></a></div>
				<?php if($lightbox!=""){ ?>
        <a class="image-wrap" href="<?php echo $lightbox;?>" rel="prettyPhoto[gallery]" title="<?php the_title();?>"><?php the_post_thumbnail( 'portfolio-post-thumbnail' ); ?><span class="zoom-icon"></span></a>
      <?php }else{ ?>
        <a class="image-wrap" href="<?php the_permalink() ?>" title="<?php _e('Permanent Link to', 'my_framework');?> <?php the_title_attribute(); ?>" ><?php the_post_thumbnail( 'portfolio-post-thumbnail' ); ?><span class="zoom-icon"></span></a>
        <?php } ?>
        <div class="folio-desc">
          <p class="excerpt"><?php $excerpt = get_the_excerpt(); echo my_string_limit_words($excerpt,18);?></p>
          <div class="link"><a href="<?php the_permalink(); ?>">More</a></div>
        </div>
      </li>
    
  
    <?php $i++; $addclass = ""; endwhile; ?>
  </ul>
  <div class="clear"></div>
</div>




<?php wp_pagenavi(); ?>
<!-- Page navigation -->
