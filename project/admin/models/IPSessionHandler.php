<?php
require('DbSessionHandler.php');
class IPSessionHandler extends DbSessionHandler {
	protected $pdo_data_source_name = 'mysql:dbname=whiteboxqa;host=development.cwjgdp1wxdy2.us-west-1.rds.amazonaws.com';
	protected $pdo_username = 'whiteboxqa';
	protected $pdo_password = 'Innovapath1*';
	protected $session_db_table = 'uc_sessions';
	protected $session_name = 'member_key';
}

?>