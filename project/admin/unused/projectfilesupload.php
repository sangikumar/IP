<?php 
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$userId = $loggedInUser->user_id;
if(!userIdExists($userId)){
  header("Location: projectfilesupload.php"); die();
}
if($_GET['userid'] != $userId){
 // header("Location: projectfilesupload.php"); die();
}
//require_once '../tabs.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Project Files Uploads</title>
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
  		//echo $userid;
      $result = mysql_query("select o.id, c.name, cl.companyname compname, v.companyname vendorname, current_date from candidate c, placement p, vendor v, client cl, po o where c.candidateid = p.candidateid and o.placementid = p.id and p.vendorid = v.id and p.clientid = cl.id and c.portalid = $userid");
			//echo $result;
      $row = mysql_fetch_array($result);
      $poid = 	$row[0];
      $candidatename = $row[1];
      $clientname = $row[2];
      $vendorname = $row[3];		
      mysql_close($connection);	
			//echo $poid;
			
      if (!empty($_POST))
      {    
        $target_path = "projectfiles/";
        $filename = $poid."_".$candidatename."_".$clientname."_".$vendorname."_".date("Y-m-d")."_".basename( $_FILES['file']['name']);
        $target_path = $target_path . $filename;      
        if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
        $message = "<br /><br />File is uploaded.<br />";
   			     echo $message;
  			} 
        else{
        print "<font color=\"red\">There was an error uploading the file, please try again!</font><br />";
        }
      }			
		
		?>


	<span style='color:red'>Please upload your project files here. This is secure place to save your documents and share it with instructors.</span><br /><br />
  <form action="projectfilesupload.php" method="post"  enctype="multipart/form-data">
    <label for="file"><span class="txt1">Please upload your files: </span></label>
    <input type="file" name="file" id="file" />
    &nbsp;
    <input type="submit" name="submit" value="Submit" />
  </form>	
	
<?
  		echo '<br>';	
			$directory = "./projectfiles/";		
      $handler = opendir($directory);
      $i = 0;
      while (false !== ($file = readdir($handler))) {
          if(is_dir($file))
          {
      		    continue;
          }
          else if($file != '.' && $file != '..' && strpos($file, $poid) === 0)
          {
      		 		 $dirFiles1[] = $file;
          }
        }
      closedir($handler);
			if (isset($dirFiles1)) {
        sort($dirFiles1);
        foreach($dirFiles1 as $file)
        {
          echo '<a href="'.$directory.$file.'" style=\"font-family:Calibri;color:Blue;font-size:14px;\">'.$file.'</a><br>';
        }
			}

?>	

</div>
<div id='bottom'></div>
</div>
<br />
<br />
</body>
</html>