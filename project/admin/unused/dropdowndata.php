<?php
require_once("models/config.php");
include_once ("../../auth.php");
include_once ("../../authconfig.php");
$connection = mysql_connect($dbhost, $dbusername, $dbpass);
$SelectedDB = mysql_select_db($dbname);	
$candidateID = $loggedInUser->candidateid;

if($_REQUEST)
{
	$id 	= $_REQUEST['parent_id'];
  $result = mysql_query("select distinct category from subjectcategory");
  $row = mysql_fetch_array($result);	
	$subjectcategory = 	$row[0];	
	
	mysql_close($connection);
}
?>
