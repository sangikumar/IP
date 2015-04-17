<?php
require_once("../models/config.php");
/*
include_once ("../../../auth.php");
include_once ("../../../authconfig.php");
$connection = mysql_connect($dbhost, $dbusername, $dbpass);
$SelectedDB = mysql_select_db($dbname);
*/
$candidateID = $loggedInUser->candidateid;

if($_REQUEST)
{
	$id 	= $_REQUEST['term'];
 // $result = mysql_query('select id, question from questions where question like "%'. mysql_real_escape_string($_REQUEST['term']) .'%" order by question asc');
	$result = $mysqli->query('select id, question from questions where question like "%'. $mysqli->real_escape_string($_REQUEST['term']) .'%" order by question asc');
    $num_rows = $result->num_rows;
	$data = array();
//  if ( $result && mysql_num_rows($result) )
	if ($num_rows > 0)
  {
 // 	while( $row = mysql_fetch_array($result, MYSQL_ASSOC) )
	  while($row = $result->fetch_assoc())
  	{
  		$data[] = array(
  			'label' => $row['question'] ,
  			'value' => $row['id'] .','. trim($row['question']) ,
  		);
  	}
  }
 
  // jQuery wants JSON data
  echo json_encode($data);
  flush();	
	
//	mysql_close($connection);
	$mysqli->close();
}
?>