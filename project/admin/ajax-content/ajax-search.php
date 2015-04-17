<?php
  if(isset($_GET['keyword'])){//IF the url contains the parameter "keyword"
      $keyword = trim($_GET['keyword']) ;//Remove any extra  space
      $keyword = mysql_real_escape_string($keyword);//Some validation
      
      $query = "select IF(subject<>'',subject,category) as ssubject, question, answer from questions q where subject like '%$keyword%' or category like '%$keyword%' or type like '%$keyword%' or answer like '%$keyword%' or keywords like '%$keyword%' or question like '%$keyword%' union select 'Candidate Interview' as ssubject, concat('<a href=''', questionslink, '''>',questionslink,'</a>') as question, '' as answer from interview where questionslink <> '' and clientname like '%$keyword%' or vendor1 like '%$keyword%' or questionskeywords like '%$keyword%' order by ssubject";
  		//$query = "select subject, question, answer from questions where subject like '%$keyword%' or keywords like '%$keyword%' or question like '%$keyword%'";
      //The SQL Query that will search for the word typed by the user .
    	$subject = "";
    	$prevsubject = "";      
	    $result = $mysqli->query($query);
      if ($result->num_rows > 0) {
       while($row = $result->fetch_assoc()){ //Display the record
			 
			  $subject = $row['ssubject'];
    		if($subject != $prevsubject)
    		{
    		 echo("<br><h3>$subject</h3>");
    		}	 
				echo '<p> '.$row['question'].'</p>'   ;
				$prevsubject = $subject;
       }
       }else {
       echo 'No Results for :"'.$_GET['keyword'].'"';//No Match found in the Database
       }
      

      }else {
       echo 'Parameter Missing in the URL';//If URL is invalid
    }

	    $mysqli->close();
	?>
