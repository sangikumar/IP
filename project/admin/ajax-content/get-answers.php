<?php
require_once("../models/config.php");
$candidateID = $loggedInUser->candidateid;

if($_REQUEST)
{
	$id 	= $_REQUEST['parent_id'];
	$pieces = explode(",", $id);
//	echo $pieces[0];
?>

<div id="accordion" style="width:800px">
<?
 
		$query = "select c.name, c.batchname, ca.answer from candidateanswers ca, candidate c where c.candidateid = ca.candidateid and questionid = $pieces[0] order by c.batchname, c.name";
		$result = $mysqli->query($query);
		while ($row =$result->fetch_row()) {
					$batchname = 		$row[1];
					$name = 		$row[0];
  				echo("<h3>$batchname - $name</h3><div>");
      		echo($row[2].'<br>');
      		echo("</div>");			
		}
?>
</div>	
<?php	
}
$mysqli->close();
?>