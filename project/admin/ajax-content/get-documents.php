<?php

require_once("../models/config.php");

if($_REQUEST)
{
  $id 	= $_REQUEST['parent_id'];
  $pieces = explode("-", $id);
 
  if ($loggedInUser->checkPermission(array(14)) || $loggedInUser->checkPermission(array(13))){
    $result = $mysqli->query("select d.description, d.link from document d where d.status = 'active' and iscandidate='Y'  and d.`type` = '$pieces[0]' and d.category = '$pieces[1]'");

  }
  else
  {
   $result = $mysqli->query("select d.description, d.link from document d where d.status = 'active' and d.`type` = '$pieces[0]' and d.category = '$pieces[1]'");
  }


  $num_rows = $result->num_rows;
  if($num_rows > 0)
  {
  echo("<tr><td>&nbsp;</td><td><ol>");
  }

  while($data = $result->fetch_row()) {
  						echo("<li><a href='$data[1]' target='_blank'>$data[0]</a></li>");
  }
  if($num_rows > 0)
  {
  echo("</ol></td></tr>");
  }
$mysqli->close();
}?>	