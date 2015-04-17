<?php

require_once("../models/config.php");
$candidateID = $loggedInUser->candidateid;

if($_REQUEST)
{
	$id 	= $_REQUEST['parent_id'];
 	$result = $mysqli->query("select questions, notes from interview where id = $id");
    $row = $result->fetch_row();
	$questions = 	$row[0];	
	$notes = 	$row[1];	


	$mysqli->close();
}
?>
<input type="hidden" name="interviewid" id="interviewid" value="<?php print $id; ?>"/>
<br /><br /><strong id="show_heading">Interview Questions: </strong>	<br />
<textarea name="questions" type="text" id="questions" rows="20" cols="80" maxlength="250">
	 		<?php print $questions; ?>
</textarea><br><br />
<strong id="show_heading">Notes(Interviewer info and other details): </strong>	<br />
<textarea name="notes" type="text" id="notes" rows="4" cols="80" maxlength="250">
	 		<?php print $notes; ?>
</textarea><br>
<input type="submit" name="Send" value="Update">