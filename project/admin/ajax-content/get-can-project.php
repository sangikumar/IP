<?php
require_once("../models/config.php");
if($_REQUEST)
{
 	$placementid 	= $_REQUEST['parent_id'];
	$notes = 	"";

	if($placementid == -1)
	{
		die();
	}
	else
	{
		$result = $mysqli->query("select projectdesc from placement where id = $placementid");
	    $row = $result->fetch_assoc();
		$notes = 	$row['projectdesc'];		
	}
	$mysqli->close();
?>

<input type="hidden" name="placementid" id="placementid" value="<?php print $placementid; ?>"/>
<table width="80%" border="0" cellpadding="1" cellspacing="1" align="left">
<tr>
<td style="text-align:right; font-weight:bolder; width:10%">Upload:</td>
<td style="text-align:center;">&nbsp;&nbsp;&nbsp;
			<div id="fileuploader">Upload</div>
  </td>
</tr>
 <tr>
    <td style="text-align:right; font-weight:bolder; width:10%">Description:</td>
    <td style="text-align:center;">&nbsp;&nbsp;&nbsp;
	<textarea name="notes" type="text" id="notes" rows="6" cols="80" maxlength="1000">
    	 		<?php print htmlspecialchars($notes, ENT_COMPAT,'ISO-8859-1', true); ?>
    </textarea></td>
  </tr>
  <tr>
    <td style="text-align:right; font-weight:bolder; width:10%">&nbsp;</td>
    <td style="text-align:left;">&nbsp;&nbsp;&nbsp;<br /><input type="submit" name="send" id="send" value="Update"></td>
  </tr>
</table>
<? 
}
?>
