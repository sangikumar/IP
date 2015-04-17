<?php 
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$userId = $loggedInUser->user_id;
if(!userIdExists($userId)){
  header("Location:login.php"); die();
}
//require_once '../tabs.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Your Sessions</title>
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
<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="../../js/i18n/grid.locale-en.js" type="text/javascript"></script>
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
//bkLib.onDomLoaded(function() {  });
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
<div id='left-nav'><?php include($_SERVER["DOCUMENT_ROOT"] ."/project/admin/left-nav.php");  ?></div>
<div id='main'>
    <?php 
      include_once ("../../auth.php");
      include_once ("../../authconfig.php");
      
      $connection = mysql_connect($dbhost, $dbusername, $dbpass);
      $SelectedDB = mysql_select_db($dbname);	
			
      $result = mysql_query("select s.`type`, s.subject, s.sessiondate, u.name instructor, s.`status`, s.feedback from session s, employee u where s.instructorid = u.id and (s.candidateid = (select candidateid from candidate where portalid = $userid) or s.candidate2id = (select candidateid from candidate where portalid = $userid) or s.candidate3id = (select candidateid from candidate where portalid = $userid) or s.candidate4id = (select candidateid from candidate where portalid = $userid) or s.candidate5id = (select candidateid from candidate where portalid = $userid)) order by s.sessiondate desc");
      $num_rows = mysql_num_rows($result);
      if($num_rows > 0)
      {
      echo("<br><b>Sessions!</b><table><tr><td><table border='1'><tr><td><strong>Type</strong></td><td><strong>Subject</strong></td><td><strong>Date</strong></td><td><strong>Instructor</strong></td><td><strong>Status</strong></td><td><strong>Feedback</strong></td></tr>");
      }
      while($data = mysql_fetch_row($result)){
      echo("<tr><td>$data[0]</td><td>$data[1]</td></td><td>$data[2]</td></td><td>$data[3]</td><td>$data[4]</td></td><td>$data[5]</td></tr>");
      }
      if($num_rows > 0)
      {
      echo("</table></td></tr></table>");
      }
			else
			{
			 echo "<span style='color:red'>No Sessions taken.</span><br /><br />";
			}
		

	    mysql_close($connection);		
			
		?>


	
</div>
<div id='bottom'></div>
</div>
<br />
<br />
</body>
</html>