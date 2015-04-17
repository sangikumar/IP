<?php
require_once("../models/config.php");
$candidateID = $loggedInUser->candidateid;

if($_REQUEST)
{
	$candemail 	= $_REQUEST['parent_id'];
	$query = "select * from candidate where email = '$candemail'";
	$results = $mysqli->query($query);
    $candrow = $results->fetch_assoc();
	$candidateid = 	$candrow['candidateid'];	
	if(!isset($candidateid))
	{
	 $candidateid = 0;
	}
	
	$name = 	$candrow['name'];	
	$enrolleddate = 	$candrow['enrolleddate'];
	$dob = 	$candrow['dob'];
	$email = 	$candrow['email'];
	$phone = 	$candrow['phone'];
	$status = 	$candrow['status'];
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
	$feedue = 	$candrow['feedue'];
	$salary0 = 	$candrow['salary0'];
	$salary6 = 	$candrow['salary6'];
	$contracturl = 	$candrow['contracturl'];
	$empagreementurl = 	$candrow['empagreementurl'];
	$offerletterurl = 	$candrow['offerletterurl'];
	$dlurl = 	$candrow['dlurl'];
	$workpermiturl = 	$candrow['workpermiturl'];
	$ssnurl = 	$candrow['ssnurl'];
	$batchname = 	$candrow['batchname'];
	$candnotes = 	$candrow['notes'];
	$ssn = 	$candrow['ssn'];
	
	$portalid = 	$candrow['portalid'];
  $loginresult = $mysqli->query("select * from authuser where id = $portalid");
  $loginrow = $loginresult->fetch_assoc();
	$loginid = 	$loginrow['id'];	
	$uname = 	$loginrow['uname'];	
	$loginaddress = 	$loginrow['address'].' '.$loginrow['city'].' '.$loginrow['state'].' '.$loginrow['country'].' '.$loginrow['zip'];	
	$loginphone = 	$loginrow['phone'];
	$registereddate = 	$loginrow['registereddate'];
	$lastlogin = 	$loginrow['lastlogin'];
	$logincount = 	$loginrow['logincount'];

?>
<input type="hidden" name="candidateid" id="candidateid" value="<?php print $candidateid; ?>"/>
<input type="hidden" name="email" id="email" value="<?php print $email; ?>"/>

<div id="accordion" style="width:800px">
  <h3><?php print htmlspecialchars($name); ?></h3>
	<div>
    <strong id="show_heading">Email:</strong> <a href=<?php print "mailto:".$email; ?>><?php print htmlspecialchars($email); ?></a>	<br />
    <strong id="show_heading">Phone:</strong> <a href=<?php print "tel:".$phone; ?>><?php print htmlspecialchars($phone); ?></a>	<br />
    <strong id="show_heading">Enrolled Date:</strong> <?php print htmlspecialchars($enrolleddate); ?>	<br />
		<strong id="show_heading">DOB:</strong> <?php print htmlspecialchars($dob); ?>	<br />
		<strong id="show_heading">Status:</strong> <?php print htmlspecialchars($status); ?>	<br />
		<strong id="show_heading">Batch:</strong> <?php print htmlspecialchars($batchname); ?>	<br />
    <strong id="show_heading">Address:</strong> <?php print htmlspecialchars($address); ?>	<br />
    <strong id="show_heading">Work Status:</strong> <?php print htmlspecialchars($workstatus); ?>	<br />
    <strong id="show_heading">Education:</strong> <?php print htmlspecialchars($education); ?>	<br />
    <strong id="show_heading">Wrk Experience:</strong> <?php print htmlspecialchars($workexperience); ?>	<br /><br />
	</div>
  <h3>More Information</h3>
	<div>
    <strong id="show_heading">Sec Email:</strong> <a href=<?php print "mailto:".$secondaryemail; ?>><?php print htmlspecialchars($secondaryemail); ?></a>	<br />
    <strong id="show_heading">Sec Phone:</strong> <a href=<?php print "tel:".$secondaryphone; ?>><?php print htmlspecialchars($secondaryphone); ?></a>	<br />
		<strong id="show_heading">Gurantor Name:</strong> <?php print htmlspecialchars($candrow['guarantorname']); ?>	<br />
		<strong id="show_heading">Gurantor Designation:</strong> <?php print htmlspecialchars($candrow['guarantordesignation']); ?>	<br />
		<strong id="show_heading">Gurantor Company:</strong> <?php print htmlspecialchars($candrow['guarantorcompany']); ?>	<br />
    <strong id="show_heading">Emer Name:</strong> <?php print htmlspecialchars($emergcontactname); ?>	<br />
  	<strong id="show_heading">Emer Email:</strong> <a href=<?php print "mailto:".$emergcontactemail; ?>><?php print htmlspecialchars($emergcontactemail); ?></a>	<br />
    <strong id="show_heading">Emer Phone:</strong> <a href=<?php print "tel:".$emergcontactphone; ?>><?php print htmlspecialchars($emergcontactphone); ?></a>	<br />
    <strong id="show_heading">Emer Address:</strong> <?php print htmlspecialchars($emergcontactaddrs); ?>	<br /><br />
	</div>			
  <h3>Agreements</h3>
	<div>
    <strong id="show_heading">Contract:</strong> <a href=<?php print $contracturl; ?>><?php print htmlspecialchars($contracturl); ?></a>	<br />
    <strong id="show_heading">Emp Agreement:</strong> <a href=<?php print $empagreementurl; ?>><?php print htmlspecialchars($empagreementurl); ?></a>	<br />
		<strong id="show_heading">Offer Letter:</strong> <a href=<?php print $offerletterurl; ?>><?php print htmlspecialchars($offerletterurl); ?></a>	<br />
		<strong id="show_heading">DL:</strong> <a href=<?php print $dlurl; ?>><?php print htmlspecialchars($dlurl); ?></a>	<br />
		<strong id="show_heading">Work Permit:</strong> <a href=<?php print $workpermiturl; ?>><?php print htmlspecialchars($workpermiturl); ?></a>	<br />	
		<strong id="show_heading">SSN URL:</strong> <a href=<?php print $ssnurl; ?>><?php print htmlspecialchars($ssnurl); ?></a>	<br />	
    <strong id="show_heading">SSN:</strong> <?php print htmlspecialchars($ssn); ?>	<br /><br />
	</div>	
  <h3>Portal Login</h3>
	<div>
		<strong id="show_heading">Address:</strong> <?php print htmlspecialchars($loginaddress); ?>	<br />
		<strong id="show_heading">Username:</strong> <a href=<?php print "mailto:".$uname; ?>><?php print htmlspecialchars($uname); ?></a>	<br />
		<strong id="show_heading">Phone:</strong> <a href=<?php print "tel:".$loginphone; ?>><?php print htmlspecialchars($loginphone); ?></a>	<br />
		<strong id="show_heading">Last Login:</strong> <?php print htmlspecialchars($lastlogin); ?>	<br />
		<strong id="show_heading">Reg Date:</strong> <?php print htmlspecialchars($registereddate); ?>	<br />
    <strong id="show_heading">Login Count:</strong> <?php print htmlspecialchars($logincount); ?>	<br /><br />		
	</div>	
<?
	  $loginhistory = $mysqli->query("select * from loginhistory where loginid = $portalid order by logindatetime desc limit 100");
    $num_rows = $loginhistory->num_rows;
    if($num_rows > 0)
    {
       echo("<h3>Login History</h3><div>");
    }
	    while($data = $loginhistory->fetch_assoc())
    						echo( date( "Y-m-d g:i A", strtotime($data["logindatetime"])).' - '.$data["ipaddress"].'<br>');
    }
    if($num_rows > 0)
    {
       echo("</div>");
    }	

		if(isset($candnotes) && strlen($candnotes) > 0)
		{
		 echo("<h3>Notes 1</h3><div>");
		 echo($candnotes.'<br><br />');
		 echo("</div>");
		}
		
		if(isset($candrow['background']) && strlen($candrow['background']) > 0)
		{
		 echo("<h3>Background</h3><div>");
		 echo($candrow['background'].'<br><br />');
		 echo("</div>");
		}		
		
		if(isset($candrow['originalresume']) && strlen($candrow['originalresume']) > 0)
		{
		 echo("<h3>Original Resume</h3><div>");
		 echo("<a href=".$candrow['originalresume'].">".$candrow['originalresume']."</a>");
		 echo("</div>");
		}	
		
		 echo("<h3>Fee and Salary</h3><div>");
     echo('Fee Paid: '.$data["feepaid"].'<br>');
     echo('Fee Due: '.$data["feedue"].'<br>');
     echo('Term: '.$data["term"].'<br />');		 
     echo('Salary 1: '.$data["salary0"].'<br />');
     echo('Salary 2: '.$data["salary6"].'<br />');		 
		 echo("</div>");		
		
		 echo("<h3>Recruiter Assesment</h3><div>");
		 echo('<textarea name="recruiterassesment" type="text" id="recruiterassesment" rows="10" cols="80">'.$candrow['recruiterassesment'].'</textarea><br>');
		 echo('<input type="submit" name="Send" value="Update">');
		 echo("</div>");
		 
		 echo("<h3>Instructor Assesment</h3><div>");
		 echo('<textarea name="instructorassesment" type="text" id="instructorassesment" rows="10" cols="80">'.$candrow['instructorassesment'].'</textarea><br>');
		 echo('<input type="submit" name="Send" value="Update">');
		 echo("</div>");	
		 
	   $candidateassignment = $mysqli->query("select q.question, t.assignment from candidateassignment t, assignment q  where t.assignmentid = q.id and t.candidateid = $candidateid order by q.weeknumber");
	   $num_rows = $candidateassignment->num_rows;
    $count = 1;
    if($num_rows > 0)
    {
       echo("<h3>Assignment Answers</h3><div>");
	      while($data = $candidateassignment->fetch_assoc()) {
        echo($count.'.'.$data["question"].'<br>');
        echo($data["assignment"].'<br><br>');
        $count++;			 
      }			
  		echo("</div>"); 
    }
		 
    $candidateanswer = $mysqli->query("select q.question, t.answer from candidateanswers t, questions q  where t.questionid = q.id and t.candidateid = $candidateid order by q.subject, q.category, q.`type`");
	  $num_rows = $candidateanswer->num_rows;
		$count = 1;
    if($num_rows > 0)
    {
       echo("<h3>Avatar Answers</h3><div>");
    }
      while($data = $candidateanswer->fetch_assoc()) {
    	 echo($count.'.'.$data["question"].'<br>');
			 echo($data["answer"].'<br><br>');
			 $count++;
    }
    if($num_rows > 0)
    {
       echo("</div>");
    }		
		
   $session = $mysqli->query("select s.sessiondate, s.`status`, s.`type`, s.subject, s.feedback, s.title, s.link from session s, candidate c, employee e where s.instructorid = e.id and  (s.candidateid = c.candidateid or  c.candidateid = s.candidate2id or c.candidateid = s.candidate3id or c.candidateid = s.candidate4id or  c.candidateid = s.candidate5id) and c.candidateid = $candidateid order by s.sessiondate desc");
   $num_rows = $session->num_rows;
    if($num_rows > 0)
    {
       echo("<h3>Sessions</h3><div>");
    }
		$count = 1;
   while($data = $session->fetch_assoc()) {		
		 echo($count.'.'.$data['sessiondate'].' '.$data['type'].' '.$data['status'].' '.$data['subject'].' '.$data['feedback'].'<br>');
		 echo($data['title']." - Recording: <a href=".$data['link'].">".$data['link']."</a><br><br>");
		 $count++;
    }
    if($num_rows > 0)
    {
       echo("</div>");
    }		
		
    $candidatemarketing = $mysqli->query("select cm.startdate, cm.`status`, cm.priority, cm.relocation, cm.intro, e.name, cm.coverletter, cm.closedate, (select count(*) from position where candidateid = cm.candidateid) positions, (select count(*) from interview where candidateid = cm.candidateid) interviews, (select count(*) from positioncalls where candidateid = cm.candidateid) calls, (select count(*) from session where candidateid = cm.candidateid) sessions from candidatemarketing cm, employee e where cm.mmid = e.id and cm.candidateid = $candidateid order by cm.candidateid");
    $num_rows = $candidatemarketing->num_rows;
    if($num_rows > 0)
    {
       echo("<h3>Marketing Details</h3><div>");
    }
		$count = 1;
    while($data = $candidatemarketing->fetch_assoc()) {
     echo($count.'.'.'Start Date: '.$data["startdate"].'<br>');
     echo('Status: '.$data["status"].'<br>');
		 echo('Close Date: '.$data["closedate"].'<br>');
     echo('Priority: '.$data["priority"].'<br />');	
		 echo('Relocation: '.$data["relocation"].'<br />');	
		 echo('Manager: '.$data["name"].'<br />');	
		 echo('Sessions: '.$data["sessions"].'<br />');	
		 echo('Positions: '.$data["positions"].'<br />');	
		 echo('Interviews: '.$data["interviews"].'<br />');	
		 echo('Calls: '.$data["calls"].'<br />');	
		 echo('Intro: '.$data["intro"].'<br />');	
		 echo($data["coverletter"].'<br><br>');
		 $count++;
    }
    if($num_rows > 0)
    {
       echo("</div>");
    }		
    $ipemail = $mysqli->query("select ip.email, ip.password, ip.`status`, ip.forwardingemail, ip.masteremail, ip.phonestatus from candidatemarketing cm, ipemail ip where cm.ipemailid = ip.id and cm.candidateid = $candidateid order by ip.lastmoddatetime desc");
    $num_rows = $ipemail->num_rows;
    if($num_rows > 0)
    {
       echo("<h3>IPEmail Details</h3><div>");
    }
		$count = 1;
    while($data = $ipemail->fetch_assoc()) {
     echo($count.'.'.'Email: '.$data["email"].'<br>');
     echo('Password: '.$data["password"].'<br>');
		 echo('Status: '.$data["status"].'<br>');
     echo('Forwarding Email: '.$data["forwardingemail"].'<br />');	
		 echo('Master Email: '.$data["masteremail"].'<br />');	
		 echo('Phone Status: '.$data["phonestatus"].'<br><br>');	
		 $count++;
    }
    if($num_rows > 0)
    {
       echo("</div>");
    }				
		
    $position = $mysqli->query("select p.positiondate, p.`status`, p.`type`, p.`client`, p.vendor1, p.vendor1email from position p, candidate c where c.candidateid = p.candidateid and p.candidateid = $candidateid order by p.positiondate desc");
    $num_rows = $position->num_rows;
    if($num_rows > 0)
    {
       echo("<h3>Positions</h3><div>");
    }
		$count = 1;
    while($data = $position->fetch_assoc()) {	
		 echo($count.'.'.$data['positiondate'].' '.$data['type'].' '.$data['status'].' '.$data['client'].' '.$data['vendor1']);
		 echo(" <a href=mailto:".$data['vendor1email'].">".$data['vendor1email']."</a><br><br>");
		 $count++;
    }
    if($num_rows > 0)
    {
       echo("</div>");
    }		
    $positioncalls = $mysqli->query("select p.positiondate, p.`client`, p.vendorcompany, p.vendoremail, p.solicitation from positioncalls p, candidate c where c.candidateid = p.candidateid and p.candidateid = $candidateid order by p.positiondate desc");
    $num_rows = $positioncalls->num_rows;
    if($num_rows > 0)
    {
       echo("<h3>Calls</h3><div>");
    }
		$count = 1;
     while($data = $positioncalls->fetch_assoc()) {		
		 echo($count.'.'.$data['positiondate'].' '.$data['client'].' '.$data['vendorcompany'].' Solicitation: '.$data['solicitation']);
		 echo(" <a href=mailto:".$data['vendoremail'].">".$data['vendoremail']."</a><br><br>");
		 $count++;
    }
    if($num_rows > 0)
    {
       echo("</div>");
    }					
    $interview = $mysqli->query("select i.interviewdate, i.`type`, i.`status`, i.clientname, i.result, i.reclink, i.questionslink  from interview i where i.candidateid = $candidateid order by i.interviewdate desc");
    $num_rows = $interview->num_rows;
    if($num_rows > 0)
    {
       echo("<h3>Interviews</h3><div>");
    }
		$count = 1;
    while($data = $interview->fetch_assoc()) {
		 echo($count.'.'.$data['interviewdate'].' '.$data['type'].' '.$data['status'].' '.$data['clientname'].' '.$data['result'].'<br>');
		 echo("Recording: <a href=".$data['reclink'].">".$data['reclink']."</a> - Questions: <a href=".$data['questionslink'].">".$data['questionslink']."</a><br><br>");
		 $count++;
    }
    if($num_rows > 0)
    {
       echo("</div>");
    }		
		
						 	 

	/*  $assesment = mysql_query("select * from candidateprogress where candidateid = $candidateid limit 1");
    $num_rows = mysql_num_rows($assesment);
    if($num_rows > 0)
    {
       echo("<h3>Assesment</h3><div>");
    }
    while($data = mysql_fetch_array($assesment)){
    						echo('Communication: '.$data["communication"].'<br>');
								echo('Type: '.$data["type"].'<br>');
								echo('Assesment: '.$data["assesment"].'<br><br />');
    }
    if($num_rows > 0)
    {
       echo("</div>");
    }			
		
	  $marketing = mysql_query("select * from candidatemarketing where candidateid = $candidateid order by startdate desc limit 10");
    $num_rows = mysql_num_rows($marketing);
    if($num_rows > 0)
    {
       echo("<h3>Marketing</h3><div>");
    }
    while($data = mysql_fetch_array($marketing)){
				$mmid = $data["mmid"];
				$ipemailid = $data["ipemailid"];
				$resumeid = $data["resumeid"];
				$feedback = $data["feedback"];
				$coverletter = $data["coverletter"];
				$mktnotes = $data["notes"];
				
				$mmresult = mysql_query("select * from employee where id = $mmid");
				if (is_resource($mmresult)) { 
          $mmrow = mysql_fetch_array($mmresult);	
    			$mmname = $mmrow["name"];				  		
				}									
				
        $feedback = mysql_query("select * from feedback where id = $feedback");        	
				if (is_resource($feedback)) { 
  				$frow = mysql_fetch_array($feedback);
  				$trainingmessage = $frow["trainingmessage"];		
  				$companymessage = $frow["companymessage"];	
  				$improvemessage = $frow["improvemessage"];
				}				
	
        echo('Create Date: '.$data["startdate"].' - '.'MM: '.$mmname.'<br>');
				echo('Status: '.$data["status"].' - '.'Priority: '.$data["priority"].'<br>');
				echo('Start: '.$data["mmstartdate"].' - '.'End: '.$data["mmfinaldate"].'<br>');
				echo('Closed Date: '.$data["closedate"].'<br><br>');
    }
    if($num_rows > 0)
    {
       echo("</div>");
    }			
		
		
	  $ipemail = mysql_query("select * from ipemail where id = $ipemailid limit 1");
    $num_rows = mysql_num_rows($ipemail);
    if($num_rows > 0)
    {
       echo("<h3>IP Email</h3><div>");
    }
    while($data = mysql_fetch_array($ipemail)){
        echo('IP Email: '.$data["email"].'<br>');
				echo('IP Phone: '.$data["phone"].'<br>');
				echo('IP Password: '.$data["password"].'<br>');
				echo('IP Status: '.$data["status"].'<br>');
				echo('Master Email: '.$data["masteremail"].'<br>');
				echo('Forwarded: '.$data["forwardingemail"].'<br><br>');
    }
    if($num_rows > 0)
    {
       echo("</div>");
    }			
	
		$sessions = mysql_query("select * from session where candidateid = $candidateid or candidate2id = $candidateid  or candidate3id = $candidateid  or candidate4id = $candidateid or candidate5id = $candidateid order by sessiondate desc");
    $num_rows = mysql_num_rows($sessions);
    if($num_rows > 0)
    {
       echo("<h3>Sessions</h3><div>");
			 echo('Count: '.$num_rows.'<br>');
    }
    while($data = mysql_fetch_array($sessions)){			
				$instructorid = $data["instructorid"];	
				$instructor = mysql_query("select * from employee where id = $instructorid");
				if (is_resource($instructor)) { 
          $instructorrow = mysql_fetch_array($instructor);	
    			$instructorname = $instructorrow["name"];				  		
				}		
				echo($data["sessiondate"].' - '.$data["type"].' - '.$instructorname.' - '.$data["status"].' - '.$data["feedback"].'<br />');
    }
    if($num_rows > 0)
    {
       echo("<br></div>");
    }		
		
	  $interviews = mysql_query("select * from interview where candidateid = $candidateid order by interviewdate desc");
    $num_rows = mysql_num_rows($interviews);
    if($num_rows > 0)
    {
       echo("<h3>Interviews</h3><div>");
			 echo('Count: '.$num_rows.'<br>');
    }
    while($data = mysql_fetch_array($interviews)){
				echo($data["interviewdate"].' - '.$data["type"].' - '.$data["clientname"].' - '.$data["vendor1"].' - '.$data["result"].'<br>');
    }
    if($num_rows > 0)
    {
       echo("<br></div>");
    }			
		
	  $positions = mysql_query("select * from position where candidateid = $candidateid order by positiondate desc");
    $num_rows = mysql_num_rows($positions);
    if($num_rows > 0)
    {
       echo("<h3>Positions</h3><div>");
			 echo('Count: '.$num_rows.'<br>');
    }
    while($data = mysql_fetch_array($positions)){
				echo($data["positiondate"].' - '.$data["type"].' - '.$data["client"].' - '.$data["vendor1"].' - '.$data["status"].'<br>');
    }
    if($num_rows > 0)
    {
       echo("<br></div>");
    }		
		
	  $positioncalls = mysql_query("select * from positioncalls where candidateid = $candidateid order by positiondate desc");
    $num_rows = mysql_num_rows($positioncalls);
    if($num_rows > 0)
    {
       echo("<h3>Position Calls</h3><div>");
			 echo('Count: '.$num_rows.'<br>');
    }
    while($data = mysql_fetch_array($positioncalls)){
				echo($data["positiondate"].' - '.$data["client"].' - '.$data["vendorcompany"].' - '.$data["status"].'<br />');
    }
    if($num_rows > 0)
    {
       echo("<br></div>");
    }	
		
	  $placements = mysql_query("select p.* from placement p, candidate c where p.candidateid = c.candidateid and c.candidateid = $candidateid order by startdate desc limit 10");
    $num_rows = mysql_num_rows($placements);
    if($num_rows > 0)
    {
       echo("<h3>Placements</h3><div>");
    }
    while($data = mysql_fetch_array($placements)){
				$startdate = $data["startdate"];
				$enddate = $data["enddate"];
				$status = $data["status"];
				$wrkemail = $data["wrkemail"];
				$mktid = $data["mmid"];
				$vendorid = $data["vendorid"];
				$clientid = $data["clientid"];
				$placementid = $data["id"];
				
				$mmresult = mysql_query("select * from employee where id = $mktid");
				if (is_resource($mmresult)) { 
          $mmrow = mysql_fetch_array($mmresult);	
    			$mmname = $mmrow["name"];				  		
				}									
				
        $vendor = mysql_query("select * from vendor where id = $vendorid");        	
				if (is_resource($vendor)) { 
  				$frow = mysql_fetch_array($vendor);
  				$vendorname = $frow["companyname"];		
				}				
				
        $client = mysql_query("select * from client where id = $clientid");        	
				if (is_resource($client)) { 
  				$frow = mysql_fetch_array($client);
  				$clientname = $frow["companyname"];		
				}		
        echo($mmname.' - '.$vendorname.' - '.$clientname.'<br>');
        echo($startdate.' - '.$enddate.' - '.$status.' - '.$wrkemail.'<br>');
			
        $po = mysql_query("select * from po where placementid = $placementid");        	
				if (is_resource($po)) { 
  				while($frow = mysql_fetch_array($po)){
    				$begindate = $frow["begindate"];	
  					$enddate = $frow["enddate"];
  					$rate = $frow["rate"];
  					$frequency = $frow["frequency"];
  					$freqtype = $frow["freqtype"];	
  					$invoicenet = $frow["invoicenet"];	
  					$invoicestartdate = $frow["invoicestartdate"];		
  					$polink = $frow["polink"];	
  					echo('PO: '.$begindate.' - '.$enddate.' - '.$rate.' - '.$freqtype.' - '.$frequency.' - '.$invoicenet.' - '.$invoicestartdate.'<br>');
  					echo('PO Link: <a href="'.$polink.'">'.$polink.'</a><br><br>');						
					}				
				}					
    }
    if($num_rows > 0)
    {
       echo("</div>");
    }				
		
		
	  $invoices = mysql_query("select i.* from invoice i, po p, placement pl where i.poid = p.id and p.placementid = pl.id and pl.candidateid = $candidateid order by invoicedate desc");
    $num_rows = mysql_num_rows($invoices);
    if($num_rows > 0)
    {
       echo("<h3>Invoices</h3><div>");
			 echo('Count: '.$num_rows.'<br>');
    }
    while($data = mysql_fetch_array($invoices)){
				echo($data["invoicenumber"].' - '.$data["startdate"].' - '.$data["enddate"].' - '.$data["invoicedate"].' - '.$data["status"].' - '.$data["quantity"].' - '.$data["amountreceived"].'<br />');
    }
    if($num_rows > 0)
    {
       echo("<br></div>");
    }			
		
	  $payments = mysql_query("select i.* from payment i, po p, placement pl where i.poid = p.id and p.placementid = pl.id and pl.candidateid = $candidateid order by paiddate desc");
    $num_rows = mysql_num_rows($payments);
    if($num_rows > 0)
    {
       echo("<h3>Payments</h3><div>");
			 echo('Count: '.$num_rows.'<br>');
    }
    while($data = mysql_fetch_array($payments)){
				echo($data["type"].' - '.$data["periodbegindate"].' - '.$data["periodenddate"].' - '.$data["paiddate"].' - '.$data["status"].' - '.$data["amount"].' - '.$data["employertaxes"].'<br />');
    }
    if($num_rows > 0)
    {
       echo("<br></div>");
    }			
		
	  $resume = mysql_query("select * from resume where id = $resumeid order by createdate desc limit 1");
    while($data = mysql_fetch_array($resume)){
				$resumekey = $data["resumekey"];
				$resumelink = $data["link"];
				$application1 = $data["application1"];
				$client1 = $data["client1"];
				$project1 = $data["project1"];
				$notes1 = $data["notes1"];
				$notes1link = $data["notes1link"];			
				$application2 = $data["application2"];
				$client2 = $data["client2"];
				$project2 = $data["project2"];
				$notes2 = $data["notes2"];
				$notes2link = $data["notes2link"];			
				$intro = $data["intro"];																							
	    }

		if(isset($resumekey))
		{
		 echo("<h3>Resume Setup</h3><div>");
		 echo('Resume Link: <a href="'.$resumelink.'">'.$resumelink.'</a><br>');
		 echo('Key: '.$resumekey.'<br>');
		 echo('Application 1: '.$application1.'<br>');
		 echo('Client 1: '.$client1.'<br>');
		 echo('Notes 1 Link: <a href="'.$notes1link.'">'.$notes1link.'</a><br>');
		 echo('Intro: <br>');
		 echo('<textarea name="intro" type="text" id="intro" rows="5" cols="80">'.$intro.'</textarea><br>');
		 echo("</div>");
		}					
		
		if(isset($project1))
		{
		 echo("<h3>Resume Part 1</h3><div>");
		 echo('Project 1: <br>');
		 echo('<textarea name="project1" type="text" id="project1" rows="5" cols="80">'.$project1.'</textarea>');
		 echo('Notes 1: <br>');
		 echo('<textarea name="notes1" type="text" id="notes1" rows="5" cols="80">'.$notes1.'</textarea><br>');
		 echo("</div>");
		}				
		
		if(isset($project2))
		{
		 echo("<h3>Resume Part 2</h3><div>");
		 echo('Project 2: <br>');
		 echo('<textarea name="project2" type="text" id="project2" rows="5" cols="80">'.$project2.'</textarea>');
		 echo('Notes 2: <br>');
		 echo('<textarea name="notes2" type="text" id="notes2" rows="5" cols="80">'.$notes2.'</textarea><br>');
		 echo("</div>");
		}					
				
		if(isset($coverletter))
		{
		 echo("<h3>Coverletter</h3><div>");
		 echo('<textarea name="coverletter" type="text" id="coverletter" rows="5" cols="80">'.$coverletter.'</textarea><br>');
		 echo("</div>");
		}	
		
		if(isset($mktnotes))
		{
		 echo("<h3>Mkt Notes</h3><div>");
		 echo('<textarea name="mktnotes" type="text" id="mktnotes" rows="5" cols="80">'.$mktnotes.'</textarea><br>');
		 echo("</div>");
		}		
		
		if(isset($trainingmessage))
		{
		 echo("<h3>Training Feedback</h3><div>");
		 echo('<textarea name="trainingmessage" type="text" id="trainingmessage" rows="5" cols="80">'.$trainingmessage.'</textarea><br>');
		 echo("</div>");
		}
		
		if(isset($companymessage))
		{
		 echo("<h3>Company Feedback</h3><div>");
		 echo('<textarea name="companymessage" type="text" id="companymessage" rows="5" cols="80">'.$companymessage.'</textarea><br>');
		 echo("</div>");
		}
		
		if(isset($improvemessage))
		{
		 echo("<h3>Improve Message</h3><div>");
		 echo('<textarea name="improvemessage" type="text" id="improvemessage" rows="5" cols="80">'.$improvemessage.'</textarea><br>');
		 echo("</div>");
		}		*/
		
?>
</div>	
<?php	

$mysqli->close();	
?>