<?php
// =============================== My Request Quote Widget ======================================
class MY_RequestQuoteWidget extends WP_Widget {
    /** constructor */
    function MY_RequestQuoteWidget() {
        parent::WP_Widget(false, $name = 'My - Request a Quote');	
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
        $title = apply_filters('widget_txt1', $instance['title']);
				$txt1 = apply_filters('widget_txt1', $instance['txt1']);
				$txt2 = apply_filters('widget_txt2', $instance['txt2']);
				$txt3 = apply_filters('widget_txt2', $instance['txt3']);
        ?>
              
		<?php 
			if($txt2=="" && $txt3==""){ 
				$class='w-full';
			} else {}
		?>
              <?php echo $before_widget; ?>
			  
			  			<?php if($title!=""){ ?>
						<div class="box">
						<div class="box-text <?php echo $class; ?>">
							<div class="image"><img src="<?php echo $title; ?>" alt="" /></div>
							<?php echo $txt1; ?>
						</div><!-- end 'with title' -->
						<?php } else { ?>
						<div class="box">
						<div class="box-text <?php echo $class; ?>">
							<?php echo $txt1; ?>
						</div><!-- end 'without title' -->
						<?php } ?>
						
						<?php if($txt2!="" && $txt3!=""){ ?>
						<div class="link">
							<a href="<?php echo $txt3; ?>" class="but"><?php echo $txt2; ?></a>
						</div><!-- end 'button' -->
						<?php } ?>
				</div>
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
				$txt1 = esc_attr($instance['txt1']);
				$txt2 = esc_attr($instance['txt2']);
				$txt3 = esc_attr($instance['txt3']);
        ?>
       <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Image URL:', 'my_framework'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
			 <p><label for="<?php echo $this->get_field_id('txt1'); ?>"><?php _e('Text:', 'my_framework'); ?><textarea rows="5"  class="widefat" id="<?php echo $this->get_field_id('txt1'); ?>" name="<?php echo $this->get_field_name('txt1'); ?>"><?php echo $txt1; ?></textarea></label></p>
			 <p><label for="<?php echo $this->get_field_id('txt2'); ?>"><?php _e('Button Text:', 'my_framework'); ?> <input class="widefat" id="<?php echo $this->get_field_id('txt2'); ?>" name="<?php echo $this->get_field_name('txt2'); ?>" type="text" value="<?php echo $txt2; ?>" /></label></p>
			 <p><label for="<?php echo $this->get_field_id('txt3'); ?>"><?php _e('Url:', 'my_framework'); ?> <input class="widefat" id="<?php echo $this->get_field_id('txt3'); ?>" name="<?php echo $this->get_field_name('txt3'); ?>" type="text" value="<?php echo $txt3; ?>" /></label></p>
        <?php 
    }

} // class Request Quote Widget

?>