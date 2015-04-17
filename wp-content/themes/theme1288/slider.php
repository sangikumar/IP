<div id="slider" class="nivoSlider">
	<?php
		query_posts("post_type=slider&post_status=publish&posts_per_page=-1");
		while ( have_posts() ) : the_post();
	?>
	<?php
		$custom = get_post_custom($post->ID);
		$url = get_post_custom_values("slider-url");
		$sl_thumb = $custom["thumb"][0];
		$sl_caption = $custom["caption"][0];
	?>
  <?php if(has_post_thumbnail( $the_ID) || $sl_thumb!=""){ ?>
  <?php 
		if($sl_thumb!=""){
			echo "<a href='" . $url[0] . "'>";
			echo "<img src='" . $sl_thumb . "' alt='' title='" . $sl_caption . "' />";
			echo "</a>";
		} else{
			echo "<a href='" . $url[0] . "'>";
			the_post_thumbnail( 'slider-post-thumbnail' );
			echo "</a>";
		}
		?>
  <?php } ?>
  <?php endwhile; ?>
</div>
<?php wp_reset_query();?>