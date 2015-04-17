<?php
/**
 * Created by PhpStorm.
 * User: Shilpi
 * Date: 1/13/2015
 * Time: 4:52 PM
 */
require_once("../models/config.php");

if($_REQUEST) {
    $templateid = $_REQUEST['templateid'];
    $groupid = $_REQUEST['groupid'];

    // Get loggedin user email
    $employeeid = $loggedInUser->employeeid;
    $result = $mysqli->query("select name, email from employee where id = $employeeid");
    $row = $result->fetch_assoc();
    $defaultto = $row['email'];
    $defaultfrom =$row['name'].'<'.$row['email'].'>';


    if ($templateid && $templateid != 0) {
        $result = $mysqli->query("select htmlcode from ip_email_templates where id = $templateid");
        $row = $result->fetch_assoc();
        $htmlcode = $row['htmlcode'];
        $mysqli->close();

        echo "
        <div><label class='label-align'>Subject</label>
        <input class='inputs' name='subject' id='subject' />
        </div>
        <div><label class='label-align'>To</label>
        <input type='email' class='inputs' name='to' id='to' value = '$defaultto'/>
        </div>

        <div><label class='label-align'>From</label>
        <input class='inputs' name='from' id='from' value = '$defaultfrom'/>
        </div>

        <div>
        <label class='label-align'>Message</label>
        <textarea id='txtDefaultHtmlArea' name='txtDefaultHtmlArea' cols='100' rows='30'>$htmlcode</textarea>
        </div>

        <div class='centerbuttons'>
        <input class ='buttonStyle' type='submit' name='sendEmailSubmit' value='Send Email'/>
        </div>


     " ;
    }// end if templateid

    if($groupid && $groupid != 0) {
        if ($groupid == 1000000)
            $emaillist ='';
        else {
            $query = "select dbsql from ip_email_group where id = $groupid";
            $result = $mysqli->query($query);
            if (!$result) {
               echo "DB Error".$mysqli->error;
            }
            $row = $result->fetch_row();
            $dbsql = $row[0];
            $emaillist = '';

            ini_set('max_execution_time', 300);
           // Get emailing list by executing above sql
            $result = $mysqli->query('' . $row[0]);
            if (!$result) {
                echo "DB Error".$mysqli->error;
            }

            while ($rows = $result->fetch_assoc()) {
                $emaillist = $emaillist . $rows['email'] . ',';
            }
            $emaillist = rtrim($emaillist, ',');

            $mysqli->close();
        }

        echo "
        <div>
        <label class='label-align'>EmailList</label>
            <textarea id='txtEmailArea' name='txtEmailArea' cols='100' rows='5'>$emaillist</textarea>
        </div>
        ";
    }
}
?>