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
<title>Resumes-Search</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" />
<link rel="stylesheet" href="http://gregfranko.com/jquery.selectBoxIt.js/css/jquery.selectBoxIt.css" />
<link href="exam/css/jquery.tagsinput.css" type="text/css" rel="stylesheet"/>
<link href="css/newstyle.css" type="text/css" rel="stylesheet"/>
<link href="models/site-templates/default.css" rel='stylesheet' type='text/css' />
<link href="exam/js/datepicker/zebra_datepicker.css" rel='stylesheet' type='text/css' />
<link href="http://hayageek.github.io/jQuery-Upload-File/uploadfile.min.css" rel="stylesheet">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script src="http://gregfranko.com/jquery.selectBoxIt.js/js/jquery.selectBoxIt.min.js"></script>
<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script src="exam/js/datepicker/zebra_datepicker.js" type="text/javascript"></script>
<script src="exam/js/numericInput.min.js" type="text/javascript"></script>
<script src="http://hayageek.github.io/jQuery-Upload-File/jquery.uploadfile.min.js"></script>
<script src="exam/js/jquery.tagsinput.js"></script>
<script src="exam/js/jquery.tagsinput.min.js"></script>
<script src="exam/js/jquery.watermark.js" type="text/javascript"></script>
<script src='models/funcs.js' type='text/javascript'></script>
<style>  
.ui-menu { width: 130px; }  
</style>
<script type="text/javascript">
//bkLib.onDomLoaded(function() {  });
//<![CDATA[
        $(document).ready(function(){
            $(".link").button();
			$('#mymenu').menu();				
            $("#faq_search_input").watermark("Search resume notes....");
            
          $("#faq_search_input").keyup(function()
          {
              var faq_search_input = $(this).val();
              var dataString = 'keyword='+ faq_search_input;
              if(faq_search_input.length>2)            
              {
                $.ajax({
                type: "GET",
                url: "../ajax-content/get-resumelist.php",
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
          			$( "#accordion" ).accordion({
						collapsible: true,
						active: false,
						heightStyle: "content"
                });										               
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
  <h2>Resume Notes Search</h2>
  <br />
  <div id='left-nav'>
    <?php include($_SERVER["DOCUMENT_ROOT"] ."/project/admin/left-nav.php");  ?>
  </div>
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
