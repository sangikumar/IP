<?php
require_once("../models/config.php");
$candidateID = $loggedInUser->candidateid;

if($_REQUEST)
{
  $id 	= $_REQUEST['parent_id'];
  if($id == '0') { die();}
  
  $result = $mysqli->query("select pc.`client`, pc.positiondate, pc.`status`, pc.vendoremail, pc.vendorcompany, pc.clientemail, pc.solicitation, pc.notes from positioncalls pc where pc.id = $id");

  $row = $result->fetch_row();
  $client = 	$row[0];	
  $positiondate = 	$row[1];
  $status = 	$row[2];
  $vendoremail = 	$row[3];
  $vendorcompany = 	$row[4];
  $clientemail = 	$row[5];
  $solicitation = 	$row[6];
  $notes = 	$row[7];

  $mysqli->close();
}
?>

<input type="hidden" name="positioncallid" id="positioncallid" value="<?php print $id; ?>"/>
<tr>
  <td><strong id="show_heading">Position Date:</strong></td>
  <td><input style="width: 100px;" class="hasDatepicker" name="positiondate" id="positiondate" value="<?php print $positiondate; ?>"/></td>
</tr>
<tr>
  <td><strong id="show_heading">Vendor:</strong></td>
  <td><input type="text" id="vendorcompany" name="vendorcompany" style="width: 50%;" value="<?php print $vendorcompany; ?>"/>&nbsp;<em>Use comma as seperator.</em></td>
</tr>
<tr>
  <td><strong id="show_heading">Recruiter Email:</strong></td>
  <td><input type="text" id="vendoremail" name="vendoremail" style="width: 50%;" value="<?php print $vendoremail; ?>"/>&nbsp;<em>Use comma as seperator.</em></td>
</tr>
<tr>
  <td><strong id="show_heading">Solicitation:</strong></td>
  <td>
  <select name="solicitation" id="solicitation" style="width: 10%;">
	  <option <? if($solicitation == 'N') print "selected"; ?> value="N">N</option>
	  <option <? if($solicitation == 'Y') print "selected"; ?> value="Y">Y</option>
  </select>&nbsp;<em style="color:red">Did the vendor/client ask you to work on their W2?</em>
</tr>
<tr>
  <td><strong id="show_heading">Client:</strong></td>
  <td><input type="text" id="client" name="client" style="width: 50%;" value="<?php print $client; ?>"/>&nbsp;<em>Use comma as seperator.</em></td>
</tr>
<tr>
  <td><strong id="show_heading">Client Email:</strong></td>
  <td><input type="text" id="clientemail" name="clientemail" style="width: 50%;" value=<?php print $clientemail; ?>>&nbsp;<em>Use comma as seperator.</em></td>
</tr>
<tr>
  <td><strong id="show_heading">Notes: </strong></td>
  <td><textarea name="notes" type="text" id="notes" rows="5" cols="80" maxlength="250">
	 		<?php print $notes; ?>
</textarea></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td align="center"><input type="submit" name="Send" value="Update"></td>
</tr>
