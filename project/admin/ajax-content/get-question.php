<?php
require_once("../models/config.php");
$candidateID = $loggedInUser->candidateid;

if ($_REQUEST) {
    $id = $_REQUEST['parent_id'];
    $query = "select subject, category, type, question from questions where id = $id";
    $result = $mysqli->query($query);
    $row = $result->fetch_row();
    $subject = $row[0];
    $category = $row[1];
    $type = $row[2];
    $question = $row[3];

    $query = "select id, answer from candidateanswers where questionid = $id and candidateid = $candidateID";
    $result = $mysqli->query($query);
    $row = $result->fetch_row();
    if ($row) {
        $candidateanswerid = $row[0];
        $candidateanswer = $row[1];
    }

    $mysqli->close();
}
?>

<input type="hidden" name="candidateanswerid" id="candidateanswerid" value="<?php print $candidateanswerid; ?>"/>
<input type="hidden" name="questionid" id="questionid" value="<?php print $id; ?>"/>
<tr>
    <td>Details:</td>
    <td><strong>Subject</strong>: <?php print htmlspecialchars($subject); ?>
        <strong>Category</strong>: <?php print htmlspecialchars($category); ?>
        <strong>Type</strong>: <?php print htmlspecialchars($type); ?></td>
</tr>
<tr>
    <td>Question:</td>
    <td><?php print $question; ?></td>
</tr>
<tr>
    <td>Your Answer:</td>
    <td><textarea name="candidateanswer" type="text" id="candidateanswer" rows="5" cols="80" maxlength="250">
	 		<?php print $candidateanswer; ?>
</textarea></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="Send" value="Update"></td>
</tr>
