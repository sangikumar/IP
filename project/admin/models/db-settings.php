<?php
include($_SERVER["DOCUMENT_ROOT"] . "/project/php/adodb5/adodb.inc.php");
$db_host = "development.cwjgdp1wxdy2.us-west-1.rds.amazonaws.com"; //Host address (most likely localhost)
$db_name = "whiteboxqa"; //Name of Database
$db_user = "whiteboxqa"; //Name of database user
$db_pass = "Innovapath1*"; //Password for database user
$db_table_prefix = "uc_";

GLOBAL $errors;
GLOBAL $successes;
GLOBAL $mysqli;

$errors = array();
$successes = array();

/* Create a new mysqli object with database connection parameters */
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);


if(mysqli_connect_errno()) {
	echo "Connection Failed: " . mysqli_connect_errno();
	exit();
}

GLOBAL $DB;

try{
    $connstring = 'mysql:host='.$db_host.';dbname='.$db_name;
	  $DB = new PDO($connstring, $db_user, $db_pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'')); 
}
catch (PDOException $e) {
    echo 'DB Connection Error :'.$e->getMessage();
		die();
}

//Direct to install directory, if it exists
if(is_dir("install/"))
{
	header("Location: install/");
	die();

}

?>