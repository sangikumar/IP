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
	<title>Recruiter Search</title>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" />
	<link rel="stylesheet" href="http://gregfranko.com/jquery.selectBoxIt.js/css/jquery.selectBoxIt.css" />
	<link href="/project/admin/models/site-templates/default.css" rel='stylesheet' type='text/css' />
	<link href="/project/js/jquery.tagsinput.css" type="text/css" rel="stylesheet"/>
	<link href="/css/newstyle.css" type="text/css" rel="stylesheet"/>
	<link href="/project/js/datepicker/zebra_datepicker.css" rel='stylesheet' type='text/css' />
	<link href="http://hayageek.github.io/jQuery-Upload-File/uploadfile.min.css" rel="stylesheet">
	<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<script src="http://gregfranko.com/jquery.selectBoxIt.js/js/jquery.selectBoxIt.min.js"></script>
	<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
	<script src="/project/js/datepicker/zebra_datepicker.js" type="text/javascript"></script>
	<script src="/project/js/numericInput.min.js" type="text/javascript"></script>
	<script src="/project/js/jquery.tagsinput.js"></script>
	<script src="/project/js/jquery.tagsinput.min.js"></script>
	<script src="/project/js/jquery.watermark.js" type="text/javascript"></script>
	<script src='/project/admin/models/funcs.js' type='text/javascript'></script>
	<script src="http://hayageek.github.io/jQuery-Upload-File/jquery.uploadfile.min.js"></script>
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
		$('select').selectBoxIt();
		//$("#faq_search_input").watermark("Search recruiters...");
		$('#faq_search_input').autocomplete({
			source:'../ajax-content/suggest_recruiter.php', minLength:2,
			select: function( event, ui ) {
				$("#faq_search_input").val(ui.item.value);
				$('#show_document').fadeOut();
				$('#loader').show();
				$.post("../ajax-content/get-recruiter.php", {
				parent_id: $('#faq_search_input').val(),
				}, function(response){
				setTimeout("finishAjax('show_document', '"+escape(response)+"')", 400);
				});
				return false;
			}
		});
		var inp = $("#faq_search_input");
		if (inp.val().length > 0){
			$('#show_document').fadeOut();
			$('#loader').show();
			$.post("../ajax-content/get-recruiter.php", {
				parent_id: $('#faq_search_input').val(),
			}, function(response){
				setTimeout("finishAjax('show_document', '"+escape(response)+"')", 400);
			});
		}
	});
		
    function finishAjax(id, response){
		$('#loader').hide();
		$('#show_heading').show();
		$('#'+id).html(unescape(response));
		$('#'+id).fadeIn();
		$( "#tabs" ).tabs();
		new nicEditor({maxHeight : 300}).panelInstance('notes');
		new nicEditor({maxHeight : 300}).panelInstance('callnotes');
		new nicEditor({maxHeight : 300}).panelInstance('meetnotes');
		$('input').addClass("ui-corner-all");
		$('select').addClass("ui-corner-all");
		$('#send').button();

		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();

		if(dd<10) {
			dd='0'+dd
		}

		if(mm<10) {
			mm='0'+mm
		}
		today = yyyy+'-'+mm+'-'+dd;

		$('#dob').Zebra_DatePicker();
		$('#calldate').Zebra_DatePicker();
		$("#calldate").val(today);
		$('#meetdate').Zebra_DatePicker();
		$("#meetdate").val(today);
		$('select').selectBoxIt();
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
  	background:url(/images/loading_static.gif) no-repeat right 50%;
  	width:500px;
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
<h1>Recruiter Search</h1>
<div id='left-nav'><?php include($_SERVER["DOCUMENT_ROOT"] ."/project/admin/left-nav.php");  ?></div>
<div id='main'>
	<?php

	$email = "";
	if (!empty($_POST))
	{
		$recruiterid = $_POST['recruiterid'];
		if($_POST['send'])
		{
			$email = $_POST['email'];
			$name = $_POST['name'];
			$phone = $_POST['phone'];
			$designation = $_POST['designation'];
			$notes = $_POST['notes'];
			$vendorid = $_POST['vendorid'];
			$clientid = $_POST['clientid'];
			$status = $_POST['status'];
			$personalemail = $_POST['personalemail'];
			$dob = $_POST['dob'];
			$skypeid = $_POST['skypeid'];
			$linkedin = $_POST['linkedin'];
			$notes = $_POST['notes'];

			$updatesql = "update recruiter p set p.notes = '$notes', p.name = '$name', p.phone = '$phone', p.designation = '$designation', p.status = '$status', p.personalemail = '$personalemail', p.dob = '$dob', p.skypeid = '$skypeid', p.linkedin = '$linkedin', p.vendorid = $vendorid, p.clientid = $clientid where p.id = $recruiterid";
			$retval = $mysqli->query($updatesql);
		}

		if($_POST['CallSend'])
		{
			$email = $_POST['email'];
			$calldate = $_POST['calldate'];
			$callnotes = $_POST['callnotes'];
			$candidateid = $_POST['candidateid'];
			$position = $_POST['position'];
			$rate = $_POST['rate'];
			$employeeid = $_POST['employeeid'];
			$updatesql = "insert into vendorcalls(recruiterid, candidateid, employeeid, position, rate, calldate, notes) values ($recruiterid, $candidateid, $employeeid, '$position', $rate, '$calldate', '$callnotes')";
			$retval = $mysqli->query($updatesql);
		}


		if($_POST['MeetSend'])
		{
			$email = $_POST['email'];
			$meetdate = $_POST['meetdate'];
			$meetnotes = $_POST['meetnotes'];
			$employeeid = $_POST['employeeid'];
			$updatesql = "insert into vendormeet(recruiterid, employeeid, meetdate, notes) values ($recruiterid, $employeeid, '$meetdate', '$meetnotes')";
			$retval = $mysqli->query($updatesql);
		}
	}
	?>
  <form action="recruitersearch.php" method="post">
    <div class="prod-content">
      <div class="faqsearch">
        <div class="faqsearchinputbox" style="width: 100%">
    			<input name="query" type="text" id="faq_search_input" value="<?php print $email; ?>"/>
        </div>
				
      	<div class="both">
      		<h1 id="show_heading">&nbsp;</h1>
      		<div id="show_document">
      			<img src="/images/loader.gif" style="margin-top:8px; float:left" id="loader" alt="" />
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