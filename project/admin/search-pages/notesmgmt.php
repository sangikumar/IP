<?php
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])) {
    die();
}
$userId = $loggedInUser->user_id;
$candidateID = $loggedInUser->candidateid;
if (!userIdExists($userId)) {
    header("Location:login.php");
    die();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Class Notes</title>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css"/>
    <link rel="stylesheet" href="http://gregfranko.com/jquery.selectBoxIt.js/css/jquery.selectBoxIt.css"/>
    <link href="models/site-templates/default.css" rel='stylesheet'
          type='text/css'/>
    <link href="exam/js/datepicker/zebra_datepicker.css" rel='stylesheet' type='text/css'/>
    <link href="http://hayageek.github.io/jQuery-Upload-File/uploadfile.min.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script src="http://gregfranko.com/jquery.selectBoxIt.js/js/jquery.selectBoxIt.min.js"></script>
    <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
    <script src="exam/js/datepicker/zebra_datepicker.js" type="text/javascript"></script>
    <script src="exam/js/numericInput.min.js" type="text/javascript"></script>
    <script src="http://hayageek.github.io/jQuery-Upload-File/jquery.uploadfile.min.js"></script>
    <style>
        .ui-menu {
            width: 130px;
        }
    </style>
    <script type="text/javascript">
        //<![CDATA[
        $(document).ready(function () {
            $(".link").button();
            $('#mymenu').menu();
            $('#loader').hide();
            $('#show_heading').hide();
            $('select').selectBoxIt();

            $('#class').change(function () {
                $('#show_document').fadeOut();
                if (inp.val().length > 0) {
                    $('#loader').show();

                    var classinfo = {parent_id: $('#class').val()};

                    $.post("../ajax-content/get-classnotes.php", classinfo, function (data) {
                        setTimeout("finishAjax('show_document', '" + escape(data) + "')", 400);
                    });
                }
                return false;
            });

            var inp = $("#class");
            if (inp.val().length > 0) {
                $('#show_document').fadeOut();
                $('#loader').show();
                $.post("../ajax-content/get-classnotes.php", {
                    parent_id: $('#class').val(),
                }, function (response) {
                    setTimeout("finishAjax('show_document', '" + escape(response) + "')", 400);
                });
            }

        });
        //]]>

        function finishAjax(id, response) {
            $('#loader').hide();
            $('#show_heading').show();
            $('#show_heading').empty();
            $('#' + id).html(unescape(response));
            $('#' + id).fadeIn();
            new nicEditor({maxHeight: 300}).panelInstance('notes');
            $('#classdate').datepicker();
            $('input').addClass("ui-corner-all");
            $('select').addClass("ui-corner-all");
            $('#send').button();
            $('#classdate').Zebra_DatePicker();
        }

    </script>
    <style type="text/css">

        #show_recording {
            display: none;
        }

        @media print {
            #mymenu {
                display: none;
            }

            #topmenu {
                display: none;
            }

            #recordingid {
                display: none;
            }

            #show_recording {
                display: block;
            }
        }
    </style>
</head>
<body>
<div id='wrapper'>
    <div id='top'>
        <div id='logo'></div>
    </div>
    <div id='content'>
        <h2>Notes Management</h2>
        <br/>

        <div id='left-nav'>
            <?php

            include($_SERVER["DOCUMENT_ROOT"] . "/project/admin/left-nav.php");

            ?>
        </div>
        <div id='main'>
            <?php
            $result = $mysqli->query("select distinct batchname from batch order by batchname desc limit 1");
            $row = $result->fetch_row();

            $batch = $row[0];

            if (!empty($_POST)) {
                $class = $_POST['class'];
                $classid = $_POST['classid'];
                $subject = $_POST['subject'];
                $classdate = $_POST['classdate'];
                $notes = $_POST['notes'];
                $batchname = $_POST['batchname'];
                if (isset($batchname)) {
                    $batch = $batchname;
                }

                if ($notes) {
                    if ($classid != 100000000) {
                        $updatesql = "update class_notes p set p.notes = '$notes', p.subject = '$subject', p.classdate = '$classdate' where p.id = $classid";

                        $retval = $mysqli->query($updatesql);
                    } else {
                        $updatesql = "INSERT INTO class_notes(batchname,notes,subject,classdate) VALUES ('$batchname', '$notes', '$subject', '$classdate')";
                        $retval = $mysqli->query($updatesql);

                        $classid = $mysqli->insert_id;
                    }
                }
            }
            ?>
            <form action="notesmgmt.php" id="form1" name="form1" method="post" enctype="multipart/form-data">
                <table width="80%" border="0" cellspacing="5" cellpadding="5">
                    <thead>
                    <tr>
                        <td>Batch:</td>
                        <td><select style="width: 100px;" name="batchname" id="batchname" onchange="this.form.submit()">
                                <?php
                                $query = "select distinct batchname from batch order by batchname desc";

                                $results = $mysqli->query($query);

                                while ($rows = $results->fetch_assoc()) {
                                    ?>
                                    <option
                                        value="<?php echo $rows['batchname'];?>" <?php if ($batch == $rows['batchname']) {
                                        echo "selected";
                                    } ?>><?php echo $rows['batchname'];?></option>
                                <?php
                                } ?>
                            </select></td>
                    </tr>
                    <tr>
                        <td>Class:</td>
                        <td><select name="class" style="width: 300px;" id="class">
                                <?php
                                if ($loggedInUser->employee == "Y") {
                                    $query = "select 100000000 as id, 'Add New' as bvalue from dual union select id, concat(classdate, '-', subject) as bvalue from class_notes where batchname = '$batch' order by id desc";
                                } else {
                                    $query = "select id, concat(classdate, '-', subject) as bvalue from class_notes where batchname = '$batch' order by id desc";
                                }


                                $results = $mysqli->query($query);
                                echo "<option value=''>Select Notes...</option>";
                                while ($rows = $results->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $rows['id'];?>"<?php if ($classid == $rows['id']) {
                                        echo "selected";
                                    } ?>><?php echo $rows['bvalue'];?></option>
                                <?php
                                } ?>
                            </select></td>
                    </tr>
                    </thead>
                    <br/>
                    <tbody id="show_document">
                    <img src="../../images/loader.gif" style="margin-top:8px; float:left" id="loader" alt=""/>
                    </tbody>

                </table>
            </form>
            <?
            $mysqli->close();
            ?>
        </div>
        <div id='bottom'></div>
    </div>
    <br/>
    <br/>
</body>
</html>
