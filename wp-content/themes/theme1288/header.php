<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>

	<title>

	<?php if ( is_tag() ) {

			echo 'Tag Archive for &quot;'.$tag.'&quot; | '; bloginfo( 'name' );

		} elseif ( is_archive() ) {

			wp_title(); echo ' Archive | '; bloginfo( 'name' );

		} elseif ( is_search() ) {

			echo 'Search for &quot;'.wp_specialchars($s).'&quot; | '; bloginfo( 'name' );

		} elseif ( is_home() ) {

			bloginfo( 'name' );

		}  elseif ( is_404() ) {

			echo 'Error 404 Not Found | '; bloginfo( 'name' );

		} else {

			echo wp_title( ' | ', false, right ); bloginfo( 'name' );

		} ?>

	</title>

	<meta name="keywords" content="<?php wp_title(); echo ' , '; bloginfo( 'name' ); echo ' , '; bloginfo( 'description' ); ?>" />

	<meta name="description" content="<?php wp_title(); echo ' | '; bloginfo( 'description' ); ?>" />

	<meta charset="<?php bloginfo( 'charset' ); ?>" />

	<link rel="profile" href="http://gmpg.org/xfn/11" />

	<link rel="index" title="<?php bloginfo( 'name' ); ?>" href="<?php echo get_option('home'); ?>/" />

  <link rel="icon" href="<?php bloginfo( 'template_url' ); ?>/favicon.ico" type="image/x-icon" />

  <link rel="icon" href="<?php echo get_option('mytheme_favicon'); ?>" type="image/x-icon" />

	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?>" href="<?php bloginfo( 'rss2_url' ); ?>" />

	<link rel="alternate" type="application/atom+xml" title="<?php bloginfo( 'name' ); ?>" href="<?php bloginfo( 'atom_url' ); ?>" />

	<!-- The HTML5 Shim is required for older browsers, mainly older versions IE -->

	<!--[if lt IE 9]>

		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>

	<![endif]-->

  <!--[if lt IE 7]>

    <div style=' clear: both; text-align:center; position: relative;'>

    	<a href="http://www.microsoft.com/windows/internet-explorer/default.aspx?ocid=ie6_countdown_bannercode"><img src="http://www.theie6countdown.com/images/upgrade.jpg" border="0" &nbsp;alt="" /></a>

    </div>

  <![endif]-->

	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />

   <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/css/prettyPhoto.css" />

	<?php

		/* We add some JavaScript to pages with the comment form

		 * to support sites with threaded comments (when in use).

		 */

		if ( is_singular() && get_option( 'thread_comments' ) )

			wp_enqueue_script( 'comment-reply' );

	

		/* Always have wp_head() just before the closing </head>

		 * tag of your theme, or you will break many plugins, which

		 * generally use this hook to add elements to <head> such

		 * as styles, scripts, and meta tags.

		 */

		wp_head();

	?>

  <!--[if lt IE 9]>

  <style type="text/css">

    .wp-pagenavi a, .wp-pagenavi span, div.wpcf7 input[type="text"], div.wpcf7 input[type="submit"], div.wpcf7 textarea, span.wpcf7-not-valid-tip {

      behavior:url(<?php bloginfo('stylesheet_directory'); ?>/PIE.php)

      }

  </style>

  <![endif]-->

  

  <script type="text/javascript">

  	// initialise plugins

		jQuery(function(){

			// main navigation init

			jQuery('ul.sf-menu').superfish({

				delay:       <?php echo get_option('my_framework_sf_delay'); ?>, 		// one second delay on mouseout 

				animation:   {opacity:'<?php echo get_option('my_framework_sf_fade_in'); ?>',height:'<?php echo get_option('my_framework_sf_slide_down'); ?>'}, // fade-in and slide-down animation 

				speed:       '<?php echo get_option('my_framework_sf_speed'); ?>',  // faster animation speed 

				autoArrows:  <?php echo get_option('my_framework_sf_arrows'); ?>,        // generation of arrow mark-up (for submenu) 

				dropShadows: <?php echo get_option('my_framework_sf_dropshadows'); ?>    // drop shadows (for submenu)

			});

			

			jQuery(".sf-menu li li:last-child a").addClass("last");

			

			// prettyphoto init

			jQuery("#gallery .portfolio a[rel^='prettyPhoto']").prettyPhoto({

				animationSpeed:'slow',

				theme:'facebook',

				slideshow:false,

				autoplay_slideshow: false,

				show_title: true,

				overlay_gallery: false

			});

			

		});

  </script>

  

  <script type="text/javascript">

		jQuery(window).load(function() {

			// nivoslider init

			jQuery('#slider').nivoSlider({

				effect: '<?php echo get_option('my_framework_sl_effects'); ?>',

				animSpeed:<?php echo get_option('my_framework_sl_animspeed'); ?>,

				pauseTime:<?php echo get_option('my_framework_sl_pausetime'); ?>,

				startSlide:<?php echo get_option('my_framework_sl_startSlide'); ?>,

				slices:<?php echo get_option('my_framework_sl_slices'); ?>,

				directionNav:<?php echo get_option('my_framework_sl_directionNav'); ?>,

				directionNavHide:<?php echo get_option('my_framework_sl_directionNavHide'); ?>,

				controlNav:<?php echo get_option('my_framework_sl_controlNav'); ?>,

				controlNavThumbs:<?php echo get_option('my_framework_sl_controlNavThumbs'); ?>,

				keyboardNav:<?php echo get_option('my_framework_sl_keyboardNav'); ?>,

				pauseOnHover:<?php echo get_option('my_framework_sl_pauseOnHover'); ?>,

				captionOpacity:<?php echo get_option('my_framework_sl_captionOpacity'); ?>

			});

		});

	</script>

  

  <!-- Custom CSS -->

  <?php $my_framework_custom_css = get_option('my_framework_custom_css'); ?>

	<?php if($my_framework_custom_css){?>

  <style type="text/css">

  	<?php echo get_option('my_framework_custom_css'); ?>

  </style>

  <?php }?>

