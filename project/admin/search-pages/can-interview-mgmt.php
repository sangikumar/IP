<?php 
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$userId = $loggedInUser->user_id;
$candidateID = $loggedInUser->candidateid;
if(!userIdExists($userId)){
  header("Location: login.php"); die();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Candidate Interview Management</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" />
<link rel="stylesheet" href="http://gregfranko.com/jquery.selectBoxIt.js/css/jquery.selectBoxIt.css" />
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
<style>  
.ui-menu { width: 130px; }  
</style>
<script type="text/javascript">
//<![CDATA[
	$(document).ready(function(){
			$(".link").button();
			$('#mymenu').menu();
			$('#loader').hide();
			$('#show_heading').hide();
			$('select').selectBoxIt();
			$('input').addClass("ui-corner-all");
			$('select').addClass("ui-corner-all");								
			$('#interviewid').change(function(){
			$('#show_question').fadeOut();
			$('#loader').show();
			$.post("../ajax-content/get-interview-questions.php", {
			parent_id: $('#interviewid').val(),
			}, function(response){
			
			setTimeout("finishAjax('show_assignment', '"+escape(response)+"')", 400);
			});							
			return false;
		});		
						
    				//return page after save
		var inp = $("#interviewid");
		if (inp.val() != null){
		$('#show_question').fadeOut();
		$('#loader').show();		
		$('input').addClass("ui-corner-all");
		$('select').addClass("ui-corner-all");					
		$.post("../ajax-content/get-interview-questions.php", {
		parent_id: $('#interviewid').val(),
		}, function(response){          			
		setTimeout("finishAjax('show_assignment', '"+escape(response)+"')", 400);
		});							
		return false;
		}								
										
        });
//]]>

function finishAjax(id, response){
	$('#loader').hide();
	$('#show_heading').show();
	$('#'+id).html(unescape(response));
	$('#'+id).fadeIn();
	$('input').addClass("ui-corner-all");
	$('select').addClass("ui-corner-all");		
	new nicEditor().panelInstance('questions');
} 

</script>
<style type="text/css">

#show_candidate { display: none; }

@media print
{
 	#mymenu { display: none; }
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
  <h2>Candidate Interview Questions</h2>
  <br />
  <div id='left-nav'>
    <?php include($_SERVER["DOCUMENT_ROOT"] ."/project/admin/left-nav.php");  ?>
  </div>

  <div id='main'>
    <?

if (!empty($_POST))
{    
    $interviewid = $_POST['interviewid'];
	$interviewers = $_POST['interviewers'];
	$interviewersphone = $_POST['interviewersphone'];
	$questions = $_POST['questions'];
	
	if($interviewid) {
		if($questions || $interviewersphone || $interviewers){
		  $updatesql = "update interview p set p.interviewersphone = '$interviewersphone', p.interviewers = '$interviewers', p.questions = '$questions' where p.id = $interviewid";
	    $retval = $mysqli->query($updatesql);
		}				
	}
}
?>
    <form action="can-interview-mgmt.php" id="form1" name="form1" method="post"  enctype="multipart/form-data">
      <table width="80%" border="0" cellspacing="5" cellpadding="5">
        <thead>
          <tr>
            <td><strong>Select Interview:</strong></td>
            <td><select name="interviewid"  id="interviewid" style="width: 50%;">
			<option value="0">Select Interview...</option>
                <?php
		
		$query = "SELECT id, concat(interviewdate, ' - ', clientname, ' - ', type) as info, i.* from interview i where i.candidateid = $candidateID order by interviewdate desc";
    $results = $mysqli->query($query);
    while ($rows = $results->fetch_assoc())
		{
		  if($interviewid == $rows['id'])
			{
  		?>
                <option selected value="<?php echo $rows['id'];?>"><?php echo $rows['info'];?></option>
                <?php
		  }
			else
			{
  		?>
                <option value="<?php echo $rows['id'];?>"><?php echo $rows['info'];?></option>
                <?php
		  }		
		
		}?>
              </select>
            </td>
          </tr>
        </thead>
        <tbody id="show_assignment">
        <img src="../../images/loader.gif" style="margin-top:8px; float:left" id="loader" alt="" />
        </tbody>
        
        <tfoot>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
        </tfoot>
      </table>
      <div class="both"> </div>
    </form>
    <?
  $mysqli->close();	
?>
  </div>
  <div id='bottom'></div>
</div>
<br />
<br />
</body>
</html>