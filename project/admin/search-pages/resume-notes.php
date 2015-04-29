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
<title>Resume Notes</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" />
<link rel="stylesheet" href="http://gregfranko.com/jquery.selectBoxIt.js/css/jquery.selectBoxIt.css" />
<link href="http://project/admin/models/site-templates/default.css" rel='stylesheet' type='text/css' />
<link href="http://project/js/datepicker/zebra_datepicker.css" rel='stylesheet' type='text/css' />
<link href="http://hayageek.github.io/jQuery-Upload-File/uploadfile.min.css" rel="stylesheet">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script src="http://gregfranko.com/jquery.selectBoxIt.js/js/jquery.selectBoxIt.min.js"></script>
<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script src="http://project/js/datepicker/zebra_datepicker.js" type="text/javascript"></script>
<script src="http://project/js/numericInput.min.js" type="text/javascript"></script>
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
			$('input').addClass("ui-corner-all");
			$('select').addClass("ui-corner-all");				
			$('#resumeid').change(function(){
			$('#show_resume').fadeOut();
			$('#loader').show();
			$.post("../ajax-content/get-resume.php", {
			parent_id: $('#resumeid').val(),
			}, function(response){
			setTimeout("finishAjax('show_resume', '"+escape(response)+"')", 400);
			});							
			return false;
          	});		
						
			//return page after save
			var inp = $("#resumeid");
			if (inp.val() != null){
			$('#show_resume').fadeOut();
			$('#loader').show();						
			$.post("../ajax-content/get-resume.php", {
				parent_id: $('#resumeid').val(),
			}, function(response){          			
				setTimeout("finishAjax('show_resume', '"+escape(response)+"')", 400);
			});							
			//return false;
			}							
										
        });
//]]>

function finishAjax(id, response){
  $('#loader').hide();
  $('#show_heading').show();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
	new nicEditor({maxHeight : 300}).panelInstance('resumetext');
	new nicEditor({maxHeight : 300}).panelInstance('resumenotes');
} 

</script>
<style type="text/css">

#show_resume { display: none; }

@media print
{
 	#mymenu { display: none; }
	#topmenu { display: none; }
	#resumeid { display: none; }
	#show_resume { display: block; }
}
</style>
</head>
<body>
<div id='wrapper'>
<div id='top'>
  <div id='logo'></div>
</div>
<div id='content'>
  <h2>Resume Notes</h2>
  <br />
  <div id='left-nav'>
    <?php include($_SERVER["DOCUMENT_ROOT"] ."/project/admin/left-nav.php");  ?>
  </div>
  <div id='main'>
    <?php 
		/*
      include_once ("../../auth.php");
      include_once ("../../authconfig.php");
      
      $connection = mysql_connect($dbhost, $dbusername, $dbpass);
      $SelectedDB = mysql_select_db($dbname);	
			*/
      if (!empty($_POST))
      {    
        $resumetext = $_POST['resumetext'];
				$resumenotes = $_POST['resumenotes'];
				$resumekey = $_POST['resumekey'];
				$resumeid = $_POST['resumeid'];
				
      	if($resumetext || $resumenotes){
					
					if($resumeid > 0)
					{
                      $updatesql = "update resume p set p.resumetext = '$resumetext', p.resumenotes = '$resumenotes' where p.lock = 'N' and p.id = $resumeid";
                      $retval = $mysqli->query($updatesql);
					}
					else
					{
                        $updatesql = "INSERT INTO resume(resumekey,resumetext,resumenotes) VALUES ('$resumekey', '$resumetext', '$resumenotes')";
                        $retval = $mysqli->query($updatesql);
                        $resumeid = $retval->insert_id;
                        $updatesql = "insert into candidateresume(resumeid, candidateid) VALUES ($resumeid, $candidateID)";
                        $retval = $mysqli->query($updatesql);
					}
					
      	}				
      }				

		?>
    <form action="resume-notes.php" method="post" id="form1" name="form1"  enctype="multipart/form-data">
      <table width="80%" border="0" cellspacing="5" cellpadding="5">
        <thead>
          <tr>
            <td>Resumes:</td>
            <td><select name="resumeid"  id="resumeid" style="width: 300px;">
                <?php
    $query = "select * from (select r.id, r.resumekey from resume r where r.id in (select cm.resumeid from candidateresume cm where cm.candidateid = $candidateID and cm.resumeid is not null) union select 0 as id, 'Create New Resume') s order by id desc";
    $results = $mysqli->query($query);
    while ($rows = $results->fetch_assoc())
    {?>
                <option value="<?php echo $rows['id'];?>" <?php if($resumeid == $rows['id']) { echo "selected";}  ?>><?php echo $rows['resumekey'];?></option>
                <?php
    }?>
              </select></td>
          </tr>
        </thead>
        <br />
        <tbody id="show_resume">
        <img src="../../images/loader.gif" style="margin-top:8px; float:left" id="loader" alt="" />
        </tbody>
        
        <tfoot>
          <tr>
            <td>&nbsp;</td>
            <td align="left"><input type="submit" name="Send" value="Update Resume"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </tfoot>
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