</head>



<body <?php body_class(); ?>>



<div id="main"><!-- this encompasses the entire Web site -->



	<header id="header">

		<div class="container">

      

      	<div class="logo">

					<?php $my_framework_logo = get_option('my_framework_logo'); ?>

          <?php if($my_framework_logo){?>

            <a href="<?php bloginfo('url'); ?>/"><img src="<?php echo get_option('my_framework_logo'); ?>" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('description'); ?>"></a>

          <?php } else { ?>

            <?php if( is_front_page() || is_home() || is_404() ) { ?>

              <h1><a href="<?php bloginfo('url'); ?>/" title="<?php bloginfo('description'); ?>"><?php bloginfo('name'); ?></a></h1>

            <?php } else { ?>

              <h2><a href="<?php bloginfo('url'); ?>/" title="<?php bloginfo('description'); ?>"><?php bloginfo('name'); ?></a></h2>

            <?php } ?>

          <?php }?>

          <p class="description"><?php bloginfo('description'); ?></p>

        </div>

        

        

        

        <?php if ( get_option('my_framework_searchbox') == 'true') { ?>  

          <div id="top-search">
         
       <ul class="top_so">
          <li><a href="https://www.facebook.com/info.Innovapath"><img src="http://innova-path.com/wp-content/uploads/2013/12/facebook.png"/></a></li>
          <li><a href="http://www.linkedin.com/company/innovapath-inc-?trk=company_name"><img src="http://innova-path.com/wp-content/uploads/2013/12/link24.png"/></a></li>
          <li><a href="https://twitter.com/innovapath1"><img src="http://innova-path.com/wp-content/uploads/2013/12/twitter.png"/></a></li>
          </ul>

           <ul class="top_li">
         <li><a href="http://innova-path.com/project/admin/login.php">Employee Login</a> </li>
          <!--<li>|<a href="http://innova-path.com/?page_id=281">Site Map</a></li>-->
         </ul> <form method="get" id="searchform" action="<?php echo get_option('home'); ?>/">

              <input type="text" name="s"><input type="submit" value="">

            </form>   

          </div>  

        <?php } ?>
        
        <nav class="primary">

          <?php wp_nav_menu( array(

            'container'       => 'ul', 

            'menu_class'      => 'sf-menu', 

            'menu_id'         => 'topnav',

            'depth'           => 0,

            'theme_location' => 'header_menu' 

            )); 

          ?>

        </nav><!--.primary-->

        

        <div id="widget-header">

        	<?php if ( ! dynamic_sidebar( 'Header' ) ) : ?>

            <!-- Widgetized Header -->

          <?php endif ?>

        </div><!--#widget-header-->

        

		</div><!--.container-->

	</header>

   

  <?php if( is_front_page() || is_home() ) { ?>

  <section id="slider-wrapper">

    <div class="container">

      	<?php include_once(TEMPLATEPATH . '/slider.php'); ?>

    </div>

  </section><!--#slider-->

  <?php } ?>

  

	<div class="primary_content_wrap">

      <div class="container">

      	<div id="indent">

      		<div class="wrapper">