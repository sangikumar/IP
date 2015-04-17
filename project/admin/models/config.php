<?php
require_once($_SERVER["DOCUMENT_ROOT"] ."/project/admin/models/db-settings.php");

$stmt = $mysqli->prepare("SELECT id, name, value
	FROM ".$db_table_prefix."configuration");	
$stmt->execute();
$stmt->bind_result($id, $name, $value);

while ($stmt->fetch()){
	$settings[$name] = array('id' => $id, 'name' => $name, 'value' => $value);
}
$stmt->close();

//Set Settings
$emailActivation = $settings['activation']['value'];
$mail_templates_dir = "models/mail-templates/";
$websiteName = $settings['website_name']['value'];
$websiteUrl = $settings['website_url']['value'];
$emailAddress = $settings['email']['value'];
$resend_activation_threshold = $settings['resend_activation_threshold']['value'];
$emailDate = date('dmy');
$language = $settings['language']['value'];
$template = $settings['template']['value'];

$master_account = -1;

$default_hooks = array("#WEBSITENAME#","#WEBSITEURL#","#DATE#");
$default_replace = array($websiteName,$websiteUrl,$emailDate);

if (!file_exists($language)) {
	$language = $_SERVER["DOCUMENT_ROOT"] ."/project/admin/models/languages/en.php";
}

if(!isset($language)) $language = $_SERVER["DOCUMENT_ROOT"] ."/project/admin/models/languages/en.php";
//Pages to require
require_once($language);
require_once($_SERVER["DOCUMENT_ROOT"] ."/project/admin/models/class.mail.php");
require_once($_SERVER["DOCUMENT_ROOT"] ."/project/admin/models/class.user.php");
require_once($_SERVER["DOCUMENT_ROOT"] ."/project/admin/models/class.newuser.php");
require_once($_SERVER["DOCUMENT_ROOT"] ."/project/admin/models/funcs.php");

//require($_SERVER["DOCUMENT_ROOT"] ."/project/admin/models/IPSessionHandler.php");
//$session_handler = new IPSessionHandler();
session_start();
if(isset($_SESSION["userCakeUser"]))
{
	$loggedInUser = unserialize($_SESSION["userCakeUser"]);
}

?>