<?php 
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$userId = $loggedInUser->user_id;
if(!userIdExists($userId)){
  header("Location: recruitersearch.php"); die();
}

//require_once '../tabs.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Recruiter-Search</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" />
<link href="../../css/newstyle.css" type="text/css" rel="stylesheet"/>
<link href="models/site-templates/default.css" rel='stylesheet' type='text/css' />
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
<script src="../../js/jquery.watermark.js" type="text/javascript"></script>
<script src='models/funcs.js' type='text/javascript'></script>
<style>  .ui-menu { width: 130px; }  </style>
<script type="text/javascript">
//bkLib.onDomLoaded(function() {  });
//<![CDATA[
    $(document).ready(function(){
        $(".link").button();
    		$('#mymenu').menu();
				$('#loader').hide();
				$('#show_heading').hide();
				$("#faq_search_input").watermark("Seach recruiters...");
				$('#faq_search_input').autocomplete({
				source:'suggest_recruiter.php', minLength:2,
				select: function( event, ui ) {
  				$("#faq_search_input").val(ui.item.value);
      		$('#show_candidate').fadeOut();
      		$('#loader').show();
      		$.post("get-recruiter.php", {
      			parent_id: $('#faq_search_input').val(),
      		}, function(response){      			
      			setTimeout("finishAjax('show_candidate', '"+escape(response)+"')", 400);
      		});							
      		return false;
				}		
				});		
    });
		
    function finishAjax(id, response){
      $('#loader').hide();
      $('#show_heading').show();
      $('#'+id).html(unescape(response));
      $('#'+id).fadeIn();
			$( "#accordion" ).accordion({
      	 collapsible: true,
				 heightStyle: "content"
      });		
		  $("a").click(function() {
		  $(this).attr('target', '_blank');
        $(this).click();
      });				
    }		
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
  	background:url(images/loading_animate.gif) no-repeat right 50%;
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
<div id='left-nav'><?php include("left-nav.php");  ?></div>
<div id='main'>
  <form action="recruitersearch.php" method="post">
    <div class="prod-content">
      <div class="faqsearch">
        <div class="faqsearchinputbox">
    			<input name="query" type="text" id="faq_search_input" />						 
        </div>
				
      	<div class="both">
      		<h1 id="show_heading">&nbsp;</h1>
      		<div id="show_candidate">
      			<img src="../../images/loader.gif" style="margin-top:8px; float:left" id="loader" alt="" />			
      		</div>
      	</div>		
				
      </div>
    </div>
		
	
    
  </form>	
</div>
<div id='bottom'></div>
</div>
<br />
<br />
</body>
</html>