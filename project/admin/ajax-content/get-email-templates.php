<?php
require_once("../models/config.php");

if($_REQUEST) {
    $templateid = $_REQUEST['templateid'];

    if ($templateid && $templateid != 0) {
        $result = $mysqli->query("select * from ip_email_templates where id = $templateid");
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $category = $row['category'];
        $htmlcode = $row['htmlcode'];
        $mysqli->close();

        echo "

        <input type='hidden' name='templateid' id='templateid' value='$templateid'/>
        <div><label class='label-align'>Name :</label>
            <input class='inputs' name='templatename' id='templatename' value='$name'/>
        </div>
        <br/>
        <div><label class='label-align'>Category :</label>
            <input class='inputs' name='category' id='category' value='$category'/>
        </div>
        <br/>
        <div><label class='label-align'>Body :</label>
            <textarea id='txtDefaultHtmlArea' name='txtDefaultHtmlArea' cols='100' rows='45'>$htmlcode</textarea>
       </div>
       <br/>
       <div class='centerbuttons'><input class ='buttonStyle' type='submit' name='sendTemplateSubmit' value='Update'/></div>


     " ;
    }
}
?>