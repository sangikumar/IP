<?php

if($_REQUEST)
{
	$id 	= $_REQUEST['parent_id'];
 // $result = mysql_query("select c.email, c.phone, au.logincount, cm.coverletter, DATE_FORMAT(au.lastlogin,'%D %M %Y %h %i %p'), c.candidateid, cm.resumeid, c.portalid, cm.id as cmid from candidate c, candidatemarketing cm, authuser au where cm.candidateid = c.candidateid and c.portalid = au.id and cm.id = $id");
	$result = $mysqli->query("select c.email, c.phone, au.logincount, cm.coverletter, DATE_FORMAT(au.lastlogin,'%D %M %Y %h %i %p'), c.candidateid, cm.resumeid, c.portalid, cm.id as cmid from candidate c, candidatemarketing cm, authuser au where cm.candidateid = c.candidateid and c.portalid = au.id and cm.id = $id");
    $row = $result->fetch_row();
	$email = 	$row[0];	
	$phone = 	$row[1];	
	$logincount = 	$row[2];	
    $coverletter = 	$row[3];
	$lastlogin = 	$row[4];	
	$candidateid = 	$row[5];	
	$resumeid = 	$row[6];
	$portalid = 	$row[7];
	$cmid = 	$row[8];
	$feedback = 	$row[9];
	
	$result = $mysqli->query("select count(*) from candidateanswers where candidateid = $candidateid");

    $row = $result->fetch_row();
	$candidateanswers = 	$row[0];	
	
	$result = $mysqli->query("select count(*) from session where candidateid = $candidateid or candidate2id = $candidateid or candidate3id = $candidateid or candidate4id = $candidateid or candidate5id = $candidateid");
     $row = $result->fetch_row();
	$sessioncount = 	$row[0];		
	
	$result = $mysqli->query("select count(*) from interview where candidateid = $candidateid");
	$row = $result->fetch_row();
	$interviewcount = 	$row[0];	
	
	$result = $mysqli->query("select count(*) from position where candidateid = $candidateid");
    $row = $result->fetch_row();
	$positioncount = 	$row[0];			
	
	$result = $mysqli->query("select count(*) from positioncalls where candidateid = $candidateid");
    $row = $result->fetch_row();
	$positioncallscount = 	$row[0];				
	
	$result = $mysqli->query("select r.intro, r.project1, r.notes1, r.project2, r.notes2, r.bugs, r.challenges, r.lock from resume r where r.id = $resumeid");
    $row = $result->fetch_row();
	$intro = 	$row[0];	
	$project1 = 	$row[1];	
	$notes1 = 	$row[2];	
	$project2 = 	$row[3];	
	$notes2 = 	$row[4];	
	$bugs = 	$row[5];	
	$challenges = 	$row[6];	
	$lock = 	$row[7];
	if($lock == "Y")
	{
	 $checked = "checked";   
	}
	
?>
<strong id="show_heading">Email:</strong> <a href=<?php print "mailto:".$email; ?>><?php print htmlspecialchars($email); ?></a>	<br />
<strong id="show_heading">Phone:</strong> <a href=<?php print "tel:".$phone; ?>><?php print htmlspecialchars($phone); ?></a>	<br />
<strong id="show_heading">Login Count:</strong> <?php print htmlspecialchars($logincount); ?>	<br />
<strong id="show_heading">Last Login:</strong> <?php print htmlspecialchars($lastlogin); ?>	<br />
<strong id="show_heading">Questions answered:</strong> <?php print htmlspecialchars($candidateanswers); ?>	<br />
<strong id="show_heading">Sessions attended:</strong> <?php print htmlspecialchars($sessioncount); ?>	<br />
<strong id="show_heading">Positions applied:</strong> <?php print htmlspecialchars($positioncount); ?>	<br />
<strong id="show_heading">Marketing calls:</strong> <?php print htmlspecialchars($positioncallscount); ?>	<br />
<strong id="show_heading">Interviews attended:</strong> <?php print htmlspecialchars($interviewcount); ?>	<br />
<br /><input type="checkbox" name="lock" id="lock" value="Y" <?php echo $checked; ?>>Lock<br /><br />
<strong id="show_heading">Feedback: </strong>	<br />
<textarea name="feedback" type="text" id="feedback" rows="5" cols="80" maxlength="250">
	 				 <?php print $feedback; ?>
</textarea><br><br />
<?
	$result = $mysqli->query("select s.`type`, s.subject, s.sessiondate, u.name instructor, s.`status`, s.feedback from session s, employee u where s.instructorid = u.id and s.candidateid = $candidateid order by s.sessiondate desc");
	$num_rows = $result->num_rows;
if($num_rows > 0)
{
echo("<br><b>Sessions!</b><table><tr><td><table border='1'><tr><td><strong>Type</strong></td><td><strong>Subject</strong></td><td><strong>Date</strong></td><td><strong>Instructor</strong></td><td><strong>Status</strong></td><td><strong>Feedback</strong></td></tr>");
}
	while($data = $result->fetch_row()) {
		echo("<tr><td>$data[0]</td><td>$data[1]</td></td><td>$data[2]</td></td><td>$data[3]</td><td>$data[4]</td></td><td>$data[5]</td></tr>");
	}
if($num_rows > 0)
{
echo("</table></td></tr></table><br />");
}

	$result = $mysqli->query("select DATE_FORMAT(logindatetime,'%D %M %Y %h %i %p') from loginhistory u where u.loginid = $portalid order by u.logindatetime desc limit 10");
	$num_rows = $result->num_rows;
if($num_rows > 0)
{
echo("<br><b>Last 10 Logins!</b><table><tr><td><table border='1'><tr><td><strong>Login</strong></td></tr>");
}
	while($data = $result->fetch_row()) {
echo("<tr><td>$data[0]</td></tr>");
}
if($num_rows > 0)
{
echo("</table></td></tr></table><br />");
}

	$result = $mysqli->query("select s.clientname, s.type, s.interviewdate, s.status, u.name manager from interview s, employee u where s.mmid = u.id and s.candidateid = $candidateid order by s.interviewdate desc");$num_rows = mysql_num_rows($result);
if($num_rows > 0)
{
echo("<br><b>Interviews!</b><table><tr><td><table border='1'><tr><td><strong>Client</strong></td><td><strong>Type</strong></td><td><strong>Date</strong></td><td><strong>Status</strong></td><td><strong>Manager</strong></td></tr>");
}

	while($data = $result->fetch_row()) {
echo("<tr><td>$data[0]</td><td>$data[1]</td></td><td>$data[2]</td></td><td>$data[3]</td><td>$data[4]</td></tr>");
}
if($num_rows > 0)
{
echo("</table></td></tr></table><br />");
}
	$result = $mysqli->query("select s.client, s.vendorcompany, s.positiondate, s.status from positioncalls s where s.candidateid = $candidateid order by s.positiondate desc");
	$num_rows = $result->num_rows;
	if($num_rows > 0)
	{
		echo("<br><b>Calls!</b><table><tr><td><table border='1'><tr><td><strong>Client</strong></td><td><strong>Type</strong></td><td><strong>Date</strong></td><td><strong>Status</strong></td></tr>");
	}

	while($data = $result->fetch_row()) {
		echo("<tr><td>$data[0]</td><td>$data[1]</td></td><td>$data[2]</td></td><td>$data[3]</td></tr>");
	}
if($num_rows > 0)
{
echo("</table></td></tr></table><br />");
}

	$result = $mysqli->query("select s.client, s.vendor1, s.positiondate, s.status, u.name manager from position s, employee u where s.mmid = u.id and s.candidateid = $candidateid order by s.positiondate desc");
	$num_rows = $result->num_rows;
if($num_rows > 0)
{
echo("<br><b>Positions!</b><table><tr><td><table border='1'><tr><td><strong>Client</strong></td><td><strong>Type</strong></td><td><strong>Date</strong></td><td><strong>Status</strong></td><td><strong>Manager</strong></td></tr>");
}

	while($data = $result->fetch_row()) {
		echo("<tr><td>$data[0]</td><td>$data[1]</td></td><td>$data[2]</td></td><td>$data[3]</td><td>$data[4]</td></tr>");
}
if($num_rows > 0)
{
echo("</table></td></tr></table><br />");
}

?>

<input type="hidden" name="resumeid" id="resumeid" value="<?php print $resumeid; ?>"/>
<input type="hidden" name="cmid" id="cmid" value="<?php print $cmid; ?>"/>

<strong id="show_heading">Cover Letter: </strong>	<br />
<textarea name="coverletter" type="text" id="coverletter" rows="10" cols="80" maxlength="250">
	 				 <?php print $coverletter; ?>
</textarea><br><br />
<strong id="show_heading">Tell me about yourself: </strong>	<br />
<textarea name="intro" type="text" id="intro" rows="5" cols="80" maxlength="250">
	 				 <?php print $intro; ?>
</textarea><br><br />
<strong id="show_heading">Project 1: </strong>	<br />
<span><?php print htmlspecialchars($project1); ?></span><br />
<textarea name="notes1" type="text" id="notes1" rows="10" cols="80" maxlength="250">
	 				 <?php print $notes1; ?>
</textarea><br><br />
<strong id="show_heading">Project 2: </strong>	<br />
<span><?php print htmlspecialchars($project2); ?></span><br />
<textarea name="notes2" type="text" id="notes2" rows="10" cols="80" maxlength="250">
	 				 <?php print $notes2; ?>
</textarea><br><br />
<strong id="show_heading">Bugs you have found: </strong>	<br />
<textarea name="bugs" type="text" id="bugs" rows="10" cols="80" maxlength="250">
	 				 <?php print $bugs; ?>
</textarea><br><br />
<strong id="show_heading">Challenges you faced: </strong>	<br />
<textarea name="challenges" type="text" id="challenges" rows="10" cols="80" maxlength="250">
	 				 <?php print $challenges; ?>
</textarea><br><br />
	
<input type="submit" name="Send" value="Update">
<?php	
	$result = $mysqli->query("select q.question, ca.answer from candidateanswers ca, questions q where ca.questionid = q.id and (trim(ca.answer) is not null or trim(ca.answer) <> '') and ca.candidateid = $candidateid order by questionid");
	$num_rows = $result->num_rows;
if($num_rows > 0)
{
echo("<br><br><b>Questions!</b><table><tr><td><table border='1'><tr><td><strong>Question</strong></td></tr>");
}
	while($data = $result->fetch_row()) {
echo("<tr><td>$data[0]</td></tr>");
echo("<tr><td>$data[1]</td></tr>");
echo("<tr><td>&nbsp;</td></tr>");
}
if($num_rows > 0)
{
echo("</table></td></tr></table><br />");
}

}

$mysqli->close();
?>