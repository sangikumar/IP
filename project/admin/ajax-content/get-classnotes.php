<?php
require_once("../models/config.php");

if($_REQUEST)
{
 	$classid 	= $_REQUEST['parent_id'];
	
	if($classid == 0)
	{
		$classdate = date("Y-m-d");
  	$notes = 	"";
		$subject = 	"";
	}
	else
	{
    $result = $mysqli->query("select * from class_notes where id = $classid");
    $row 	= $result->fetch_assoc();
  	$classdate = 	$row['classdate'];
		$subject = 	$row['subject'];
  	$notes = 	$row['notes'];
    $mysqli->close();
	}

  if($loggedInUser->employee == "Y")
  { ?>

<input type="hidden" name="classid" id="classid" value="<?php print $classid; ?>"/>
<tr>
  <td>Subject:</td>
  <td><input style="width:300px" name="subject" id="subject" value="<?php print $subject; ?>"/></td>
</tr>
<tr>
  <td>Date:</td>
  <td><input class="hasDatepicker" name="classdate" id="classdate" value="<?php print $classdate; ?>"/></td>
</tr>
<tr>
  <td>Notes:</td>
  <td><textarea name="notes" type="text" id="notes" style="width: 100%;">
    	 		<?php print htmlspecialchars($notes, ENT_COMPAT,'ISO-8859-1', true); ?>
    </textarea></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td><input type="submit" name="send" id="send" value="Update"></td>
</tr>
<? }   else   { print "<tr><td>&nbsp;</td><td>$notes</td></tr>"; }
  }
  ?>
  