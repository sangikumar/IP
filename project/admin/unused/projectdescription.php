<?php 
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$userId = $loggedInUser->user_id;
if(!userIdExists($userId)){
  header("Location: projectdescription.php"); die();
}
if($_GET['userid'] != $userId){
 // header("Location: projectfilesupload.php"); die();
}
//require_once '../tabs.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Project Description</title>
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
<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="../js/i18n/grid.locale-en.js" type="text/javascript"></script>
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
						new nicEditor().panelInstance('description');
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
<h1>INNOVAPATH, INC. - Avatar</h1>

<br />
<br />
<div id='left-nav'><?php include("left-nav.php");  ?></div>
<div id='main'>
    <?php 
      include_once ("../../auth.php");
      include_once ("../../authconfig.php");
      
      $connection = mysql_connect($dbhost, $dbusername, $dbpass);
      $SelectedDB = mysql_select_db($dbname);	
			
      if (!empty($_POST))
      {    
        $description = $_POST['description'];
      	if($description){
					//echo $userid;
					//echo $description;
					$maxresult = mysql_query("select max(pl.id) from placement pl, candidate c where pl.candidateid = c.candidateid and c.portalid = $userid");
      		$maxrow = mysql_fetch_array($maxresult);
					$placementid = 	$maxrow[0];
					//echo $description;
					
      		$updatesql = "update placement p set p.projectdesc = '$description' where p.id = $placementid";
					//echo $updatesql;
					$retval = mysql_query($updatesql, $connection);
					//mysql_query($updatesql);
      	}				
      }				
  		
      $result = mysql_query("select p.projectdesc from candidate c, placement p, vendor v, client cl, po o where c.candidateid = p.candidateid and o.placementid = p.id and p.vendorid = v.id and p.clientid = cl.id and c.portalid = $userid");
      $row = mysql_fetch_array($result);
      $description = 	$row[0];
	  mysql_close($connection);		
		?>


	<span style='color:red'>Please write your project description here. This will be used for your resume and also to update your LinkedIN profile.</span><br /><br />
  <form action="projectdescription.php" method="post"  enctype="multipart/form-data">
    <label for="file"><span class="txt1">Please update your project description: </span></label><br>
		<textarea name="description" type="text" id="description" rows="10" cols="80">
			 				 <?php print htmlspecialchars($description); ?>
		</textarea><br>
		<input type="submit" name="Send" value="Send">
  </form>	
	
</div>
<div id='bottom'></div>
</div>
<br />
<br />
</body>
</html>