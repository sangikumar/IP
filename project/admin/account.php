<?php
require_once($_SERVER["DOCUMENT_ROOT"] ."/project/admin/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$page_title = $websiteName;
if (!is_object($loggedInUser)) {
    header("Location:login.php");
    exit;
}
require_once("models/header.php");
echo "
<body>
<div id='wrapper'>
<div id='top'><div id='logo'></div><div id='logo1'></div></div>
<div id='content'>
<div id='left-nav'>";

include($_SERVER["DOCUMENT_ROOT"] ."/project/admin/left-nav.php");

$userid = $loggedInUser->user_id;
$displayname = $loggedInUser->displayname;


echo "
</div>
<div id='main'>
<br>
Hey, $loggedInUser->displayname Welcome! <br>";

//If it is candidate who logs in
if ($loggedInUser->checkPermission(array(13)) or $loggedInUser->checkPermission(array(14))){

  // check if portalid is linked with candidateid
  $query = "select candidateid from candidate where portalid = $userid";
  $result = $mysqli->query($query);
	$row = $result->fetch_row();
  if (is_null($result)){
  	 echo("<br><b style='color:red'>Your account is not setup right! Please contact <a href='mailto:recruiting@innova-path.com'>recruiting@innova-path.com</a>. Please do not use Avatar if this message shows up!</b>");
		 die();
  }
  
	// display all the recent sessions taken by the candidate
	$query = "select s.`type`, s.subject, s.sessiondate, u.name instructor, s.`status`, s.feedback from session s, employee u where s.instructorid = u.id and s.candidateid = (select candidateid from candidate where portalid = $userid) order by s.sessiondate desc limit 3";
  $result = $mysqli->query($query);
  $show_th = 1;
	$show_tb = -1;
  while ($row = $result->fetch_row()){
				if ($show_th == 1) {
					  echo("<br><b>Sessions!</b><table><tr><td><table border='1'><tr><td><strong>Type</strong></td><td><strong>Subject</strong></td><td><strong>Date</strong></td><td><strong>Instructor</strong></td><td><strong>Status</strong></td><td><strong>Feedback</strong></td></tr>");
						$show_th = -1;
 				}
   			echo("<tr><td>$row[0]</td><td>$row[1]</td></td><td>$row[2]</td></td><td>$row[3]</td><td>$row[4]</td></td><td>$row[5]</td></tr>");
				$show_tb = 1;
  }
  if($show_tb == 1)
  {
   	echo("</table></td></tr></table>");
  }
	
  echo "
  </div>
  </body>
  </html>";
  die();
}// end if check for candidates

  // display list of all portal id's not linked with userid
  $query ="select c.name, c.email from candidate c where (portalid is null or portalid = '' ) and c.batchname in (select batchname from batch b where b.startdate < curdate() and c.status not in ('Defaulted' , 'Discontinued'))";
  $result = $mysqli->query($query);
	$show_th = 1;
	$show_tb = -1;
  while ($row = $result->fetch_row()){
	 if ($show_th == 1) {
	 		  echo("<br><b>Portal ID's not linked!</b><table><tr><td><table border='1'><tr><td><strong>Name</strong></td><td><strong>Email</strong></td></tr>");
				$show_th = -1;
   }
	 echo("<tr><td>$row[0]</td><td>$row[1]</td></td></tr>");
	 $show_tb = 1;
  }
  if($show_tb == 1)
  {
    echo("</table></td></tr></table>");
  }


  // display list of all upcoming employee's birthdays
  $query = "select name, dob from employee e WHERE status = '0Active' and  dob + INTERVAL EXTRACT(YEAR FROM NOW()) - EXTRACT(YEAR FROM dob) YEAR BETWEEN CURRENT_DATE() AND CURRENT_DATE() + INTERVAL 7 DAY  order by DAY(dob)";
  $result = $mysqli->query($query);

	$show_th = 1;
	$show_tb = -1;
  while($row = $result->fetch_row()){
	  if ($show_th == 1) {
			   echo("<br><b>Employee Birthdays!</b><table><tr><td><table border='1'><tr><td><strong>NAME</strong></td><td><strong>DOB</strong></td></tr>");
         $show_th = -1;
		}
    echo("<tr><td>$row[0]</td><td>$row[1]</td></td></tr>");
		$show_tb = 1 ;
		
		}
		if ($show_tb == 1) {
  	 echo("</table></td></tr></table>");
  }

  // display list of all upcoming candidate's birthdays
  $query = "select c.name, email, phone, c.dob, c.status from candidate c WHERE status not in ('Discontinued', 'Defaulted') and dob + INTERVAL EXTRACT(YEAR FROM NOW()) - EXTRACT(YEAR FROM dob) YEAR BETWEEN CURRENT_DATE() AND CURRENT_DATE() + INTERVAL 7 DAY order by DAY(dob)";
  $result = $mysqli->query($query);
	
	$show_th = 1;
	$show_tb = -1;
  while ($row = $result->fetch_row()){

	   if ($show_th == 1) {
	 		 	 echo("<br><b>Candidate Birthdays!</b><table><tr><td><table border='1'><tr><td><strong>NAME</strong></td><td><strong>EMAIL</strong></td><td><strong>PHONE</strong></td><td><strong>DOB</strong></td><td><strong>STATUS</strong></td></tr>");
				 $show_th = -1;
  	 }
  	 echo("<tr><td>$row[0]</td><td><a href='mailto:$row[1]'>$row[1]</a></td><td>$row[2]</td></td><td>$row[3]</td><td>$row[4]</td></tr>");
		 $show_tb = 1 ;
  }// end while
	if ($show_tb == 1)
  	 echo("</table></td></tr></table>");

echo "
</div>
</div>
</body>
</html>";
// close db connection
$mysqli->close();
?>