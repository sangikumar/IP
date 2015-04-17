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

$rowid = jqGridUtils::GetParam("id"); 
if(!$rowid) die("Missed parameters"); 
$grid = new jqGrid($conn); 
// Write the SQL Query 
$grid->SubgridCommand = "select id, (select companyname from vendor v where v.id = vendorid) as vendor, detailprice, notes from insurancedetail where insuranceid=? ORDER BY id desc"; 
$grid->dataType = 'json'; 
// Use the build in function for the simple subgrid 
$grid->querySubGrid(array(&$rowid)); 
$conn = null; 
?> 