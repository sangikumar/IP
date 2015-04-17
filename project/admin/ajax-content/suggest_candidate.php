<?php
require_once("../models/config.php");
$candidateID = $loggedInUser->candidateid;

if($_REQUEST)
{
	$id 	= $_REQUEST['term'];
	//echo $id;
//  $result = mysql_query('select email, name, candidateid from candidate where email like "%'. mysql_real_escape_string($_REQUEST['term']) .'%" or name like "%'. mysql_real_escape_string($_REQUEST['term']) .'%" order by name asc');
	$result = $mysqli->query('select email, name, candidateid from candidate where email like "%'. $mysqli->real_escape_string($_REQUEST['term']) .'%" or name like "%'. $mysqli->real_escape_string($_REQUEST['term']) .'%" order by name asc');
    $data = array();
	$num_rows = $result->num_rows;
 // if ( $result && mysql_num_rows($result) )
	if ($num_rows > 0)
  {
 // 	while( $row = mysql_fetch_array($result, MYSQL_ASSOC) )
	  while($row = $result->fetch_assoc())
  	{
  		$data[] = array(
  			'label' => $row['name'] .', '. $row['email'] ,
  			'value' => $row['email']
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