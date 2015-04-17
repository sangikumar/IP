<?php 
include_once ("../ip-config.php");
require_once '../jq-config.php';
// include the jqGrid Class
require_once ABSPATH."php/jqGrid.php";
// include the driver class
require_once ABSPATH."php/jqGridPdo.php";
// Connection to the server
$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);
// Tell the db that we use utf-8
$conn->query("SET NAMES utf8");
$rowid = jqGridUtils::Strip($_REQUEST["rowid"]); 
if(!$rowid) die("Missed parameters"); 
// Get details 
$SQL = "SELECT notes FROM project, priority, status WHERE id =".(int)$rowid; 
$qres = jqGridDB::query($conn, $SQL); 
$result = jqGridDB::fetch_assoc($qres,$conn); 
$s = "<table width='60%' align='left'><tbody>"; 
$s .= "<tr><td width='15%'><b>Notes</b></td><td width='85%'>".$result["notes"]."</td></tr>"; 
$s .= "<tr><td width='15%'><b>&nbsp;</b></td><td width='85%'>&nbsp;</td></tr>"; 
$s .= "<tr><td width='15%'><b>Priority</b></td><td width='85%'>".$result["priority"]."</td></tr>"; 
$s .= "<tr><td width='15%'><b>&nbsp;</b></td><td width='85%'>&nbsp;</td></tr>"; 
$s .= "<tr><td width='15%'><b>Status</b></td><td width='85%'>".$result["status"]."</td></tr>"; 
$s .= "<tr><td width='15%'><b>&nbsp;</b></td><td width='85%'>&nbsp;</td></tr>"; 
$s .= "</tbody></table>"; 
echo $s; 
jqGridDB::closeCursor($qres); 
?> 