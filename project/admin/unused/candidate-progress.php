<?php 
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$userId = $loggedInUser->user_id;
if(!userIdExists($userId)){
  header("Location: candidate-progress.php"); die();
}
if($_GET['userid'] != $userId){
 // header("Location: projectfilesupload.php"); die();
}
//require_once '../tabs.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Candidate Progress</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" />
<link rel="stylesheet" type="text/css" media="screen" href="../themes/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="../themes/ui.multiselect.css" />
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
<script src="../js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script src='models/funcs.js' type='text/javascript'></script>
<script type="text/javascript">
//<![CDATA[
  $.jgrid.no_legacy_api = true;
  $.jgrid.useJSON = true;
//]]>
</script>
<script src="../js/jquery.jqGrid.min.js" type="text/javascript"></script>
<style>  .ui-menu { width: 130px; }  </style>
<script type="text/javascript">
//<![CDATA[
        $(document).ready(function(){
            $(".link").button();
						$('#mymenu').menu();
						$('#loader').hide();
						$('#show_heading').hide();
						
          	$('#candidateid').change(function(){
          		$('#show_candidate').fadeOut();
          		$('#loader').show();
          		$.post("get-candidate-progress.php", {
          			parent_id: $('#candidateid').val(),
          		}, function(response){
          			
          			setTimeout("finishAjax('show_candidate', '"+escape(response)+"')", 400);
          		});							
          		return false;
          	});		
										
        });
//]]>

function finishAjax(id, response){
  $('#loader').hide();
  $('#show_heading').show();
	$('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
	$('#accordion').accordion();

	
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
<h1>INNOVAPATH, INC. - Avatar</h1>

<br />
<br />
<div id='left-nav'>
<?php 

include("left-nav.php");  
include_once ("../../auth.php");
include_once ("../../authconfig.php");
$connection = mysql_connect($dbhost, $dbusername, $dbpass);
$SelectedDB = mysql_select_db($dbname);	
?></div>
<div id='main'>

<?

if (!empty($_POST))
{    
  $attendance = $_POST['attendance'];
  $communication = $_POST['communication'];
  $attitude = $_POST['attitude'];
  $hardworking = $_POST['hardworking'];
  $assignments = $_POST['assignments'];
	$exams = $_POST['exams'];
	$projects = $_POST['projects'];
	$assesment = $_POST['assesment'];
	$candidateprogressid = $_POST['candidateprogressid'];
	$candidateid = $_POST['candidateid'];

	if($attendance || $communication || $attitude || $hardworking || $assignments || $exams || $projects || $assesment){
  	if($candidateprogressid) {
        $updatesql = "update candidateprogress p set p.attendance = '$attendance', p.communication = '$communication', p.attitude = '$attitude', p.hardworking = '$hardworking', p.assignments = '$assignments', p.exams = '$exams', p.projects = '$projects', p.assesment = '$assesment' where p.id = $candidateprogressid";
        $retval = mysql_query($updatesql, $connection);
  	}
  	else
  	{
        $insertsql = "INSERT INTO candidateprogress(candidateid,type,communication,attitude,hardworking,attendance,exams,assignments,projects,assesment) values ($candidateid,'Normal','$communication','$attitude','$hardworking','$attendance','$exams','$assignments','$projects','$assesment')";
        $retval = mysql_query($insertsql, $connection);  
  	}
	}
			
}
?>

  <form action="candidate-progress.php" id="form1" name="form1" method="post"  enctype="multipart/form-data">
	
		<h4>Select Candidate:</h4>
		<select name="candidateid"  id="candidateid" size="10">
		<?php
		$query = "select candidateid as id, c.name from candidate c where c.status = 'Active' order by name";
		$results = mysql_query($query);
		
		while ($rows = mysql_fetch_assoc(@$results))
		{?>
			<option style="height: 35px;" value="<?php echo $rows['id'];?>"><?php echo $rows['name'];?></option>
		<?php
		}?>		
		</select>	
		
  	<div class="both">
  		<h4 id="show_heading">Candidate Info</h4>
  		<div id="show_candidate">
  			<img src="../../images/loader.gif" style="margin-top:8px; float:left" id="loader" alt="" />			
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