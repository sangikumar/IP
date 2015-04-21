<?php 
require_once("/project/admin/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$userId = $loggedInUser->user_id;
if(!userIdExists($userId)){
  header("Location:login.php"); die();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Training Videos</title>
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
	$('#recordingid').change(function(){
	$('#show_recording').fadeOut();
	$('#loader').show();
	$.post("../ajax-content/get-video.php", {
	parent_id: $('#recordingid').val(),
	}, function(response){
	
	setTimeout("finishAjax('show_recording', '"+escape(response)+"')", 400);
	});							
	return false;
	});		
				
});
//]]>

function finishAjax(id, response){
	$('#loader').hide();
	$('#show_heading').show();
	$('#show_heading').empty();
	$('#show_heading').append($('#recordingid option:selected').text());
	$('#'+id).html(unescape(response));
	$('#'+id).fadeIn();
} 

</script>
<style type="text/css">

#show_recording { display: none; }

@media print
{
 	#mymenu { display: none; }
	#topmenu { display: none; }
	#recordingid { display: none; }
	#show_recording { display: block; }
}
</style>
</head>
<body>
<div id='wrapper'>
<div id='top'>
  <div id='logo'></div>
</div>
<div id='content'>
  <h2>Training Videos</h2>
  <br />
  <div id='left-nav'>
    <?php 

include($_SERVER["DOCUMENT_ROOT"] ."/project/admin/left-nav.php");
?>
  </div>
  <div id='main'>
    <form action="training-videos.php" id="form1" name="form1" method="post"  enctype="multipart/form-data">
      <table width="80%" border="0" cellspacing="5" cellpadding="5">
        <thead>
          <tr>
            <td>Recordings:</td>
            <td><select name="recordingid"  id="recordingid" size="10">
                <option value="0">Select from list...</option>
                <?php
		if ($loggedInUser->checkPermission(array(14)) || $loggedInUser->checkPermission(array(13))){
			 $query = "select sessiondate, description, videoid, category from can_recording where status = 'active' order by category, sessiondate desc, description";
		}
		else
		{
			 $query = "select sessiondate, description, videoid, category from emp_recording where status = 'active' order by category, sessiondate desc, description";
		}

   $results = $mysqli->query($query);

	while ($rows = $results->fetch_assoc())
    {?>
                <option value="<?php echo $rows['videoid'];?>"><?php echo $rows['category'] . " - " . $rows['description'] . " - " . $rows['sessiondate'];?></option>
                <?php
    }?>
              </select></td>
          </tr>
        </thead>
        <tbody id="show_recording">
        <img src="/images/loader.gif" style="margin-top:8px; float:left" id="loader" alt="" />
        </tbody>
        
      </table>
    </form>
    <?php
   $mysqli->close();
?>
  </div>
  <div id='bottom'></div>
</div>
<br />
<br />
</body>
</html>
