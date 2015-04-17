<?php
require_once("../models/config.php");

$candidateID = $loggedInUser->candidateid;

if($_REQUEST)
{
 	if($loggedInUser->employee == "Y")
	{
		$id 	= $_REQUEST['parent_id'];
		$pieces = explode(",", $id);
		$resumeid = $pieces[0];
		$candidateID = $pieces[1];
	}
	else
	{
	 $resumeid 	= $_REQUEST['parent_id'];
	}
	
	if($resumeid == 0)
	{
  	$resumeid = 	0;
		$resumekey = 	$candidateID.'-'.date("Y-m-d H:i:s");
  	$link = 	"";
	}
	else
	{
	$result = $mysqli->query("select * from resume where id = $resumeid");
    $row = $result->fetch_assoc();
  	$resumeid = 	$row['id'];
		$resumekey = 	$row['resumekey'];
  	$link = 	$row['link'];
  	$resumetext = 	$row['resumetext'];
  	$resumenotes = 	$row['resumenotes'];
	$mysqli->close();
	}

?>

<input type="hidden" name="resumeid" id="resumeid" value="<?php print $resumeid; ?>"/>
<?
 	if($loggedInUser->employee == "Y")
	{ ?>
<tr>
  <td>Key:</td>
  <td><input type="text" name="resumekey" value=<?php print $resumekey; ?>></td>
</tr>
<tr>
  <td>Google Drive Link:</td>
  <td><input type="text" name="link" value=<?php print htmlspecialchars($link); ?>></td>
</tr>
<? }
	else
	{ ?>
<input type="hidden" name="resumekey" id="resumekey" value="<?php print $resumekey; ?>"/>
<tr>
  <td>Key:</td>
  <td><?php print htmlspecialchars($resumekey); ?></td>
</tr>
<tr>
  <td>Google Drive Link:</td>
  <td><a href="<?php print htmlspecialchars($link); ?>" target="_blank"><?php print htmlspecialchars($link); ?></a></td>
</tr>
<? }?>
<tr>
  <td>Resume: (PASTE YOUR RESUME)</td>
  <td><textarea name="resumetext" type="text" id="resumetext" rows="300" cols="120">
	 		<?php print htmlspecialchars($resumetext, ENT_COMPAT,'ISO-8859-1', true); ?>
</textarea></td>
</tr>
<tr>
  <td>Notes: (PASTE YOUR NOTES)</td>
  <td><textarea name="resumenotes" type="text" id="resumenotes" rows="300" cols="120">
	 		<?php print htmlspecialchars($resumenotes, ENT_COMPAT,'ISO-8859-1', true); ?>
</textarea></td>
</tr>
<?php	
}
?>
