<?php
require_once("../models/config.php");
$candidateID = $loggedInUser->candidateid;
$employeeid = $loggedInUser->employeeid;

if ($_REQUEST) {
    $id = $_REQUEST['parent_id'];
    $result = $mysqli->query("select * from recruiter where email = '$id'");
    $row = $result->fetch_assoc();
    $recruiterid = $row["id"];
    $name = $row["name"];
    $email = $row["email"];
    $phone = $row["phone"];
    $designation = $row["designation"];
    $personalemail = $row["personalemail"];
    $dob = $row["dob"];
    $status = $row["status1"];
    $skypeid = $row["skypeid"];
    $linkedin = $row["linkedin"];
    $twitter = $row["twitter"];
    $facebook = $row["facebook"];
    $review = $row["review"];
    $notes = $row["notes"];
    $vendorid = $row["vendorid"];
    $clientid = $row["clientid"];
    $status = $row["status"];
?>
    <input type="hidden" name="recruiterid" id="recruiterid" value="<?php print $recruiterid; ?>"/>
<div id="tabs" style="width:800px">
    <ul>
        <li><a href="#tabs-1">Information</a></li>
        <li><a href="#tabs-2">Add Call</a></li>
        <li><a href="#tabs-3">Calls List</a></li>
        <li><a href="#tabs-4">Add Meet</a></li>
        <li><a href="#tabs-5">Meets List</a></li>
    </ul>
    <div id="tabs-1">
        <table cellpadding="5" cellspacing="5">
            <tr>
                <td><strong>Email:</strong></td>
                <td><input style="width:300px" name="email" id="email" value="<?php print $email; ?>"/></td>
            </tr>
            <tr>
                <td><strong>Name:</strong></td>
                <td><input style="width:300px" name="name" id="name" value="<?php print $name; ?>"/></td>
            </tr>
            <tr>
                <td><strong>Phone:</strong></td>
                <td><input style="width:300px" name="phone" id="phone" value="<?php print $phone; ?>"/></td>
            </tr>
            <tr>
                <td><strong>Designation:</strong></td>
                <td><input style="width:300px" name="designation" id="designation" value="<?php print $designation; ?>"/></td>
            </tr>
            <tr>
                <td><strong>Vendor:</strong></td>
                <td><select style="width: 300px;" name="vendorid" id="vendorid">
                        <?php
                        $query = "select 0 as id, 'None...' as companyname from dual union select distinct id, companyname from vendor order by companyname";
                        $results = $mysqli->query($query);
                        while ($rows = $results->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $rows['id'];?>" <?php if ($vendorid == $rows['id']) {
                                echo "selected";
                            } ?>><?php echo $rows['companyname'];?></option>
                        <?php
                        } ?>
                    </select></td>
            </tr>
            <tr>
                <td><strong>Client:</strong></td>
                <td><select style="width: 300px;" name="clientid" id="clientid">
                        <?php
                        $query = "select 0 as id, 'None...' as companyname from dual union select distinct id, companyname from client order by companyname";
                        $results = $mysqli->query($query);
                        while ($rows = $results->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $rows['id'];?>" <?php if ($clientid == $rows['id']) {
                                echo "selected";
                            } ?>><?php echo $rows['companyname'];?></option>
                        <?php
                        } ?>
                    </select></td>
            </tr>
            <tr>
                <td><strong>Status:</strong></td>
                <td><select style="width: 100px;" name="status" id="status">
                        <?php
                        $query = "select distinct status from recruiter order by status";
                        $results = $mysqli->query($query);
                        while ($rows = $results->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $rows['status'];?>" <?php if ($status == $rows['status']) {
                                echo "selected";
                            } ?>><?php echo $rows['status'];?></option>
                        <?php
                        } ?>
                    </select></td>
            </tr>
            <tr>
                <td><strong>Personal Email:</strong></td>
                <td><input style="width:300px" name="personalemail" id="personalemail" value="<?php print $personalemail; ?>"/></td>
            </tr>
            <tr>
                <td><strong>DOB:</strong></td>
                <td><input style="width:100px" name="dob" id="dob" value="<?php print $dob; ?>"/>
                </td>
            </tr>
            <tr>
                <td><strong>Skype:</strong></td>
                <td><input style="width:300px" name="skypeid" id="skypeid" value="<?php print $skypeid; ?>"/></td>
            </tr>
            <tr>
                <td><strong>LinkedIN:</strong></td>
                <td><input style="width:300px" name="linkedin" id="linkedin" value="<?php print $linkedin; ?>"/></td>
            </tr>
            <tr>
                <td><strong>Notes:</strong></td>
                <td><textarea class="nicnotes" name="notes" type="text" id="notes" style="width:600px">
    	 		<?php print htmlspecialchars($notes, ENT_COMPAT, 'ISO-8859-1', true); ?>
                </textarea></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="send" id="send" value="Update"></td>
            </tr>
        </table>


    </div>
    <div id="tabs-2">
        <table cellpadding="5" cellspacing="5">
            <tr>
                <td><strong>Position Details:</strong></td>
                <td><input style="width:300px" name="position" id="position"/></td>
            </tr>
           <tr>
                <td><strong>Call Date:</strong></td>
                <td><input style="width:100px" name="calldate" id="calldate" value="<?php print $calldate; ?>"/>
                </td>
            </tr>
            <tr>
                <td><strong>Rate:</strong></td>
                <td><input style="width:100px" name="rate" id="rate" value="0"/></td>
            </tr>
            <tr>
                <td><strong>Employee:</strong></td>
                <td><select style="width: 300px;" name="employeeid" id="employeeid">
                        <?php
                        $query = "select 0 as id, 'None...' as name from dual union SELECT distinct id, name FROM employee where status = '0Active' order by name";
                        $results = $mysqli->query($query);
                        while ($rows = $results->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $rows['id'];?>"<?php if ($employeeid == $rows['id']) {
                                echo "selected";
                            } ?>><?php echo $rows['name'];?></option>
                        <?php
                        } ?>
                    </select></td>
            </tr>
            <tr>
                <td><strong>Candidate:</strong></td>
                <td><select style="width: 300px;" name="candidateid" id="candidateid">
                        <?php
                        $query = "select 0 as id, ' General Call' as name from dual union select distinct c.candidateid as id, c.name from candidatemarketing cm, candidate c where c.candidateid = cm.candidateid and cm.`status` in ('0-InProgress', '2-ToDo') order by name";
                        $results = $mysqli->query($query);
                        while ($rows = $results->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $rows['id'];?>"><?php echo $rows['name'];?></option>
                        <?php
                        } ?>
                    </select></td>
            </tr>
            <tr>
                <td><strong>Notes:</strong></td>
                <td><textarea class="nicnotes" name="callnotes" type="text" id="callnotes" style="width:600px">
    	 		Write Notes here...
                </textarea></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="CallSend" id="CallSend" value="Update"></td>
            </tr>
        </table>
    </div>
    <div id="tabs-3">
        <?php

        $result = $mysqli->query("select calldate, position, rate, notes from vendorcalls where recruiterid = $recruiterid order by calldate desc limit 10");
        $num_rows = $result->num_rows;
        if($num_rows > 0)
        {
            echo("<table cellpadding='5' cellspacing='5'>");
        }
        while($data = $result->fetch_row()) {
            echo('<tr><td><strong>'.$data[0].'--'.$data[1].'--'.$data[2].':</strong></td><td>'.$data[3].'</td></tr>');
        }
        if($num_rows > 0)
        {
            echo("</table>");
        }
        ?>
    </div>
    <div id="tabs-4">
        <table cellpadding="5" cellspacing="5">
            <tr>
                <td><strong>Employee:</strong></td>
                <td><select style="width: 300px;" name="employeeid" id="employeeid">
                        <?php
                        $query = "select 0 as id, 'None...' as name from dual union SELECT distinct id, name FROM employee where status = '0Active' order by name";
                        $results = $mysqli->query($query);
                        while ($rows = $results->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $rows['id'];?>"<?php if ($employeeid == $rows['id']) {
                                echo "selected";
                            } ?>><?php echo $rows['name'];?></option>
                        <?php
                        } ?>
                    </select></td>
            </tr>
            <tr>
                <td><strong>Meet Date:</strong></td>
                <td><input style="width:100px" name="meetdate" id="meetdate" value="<?php print $meetdate; ?>"/>
                </td>
            </tr>
            <tr>
                <td><strong>Notes:</strong></td>
                <td><textarea class="nicnotes" name="meetnotes" type="text" id="meetnotes" style="width:600px">
    	 		Write Notes here...
                </textarea></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="MeetSend" id="MeetSend" value="Update"></td>
            </tr>
        </table>
    </div>
    <div id="tabs-5">
        <?php

        $result = $mysqli->query("select vm.meetdate, e.name, vm.`status`, vm.notes from vendormeet vm, employee e where vm.employeeid = e.id and recruiterid = $recruiterid order by meetdate desc limit 10");
        $num_rows = $result->num_rows;
        if($num_rows > 0)
        {
            echo("<table cellpadding='5' cellspacing='5'>");
        }
        while($data = $result->fetch_row()) {
            echo('<tr><td><strong>'.$data[0].'---'.$data[1].':</strong></td><td>'.$data[3].'</td></tr>');
        }
        if($num_rows > 0)
        {
            echo("</table>");
        }
        ?>
    </div>
</div>
<?
}
$mysqli->close();
?>
