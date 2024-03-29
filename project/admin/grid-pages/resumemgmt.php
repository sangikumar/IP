<?php 
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$userId = $loggedInUser->user_id;
if(!userIdExists($userId)){
  header("Location: http://project/admin/login.php"); die();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Resume-Search</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" />
<link href="../../../css/newstyle.css" type="text/css" rel="stylesheet"/>
<link href="../models/site-templates/default.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="http://gregfranko.com/jquery.selectBoxIt.js/css/jquery.selectBoxIt.css" />
<style type="text">
<![CDATA[
        html, body {
        margin: 0;      /* Remove body margin/padding */
        padding: 0;
        overflow: hidden; /* Remove scroll bars on browser window */
        font-size: 75%;
        }
				
.styled-select select {
   background: transparent;
   width: 268px;
   padding: 5px;
   font-size: 16px;
   line-height: 1;
   border: 0;
   border-radius: 0;
   height: 34px;
   -webkit-appearance: none;
   }				
]]>
</style>
<script src="http://code.jquery.com/jquery-1.9.1.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="../../../js/jquery.watermark.js" type="text/javascript"></script>
<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script src="http://gregfranko.com/jquery.selectBoxIt.js/js/jquery.selectBoxIt.min.js"></script>
<script src='../models/funcs.js' type='text/javascript'></script>
<style>  .ui-menu { width: 130px; }  </style>
<script type="text/javascript">
//bkLib.onDomLoaded(function() {  });
//<![CDATA[

function notify() {
  alert( "changed" );
}
$("#resumeid").on( "change", notify );

    $(document).ready(function(){
        $(".link").button();
    		$('#mymenu').menu();
				$('#loader').hide();
				$('#show_heading').hide();							
				$("#faq_search_input").watermark("Search Candidates...");
				$('select').selectBoxIt();
				
				//select autocomplete
    		$('#faq_search_input').autocomplete({
				source:'../ajax-content/suggest_candidate.php', minLength:2,
				select: function( event, ui ) {
  				$("#faq_search_input").val(ui.item.value);
      		$('#show_candidate').fadeOut();
      		$('#loader').show();
      		$.post("../ajax-content/get-candidate-resume.php", {
      			parent_id: $('#faq_search_input').val(),
      		}, function(response){
      			
      			setTimeout("finishAjax('show_candidate', '"+escape(response)+"')", 400);
      		});							
      		return false;
				}		
				});	
				
				//return page after save
				var inp = $("#faq_search_input");
      	if (inp.val() != "Search Candidates..." && inp.val().length > 2){
          $.post("../ajax-content/get-candidate-resume.php", {
      			parent_id: $('#faq_search_input').val(),
      		}, function(response){      			
      			setTimeout("finishAjax('show_candidate', '"+escape(response)+"')", 400);
      		});							
        }		
					
    });
		
    function finishAjax(id, response){
      $('#loader').hide();
      $('#show_heading').show();
      $('#'+id).html(unescape(response));
      $('#'+id).fadeIn();
      $('input').addClass("ui-corner-all");
      $('select').selectBoxIt();
      $('#send').button();
			
    	$('#resumeid').change(function(){
    		$('#show_resume').fadeOut();
    		$('#loader').show();
    		$.post("../ajax-content/get-resume.php", {
    			parent_id: $('#resumeid').val() + "," + $('#candidateid').val(),
    		}, function(response){
    			setTimeout("finishAjax1('show_resume', '"+escape(response)+"')", 400);
    		});							
    		return false;
    	});		
			
  		//return page after save
  		var inp = $("#resumeid");
      	if (inp.val() != null){
      		$('#show_resume').fadeOut();
      		$('#loader').show();						
      		$.post("../ajax-content/get-resume.php", {
      			parent_id: $('#resumeid').val() + "," + $('#candidateid').val(),
      		}, function(response){          			
      			setTimeout("finishAjax1('show_resume', '"+escape(response)+"')", 400);
      		});							
      		//return false;
        }							
					
    }	
		
    function finishAjax1(id, response){
      $('#loader').hide();
      $('#'+id).html(unescape(response));
      $('#'+id).fadeIn();
    	new nicEditor({maxHeight : 300}).panelInstance('resumetext');
    	new nicEditor({maxHeight : 300}).panelInstance('resumenotes');
      $('input').addClass("ui-corner-all");
      $('select').selectBoxIt();
      $('#send').button();			
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
<h1>INNOVAPATH, INC. - Avatar</h1>
<br /><br />
<div id='left-nav'>
<?php 
include($_SERVER["DOCUMENT_ROOT"] ."left-nav.php");
?>
</div>
<div id='main'>

<?
if (!empty($_POST))
{    
    $resumetext = $_POST['resumetext'];
		$resumenotes = $_POST['resumenotes'];
		$resumekey = $_POST['resumekey'];
		$resumeid = $_POST['resumeid'];
		$candidateid = $_POST['candidateid'];
		$email = $_POST['email'];
		$link = $_POST['link'];
		
    	if($resumetext || $resumenotes){			
  			if($resumeid > 0)
  			{
        		$updatesql = "update resume p set p.resumetext = '$resumetext', p.resumenotes = '$resumenotes', p.link = '$link' where p.lock = 'N' and p.id = $resumeid";
					  $stmt = $mysqli->prepare($updatesql);
						$stmt->execute();
						$stmt->close();			
  			}
  			else
  			{
        		$updatesql = "INSERT INTO resume(resumekey,resumetext,resumenotes,link) VALUES ('$resumekey', '$resumetext', '$resumenotes', '$link')";
					  $stmt = $mysqli->prepare($updatesql);
						$stmt->execute();	
						$stmt->close();
					  $resumeid = $mysqli->insert_id;
						if($resumeid != 0)
						{
          		$updatesql = "insert into candidateresume(resumeid, candidateid) VALUES ($resumeid, $candidateid)";
						  $stmt = $mysqli->prepare($updatesql);
							$stmt->execute();	
							$stmt->close();
						}													
  			}  			
    	}	
}
?>

  <form action="resumemgmt.php" method="post">
    <div class="prod-content">
      <div class="faqsearch">
        <div class="faqsearchinputbox">
    			<input name="query" type="text" id="faq_search_input" value="<?php print $email; ?>" />						 
        </div>
				
      	<div class="both">
      		<h1 id="show_heading">&nbsp;</h1>
      		<div id="show_candidate">
      			<img src="../../../images/loader.gif" style="margin-top:8px; float:left" id="loader" alt="" />			
      		</div>
      	</div>		
				
      </div>
    </div>
		
	
    
  </form>	
</div>

<?
	$mysqli->close();
?>	

<div id='bottom'></div>
</div>
<br />
<br />
</body>
</html>