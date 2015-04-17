<?php get_header(); ?>

   <div id="content">
      <?php
       if(isset($_GET['author_name'])) :
         $curauth = get_userdatabylogin($author_name);
         else :
         $curauth = get_userdata(intval($author));
       endif;
     ?>
     <div class="author-info">
       <h1>About: <?php echo $curauth->display_name; ?></h1>
       <p class="avatar">
         <?php if(function_exists('get_avatar')) { echo get_avatar( $curauth->user_email, $size = '120' ); } /* Displays the Gravatar based on the author's email address. Visit Gravatar.com for info on Gravatars */ ?>
       </p>
       
       <?php if($curauth->description !="") { /* Displays the author's description from their Wordpress profile */ ?>
         <p><?php echo $curauth->description; ?></p>
       <?php } ?>
     </div><!--.author-->
     <div id="recent-author-posts">
       <h1 class="extra">Recent Posts by <?php echo $curauth->display_name; ?></h1>
       <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); /* Displays the most recent posts by that author. Note that this does not display custom content types */ ?>
         <?php static $count = 0;
           if ($count == "5") // Number of posts to display
                   { break; }
           else { ?>
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
         <?php $count++; } ?>
         <?php endwhile; else: ?>
           <p>
             No posts by <?php echo $curauth->display_name; ?> yet.
           </p>
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
     </div><!--#recentPosts-->
     <div id="recent-author-comments">
       <h3>Recent Comments by <?php echo $curauth->display_name; ?></h3>
         <?php
           $number=5; // number of recent comments to display
           $comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_approved = '1' and comment_author_email='$curauth->user_email' ORDER BY comment_date_gmt DESC LIMIT $number");
         ?>
         <ul>
           <?php
             if ( $comments ) : foreach ( (array) $comments as $comment) :
             echo  '<li class="recentcomments">' . sprintf(__('%1$s on %2$s'), get_comment_date(), '<a href="'. get_comment_link($comment->comment_ID) . '">' . get_the_title($comment->comment_post_ID) . '</a>') . '</li>';
           endforeach; else: ?>
                     <p>
                       No comments by <?php echo $curauth->display_name; ?> yet.
                     </p>
           <?php endif; ?>
               </ul>
     </div><!--#recentAuthorComments-->
   
     
   </div><!--#content-->
   
   <?php get_sidebar(); ?>

<?php get_footer(); ?>