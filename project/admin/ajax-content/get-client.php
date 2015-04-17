<?php
require_once("../models/config.php");
$candidateID = $loggedInUser->candidateid;

if($_REQUEST)
{
	$id 	= $_REQUEST['parent_id'];	
	$result = $mysqli->query("select * from client where email = '$id'");
	$row = $result->fetch_assoc();
	$vendorid = 	$row["id"];	
	$name = 	$row["companyname"];	
	$tier = 	$row["tier"];
	$url = 	$row["url"];
	$email = 	$row["email"];
	$phone = 	$row["phone"];
	$fax = 	$row["fax"];
	$address = 	$row["address"]." ".$row["city"]." ".$row["country"]." ".$row["zip"];
	$status = 	$row["status"];
	$notes = 	$row["notes"];					
}
?>

<input type="hidden" name="clientid" id="clientid" value="<?php print $id; ?>"/>
<input type="hidden" name="email" id="email" value="<?php print $email; ?>"/>
<div id="accordion" style="width:800px">
  <h3><?php print htmlspecialchars($name); ?></h3>
  <div> <strong id="show_heading">Status:</strong> <?php print htmlspecialchars($status); ?> <br />
    <strong id="show_heading">Tier:</strong> <?php print htmlspecialchars($vendortier[$tier]); ?> <br />
  </div>
  <h3>Contact</h3>
  <div> <strong id="show_heading">URL:</strong> <a href=<?php print $url; ?>><?php print htmlspecialchars($url); ?></a> <br />
    <strong id="show_heading">Email:</strong> <a href=<?php print "mailto:".$email; ?>><?php print htmlspecialchars($email); ?></a> <br />
    <strong id="show_heading">Phone:</strong> <a href=<?php print "tel:".$phone; ?>><?php print htmlspecialchars($phone); ?></a> <br />
    <strong id="show_heading">Fax:</strong> <a href=<?php print "tel:".$fax; ?>><?php print htmlspecialchars($fax); ?></a> <br />
    <strong id="show_heading">Address:</strong> <?php print htmlspecialchars($address); ?> <br />
  </div>
  <h3>Notes</h3>
  <div> <strong id="show_heading">Notes:</strong> <?php print htmlspecialchars($notes); ?> <br />
  </div>
 </div>
<?		
 $mysqli->close();
?>
