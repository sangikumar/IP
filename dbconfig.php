<?php

$db_host = "development.cwjgdp1wxdy2.us-west-1.rds.amazonaws.com"; //Host address 
$db_name = "whiteboxqa"; //Name of Database
$db_user = "whiteboxqa"; //Name of database master user
$db_pass = "Innovapath1*"; //Password for database user

GLOBAL $DB;

try{
    $connstring = 'mysql:host='.$db_host.';dbname='.$db_name;
	  $DB = new PDO($connstring, $db_user, $db_pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'')); 
}
catch (PDOException $e) {
    echo 'DB Connection Error :'.$e->getMessage();
		die();
}

?>