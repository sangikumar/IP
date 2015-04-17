<?php
require_once($_SERVER["DOCUMENT_ROOT"] ."/project/admin/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$userId = $loggedInUser->user_id;
if(!userIdExists($userId)){
  header("Location : login.php"); die();
}
require($_SERVER["DOCUMENT_ROOT"]."/project/admin/models/header.php");
require($_SERVER["DOCUMENT_ROOT"] ."/project/admin/models/db-settings.php");
?>
<body>
<div id='wrapper'>
<div id='top'><div id='logo'></div><div id='logo1'></div></div>
<div id='content'>
<div id='left-nav'>
<?php
require ($_SERVER["DOCUMENT_ROOT"]."/project/admin/left-nav.php");
?>

</div>
<div id='main'> 
<?php
require($page_grid);
?>

</div>
</div>
<br />
<br />
</body>
</html>