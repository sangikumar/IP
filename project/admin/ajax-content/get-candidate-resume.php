<?php

require_once("../models/config.php");
$candidateID = $loggedInUser->candidateid;

if($_REQUEST)
{
	$candemail 	= $_REQUEST['parent_id'];

	$candresult = $mysqli->query("select * from candidate where email = '$candemail'");

    $candrow = $candresult->fetch_assoc();
	$candidateid = 	$candrow['candidateid'];	

?>

<strong>RESUMES:</strong>
<input type="hidden" name="candidateid" id="candidateid" value="<?php print $candidateid; ?>"/>
<input type="hidden" name="email" id="email" value="<?php print $candemail; ?>"/>
<select name="resumeid"  id="resumeid" class="styled-select" style="width: 300px;" onselected="this.form.submit();">
<?php
$query = "select * from (select r.id, r.resumekey from resume r where r.id in (select cm.resumeid from candidateresume cm where cm.candidateid = $candidateid and cm.resumeid is not null) union select 0 as id, 'Create New Resume') s order by id desc";

 $results = $mysqli->query($query);

  while ($rows = $results->fetch_assoc())
{?>
	<option value="<?php echo $rows['id'];?>" <?php if($resumeid == $rows['id']) { echo "selected";}  ?>><?php echo $rows['resumekey'];?></option>
<?php
}?>		
</select>	<br /><br />

<div class="both">
<div id="show_resume">
	
</div>
</div>		
<br>
<input type="submit" name="Send" value="Update Resume">
<?php	
}

 $mysqli->close();
?>
