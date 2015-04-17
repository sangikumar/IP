<?php
require_once("../models/config.php");

$candidateID = $loggedInUser->candidateid;

if($_REQUEST)
{
  $id 	= $_REQUEST['parent_id'];
  if($id == '0') { die();}
  
  $result = $mysqli->query("select interviewersphone, t.interviewers, t.questions from interview t where t.id = $id");
  $row = $result->fetch_row();
  $interviewersphone = 	$row[0];	
  $interviewers = 	$row[1];
  $questions = 	$row[2];

  $mysqli->close();
}
?>

<input type="hidden" name="interviewid" id="interviewid" value="<?php print $id; ?>"/>
<tr>
  <td><strong id="show_heading">Interviewers:</strong></td>
  <td><input type="text" name="interviewers" width="250px" value=<?php print $interviewers; ?>>&nbsp;<em>For multiple interviewers seperate names using comma.</em></td>
</tr>
<tr>
  <td><strong id="show_heading">Interviewer Phone:</strong></td>
  <td><input type="text" name="interviewersphone" width="250px" value=<?php print $interviewersphone; ?>>&nbsp;<em>For multiple interviewers seperate ph. no. using comma.</em></td>
</tr>
<tr>
  <td><strong id="show_heading">Questions: </strong></td>
  <td><textarea name="questions" type="text" id="questions" rows="5" cols="80" maxlength="250">
	 		<?php print $questions; ?>
</textarea></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td align="center"><input type="submit" name="Send" value="Update"></td>
</tr>
