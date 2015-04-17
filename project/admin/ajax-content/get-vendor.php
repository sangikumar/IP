<?php
require_once("../models/config.php");
$candidateID = $loggedInUser->candidateid;

if($_REQUEST)
{
	$id 	= $_REQUEST['parent_id'];	
  $result = $mysqli->query("select * from vendor where email = '$id'");

  $row = $result->fetch_assoc();
	$vendorid = 	$row["id"];	
	$name = 	$row["companyname"];	
	$url = 	$row["url"];
	$clients = 	$row["clients"];
	$solicited = 	$row["solicited"];
	$cul = 	$row["culture"];
	$hirebeforeterm = 	$row["hirebeforeterm"];
	$hireafterterm = 	$row["hireafterterm"];
	$minrate = 	$row["minrate"];
	$latepayments = 	$row["latepayments"];
	$totalnetterm = 	$row["totalnetterm"];
	$defaultedpayment = 	$row["defaultedpayment"];
	$email = 	$row["email"];
	$phone = 	$row["phone"];
	$fax = 	$row["fax"];
	$address = 	$row["address"]." ".$row["city"]." ".$row["country"]." ".$row["zip"];
	$status = 	$row["status"];
	$accountnumber = 	$row["accountnumber"];	
	$tier = 	$row["tier"];
	$hrname = 	$row["hrname"];
	$hremail = 	$row["hremail"];
	$hrphone = 	$row["hrphone"];
	$managername = 	$row["managername"];		
	$manageremail = 	$row["manageremail"];
	$managerphone = 	$row["managerphone"];
	$secondaryname = 	$row["secondaryname"];
	$secondaryemail = 	$row["secondaryemail"];		
	$secondaryphone = 	$row["secondaryphone"];
	$timsheetemail = 	$row["timsheetemail"];
	$agreementname = 	$row["agreementname"];
	$agreementlink = 	$row["agreementlink"];		
	$subcontractorlink = 	$row["subcontractorlink"];
	$nonsolicitationlink = 	$row["nonsolicitationlink"];
	$nonhirelink = 	$row["nonhirelink"];
	$notes = 	$row["notes"];					
	
	if(!isset($agreementname))
	{
	 $agreementname = "MSA";
	}	
	if(!isset($name))
	{
	 $name = "No Name";
	}
}
?>
<input type="hidden" name="vendorid" id="vendorid" value="<?php print $id; ?>"/>
<input type="hidden" name="email" id="email" value="<?php print $email; ?>"/>
<div id="accordion" style="width:800px">
  <h3><?php print htmlspecialchars($name); ?></h3>
	<div>
    <strong id="show_heading">Status:</strong> <?php print htmlspecialchars($status); ?>	<br />
		<strong id="show_heading">Tier:</strong> <?php print htmlspecialchars($vendortier[$tier]); ?>	<br />
		<strong id="show_heading">Culture:</strong> <?php print htmlspecialchars($culture[$cul]); ?>	<br />
    <strong id="show_heading">Solicited:</strong> <?php print htmlspecialchars($solicited); ?>	<br />
    <strong id="show_heading">Hire Before Term:</strong> <?php print htmlspecialchars($hirebeforeterm); ?>	<br />
    <strong id="show_heading">Hire After Term:</strong> <?php print htmlspecialchars($hireafterterm); ?>	<br />
		<strong id="show_heading">Min Rate:</strong> <?php print htmlspecialchars($minrate); ?>	<br />
		<strong id="show_heading">Account Number:</strong> <?php print htmlspecialchars($accountnumber); ?>	<br />
	</div>
	
	<h3>Clients</h3>
	<div>
    <textarea name="clients" id="clients" type="text" rows="20" cols="80"><?php print $clients; ?></textarea><br>
		<input type="submit" name="Send" value="Update">
	</div>	
	
  <h3>HR</h3>
	<div>
		<strong id="show_heading">Late Payments:</strong> <?php print htmlspecialchars($latepayments); ?>	<br />
		<strong id="show_heading">Total Net Term:</strong> <?php print htmlspecialchars($totalnetterm); ?>	<br />
		<strong id="show_heading">Defaulted Payment:</strong> <?php print htmlspecialchars($defaultedpayment); ?>	<br />	
    <strong id="show_heading">HR Name:</strong> <?php print htmlspecialchars($hrname); ?>	<br />
		<strong id="show_heading">HR Email:</strong> <a href=<?php print "mailto:".$hremail; ?>><?php print htmlspecialchars($hremail); ?></a>	<br />
    <strong id="show_heading">HR Phone:</strong> <a href=<?php print "tel:".$hrphone; ?>><?php print htmlspecialchars($hrphone); ?></a>	<br />
    <strong id="show_heading">Timesheet Email:</strong> <a href=<?php print "mailto:".$timsheetemail; ?>><?php print htmlspecialchars($timsheetemail); ?></a>	<br />
	</div>			
	
  <h3>Contact</h3>
	<div>
    <strong id="show_heading">URL:</strong> <a href=<?php print $url; ?>><?php print htmlspecialchars($url); ?></a>	<br />
    <strong id="show_heading">Email:</strong> <a href=<?php print "mailto:".$email; ?>><?php print htmlspecialchars($email); ?></a>	<br />
    <strong id="show_heading">Phone:</strong> <a href=<?php print "tel:".$phone; ?>><?php print htmlspecialchars($phone); ?></a>	<br />
    <strong id="show_heading">Fax:</strong> <a href=<?php print "tel:".$fax; ?>><?php print htmlspecialchars($fax); ?></a>	<br />
    <strong id="show_heading">Address:</strong> <?php print htmlspecialchars($address); ?>	<br />
	</div>	
	
  <h3>Manager/Other Contacts</h3>
	<div>
    <strong id="show_heading">Mgr Name:</strong> <?php print htmlspecialchars($managername); ?>	<br />
		<strong id="show_heading">Mgr Email:</strong> <a href=<?php print "mailto:".$manageremail; ?>><?php print htmlspecialchars($manageremail); ?></a>	<br />
    <strong id="show_heading">Mgr Phone:</strong> <a href=<?php print "tel:".$managerphone; ?>><?php print htmlspecialchars($managerphone); ?></a>	<br />
    <strong id="show_heading">Sec Name:</strong> <?php print htmlspecialchars($secondaryname); ?>	<br />
		<strong id="show_heading">Sec Email:</strong> <a href=<?php print "mailto:".$secondaryemail; ?>><?php print htmlspecialchars($secondaryemail); ?></a>	<br />
    <strong id="show_heading">Sec Phone:</strong> <a href=<?php print "tel:".$secondaryphone; ?>><?php print htmlspecialchars($secondaryphone); ?></a>	<br />
	</div>		
	
  <h3>Agreements</h3>
	<div>
		<strong id="show_heading"><?php print htmlspecialchars($agreementname); ?>:</strong> <a target="_blank" href=<?php print $agreementlink; ?>><?php print htmlspecialchars($agreementlink); ?></a>	<br />
		<strong id="show_heading">Sub Contractor Link:</strong> <a target="_blank" href=<?php print $subcontractorlink; ?>><?php print htmlspecialchars($subcontractorlink); ?></a>	<br />
		<strong id="show_heading">NSA Link:</strong> <a target="_blank" href=<?php print $nonsolicitationlink; ?>><?php print htmlspecialchars($nonsolicitationlink); ?></a>	<br />
		<strong id="show_heading">Non Hire Link:</strong> <a target="_blank" href=<?php print $nonhirelink; ?>><?php print htmlspecialchars($nonhirelink); ?></a>	<br />		
	</div>	
	
  <h3>Notes</h3>
	<div>
    <strong id="show_heading">Notes:</strong> <?php print htmlspecialchars($notes); ?>	<br />
	</div>
	
  <?php
  $result = $mysqli->query("select p.startdate, p.enddate, p.status, c.name as candidatename, cl.companyname as clientname from placement p, candidate c, client cl where p.candidateid = c.candidateid and p.clientid = cl.id and p.vendorid = $vendorid order by startdate desc limit 10");

  $num_rows = $result->num_rows;
  if($num_rows > 0)
  {
     echo("<h3>Placements</h3><div>");
  }
  while($data = $result->fetch_row()) {
  						echo($data[3].' - '.$data[4].' - '.$data[2].' - '.$data[0].' - '.$data[1].'<br>');
  }
  if($num_rows > 0)
  {
     echo("</div>");
  }			
 $result = $mysqli->query("select p.positiondate, c.name, p.vendor1email  from position p, recruiter r, candidate c where r.vendorid = $vendorid and p.candidateid = c.candidateid and (r.email = p.vendor1email or r.email = p.vendor2email or r.email = p.vendor3email) order by p.positiondate desc limit 10");

  $num_rows = $result->num_rows;
    if($num_rows > 0)
    {
       echo("<h3>Positions</h3><div>");
    }

    while($data = $result->fetch_row()) {
    						echo($data[0].' - '.$data[1].' - '.$data[2].' - '.$data[3].'<br>');
    }
    if($num_rows > 0)
    {
       echo("</div>");
    }		
	
  $result = $mysqli->query("SELECT name, email, phone FROM recruiter where vendorid = $vendorid order by lastmoddatetime desc limit 20");

  $num_rows = $result->num_rows;
    if($num_rows > 0)
    {
       echo("<h3>Recruiters</h3><div>");
    }

   while($data = $result->fetch_row()) {
    						echo($data[0].' - '.$data[1].' - '.$data[2].'<br>');
    }
    if($num_rows > 0)
    {
       echo("</div>");
    }				
    $result = $mysqli->query("select vc.calldate, r.name, r.email, r.phone from vendorcalls vc, recruiter r where vc.recruiterid = r.id and r.vendorid = $vendorid order by calldate desc limit 10");  $num_rows = mysql_num_rows($rs);
    if($num_rows > 0)
    {
       echo("<h3>Calls</h3><div>");
    }
    while($data = $result->fetch_row()) {
    						echo($data[0].' - '.$data[1].' - '.$data[2].' - '.$data[3].'<br>');
    }
    if($num_rows > 0)
    {
       echo("</div>");
    }		
		
    $result = $mysqli->query("select vc.saledate, r.name, r.email, r.phone from vendorsales vc, recruiter r where vc.recruiterid = r.id and r.vendorid = $vendorid order by saledate desc limit 10");    $num_rows = mysql_num_rows($rs);
    $num_rows = $result->num_rows;
  if($num_rows > 0)
    {
       echo("<h3>Sales</h3><div>");
    }
    while ($data = $result->fetch_row()) {
    						echo($data[0].' - '.$data[1].' - '.$data[2].' - '.$data[3].'<br>');
    }
    if($num_rows > 0)
    {
       echo("</div>");
    }		
		
   $result = $mysqli->query("select vc.meetdate, r.name, r.email, r.phone from vendormeet vc, recruiter r where vc.recruiterid = r.id and r.vendorid = $vendorid order by meetdate desc limit 10");  $num_rows = mysql_num_rows($rs);
    $num_rows = $result->num_rows;
  if($num_rows > 0)
    {
       echo("<h3>Meets</h3><div>");
    }
    while($data = $result->fetch_row()) {
    						echo($data[0].' - '.$data[1].' - '.$data[2].' - '.$data[3].'<br>');
    }
    if($num_rows > 0)
    {
       echo("</div>");
    }																
  ?>		
	
</div>


<?php
  $mysqli->close();
?>
