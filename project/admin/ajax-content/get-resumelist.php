<?php
		require_once("../models/config.php");
    if(isset($_GET['keyword'])){//IF the url contains the parameter "keyword"
      $keyword =     trim($_GET['keyword']) ;//Remove any extra  space
	  $keyword = $mysqli->real_escape_string($keyword);
	  $keyword =     strtolower($keyword);
      
      $query = "select c.name, r.resumekey, c.batchname, r.resumetext, r.resumenotes from resume r, candidateresume cr, candidate c where r.id = cr.resumeid and cr.candidateid = c.candidateid and (LOWER(r.resumetext) like '%$keyword%' or LOWER(r.resumenotes) like '%$keyword%') order by batchname desc, name asc";
  		//$query = "select subject, question, answer from questions where subject like '%$keyword%' or keywords like '%$keyword%' or question like '%$keyword%'";
      //The SQL Query that will search for the word typed by the user .
    	$subject = "";
    	$prevsubject = "";      
      $result = $mysqli->query($query);
	  $num_rows = $result->num_rows;

       if($num_rows > 0){//and if atleast one record is found
			 echo('<div id="accordion" style="width:800px">');
        while ($row = $result->fetch_assoc()) {
		   $resumetext = $row['resumetext'];
		   $resumenotes = $row['resumenotes'];
		   if ($resumetext && $loggedInUser->candidate == "N") {
			   echo('<h3>' . $row['batchname'] . '-' . $row['name'] . ' - Resume</h3><div>');
			   echo('<p>' . $resumetext . '</p>');
			   echo('</div>');
		   }

		   if ($resumenotes) {
			   echo('<h3>' . $row['batchname'] . '-' . $row['name'] . ' - Notes</h3><div>');
			   echo('<p>' . $resumenotes . '</p>');
			   echo('</div>');
		   }

	   }
			 echo('</div>');
       }else {
       echo 'No Results for :"'.$_GET['keyword'].'"';//No Match found in the Database

      
      }
      }else {
       echo 'Parameter Missing in the URL';//If URL is invalid
    }
	
	$mysqli->close();
	?>
