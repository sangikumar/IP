<?php
require_once("../models/config.php");

$candidateID = $loggedInUser->candidateid;

if($_REQUEST)
{
  $id 	= $_REQUEST['term'];
  $type 	= $_GET['type'];
 	$result = $mysqli->query('select email, companyname from client where email like "%'. $mysqli->real_escape_string($_REQUEST['term']) .'%" or url like "%'.$mysqli->real_escape_string($_REQUEST['term']) .'%" or companyname like "%'. $mysqli->real_escape_string($_REQUEST['term']) .'%" order by companyname asc');
  $data = array();
	$num_rows = $result->num_rows;

	if ($num_rows > 0)
  {

	  while ($row = $result->fetch_assoc())
  	{
		if($type == 'company')
		{
			$data[] = array(
				'label' => $row['companyname'] ,
				'value' => $row['companyname']
			);		
		}
		else
		{
			$data[] = array(
				'label' => $row['companyname'] ,
				'value' => $row['email']
			);
		}
  	}
  }
 
  // jQuery wants JSON data
  echo json_encode($data);
  flush();	
	

	$mysqli->close();
}
?>