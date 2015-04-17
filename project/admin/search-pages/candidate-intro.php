<?php 
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$userId = $loggedInUser->user_id;	
if(!userIdExists($userId)){
  header("Location: login.php"); die();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Background and Resume</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" />
<link rel="stylesheet" href="http://gregfranko.com/jquery.selectBoxIt.js/css/jquery.selectBoxIt.css" />
<link href="models/site-templates/default.css" rel='stylesheet' type='text/css' />
<link href="exam/js/datepicker/zebra_datepicker.css" rel='stylesheet' type='text/css' />
<link href="http://hayageek.github.io/jQuery-Upload-File/uploadfile.min.css" rel="stylesheet">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script src="http://gregfranko.com/jquery.selectBoxIt.js/js/jquery.selectBoxIt.min.js"></script>
<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script src="http://innova-path.com/project/js/datepicker/zebra_datepicker.js" type="text/javascript"></script>
<script src="exam/js/numericInput.min.js" type="text/javascript"></script>
<script src="http://hayageek.github.io/jQuery-Upload-File/jquery.uploadfile.min.js"></script>
<style>  
.ui-menu { width: 130px; }  
.selectboxit-container .selectboxit-options {
    width: 250px;
    max-height: 240px;
  }
</style>
<script type="text/javascript">
//<![CDATA[
	$(document).ready(function(){
		$(".link").button();
		$('#mymenu').menu();
		$('select').selectBoxIt();
		$('input').addClass("ui-corner-all");
		$('select').addClass("ui-corner-all");		
		new nicEditor().panelInstance('background');
		$("#fileuploader").uploadFile({
			url:"../utils/upload.php",
			fileName:"myfile",
			dragDropStr: "<span><b>Upload or Drop resume here...</b></span>",
			formData: {"type":"originalresume","candidateid":$('#candidateid').val()}
		});		
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
  <h2>Candidate Introduction</h2>
  <br />
  <div id='left-nav'>
    <?php include($_SERVER["DOCUMENT_ROOT"] ."/project/admin/left-nav.php");  ?>
  </div>
  <div id='main'>
    <?php 

	if (!empty($_POST))
	{    
		$background = $_POST['background'];
		if($background){
			$updatesql = "update candidate c set c.background = '$background' where c.portalid = $userid";
		  $retval = $mysqli->query($updatesql);
		}				
	}				
	$query = "select c.background, c.candidateid from candidate c where c.portalid = $userid";
	$results = $mysqli->query($query);
	$row = $results->fetch_row();
	$background = 	$row[0];	
	$candidateid = 	$row[1];

	$mysqli->close();		
?>
    <form action="candidate-intro.php" method="post"  enctype="multipart/form-data">
	<input type="hidden" name="candidateid" id="candidateid" value="<?php print $candidateid; ?>"/>
      <table width="80%" border="0" cellspacing="5" cellpadding="5">
        <tr>
          <td style="font-weight:bold">Resume:</td>
          <td><div id="fileuploader">Upload</div></td>
        </tr>
        <tr>
          <td style="font-weight:bold">Background & Education:</td>
          <td><textarea name="background" type="text" id="background" rows="10" cols="80">
			 				 <?php print htmlspecialchars($background); ?>
		</textarea></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td style="text-align:center"><input type="submit" name="Send" value="Update"></td>
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
