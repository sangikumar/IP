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
<title>Timesheets</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/project/themes/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/project/themes/ui.multiselect.css" />
<link href="/project/admin/models/site-templates/default.css" rel='stylesheet' type='text/css' />
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
<script src="/project/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src='/project/admin/models/funcs.js' type='text/javascript'></script>
<script type="text/javascript">
//<![CDATA[
  $.jgrid.no_legacy_api = true;
  $.jgrid.useJSON = true;
//]]>
</script>
<script src="/project/js/jquery.jqGrid.min.js" type="text/javascript"></script>
<style>  .ui-menu { width: 130px; }  </style>
<script type="text/javascript">
//<![CDATA[
        $(document).ready(function(){
            $(".link").button();
						$('#mymenu').menu();
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
<br />
<div id='left-nav'><?php include($_SERVER["DOCUMENT_ROOT"] ."/project/admin/left-nav.php");  ?></div>
<div id='main'>
<?
if (!empty($_POST))
{  
	$path = "../timesheets/"; 
  if(isset($_POST['mychk']))
  {
    if (is_array($_POST['mychk'])) {
      foreach($_POST['mychk'] as $value){
       rename($path."/".$value, strtolower($path."/arc-".$value));
      }
    } else {
      $value = $_POST['mychk'];
      rename($path."/".$value, strtolower($path."/arc-".$value));
    }
  }

}
?>
<br><br><br>
<form action="candidatetimesheets.php" id="form1" name="form1" method="post"  enctype="multipart/form-data">
<h4>Timesheet Uploaded (Select):<input type="submit" name="Archive" value="Archive"></h4>
<?php 
  include_once ("/auth.php");
  include_once ("/authconfig.php");

  $files = array();
  $dir = new DirectoryIterator('../timesheets/');
  foreach ($dir as $fileinfo) {     
     $files[$fileinfo->getMTime()] = $fileinfo->getFilename();
  }
  
  krsort($files);
  
  foreach($files as $file) {
  	$filename = $file."";						 
    if (strlen($filename) > 1 && strpos($filename, "arc-") === false) {
      $lastModified = date('F d Y, H:i:s',filemtime(utf8_decode('../timesheets/'.$file)));
    	echo "<input type='checkbox' name='mychk[]' value='$file'>";
    	echo "<a href='$root/timesheets/$file' target='_blank'>Uploaded: $lastModified Filename: $file </a><br>";
    }
  }			

  echo '<br><br><br>';			
?>
</form>	

</div>
<div id='bottom'></div>
</div>
<br />
<br />
</body>
</html>