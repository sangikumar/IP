<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/project/admin/models/db-settings.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/project/admin/models/class.mail.php");
	
if(isset($_FILES["myfile"]))
{
	$ret = array();
	if($_POST['type'] == "timesheet")
	{
	//	$output_dir = "../timesheets/";
	  $output_dir = $_SERVER["DOCUMENT_ROOT"]."/ip-uploads/timesheets/";
		$poid = $_POST['poid'];		
		$row = $DB->GetRow("select cl.companyname, replace(c.name, ' ', '-') candname, p.id poid from po p, placement pl, candidate c, client cl where p.id = $poid and p.placementid = pl.id and pl.candidateid = c.candidateid and pl.clientid = cl.id");	
		$candidatename = $row[1];	
		$companyname = $row[0];
		$prefix = $poid."-".$candidatename;
	}
	if($_POST['type'] == "projectfile")
	{
	//	$output_dir = "../projectfiles/";	
	  $output_dir = $_SERVER["DOCUMENT_ROOT"]."/ip-uploads/projectfiles/";
		$placementid = $_POST['placementid'];		
		$row = $DB->GetRow("select replace(cl.companyname, ' ', '-'), replace(c.name, ' ', '-') candname from placement pl, candidate c, client cl where pl.id = $placementid and pl.candidateid = c.candidateid and pl.clientid = cl.id");	
		$candidatename = $row[1];	
		$companyname = $row[0];
		$prefix = $placementid."-".$companyname;
	}
	if($_POST['type'] == "originalresume")
	{
		$output_dir = "../../../uploads/";	
		$candidateid = $_POST['candidateid'];		
		$prefix = $candidateid."";
	}	

	//You need to handle  both cases
	//If Any browser does not support serializing of multiple files using FormData() 
	if(!is_array($_FILES["myfile"]["name"])) //single file
	{		
		$fileName = $prefix."_".$_FILES["myfile"]["name"];
 		move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName);
		$ret[]= $fileName;
	}
	else  //Multiple files, file[]
	{
	  $fileCount = count($_FILES["myfile"]["name"]);
	  for($i=0; $i < $fileCount; $i++)
	  {
	  	$fileName = $prefix."_".$_FILES["myfile"]["name"][$i];
		move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName);
	  	$ret[]= $fileName;
	  }	
	}
	
	$mail = new userCakeMail();
	if($type == "timesheet")
	{
		$link = "http://project/admin/timesheets/".$fileName;
		$message = "Candidate Name: ".$candidatename."<br>";
		$message .= "Client Name: ".$companyname."<br>";	
		$message .= "PO ID: ".$poid."<br>";
		$message .= "Timesheet: <a target='_blank' href='".$link."'>".$link."</a><br>";		
		$mail->sendMail("hr@innova-path.com","Timesheet Uploaded ".$candidatename, $message);		
	}
	if($_POST['type'] == "projectfile")
	{
 		$link = "http://project/admin/projectfiles/".$fileName;
		$message .= "Client Name: ".$companyname."<br>";	
		$message = "Candidate Name: ".$candidatename."<br>";
		$message .= "File: <a target='_blank' href='".$link."'>".$link."</a><br>";		
		$mail->sendMail("training@innova-path.com","Project File Uploaded ".$companyname, $message);
	}		
	if($_POST['type'] == "originalresume")
	{
 		$link = "http://uploads/".$fileName;
		$message .= "Resume is uploaded through candidate portal.<br>";	
		$message .= "File: <a target='_blank' href='".$link."'>".$link."</a><br>";		
		$mail->sendMail("training@innova-path.com","Candidate Resume Uploaded ", $message);
		$mail->sendMail("recruiting@innova-path.com","Candidate Resume Uploaded ", $message);
		$ok = $DB->Execute("update candidate c set c.originalresume = '$link' where c.candidateid = $candidateid");
	}	
	echo json_encode($ret);
 }
 ?>