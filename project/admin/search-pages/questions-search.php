<?php

require_once("/project/admin/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$userId = $loggedInUser->user_id;
if(!userIdExists($userId)){
  header("Location:login.php"); die();
}

//require_once '../tabs.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Questions-Search</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" />
<link href="/css/newstyle.css" type="text/css" rel="stylesheet"/>
<link href="/project/admin/models/site-templates/default.css" rel='stylesheet' type='text/css' />
<style type="text">
<![CDATA[
        html, body {
        margin: 0;      /* Remove body margin/padding */
        padding: 0;
        overflow: hidden; /* Remove scroll bars on browser window */
        font-size: 75%;
        }
]]>
</style>
<script src="http://code.jquery.com/jquery-1.9.1.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="/js/jquery.watermark.js" type="text/javascript"></script>
<script src='/project/admin/models/funcs.js' type='text/javascript'></script>
<style>  .ui-menu { width: 130px; }  </style>
<script type="text/javascript">
//bkLib.onDomLoaded(function() {  });
//<![CDATA[
        $(document).ready(function(){
            $(".link").button();
						$('#mymenu').menu();
						
              $("#faq_search_input").watermark("Begin Typing to Search questions");
            
              $("#faq_search_input").keyup(function()
              {
                var faq_search_input = $(this).val();
                var dataString = 'keyword='+ faq_search_input;
                if(faq_search_input.length>2)
              
              	{
                $.ajax({
                type: "GET",
                url: "../ajax-content/ajax-search.php",
                data: dataString,
                beforeSend:  function() {
              
              	$('input#faq_search_input').addClass('loading');
              
                },
                success: function(server_response)
              {
              
                $('#searchresultdata').html(server_response).show();
                $('span#faq_category_title').html(faq_search_input);
                
                if ($('input#faq_search_input').hasClass("loading")) {
                 $("input#faq_search_input").removeClass("loading");
                  } 
              
              }
              });
              }return false;
            });
						
        });
//]]>
</script>

<style type="text/css">
  /*This css contains code for the statis loading image in the right of the textbox */
  .faqsearchinputbox input {
  	font-size:16px;
  	color:#6e6e6e;
  	padding:10px;
  	border:none;
  	background:url(images/loading_static.gif) no-repeat right 50%;
  	width:300px;
  }
  /*The css class below contains the animated loading image .this will be added on the dom later with Jquery*/
  .faqsearchinputbox input.loading {
  	background:url(/images/loading_animate.gif) no-repeat right 50%;
  }
</style>	

</head>
<body>
<div id='wrapper'>
<div id='top'>
<div id='logo'></div>
</div>
<div id='content'>
<h1>INNOVAPATH, INC. - Avatar</h1>

<br />
<br />
<div id='left-nav'><?php include($_SERVER["DOCUMENT_ROOT"] ."/project/admin/left-nav.php");  ?></div>
<div id='main'>
<div class="prod-content">
  <div class="faqsearch">
    <div class="faqsearchinputbox">
		  <!-- The Searchbox Starts Here  -->
      <input  name="query" type="text" id="faq_search_input" />
      <!-- The Searchbox Ends  Here  -->
    </div>
  </div>
  <div id="searchresultdata" class="faq-articles"> </div>
</div>
	
</div>
<div id='bottom'></div>
</div>
<br />
<br />
</body>
</html>