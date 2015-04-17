<?php
require_once($_SERVER["DOCUMENT_ROOT"] ."/project/admin/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$page_title = $websiteName;
if (!is_object($loggedInUser)) {
    header("Location:login.php");
    exit;
}
require_once("models/header.php"); 			
echo "
<body>
<div id='wrapper'>
<div id='top'><div id='logo'></div><div id='logo1'></div></div>
<div id='content'>

<div id='left-nav'>";
include($_SERVER["DOCUMENT_ROOT"] ."left-nav.php");

$userid = $loggedInUser->user_id;
$displayname = $loggedInUser->displayname;
$connection = mysql_connect($db_host, $db_user, $db_pass);
$SelectedDB = mysql_select_db($db_name);
$employeeid = -1;
$mgrid = -1;

if($userid) {
$result = mysql_query("SELECT c.id, c.mgrid FROM employee c where loginid = $userid");
$num_rows = mysql_num_rows($result);
  if($num_rows > 0)
  {
    $row = mysql_fetch_row($result);
    $employeeid = $row[0];
    $mgrid = $row[1];
  }
}

echo "
</div>
<div id='main'>
<br>
Hey, $loggedInUser->displayname Welcome! <br>";

//Logic to insert contacts from IP CONTACT FORM TO LEADS
$leads = mysql_query("select id, notifyto, data from wp_cftemail_messages");
while($ldata = mysql_fetch_row($leads)){
$insertsql = "insert into leads(email, name, notes) values ('$ldata[1]', 'IP SITE CONTACT', '$ldata[2]')";
$retval = mysql_query($insertsql, $connection);
$deletesql = "delete from wp_cftemail_messages where id = $ldata[0]";
$retval = mysql_query($deletesql, $connection);
}

//If it is candidate who logs in
if ($loggedInUser->checkPermission(array(13))){

$result = mysql_query("select candidateid from candidate where portalid = $userid");
$num_rows = mysql_num_rows($result);
if($num_rows == 0)
{
echo("<br><b style='color:red'>Your account is not setup right! Please contact <a href='mailto:info@innova-path.com'>info@innova-path.com</a>. Please do not use Avatar if this message shows up!</b>");
}

$result = mysql_query("SELECT c.offerletter, c.feedue, p.wrkemail, p.wrkdesignation, p.wrkphone, p.mgrname, p.mgremail, p.mgrphone, p.hiringmgrname, p.hiringmgremail, p.hiringmgrphone, p.guidelines, p.feedbackid FROM po o, placement p, candidate c where o.placementid = p.id and p.candidateid = c.candidateid and c.portalid = $userid");
$row = mysql_fetch_row($result);

$pending = "N";
$offerletter = $row[0];
$feedue = $row[1];
$wrkemail = $row[2];
$wrkdesignation = $row[3];
$wrkphone = $row[4];
$mgrname = $row[5];
$mgremail = $row[6];
$mgrphone = $row[7];
$hiringmgrname = $row[8];
$hiringmgremail = $row[9];
$hiringmgrphone = $row[10];
$guidelines = $row[11];
$feedbackid = $row[12];

/*$message = "<br>";
$message .= "<p>You have the following paperwork pending. <strong style='color:red'>Your payments cannot start without submitting the following paperwork.</strong></p>";
$message .= "<p><ol>";*/

/*
if($offerletter != "Y")
{
 $message .= "<li>Offer Letter</li>";
 $pending = "Y";
}
if($feedue > 0.0)
{
 $message .= "<li>Fee:$feedue</li>";
 $pending = "Y";
}
if(!isset($wrkemail) || empty($wrkemail) || !isset($wrkdesignation) || empty($wrkdesignation) || !isset($wrkphone) || empty($wrkphone))
{
 $message .= "<li>Work Email, Designation and Phone</li>";
 $pending = "Y";
}
if(!isset($mgrname) || empty($mgrname) || !isset($mgremail) || empty($mgremail) || !isset($mgrphone) || empty($mgrphone))
{
 $message .= "<li>Manager Name, Email and Phone</li>";
 $pending = "Y";
}
if(!isset($hiringmgrname) || empty($hiringmgrname) || !isset($hiringmgremail) || empty($hiringmgremail) || !isset($hiringmgrphone) || empty($hiringmgrphone))
{
 $message .= "<li>Hiring Manager Name, Email and Phone</li>";
 $pending = "Y";
}
if($guidelines != "Y")
{
 $message .= "<li>Client Project Guidelines Document</li>";
 $pending = "Y";
}
if(!isset($feedbackid) || empty($feedbackid))
{
 $message .= "<li>Feedback. Please provide feedback <a href='http://whiteboxqa.com/testimonial.php' target='_blank'>here</a></li>";
 $pending = "Y";
}
if($feedue > 0.0)
{
 $message .= "<li>Fee:$feedue</li>";
 $pending = "Y";
}*/

echo "<br />Please contact HR at <strong><a href='mailto:hr@innova-path.com'>hr@innova-path.com</a></strong> for any concerns or questions regarding this application.";

if($pending == "Y")
{
 echo $message;
}

echo "</ol></p>";

echo "


</div>
</body>
</html>";
die();
}

//If it is candidate who logs in
if ($loggedInUser->checkPermission(array(14))){

$result = mysql_query("select candidateid from candidate where portalid = $userid");
$num_rows = mysql_num_rows($result);
if($num_rows == 0)
{
echo("<br><b style='color:red'>Your account is not setup right! Please contact <a href='mailto:training@innova-path.com'>training@innova-path.com</a> or <a href='mailto:info@innova-path.com'>info@innova-path.com</a></b>");
}

$result = mysql_query("select s.`type`, s.subject, s.sessiondate, u.name instructor, s.`status`, s.feedback from session s, employee u where s.instructorid = u.id and s.candidateid = (select candidateid from candidate where portalid = $userid) order by s.sessiondate desc limit 3");
$num_rows = mysql_num_rows($result);
if($num_rows > 0)
{
echo("<br><b>Sessions!</b><table><tr><td><table border='1'><tr><td><strong>Type</strong></td><td><strong>Subject</strong></td><td><strong>Date</strong></td><td><strong>Instructor</strong></td><td><strong>Status</strong></td><td><strong>Feedback</strong></td></tr>");
}
while($data = mysql_fetch_row($result)){
echo("<tr><td>$data[0]</td><td>$data[1]</td></td><td>$data[2]</td></td><td>$data[3]</td><td>$data[4]</td></td><td>$data[5]</td></tr>");
}
if($num_rows > 0)
{
echo("</table></td></tr></table>");
}

echo "
</div>
</div>
</body>
</html>";
die();
}



$result = mysql_query("select c.name, c.email from candidate c where portalid = '' and c.batchname in (select batchname from batch b where b.startdate > curdate())");
$num_rows = mysql_num_rows($result);
if($num_rows > 0)
{
echo("<br><b>Portal ID's not linked!</b><table><tr><td><table border='1'><tr><td><strong>Name</strong></td><td><strong>Email</strong></td></tr>");
}
while($data = mysql_fetch_row($result)){
echo("<tr><td>$data[0]</td><td>$data[1]</td></td></tr>");
}
if($num_rows > 0)
{
echo("</table></td></tr></table>");
}

if (!$loggedInUser->checkPermission(array(14) ) and  !$loggedInUser->checkPermission(array(13) )){

$result = mysql_query("select name, dob from employee e WHERE status = '0Active' and  dob + INTERVAL EXTRACT(YEAR FROM NOW()) - EXTRACT(YEAR FROM dob) YEAR BETWEEN CURRENT_DATE() AND CURRENT_DATE() + INTERVAL 7 DAY  order by DAY(dob)");
$num_rows = mysql_num_rows($result);
if($num_rows > 0)
{
echo("<br><b>Employee Birthdays!</b><table><tr><td><table border='1'><tr><td><strong>NAME</strong></td><td><strong>DOB</strong></td></tr>");
}
while($data = mysql_fetch_row($result)){
echo("<tr><td>$data[0]</td><td>$data[1]</td></td></tr>");
}
if($num_rows > 0)
{
echo("</table></td></tr></table>");
}

$result = mysql_query("select c.name, email, phone, c.dob, c.status from candidate c WHERE status not in ('Discontinued', 'Defaulted') and dob + INTERVAL EXTRACT(YEAR FROM NOW()) - EXTRACT(YEAR FROM dob) YEAR BETWEEN CURRENT_DATE() AND CURRENT_DATE() + INTERVAL 7 DAY order by DAY(dob)");
$num_rows = mysql_num_rows($result);
if($num_rows > 0)
{
echo("<br><b>Candidate Birthdays!</b><table><tr><td><table border='1'><tr><td><strong>NAME</strong></td><td><strong>EMAIL</strong></td><td><strong>PHONE</strong></td><td><strong>DOB</strong></td><td><strong>STATUS</strong></td></tr>");
}
while($data = mysql_fetch_row($result)){
echo("<tr><td>$data[0]</td><td><a href='mailto:$data[1]'>$data[1]</a></td><td>$data[2]</td></td><td>$data[3]</td><td>$data[4]</td></tr>");
}
if($num_rows > 0)
{
echo("</table></td></tr></table>");
}
}// end checkpermission if 

echo "
</div>
</div>


</body>
</html>";
mysql_close($connection);
?>