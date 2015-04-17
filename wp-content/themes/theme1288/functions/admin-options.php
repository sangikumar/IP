<?php
	$themename = "StarCorp";
	$shortname = "my_framework";
	
	
	
	
	//Theme options
	$options = array(
 
		array ( "name" => "Options",
					  "type" => "title" ),

		array ( "name" => "General",
						"type" => "section" ),
		array ( "type" => "open"),

		array ( "name" => "Logo URL",
						"desc" => "Enter the link to your logo image",
						"id" => $shortname . "_logo",
						"type" => "text",
						"std" => "" ),
		
		array ( "name" => "Display search box",
						"desc" => "Display search box in the header?",
						"id" => $shortname . "_searchbox",
						"type" => "checkbox",
						"std" => "" ),

		array ( "name" => "Custom CSS",
						"desc" => "Want to add any custom CSS code? Put in here, and the rest is taken care of. This overrides any other stylesheets. eg: a.button{color:green}",
						"id" => $shortname . "_custom_css",
						"type" => "textarea",
						"std" => "" ),

		array ( "type" => "close"),
		
		
		
		array ( "name" => "Main Navigation",
						"type" => "section" ),

		array ("type" => "open"),

		array ( "name" => "Delay",
						"desc" => "miliseconds delay on mouseout",
						"id" => $shortname . "_sf_delay",
						"type" => "text",
						"std" => "" ),
		
		array ( "name" => "Fade-in animation",
						"desc" => "fade-in animation",
						"id" => $shortname . "_sf_fade_in",
						"type" => "select",
						"options" => array ("show", "false"),
						"std" => "" ),
		
		array ( "name" => "Slide-down animation",
						"desc" => "slide-down animation",
						"id" => $shortname . "_sf_slide_down",
						"type" => "select",
						"options" => array ("show", "false"),
						"std" => "" ),
		
		array ( "name" => "Speed",
						"desc" => "animation speed",
						"id" => $shortname . "_sf_speed",
						"type" => "select",
						"options" => array ("slow", "normal", "fast"),
						"std" => "" ),
		
		array ( "name" => "Arrows markup",
						"desc" => "generation of arrow mark-up",
						"id" => $shortname . "_sf_arrows",
						"type" => "select",
						"options" => array ("false", "true"),
						"std" => "" ),
		
		array ( "name" => "Drop shadows",
						"desc" => "drop shadows (for submenu)",
						"id" => $shortname . "_sf_dropshadows",
						"type" => "select",
						"options" => array ("false", "true"),
						"std" => "false" ),
		

		array ( "type" => "close"),

		
		
		
		
		array ( "name" => "Slider",
						"type" => "section" ),

		array ("type" => "open"),

		array ( "name" => "Slider effects",
						"desc" => "Slider effects",
						"id" => $shortname ."_sl_effects",
						"type" => "select",
						"options" => array ("random", "fold", "fade", "sliceDown", "sliceDownLeft", "sliceUp", "sliceUpLeft", "sliceUpDown", "sliceUpDownLeft", "slideInRight", "slideInLeft", "boxRandom", "boxRain", "boxRainReverse", "boxRainGrow", "boxRainGrowReverse"),
						"std" => ""),
		
		array ( "name" => "Number of slices",
						"desc" => "Number of slices",
						"id" => $shortname ."_sl_slices",
						"type" => "select",
						"options" => array ("2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30"),
						"std" => ""),
		
		array(  "name" => "Animation speed",
						"desc" => "Animation speed",
						"id" => $shortname."_sl_animspeed",
						"type" => "text",
						"std" => ""),
		
		array(  "name" => "Pause time",
						"desc" => "Pause time",
						"id" => $shortname."_sl_pausetime",
						"type" => "text",
						"std" => ""),
		
		array(  "name" => "Start slide",
						"desc" => "Start slide",
						"id" => $shortname."_sl_startSlide",
						"type" => "text",
						"std" => ""),
		
		array ( "name" => "Next & Prev navigation",
						"desc" => "Display navigation?",
						"id" => $shortname ."_sl_directionNav",
						"type" => "select",
						"options" => array ("true", "false"),
						"std" => ""),
		
		array ( "name" => "Next & Prev navigation",
						"desc" => "false - always visible, true - only on hover",
						"id" => $shortname ."_sl_directionNavHide",
						"type" => "select",
						"options" => array ("true", "false"),
						"std" => ""),
		
		array ( "name" => "Pagination",
						"desc" => "show pagination",
						"id" => $shortname ."_sl_controlNav",
						"type" => "select",
						"options" => array ("true", "false"),
						"std" => ""),
		
		array ( "name" => "Thumbnails",
						"desc" => "use thumbnails for Control Navigation",
						"id" => $shortname ."_sl_controlNavThumbs",
						"type" => "select",
						"options" => array ("true", "false"),
						"std" => ""),
		
		array ( "name" => "Keyboard navigation",
						"desc" => "use keyboard navigation",
						"id" => $shortname ."_sl_keyboardNav",
						"type" => "select",
						"options" => array ("true", "false"),
						"std" => ""),
		
		array ( "name" => "Pause on hover",
						"desc" => "stop animation while hovering",
						"id" => $shortname ."_sl_pauseOnHover",
						"type" => "select",
						"options" => array ("true", "false"),
						"std" => ""),
		
		array(  "name" => "Opacity of caption",
						"desc" => "universal caption opacity (0.8 by default)",
						"id" => $shortname."_sl_captionOpacity",
						"type" => "text",
						"std" => "0.8"),
		
		array ( "type" => "close"),
		
		
		

		array ( "name" => "Footer",
						"type" => "section"),

		array ( "type" => "open"),

		array(  "name" => "Footer copyright text",
						"desc" => "Enter text used in the right side of the footer. It can be HTML",
						"id" => $shortname."_footer_text",
						"type" => "textarea",
						"std" => ""),

		array(  "name" => "Google Analytics Code",
						"desc" => "You can paste your Google Analytics or other tracking code in this box. This will be automatically added to the footer.",
						"id" => $shortname."_ga_code",
						"type" => "textarea",
						"std" => ""),

		array(  "name" => "Feedburner URL",
						"desc" => "Feedburner is a Google service that takes care of your RSS feed. Paste your Feedburner URL here to let readers see it in your website",
						"id" => $shortname."_feedburner",
						"type" => "text",
						"std" => get_bloginfo('rss2_url')),
		
		array(  "name" => "Footer Menu",
						"desc" => "Enable footer menu",
						"id" => $shortname."_footermenu",
						"type" => "checkbox",
						"std" => ""),

		array( "type" => "close")

);