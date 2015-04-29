<?php 
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$userId = $loggedInUser->user_id;
$candidateID = $loggedInUser->candidateid;
if(!userIdExists($userId)){header("Location:login.php"); die();}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Candidate Project</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" />
<link rel="stylesheet" href="http://gregfranko.com/jquery.selectBoxIt.js/css/jquery.selectBoxIt.css" />
<link href="models/site-templates/default.css" rel='stylesheet' type='text/css' />
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script src="http://gregfranko.com/jquery.selectBoxIt.js/js/jquery.selectBoxIt.min.js"></script>
<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<link href="http://hayageek.github.io/jQuery-Upload-File/uploadfile.min.css" rel="stylesheet">
<script src="http://hayageek.github.io/jQuery-Upload-File/jquery.uploadfile.min.js"></script>
<style>  
.ui-menu { width: 130px; }  
.selectboxit-container .selectboxit-options {
    width: 250px;
    max-height: 240px;
  }
</style>
<script type="text/javascript">
  $(document).ready(function(){
      $(".link").button();
			$('#mymenu').menu();
			$('#loader').hide();
			$('#show_heading').hide();
			$('#show_content').hide();
			$('select').selectBoxIt();
			
			$('#project').change(function(){
				$('#show_content').fadeOut();
				if(inp.val().length > 0){          		
          		$('#loader').show();
				$.post("../ajax-content/get-can-project.php", {
          			parent_id: $('#project').val(),
          		}, function(response){          			
          			setTimeout("finishAjax('show_content', '"+escape(response)+"')", 400);
          		});			
				}
          		return false;
          	});		
						
			var inp = $("#project");
			if (inp.val().length > 0){
				$('#show_content').fadeOut();
				$('#loader').show();						
				$.post("../ajax-content/get-can-project.php", {
					parent_id: $('#project').val(),
				}, function(response){          			
					setTimeout("finishAjax('show_content', '"+escape(response)+"')", 400);
				});							
		  }							
										
        });
//]]>

function finishAjax(id, response){
	$('#loader').hide();
	$('#show_heading').show();
	$('#show_heading').empty();
	$('#'+id).html(unescape(response));
	$('#'+id).fadeIn();
	new nicEditor({maxHeight : 300}).panelInstance('notes');
	$('input').addClass("ui-corner-all");
	$('select').addClass("ui-corner-all");
	$('#send').button();	
	$("#fileuploader").uploadFile({
		url:"../utils/upload.php",
		fileName:"myfile",
		dragDropStr: "<span><b>Upload or Drop files here...</b></span>",
		formData: {"type":"projectfile","placementid":$('#project').val(),"companyname":$('#project').text()}
	});
} 

</script>
</head>
<body>
<div id='wrapper'>
<div id='top'>
  <div id='logo'></div>
</div>
<div id='content'>
  <br />
  <div id='left-nav'>
    <?php 
		include($_SERVER["DOCUMENT_ROOT"] ."/project/admin/left-nav.php");  
	?>
  </div>
  <div id='main'>
    <?php
  	$result = $mysqli->query("select p.id, CONCAT(cl.companyname, '- ', DATE_FORMAT(p.startdate,'%m.%d.%Y')) project from placement p, client cl, candidate c where c.candidateid = $candidateID and c.candidateid = p.candidateid and p.clientid = cl.id order by p.startdate desc, id desc limit 1");	
    $row = $result->fetch_row();
  	$placement = $row[0];
	
//	echo $po;

if (!empty($_POST))
{    
	$placementid = $_POST['placementid'];
	$notes = $_POST['notes'];
	if(isset($placementid))
	{
		$placement = $placementid;
	}				
	if(isset($notes))
	{
		$updatesql = "update placement p set p.projectdesc = '$notes' where p.id = $placementid";
		$retval = $mysqli->query($updatesql);				
	}	
}
?>
    <form action="can-project.php" id="form1" method="post"  enctype="multipart/form-data">
      <table width="80%" border="0" cellpadding="10" cellspacing="1" align="left">
        <tr>
          <td style="text-align:right; font-weight:bolder; width:10%"> Project:</td>
          <td><select style="width: 400px;" name="project"  id="project">
              <?php
    	 $query = "select p.id, CONCAT(cl.companyname, '- ', DATE_FORMAT(p.startdate,'%m.%d.%Y')) project from placement p, client cl, candidate c where c.candidateid = $candidateID and c.candidateid = p.candidateid and p.clientid = cl.id order by p.startdate desc, id desc";
	     $results = $mysqli->query($query);    
	     while($rows = $results->fetch_assoc())
       {?>
              <option value="<?php echo $rows['id'];?>" <?php if($placement == $rows['id']) { echo "selected";}  ?>><?php echo $rows['project'];?></option>
              <?php
    }?>
            </select></td>
        </tr>
      </table>
      <div class="both">
        <div id="show_content"> <img src="../../images/loader.gif" style="margin-top:0px; float:left" id="loader" alt="" /> </div>
      </div>
    </form>
    <?
    $mysqli->close();
?>
  </div>
</div>
<br />
<br />
</body>
</html>
