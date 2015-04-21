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
				$('.selectBoxIt').selectBoxIt();
				$('input').addClass("ui-corner-all");
				$('select').addClass("ui-corner-all");	
				$('#questionid').change(function(){
				$('#show_content').fadeOut();
				$('#loader').show();
				$.post("../ajax-content/get-question.php", {
				parent_id: $('#questionid').val(),
				}, function(response){				
				setTimeout("finishAjax('show_content', '"+escape(response)+"')", 400);
				});							
				return false;
          	});		
						
						
    				//return page after save
			var inp = $("#questionid");
			if (inp.val() != null){
			$('#show_content').fadeOut();
			$('#loader').show();						
			$.post("../ajax-content/get-question.php", {
			parent_id: $('#questionid').val(),
			}, function(response){          			
			setTimeout("finishAjax('show_content', '"+escape(response)+"')", 400);
			});							
			return false;
			}									
										
        });
//]]>

function finishAjax(id, response){
	$('#loader').hide();
	$('#'+id).html(unescape(response));
	$('#'+id).fadeIn();
	$('.selectBoxIt').selectBoxIt();
	$('input').addClass("ui-corner-all");
	$('select').addClass("ui-corner-all");	
	new nicEditor().panelInstance('candidateanswer');
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
  <h2>Candidate Answers</h2>
  <br />
  <div id='left-nav'>
    <?php 

include($_SERVER["DOCUMENT_ROOT"] ."/project/admin/left-nav.php");  

?>
  </div>
  <div id='main'>
    <?

if (!empty($_POST))
{    
    $candidateanswer = $_POST['candidateanswer'];
	$candidateanswerid = $_POST['candidateanswerid'];
	$questionid = $_POST['questionid'];
	$category = $_POST['category'];
	
	if($candidateanswerid) {
		if($candidateanswer){
		  $updatesql = "update candidateanswers p set p.answer = '$candidateanswer' where p.id = $candidateanswerid";
		  $retval = $mysqli->query($updatesql);
		}				
	}
	else
	{
	    $insertsql = "insert into candidateanswers(questionid, candidateid, answer) values ($questionid, $candidateID, '$candidateanswer')";
		  $retval = $mysqli->query($insertsql);
	}
}

if(!isset($category))
{
$category = "QA-Must";
}
?>
    <form action="candidateanswermgmt.php" id="form1" name="form1" method="post"  enctype="multipart/form-data">
      <table width="80%" border="0" cellspacing="5" cellpadding="5">
        <thead>
          <tr>
            <td>Category:</td>
            <td><select class='selectBoxIt' style="width: 100px;" name="category"  id="category" onchange="this.form.submit()">
                <?php
    $query = "select distinct q.category, case category when 'QA-Must' then '500-Must' when 'QA' then 'All' else category end as value from questions q";
    $results = $mysqli->query($query);
    while ($rows = $results->fetch_assoc())
    {?>
                <option value="<?php echo $rows['category'];?>" <?php if($category == $rows['category']) { echo "selected";}  ?>><?php echo $rows['value'];?></option>
                <?php
    }?>
              </select></td>
          </tr>
          <tr>
            <td>Select Question:</td>
            <td><select name="questionid"  id="questionid" size="5" style="width: 650px;">
                <?php
		
		$query = "SELECT distinct id, concat(subject, ' - ', question) as name FROM questions where category = '$category' order by subject";
	  $results = $mysqli->query($query);
	  while($rows = $results->fetch_assoc())
		{
		  if($questionid == $rows['id'])
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
              </select></td>
          </tr>
        </thead>
        <br />
        <tbody id="show_content">
        <img src="../../images/loader.gif" style="margin-top:8px; float:left" id="loader" alt="" />
        </tbody>
        
      </table>
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
