				</div><!--.wrapper-->
         </div><!--#indent-->
      </div><!--.container-->
   </div><!--.primary_content_wrap-->
   
	<footer id="footer">
		<div class="container">
         
         <?php if ( is_front_page() || is_home() ) { ?>
            <div class="footer-widget">
               <div class="inner">
                  <div class="wrapper">
                  	
                     <div id="footer-title">
								<?php if ( ! dynamic_sidebar( 'Footer Widget Title' ) ) : ?>
                           <!--Widgetized Footer-->
                        <?php endif ?>
                     </div>
                     
                     <div class="wrapper">
                     
                        <div class="col-1">
                           <?php if ( ! dynamic_sidebar( 'Footer Widget - 1' ) ) : ?>
                              <!--Widgetized Footer-->
                           <?php endif ?>
                        </div>
                        
                        <div class="col-2">
                           <?php if ( ! dynamic_sidebar( 'Footer Widget - 2' ) ) : ?>
                              <!--Widgetized Footer-->
                           <?php endif ?>
                        </div>
                        
                        <div class="col-3">
                           <?php if ( ! dynamic_sidebar( 'Footer Widget - 3' ) ) : ?>
                              <!--Widgetized Footer-->
                           <?php endif ?>
                        </div>
                        
                        <div class="col-4">
                           <?php if ( ! dynamic_sidebar( 'Footer Widget - 4' ) ) : ?>
                              <!--Widgetized Footer-->
                           <?php endif ?>
                        </div>
                     
                     </div>
                     
                  </div>
               </div>
            </div>
         <?php } ?>
        
         <div class="footer-info">
         	<div class="inner">
               <div class="wrapper">
               
                  <?php if ( get_option('my_framework_footermenu') == 'true') { ?>  
                   <nav class="footer">
                           <?php wp_nav_menu( array(
                       'container'       => 'ul', 
                       'menu_class'      => 'footer-nav', 
                       'depth'           => 0,
                       'theme_location' => 'footer_menu' 
                       )); 
                     ?>
                   </nav>
                  <?php } ?>
                 
                  <?php $my_framework_footer_text = get_option('my_framework_footer_text'); ?>
                  <?php if($my_framework_footer_text){?>
                     <?php echo get_option('my_framework_footer_text'); ?>
                  <?php } else { ?>
                     <p>Copyright © 2014</p>
                  <?php } ?>
               
               </div>
            </div>
         </div>
        
		</div><!--.container-->
	</footer>
   
</div><!--#main-->
<?php wp_footer(); ?> <!-- this is used by many Wordpress features and for plugins to work proporly -->

<?php echo stripslashes(get_option('my_framework_ga_code')); ?><!-- Show Google Analytics -->
<script type="text/javascript"> Cufon.now(); </script>
</body>
</html>