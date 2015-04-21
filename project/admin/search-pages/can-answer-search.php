<?php 
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$userId = $loggedInUser->user_id;
$candidateID = $loggedInUser->candidateid;
if(!userIdExists($userId)){
  header("Location:login.php"); die();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Candidate Answer Search</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" />
<link rel="stylesheet" href="http://gregfranko.com/jquery.selectBoxIt.js/css/jquery.selectBoxIt.css" />
<link href="/css/jquery.tagsinput.css" type="text/css" rel="stylesheet"/>
<link href=/css/newstyle.css" type="text/css" rel="stylesheet"/>
<link href="/project/admin/models/site-templates/default.css" rel='stylesheet' type='text/css' />
<link href="/project/js/datepicker/zebra_datepicker.css" rel='stylesheet' type='text/css' />
<link href="http://hayageek.github.io/jQuery-Upload-File/uploadfile.min.css" rel="stylesheet">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script src="http://gregfranko.com/jquery.selectBoxIt.js/js/jquery.selectBoxIt.min.js"></script>
<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script src="/project/js/datepicker/zebra_datepicker.js" type="text/javascript"></script>
<script src="/project/js/numericInput.min.js" type="text/javascript"></script>
<script src="http://hayageek.github.io/jQuery-Upload-File/jquery.uploadfile.min.js"></script>
<script src="/js/jquery.tagsinput.js"></script>
<script src="/js/jquery.tagsinput.min.js"></script>
<script src="/js/jquery.watermark.js" type="text/javascript"></script>
<script src='/project/admin/models/funcs.js' type='text/javascript'></script>
<style>  
.ui-menu { width: 130px; }  
</style>
<script type="text/javascript">
//bkLib.onDomLoaded(function() {  });
//<![CDATA[
    $(document).ready(function(){
		$(".link").button();
		$('#mymenu').menu();
		$('#loader').hide();
		$('#show_heading').hide();	
		$('input').addClass("ui-corner-all");
		$('select').addClass("ui-corner-all");											
		$("#faq_search_input").watermark("Search answers...");				
		
		$('#faq_search_input').autocomplete({
			source:'../ajax-content/suggest_question.php', minLength:2,
			select: function( event, ui ) {
				$("#faq_search_input").val(ui.item.value);
				$('#show_content').fadeOut();
				$('#loader').show();
				$.post("../ajax-content/get-answers.php", {
				parent_id: $('#faq_search_input').val(),
			}, function(response){      			
				setTimeout("finishAjax('show_content', '"+escape(response)+"')", 400);
			});							
			return false;
			}	
		});		
    });
		
    function finishAjax(id, response){
      $('#loader').hide();
	  $('input').addClass("ui-corner-all");
	  $('select').addClass("ui-corner-all");	  
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
  	width:600px;
  }
  /*The css class below contains the animated loading image .this will be added on the dom later with Jquery*/
  .faqsearchinputbox input.loading {
  	background:url(images/loading_animate.gif) no-repeat right 50%;
  }

  #show_candidate { display: none; }
  
  @media print
  {
   	#mymenu { display: none; }
	h1 { display: none; }
  	#topmenu { display: none; }
  	#candidateid { display: none; }
  	#show_candidate { display: block; }
  }
	
</style>
</head>
<body>
<div id='wrapper'>
<div id='top'>
  <div id='logo'></div>
</div>
<div id='content'>
  <h2>Candidate Answers Search</h2>
  <br />
  <div id='left-nav'>
    <?php include($_SERVER["DOCUMENT_ROOT"] ."/project/admin/left-nav.php");  ?>
  </div>
  <div id='main'>
    <form action="can-answer-search.php" method="post">
      <div class="prod-content">
        <div class="faqsearch">
          <div class="faqsearchinputbox">
           <input name="query" type="text" id="faq_search_input" />
          </div>
          <div class="both">
            <h1 id="show_heading">&nbsp;</h1>
            <div id="show_content"> <img src="/images/loader.gif" style="margin-top:8px; float:left" id="loader" alt="" /> </div>
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
