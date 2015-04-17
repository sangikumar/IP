<?php 
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$userId = $loggedInUser->user_id;
if(!userIdExists($userId)){
  header("Location: candidate-default.php"); die();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Candidate Default Management</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" />
<link rel="stylesheet" type="text/css" media="screen" href="../themes/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="../themes/ui.multiselect.css" />
<link rel="stylesheet" href="http://gregfranko.com/jquery.selectBoxIt.js/css/jquery.selectBoxIt.css" />
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
<script src="http://gregfranko.com/jquery.selectBoxIt.js/js/jquery.selectBoxIt.min.js"></script>
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
						$('input').addClass("ui-corner-all");
						$('select').addClass("ui-corner-all");
          	$('#candidateid').change(function(){
          		$('#show_candidate').fadeOut();
          		$('#loader').show();
          		$.post("get-candidate-default.php", {
          			parent_id: $('#candidateid').val(),
          		}, function(response){
          			
          			setTimeout("finishAjax('show_candidate', '"+escape(response)+"')", 400);
          		});							
          		return false;
          	});		

        		var inp = $("#candidateid");
            	if (inp.val() != 0){
            		$('#show_document').fadeOut();
            		$('#loader').show();						
            		$.post("get-candidate-default.php", {
            			parent_id: $('#candidateid').val(),
            		}, function(response){          			
            			setTimeout("finishAjax('show_document', '"+escape(response)+"')", 400);
            		});							
              }		
										
        });
//]]>

function finishAjax(id, response){
  $('#loader').hide();
  $('#show_heading').show();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
	new nicEditor().panelInstance('reason');
	new nicEditor().panelInstance('comments');
	$('input').addClass("ui-corner-all");
	$('select').addClass("ui-corner-all");
	$('#send').button();	
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
  $canid = $_POST['canid'];
  $comments = $_POST['comments'];
  $reason = $_POST['reason'];
	if($canid) {
    if($comments || $reason){
      $updatesql = "update candidatedefault p set p.reason = '$reason', p.comments = '$comments' where p.candidateid = $canid";
      $retval = mysql_query($updatesql, $connection);
    }		
	}
			
}
?>

  <form action="candidate-default.php" id="form1" name="form1" method="post"  enctype="multipart/form-data">
	
		<h4>Select Candidate:
		<select name="candidateid"  id="candidateid">
		<?php
		$query = "select 0 as candidateid, ' Select ...' as name from dual union select c.candidateid, c.name from candidate c, candidatedefault cd where c.candidateid = cd.candidateid order by name";
		$results = mysql_query($query);
		
		while ($rows = mysql_fetch_assoc(@$results))
		{?>
			<option style="height: 35px;" value="<?php echo $rows['candidateid'];?>" <?php if($canid == $rows['candidateid']) { echo "selected";}  ?>><?php echo $rows['name'];?></option>
		<?php
		}?>		
		</select>	</h4>
		
  	<div class="both">
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