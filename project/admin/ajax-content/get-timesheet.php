<?php

if(isset($_GET['keyword']))
{
	$id 	= trim($_GET['keyword']);
	$upper = strtoupper($id);
	$ucf = ucfirst($id);
	chdir(".././timesheets/"); 
  foreach (glob("*$id*", GLOB_BRACE) as $filename) {
	 		echo "<a href='timesheets/$filename' target='_blank'>$filename </a><br>";
  }	
  foreach (glob("*$upper*", GLOB_BRACE) as $filename) {
      echo "<a href='timesheets/$filename' target='_blank'>$filename </a><br>";
  }	
  foreach (glob("*$ucf*", GLOB_BRACE) as $filename) {
      echo "<a href='timesheets/$filename' target='_blank'>$filename </a><br>";
  }			
}
?>
