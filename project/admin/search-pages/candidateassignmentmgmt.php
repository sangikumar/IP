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
<title>Candidate Answer Management</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" />
<link rel="stylesheet" href="http://gregfranko.com/jquery.selectBoxIt.js/css/jquery.selectBoxIt.css" />
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
			//$('select').selectBoxIt();
			$('input').addClass("ui-corner-all");
			$('select').addClass("ui-corner-all");								
			$('#assignmentid').change(function(){
			$('#show_question').fadeOut();
			$('#loader').show();
			$.post("../ajax-content/get-assignment.php", {
			parent_id: $('#assignmentid').val(),
			}, function(response){
			
			setTimeout("finishAjax('show_assignment', '"+escape(response)+"')", 400);
			});							
			return false;
		});		
						
    				//return page after save
		var inp = $("#assignmentid");
		if (inp.val() != null){
		$('#show_question').fadeOut();
		$('#loader').show();		
		$('input').addClass("ui-corner-all");
		$('select').addClass("ui-corner-all");					
		$.post("../ajax-content/get-assignment.php", {
		parent_id: $('#assignmentid').val(),
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
	new nicEditor().panelInstance('assignment');
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
  <h2>Candidate Assignments</h2>
  <br />
  <div id='left-nav'>
    <?php include($_SERVER["DOCUMENT_ROOT"] ."left-nav.php");  ?>
  </div>
  <div id='main'>
  </div>
  <div id='main'>
    <?

if (!empty($_POST))
{    
  $assignment = $_POST['assignment'];
	$candidateassignmentid = $_POST['candidateassignmentid'];
	$assignmentid = $_POST['assignmentid'];
	$category = $_POST['category'];
	
	if($candidateassignmentid) {
    if($assignment){
      $updatesql = "update candidateassignment p set p.assignment = '$assignment' where p.id = $candidateassignmentid";
 	    $retval = $mysqli->query($updatesql);
    }				
	}
	else
	{
	    $insertsql = "insert into candidateassignment(assignmentid, candidateid, assignment) values ($assignmentid, $candidateID, '$assignment')";
		  $retval = $mysqli->query($insertsql);	
	}
}
?>
    <form action="candidateassignmentmgmt.php" id="form1" name="form1" method="post"  enctype="multipart/form-data">
      <table width="90%" border="0" cellspacing="5" cellpadding="5">
        <thead>
          <tr>
            <td><strong>Select Assignment Question:</strong></td>
            <td><select name="assignmentid"  id="assignmentid" size="5" style="width: 650px;">
                <?php
		
		$query = "SELECT distinct id, concat('Week - ', weeknumber, ' - ', (select category from ip_subjectcategory where id = categoryid ) , ' - ', (select subcategory from ip_subjectsubcategory where id = subcategoryid ), ' - ', question  ) as name FROM ip_assignment order by weeknumber";
		$results = $mysqli->query($query);
	  while($rows = $results->fetch_assoc())
		{
		  if($assignmentid == $rows['id'])
			{
  		?>
                <option selected style="height: 35px;" value="<?php echo $rows['id'];?>"><?php echo $rows['name'];?></option>
                <?php
		  }
			else
			{
  		?>
                <option style="height: 35px;" value="<?php echo $rows['id'];?>"><?php echo $rows['name'];?></option>
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
