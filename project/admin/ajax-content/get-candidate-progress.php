<?php

if($_REQUEST)
{
	$candidateid 	= $_REQUEST['parent_id'];
	$candresult = $mysqli->query("select * from candidate where candidateid = $candidateid");

    $candrow = $candresult->fetch_assoc();
	$name = 	$candrow['name'];	
	$enrolleddate = 	$candrow['enrolleddate'];
	$dob = 	$candrow['dob'];
	$email = 	$candrow['email'];
	$phone = 	$candrow['phone'];
	$workstatus = 	$candrow['workstatus'];
	$education = 	$candrow['education'];
	$workexperience = 	$candrow['workexperience'];
	$secondaryemail = 	$candrow['secondaryemail'];
	$secondaryphone = 	$candrow['secondaryphone'];
	$address = 	$candrow['address'].' '.$candrow['city'].' '.$candrow['state'].' '.$candrow['country'].' '.$candrow['zip'];
	$emergcontactname = 	$candrow['emergcontactname'];
	$emergcontactemail = 	$candrow['emergcontactemail'];
	$emergcontactphone = 	$candrow['emergcontactphone'];
	$emergcontactaddrs = 	$candrow['emergcontactaddrs'];
	$term = 	$candrow['term'];
	$feepaid = 	$candrow['feepaid'];
	
?>
<div id="accordion" style="width:800px">
  <h3><?php print htmlspecialchars($name); ?></h3>
	<div>
    <strong id="show_heading">Email:</strong> <a href=<?php print "mailto:".$email; ?>><?php print htmlspecialchars($email); ?></a>	<br />
    <strong id="show_heading">Phone:</strong> <a href=<?php print "tel:".$phone; ?>><?php print htmlspecialchars($phone); ?></a>	<br />
    <strong id="show_heading">Enrolled Date:</strong> <?php print htmlspecialchars($enrolleddate); ?>	<br />
		<strong id="show_heading">DOB:</strong> <?php print htmlspecialchars($dob); ?>	<br />
		<strong id="show_heading">Batch:</strong> <?php print htmlspecialchars($candrow['batchname']); ?>	<br />
    <strong id="show_heading">Address:</strong> <?php print htmlspecialchars($address); ?>	<br />
    <strong id="show_heading">Work Status:</strong> <?php print htmlspecialchars($workstatus); ?>	<br />
    <strong id="show_heading">Education:</strong> <?php print htmlspecialchars($education); ?>	<br />
    <strong id="show_heading">Wrk Experience:</strong> <?php print htmlspecialchars($workexperience); ?>	<br />
	</div>
  <h3>More Information</h3>
	<div>
    <strong id="show_heading">Sec Email:</strong> <a href=<?php print "mailto:".$secondaryemail; ?>><?php print htmlspecialchars($secondaryemail); ?></a>	<br />
    <strong id="show_heading">Sec Phone:</strong> <a href=<?php print "tel:".$secondaryphone; ?>><?php print htmlspecialchars($secondaryphone); ?></a>	<br />
    <strong id="show_heading">Emer Name:</strong> <?php print htmlspecialchars($emergcontactname); ?>	<br />
  	<strong id="show_heading">Emer Email:</strong> <a href=<?php print "mailto:".$emergcontactemail; ?>><?php print htmlspecialchars($emergcontactemail); ?></a>	<br />
    <strong id="show_heading">Emer Phone:</strong> <a href=<?php print "tel:".$emergcontactphone; ?>><?php print htmlspecialchars($emergcontactphone); ?></a>	<br />
    <strong id="show_heading">Emer Address:</strong> <?php print htmlspecialchars($emergcontactaddrs); ?>	<br />
	</div>			
  <h3>Agreements</h3>
	<div>
	</div>	

</div>	
<?php	

}

   $mysqli->close();
?>