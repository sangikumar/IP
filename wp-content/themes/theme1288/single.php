<?php get_header(); ?>

   <div id="content">
      <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
       <div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
         <article class="single-post">
          <h1><?php the_title(); ?></h1>
          <?php the_content(); ?>
         </article>
   
           
   
            <?php /* If a user fills out their bio info, it's included here */ ?>
         <div id="post-author">
           <h3>Written by <?php the_author_posts_link() ?></h3>
           <p class="gravatar"><?php if(function_exists('get_avatar')) { echo get_avatar( get_the_author_email(), '80' ); /* This avatar is the user's gravatar (http://gravatar.com) based on their administrative email address */  } ?></p>
           <div id="author-description">
             <?php the_author_meta('description') ?> 
             <div id="author-link">
               <p>View all posts by: <?php the_author_posts_link() ?></p>
             </div><!--#author-link-->
           </div><!--#author-description -->
         </div><!--#post-author-->
   
       </div><!-- #post-## -->
       
       
       <nav class="oldernewer">
         <div class="older">
           <?php previous_post_link('%link', '&laquo; Previous post') ?>
         </div><!--.older-->
         <div class="newer">
           <?php next_post_link('%link', 'Next Post &raquo;') ?>
         </div><!--.newer-->
       </nav><!--.oldernewer-->
   
       <?php comments_template( '', true ); ?>
   
     <?php endwhile; /* end loop */ ?>
   </div><!--#content-->
   
   <?php get_sidebar(); ?>

<?php get_footer(); ?>