<?php

require_once("/project/admin/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$userId = $loggedInUser->user_id;
$candidateID = $loggedInUser->candidateid;
if(!userIdExists($userId)){
  header("Location:login.php"); die();
}
//require_once '../tabs.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Candidate Interview Management</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/project/themes/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/project/themes/ui.multiselect.css" />
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
<script src="/project/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script src='/project/admim/models/funcs.js' type='text/javascript'></script>
<script type="text/javascript">
//<![CDATA[
  $.jgrid.no_legacy_api = true;
  $.jgrid.useJSON = true;
//]]>
</script>
<script src="/project/js/jquery.jqGrid.min.js" type="text/javascript"></script>
<style>  .ui-menu { width: 130px; }  </style>
<script type="text/javascript">
//<![CDATA[
        $(document).ready(function(){
            $(".link").button();
						$('#mymenu').menu();
						$('#loader').hide();
						$('#show_heading').hide();
						
          	$('#interviewid').change(function(){
          		$('#show_interview').fadeOut();
          		$('#loader').show();
          		$.post("../ajax-content/get-candidateinterview.php", {
          			parent_id: $('#interviewid').val(),
          		}, function(response){
          			
          			setTimeout("finishAjax('show_interview', '"+escape(response)+"')", 400);
          		});							
          		return false;
          	});		
						
						
    				//return page after save
    				var inp = $("#interviewid");
          	if (inp.val() != null){
          		$('#show_interview').fadeOut();
          		$('#loader').show();						
          		$.post("../ajax-content/get-candidateinterview.php", {
          			parent_id: $('#interviewid').val(),
          		}, function(response){          			
          			setTimeout("finishAjax('show_interview', '"+escape(response)+"')", 400);
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
	new nicEditor().panelInstance('questions');
	new nicEditor().panelInstance('notes');
} 

</script>

<style type="text/css">

#show_candidate { display: none; }

@media print
{
 	#mymenu { display: none; }
	#topmenu { display: none; }
	#interviewid { display: none; }
	#show_interview { display: block; }
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
<div id='left-nav'>
<?php 

include($_SERVER["DOCUMENT_ROOT"] ."/project/admin/left-nav.php");
include_once ("/auth.php");
include_once ("/authconfig.php");
$connection = mysql_connect($dbhost, $dbusername, $dbpass);
$SelectedDB = mysql_select_db($dbname);	
?></div>
<div id='main'>

<?

if (!empty($_POST))
{    
  $questions = $_POST['questions'];
	$notes = $_POST['notes'];
	$interviewid = $_POST['interviewid'];
	
	if($interviewid) {
    if($questions){
      $updatesql = "update interview p set p.questions = '$questions', p.notes = '$notes' where p.id = $interviewid";
      $retval = mysql_query($updatesql, $connection);
    }				
	}	
}
?>

  <form action="candidateinterviewmgmt.php" id="form1" name="form1" method="post"  enctype="multipart/form-data">
	
    <h4>Select Interview:</h4>
		<select name="interviewid"  id="interviewid" size="5" style="width: 650px;">
		<?php
		
		$query = "select i.id, concat(i.interviewdate, '-', i.clientname, '-', i.`type`) as name from interview i where i.candidateid = $candidateID order by i.id desc";
		$results = mysql_query($query);
		
		while ($rows = mysql_fetch_assoc(@$results))
		{
		  if($interviewid == $rows['id'])
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
		
  	<div class="both">
  		<!--<h4 id="show_heading"></h4>-->
  		<div id="show_interview">
  			<img src="/images/loader.gif" style="margin-top:8px; float:left" id="loader" alt="" />
  		</div>
  	</div>		
		
		
  </form>	
	
<?
	mysql_close($connection);	
?>	
	
</div>
<div id='bottom'></div>
</div>
<br />
<br />
</body>
</html>