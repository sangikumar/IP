<?php
require_once("../models/config.php");

$candidateID = $loggedInUser->candidateid;

if($_REQUEST)
{
  $id = $_REQUEST['term'];
  $type = $_GET['type'];
  $result = $mysqli->query('select email, name from recruiter where email like "%'. $mysqli->real_escape_string($_REQUEST['term']) .'%" or name like "%'. $mysqli->real_escape_string($_REQUEST['term']) .'%" order by name asc');
  $num_rows = $result->num_rows;
	$data = array();
  if ($num_rows > 0)
  {
     while ($row = $result->fetch_assoc())
  	{
  		$data[] = array(
  			'label' => $row['email'] .', '. $row['name'] ,
  			'value' => $row['email']
  		);
  	}
  }
 
  // jQuery wants JSON data
  echo json_encode($data);
  flush();	
	
  $mysqli->close();
}
?>