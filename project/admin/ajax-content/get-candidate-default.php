<?php
require_once("../models/config.php");
$candidateID = $loggedInUser->candidateid;

if($_REQUEST)
{
	$id 	= $_REQUEST['parent_id'];	
		
	if($id == 0)
	{
  	$cname = 	"";
		$ename = 	"";
  	$aname = 	"";
		$status = 	"";
		$startdate = 	"";
		$agencystartdate = 	"";
		$amountdue =  "";
		$amountclosed = 	"";
		$agencyamount = 	"";
		$closeddate = 	"";
		$reason = 	"";
		$comments = 	"";
	}
	else
	{
	   $result = $mysqli->query("select (select name from candidate ca where ca.candidateid = c.candidateid) cname, (select name from employee e where e.id = c.employeeid) ename, (select companyname from collection_agency ca where ca.id = c.agencyid) aname, c.* from candidatedefault c where candidateid = $id");
       $row = $result->fetch_assoc();
  		$cname = 	$row['cname'];
		$ename = 	$row['ename'];
  		$aname = 	$row['aname'];
		$status = 	$row['status'];
		$startdate = 	$row['startdate'];
		$agencystartdate = 	$row['agencystartdate'];
		$amountdue = 	$row['amountdue'];
		$amountclosed = 	$row['amountclosed'];
		$agencyamount = 	$row['agencyamount'];
		$closeddate = 	$row['closeddate'];
		$reason = 	$row['reason'];
		$comments = 	$row['comments'];
	}
	$mysqli->close();
?>

<input type="hidden" name="canid" id="canid" value="<?php print $id; ?>"/>    
<strong id="show_heading">Employee:</strong> <?php print htmlspecialchars($ename); ?>	<br />
<strong id="show_heading">Agency:</strong> <?php print htmlspecialchars($aname); ?>	<br />
<strong id="show_heading">Status:</strong> <?php print htmlspecialchars($status); ?>	<br />
<strong id="show_heading">Employee Start Date:</strong> <?php print htmlspecialchars($startdate); ?>	<br />
<strong id="show_heading">Agency Start Date:</strong> <?php print htmlspecialchars($agencystartdate); ?>	<br />
<strong id="show_heading">Amount Due:</strong> <?php print htmlspecialchars($amountdue); ?>	<br />
<strong id="show_heading">Status:</strong> <?php print htmlspecialchars($amountclosed); ?>	<br />
<strong id="show_heading">Agency Amount:</strong> <?php print htmlspecialchars($agencyamount); ?>	<br />
<strong id="show_heading">Closed Date:</strong> <?php print htmlspecialchars($closeddate); ?>	<br /><br />
<strong id="show_heading">Reason:</strong>
<textarea name="reason" type="text" id="reason" style="width: 100%;">
<?php print htmlspecialchars($reason, ENT_COMPAT,'ISO-8859-1', true); ?>
</textarea><br /><br />
<strong id="show_heading">Comments:</strong>
<textarea name="comments" type="text" id="comments" style="width: 100%;">
<?php print htmlspecialchars($comments, ENT_COMPAT,'ISO-8859-1', true); ?>
</textarea><br />
<input type="submit" name="send" id="send" value="Update"> 

<? } ?>
