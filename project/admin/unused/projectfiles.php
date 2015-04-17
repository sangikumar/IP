<?php 
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$userId = $loggedInUser->user_id;
if(!userIdExists($userId)){
  header("Location: projectfiles.php"); die();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Real Project Files</title>
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
		
		?>


	<span style='color:red'>Real Project files.</span><br /><br />
	
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
          else if($file != '.' && $file != '..')
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