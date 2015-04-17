<?php
// =============================== My Popular Post widget ======================================
class MY_PopularPostsWidget extends WP_Widget {
    /** constructor */
    function MY_PopularPostsWidget() {
        parent::WP_Widget(false, $name = 'My - Popular Posts Widget');	
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
						
							
              
              <?php global $wpdb; ?>
              <ul class="popular-posts">
								<?php
                  $pop_posts = 5;
                    $popularposts = "SELECT $wpdb->posts.ID, $wpdb->posts.post_title,  COUNT($wpdb->comments.comment_post_ID) AS 'stammy' FROM $wpdb->posts, $wpdb->comments WHERE comment_approved = '1' AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status = 'publish' AND comment_status = 'open' GROUP BY $wpdb->comments.comment_post_ID ORDER BY stammy DESC LIMIT ".$pop_posts;
                    $posts = $wpdb->get_results($popularposts);
                    if($posts){
                      foreach($posts as $post){
                        $post_title = stripslashes($post->post_title);
                        $guid = get_permalink($post->ID);
                        $thumb = get_post_meta($post->ID,'_thumbnail_id',false);
                        $thumb = wp_get_attachment_image_src($thumb[0], 'small-post-thumbnail', false);
                        $thumb = $thumb[0];
                ?>
                        <li>
                          <?php if ($thumb) { ?>
                            <figure class="post-thumb">
                              <img src="<?php echo $thumb; ?>" />
                            </figure>
                          <?php } ?>
                          <h5><a href="<?php echo $guid; ?>" title="<?php echo $post_title; ?>"><?php echo $post_title; ?></a></h5>
                          <?php $excerpt = get_the_excerpt(); echo my_string_limit_words($excerpt,10);?>
                          
                        </li>
                    <?php
                        }
                    }
                    ?>
              </ul>
              
              <?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
        return $new_instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {				
			$title = esc_attr($instance['title']);
    ?>
      <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'theme1203'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>

      </label></p>
      <?php 
    }

} // class Cycle Widget


?>