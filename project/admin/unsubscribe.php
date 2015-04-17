<?php
require_once("models/config.php");
include_once("../../auth.php");
include_once("../../authconfig.php");
include_once("../../authconfig.php");
$connection = mysql_connect($dbhost, $dbusername, $dbpass);
$SelectedDB = mysql_select_db($dbname);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Unsubscribe</title>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css"/>
    <link rel="stylesheet" type="text/css" media="screen" href="../themes/ui.jqgrid.css"/>
    <link rel="stylesheet" type="text/css" media="screen" href="../themes/ui.multiselect.css"/>
    <link href="models/site-templates/default.css" rel='stylesheet' type='text/css'/>
    <style type="text">
        <
        !
        [CDATA[
        html, body {
            margin: 0; /* Remove body margin/padding */
            padding: 0;
            overflow: hidden; /* Remove scroll bars on browser window */
            font-size: 75%;
        }

        ]
        ]
        >
    </style>
    <script src="http://code.jquery.com/jquery-1.9.1.js" type="text/javascript"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="../js/i18n/grid.locale-en.js" type="text/javascript"></script>
    <script src='models/funcs.js' type='text/javascript'></script>
    <script type="text/javascript">
        //<![CDATA[
        $.jgrid.no_legacy_api = true;
        $.jgrid.useJSON = true;
        //]]>
    </script>
    <script src="../js/jquery.jqGrid.min.js" type="text/javascript"></script>
    <style>  .ui-menu {
            width: 130px;
        }  </style>
    <script type="text/javascript">
        //<![CDATA[
        $(document).ready(function () {
            $(".link").button();
            $('#mymenu').menu();
        });
        //]]>
    </script>
</head>
<body>
<div id='wrapper'>
    <div id='top'>
        <div id='logo'></div>
    </div>
    <div id='content'>
        <h1>Unsubscribe to Avatar!</h1>
        <br/>
        <br/>

        <div id='main'>
            <?php
            if (!empty($_POST)) {
                $id = $_POST['email'];

                if ($SelectedDB) {
                    $SQL = "update massemail set emailtouse = null, remove ='Y' where email = '$id'";
                    $result = mysql_query($SQL);
                    mysql_close($connection);
                    echo "<br /><br />Your email $id is unsubscribed.<br /><br /><br /><br /><br />";
                    die();
                }
            }

            if (!empty($_GET)) {
                $id = $_GET['email'];

                if ($SelectedDB) {
                    $SQL = "update massemail set emailtouse = null, remove ='Y' where email = '$id'";
                    $result = mysql_query($SQL);
                    mysql_close($connection);
                    echo "<br /><br />Your email $id is unsubscribed.<br /><br /><br /><br /><br />";
                    die();
                }
            }
            ?>

            <form name="Sample" method="post" action="unsubscribe.php">
                <fieldset>
                    <br/><br/>

                    <div>
                        <label>Enter your Email:</label>
                        <input type="text" name="email" size="34" value="<?= $email ?>" maxlength="50">
                    </div>
                    <br/><br/>

                    <div class="rowElem">
                        <input type="submit" name="Send" value="Unsubscribe">
                    </div>
                    <br/><br/><br/><br/><br/><br/>
            </form>


        </div>
        <div id='bottom'></div>
    </div>
    <br/>
    <br/>
</body>
</html>
