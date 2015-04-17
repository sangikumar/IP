<?php
require_once("../models/config.php");
/*
include_once ("../../../auth.php");
include_once ("../../../authconfig.php");
$connection = mysql_connect($dbhost, $dbusername, $dbpass);
$SelectedDB = mysql_select_db($dbname);	
*/
if($_REQUEST)
{
 	$timesheetid 	= $_REQUEST['parent_id'];
	$monday = 	0.0;
	$tuesday = 	0.0;
	$wednesday = 	0.0;
	$thursday = 	0.0;
	$friday = 	0.0;
	$saturday = 	0.0;
	$sunday = 	0.0;
	$overtime = 	0.0;
	$notes = 	"";

	if($timesheetid == -1)
	{
		$notes = 	"";
	}
	else
	{
		//$result = mysql_query("select * from timesheetdetail where id = $timesheetid");
        $result = $mysqli->query("select * from timesheetdetail where id = $timesheetid");
		//$row = mysql_fetch_array($result);
		$row = $result->fetch_assoc();
		$weekenddate = $row['weekenddate'];
		$monday = 	$row['monday'];
		$tuesday = 	$row['tuesday'];
		$wednesday = 	$row['wednesday'];
		$thursday = 	$row['thursday'];
		$friday = 	$row['friday'];
		$saturday = 	$row['saturday'];
		$sunday = 	$row['sunday'];
		$notes = 	$row['notes'];		
	}
//	mysql_close($connection);
    $mysqli->close();
?>

<input type="hidden" name="timesheetid" id="timesheetid" value="<?php print $timesheetid; ?>"/>
<table width="80%" border="0" cellpadding="10" cellspacing="1" align="left">
  <tr>
    <td style="text-align:right; font-weight:bolder; width:10%">Week End Date (Sunday):</td>
    <td>&nbsp;&nbsp;&nbsp;
      <input style="width:100px" class="hasDatepicker" name="weekenddate" id="weekenddate" value="<?php print $weekenddate; ?>"/>
      <em>This is the end date of the week.</em></td>
  </tr>
  <tr>
    <td style="text-align:right; font-weight:bolder; width:10%">Time:</td>
    <td>
      <table cellspacing="1">
        <tr>
          <td>Mon<br />
            <input style="width:40px" class="timesheetday" name="monday" id="monday" value="<?php print $monday; ?>"/>
          </td>
          <td>Tue<br />
            <input style="width:40px" class="timesheetday" name="tuesday" id="tuesday" value="<?php print $tuesday; ?>"/>
          </td>
          <td>Wed<br />
            <input style="width:40px" class="timesheetday" name="wednesday" id="wednesday" value="<?php print $wednesday; ?>"/>
          </td>
          <td>Thu<br />
            <input style="width:40px" class="timesheetday" name="thursday" id="thursday" value="<?php print $thursday; ?>"/>
          </td>
          <td>Fri<br />
            <input style="width:40px" class="timesheetday" name="friday" id="friday" value="<?php print $friday; ?>"/>
          </td>
          <td>Sat<br />
            <input style="width:40px" class="timesheetday" name="saturday" id="saturday" value="<?php print $saturday; ?>"/>
          </td>
          <td>Sun<br />
            <input style="width:40px" class="timesheetday" name="sunday" id="sunday" value="<?php print $sunday; ?>"/>
          </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td style="text-align:right; font-weight:bolder; width:10%">Upload:</td>
    <td style="text-align:center;"><div id="fileuploader">Upload</div></td>
  </tr>
  <tr>
    <td style="text-align:right; font-weight:bolder; width:10%">Notes:</td>
    <td style="text-align:center;">&nbsp;&nbsp;&nbsp;
      <textarea name="notes" type="text" style="width:600px" id="notes" rows="3" cols="80" maxlength="1000">
    	 		<?php print htmlspecialchars($notes, ENT_COMPAT,'ISO-8859-1', true); ?>
    </textarea></td>
  </tr>
  <tr>
    <td style="text-align:right; font-weight:bolder; width:10%">&nbsp;</td>
    <td style="text-align:left;">&nbsp;&nbsp;&nbsp;
      <input type="submit" name="send" id="send" value="Update"></td>
  </tr>
</table>
<? 
}
?>
