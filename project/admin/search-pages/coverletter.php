<?php 
require_once("/project/admin/models/config.php");
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
<title>Coverletter</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" />
<link rel="stylesheet" href="http://gregfranko.com/jquery.selectBoxIt.js/css/jquery.selectBoxIt.css" />
<link href="/css/jquery.tagsinput.css" type="text/css" rel="stylesheet"/>
<link href="/css/newstyle.css" type="text/css" rel="stylesheet"/>
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
<script src="/project/js/jquery.tagsinput.js"></script>
<script src="/project/js/jquery.tagsinput.min.js"></script>
<script src="/project/js/jquery.watermark.js" type="text/javascript"></script>
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
		$('input').addClass("ui-corner-all");
		$('select').addClass("ui-corner-all");		
		new nicEditor().panelInstance('description');
				//$('#mymenu').overlay();
});
//]]>
</script>
</head>
<body>
<div id='wrapper'>
<div id='top'>
  <div id='logo'></div>
</div>
<div id='content'>
  <h2>Candidate Coverletter</h2>
  <br />
  <div id='left-nav'>
    <?php include($_SERVER["DOCUMENT_ROOT"] ."/project/admin/left-nav.php");  ?>
  </div>
  <div id='main'>
    <?php 
      if (!empty($_POST))
      {    
        $description = $_POST['description'];
      	if($description){
	      		$updatesql = "update candidate p set p.coverletter = '$description' where p.portalid = $userid";
				    $retval = $mysqli->query($updatesql);
						echo $userid.'#';
						
      	}				
      }				
  		
		  $query = "select coverletter from candidate where portalid = '$userid'";
	    $result = $mysqli->query($query);
		  $num_rows = $result->num_rows;

 		  $row = $result->fetch_assoc();
      $description = 	$row['coverletter'];

	    $mysqli->close();		
			
			if($num_rows <= 0)
			{
			 echo "<span style='color:red'>Your marketing status is not setup yet.</span><br /><br />";
			 die();
			}				
			
		?>
    <form action="coverletter.php" method="post"  enctype="multipart/form-data">
      <table width="80%" border="0" cellspacing="5" cellpadding="5">
        <tr>
          <td>Coverletter:</td>
					
          <td><textarea name="description" type="text" id="description" rows="10" cols="80" maxlength="250">
			 				 <?php print $description; ?>
		</textarea></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="center"><input type="submit" name="Send" value="Update"></td>
        </tr>
      </table>
    </form>
  </div>
  <div id='bottom'></div>
</div>
<br />
<br />
</body>
</html>
