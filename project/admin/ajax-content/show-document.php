<?php 
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$userId = $loggedInUser->user_id;
if(!userIdExists($userId)){
  header("Location:login.php"); die();
}
if($_GET['userid'] != $userId){
 // header("Location: projectfilesupload.php"); die();
}
//require_once '../tabs.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Documents</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" />
<link rel="stylesheet" type="text/css" media="screen" href="../../themes/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="../../themes/ui.multiselect.css" />
<link href="../models/site-templates/default.css" rel='stylesheet' type='text/css' />
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
<script src="../../js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script src='../models/funcs.js' type='text/javascript'></script>
<script type="text/javascript">
//<![CDATA[
  $.jgrid.no_legacy_api = true;
  $.jgrid.useJSON = true;
//]]>
</script>
<script src="../../js/jquery.jqGrid.min.js" type="text/javascript"></script>
<style>  .ui-menu { width: 130px; }  </style>
<script type="text/javascript">
//<![CDATA[
        $(document).ready(function(){
            $(".link").button();
						$('#mymenu').menu();
						$('#loader').hide();
						$('#show_heading').hide();
						
          	$('#type').change(function(){
          		$('#show_document').fadeOut();
          		$('#loader').show();
          		$.post("get-documents.php", {
          			parent_id: $('#type').val(),
          		}, function(response){
          			
          			setTimeout("finishAjax('show_document', '"+escape(response)+"')", 400);
          		});							
          		return false;
          	});		
										
        });
//]]>

function finishAjax(id, response){
  $('#loader').hide();
  $('#show_heading').show();
	$('#show_heading').empty();
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
<h1>INNOVAPATH, INC. - Avatar</h1>

<br />
<br />
<div id='left-nav'>
<?php 

include($_SERVER["DOCUMENT_ROOT"] ."/project/admin/left-nav.php");  
include_once ("../../../auth.php");
include_once ("../../../authconfig.php");
$connection = mysql_connect($dbhost, $dbusername, $dbpass);
$SelectedDB = mysql_select_db($dbname);	
?></div>
<div id='main'>
 <?php
  $result = mysql_query("select distinct category from document order by category asc limit 1");	
	$row = mysql_fetch_row($result);
	$category = $row[0];
	$categoryid = $_POST['categoryid'];
	if(isset($categoryid))
	{
	 $category = $categoryid;
	}

?> 

  <form action="show-document.php" id="form1" name="form1" method="post"  enctype="multipart/form-data">
	
    <h4>DOCUMENT CATEGORY:
    <select style="width: 100px;" name="categoryid"  id="categoryid" onchange="this.form.submit()">
    <?php
    if ($loggedInUser->checkPermission(array(14)) || $loggedInUser->checkPermission(array(13))){
    	 $query = "select 'Candidate' category from dual";
    }
    else
    {
    	 $query = "select distinct category from document order by category asc";
    }	 		
		    
    $results = mysql_query($query);
    
    while ($rows = mysql_fetch_assoc(@$results))
    {?>
    	<option value="<?php echo $rows['category'];?>" <?php if($category == $rows['category']) { echo "selected";}  ?>><?php echo $rows['category'];?></option>
    <?php
    }?>		
    </select>		</h4>
	
		<h4>DOCUMENT TYPE:
		<select name="type"  id="type">
		<?php
    $query = "select distinct type from document where category = '$category' order by type";
    $results = mysql_query($query);		
		echo "<option value=''> </option>";
    while ($rows = mysql_fetch_assoc(@$results))
    {?>
    	<option value="<?php echo $rows['type'] . "-" . $category;?>"><?php echo $rows['type'];?></option>
    <?php
    }?>			
		</select>	</h4>
		
  	<div class="both">
      <h4 id="show_heading"></h4>
      <div id="show_document">
      	<img src="../../../images/loader.gif" style="margin-top:8px; float:left" id="loader" alt="" />			
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