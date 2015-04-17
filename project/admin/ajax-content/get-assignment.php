<?php
require_once("../models/config.php");
/*
include_once ("../../../auth.php");
include_once ("../../../authconfig.php");
$connection = mysql_connect($dbhost, $dbusername, $dbpass);
$SelectedDB = mysql_select_db($dbname);	*/
$candidateID = $loggedInUser->candidateid;

if($_REQUEST)
{
	$id 	= $_REQUEST['parent_id'];
//  $result = mysql_query("select e.name instructorname, t.weeknumber, t.question from ip_assignment t, employee e where t.instructorid = e.id and t.id = $id");
  $result = $mysqli->query("select e.name instructorname, t.weeknumber, t.question from ip_assignment t, employee e where t.instructorid = e.id and t.id = $id");
//  $row = mysql_fetch_array($result);
   $row = $result->fetch_row();
	$instructorname = 	$row[0];	
	$question = 	$row[2];	
//	$result = mysql_query("select id, assignment from candidateassignment where assignmentid = $id and candidateid = $candidateID");
  $result = $mysqli->query("select id, assignment from candidateassignment where assignmentid = $id and candidateid = $candidateID");
  if ($result->num_rows > 0) {
   //     $row = mysql_fetch_array($result);
        $row = $result->fetch_row();
      	$candidateassignmentid = 	$row[0];	
      	$assignment = 	$row[1];	
  }	
	
//	mysql_close($connection);
   $mysqli->close();
}
?>

<input type="hidden" name="candidateassignmentid" id="candidateassignmentid" value="<?php print $candidateassignmentid; ?>"/>
<input type="hidden" name="assignmentid" id="assignmentid" value="<?php print $id; ?>"/>
<tr>
  <td><strong id="show_heading">Instructor:</strong></td>
  <td><?php print htmlspecialchars($instructorname); ?></td>
</tr>
<tr>
  <td><strong id="show_heading">Question:</strong></td>
  <td><?php print $question; ?></td>
</tr>
<tr>
  <td><strong id="show_heading">Your Answer: </strong></td>
  <td><textarea name="assignment" type="text" id="assignment" rows="5" cols="80" maxlength="250">
	 		<?php print $assignment; ?>
</textarea></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td align="center"><input type="submit" name="Send" value="Update"></td>
</tr>
