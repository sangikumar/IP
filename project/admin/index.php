<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$page_title = $websiteName;
require_once("models/header.php");

echo "
<body>
<div id='wrapper'>
<div id='top'><div id='logo'></div><div id='logo1'></div></div>

<div id='content'>

<div id='left-nav'>";
include($_SERVER["DOCUMENT_ROOT"] ."/project/admin/left-nav.php");
echo "
</div><div id='main'> <p>Thank you for using Avatar.</p><br></div>
</div></div>
</body>
</html>";

?>
