<?php
require_once("/project/admin//models/config.php");
if (!securePage($_SERVER['PHP_SELF'])) {
    die();
}
$userId = $loggedInUser->user_id;
$candidateID = $loggedInUser->candidateid;
if (!userIdExists($userId)) {
    header("Location: login.php");
    die();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Vendor-Search</title>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css"/>
    <link rel="stylesheet" href="http://gregfranko.com/jquery.selectBoxIt.js/css/jquery.selectBoxIt.css"/>
    <link href="/project/admin/models/site-templates/default.css" rel='stylesheet'
          type='text/css'/>
    <link href="css/jquery.tagsinput.css" type="text/css" rel="stylesheet"/>
    <link href="/css/newstyle.css" type="text/css" rel="stylesheet"/>
    <link href="/project/js/datepicker/zebra_datepicker.css" rel='stylesheet' type='text/css'/>
    <link href="http://hayageek.github.io/jQuery-Upload-File/uploadfile.min.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script src="http://gregfranko.com/jquery.selectBoxIt.js/js/jquery.selectBoxIt.min.js"></script>
    <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
    <script src="/project/js/datepicker/zebra_datepicker.js" type="text/javascript"></script>
    <script src="/project/js/numericInput.min.js" type="text/javascript"></script>
    <script src="/js/jquery.tagsinput.js"></script>
    <script src="/js/jquery.tagsinput.min.js"></script>
    <script src="/js/jquery.watermark.js" type="text/javascript"></script>
    <script src='/project/admin/models/funcs.js' type='text/javascript'></script>
    <script src="http://hayageek.github.io/jQuery-Upload-File/jquery.uploadfile.min.js"></script>
    <style>
        .ui-menu {
            width: 130px;
        }
    </style>
    <script type="text/javascript">
        //bkLib.onDomLoaded(function() {  });
        //<![CDATA[
        $(document).ready(function () {
            $(".link").button();
            $('#mymenu').menu();
            $('#loader').hide();
            $('#show_heading').hide();
            $("#faq_search_input").watermark("Search vendors...");

            //return page after save
            var inp = $("#faq_search_input");
            if (inp.val() != "Seach vendors..." && inp.val().length > 2) {
                $.post("../ajax-content/get-vendor.php", {
                    parent_id: $('#faq_search_input').val(),
                }, function (response) {
                    setTimeout("finishAjax('show_candidate', '" + escape(response) + "')", 400);
                });
                return false;
            }

            $('#faq_search_input').autocomplete({
                source: '../ajax-content/suggest_vendor.php', minLength: 2,
                select: function (event, ui) {
                    $("#faq_search_input").val(ui.item.value);
                    $('#show_candidate').fadeOut();
                    $('#loader').show();
                    $.post("../ajax-content/get-vendor.php", {
                        parent_id: $('#faq_search_input').val(),
                    }, function (response) {

                        setTimeout("finishAjax('show_candidate', '" + escape(response) + "')", 400);
                    });
                    return false;
                }

            });
        });

        function finishAjax(id, response) {
            $('#loader').hide();
            $('#show_heading').show();
            $('#' + id).html(unescape(response));
            $('#' + id).fadeIn();
            $("#accordion").accordion({
                collapsible: true,
                heightStyle: "content"
            });

            $('#clients').tagsInput({width: 'auto'});
            $('input').addClass("ui-corner-all");
            $('select').addClass("ui-corner-all");
            $('#Send').button();
        }
        //]]>
    </script>

    <style type="text/css">
        /*This css contains code for the statis loading image in the right of the textbox */
        .faqsearchinputbox input {
            font-size: 16px;
            color: #6e6e6e;
            padding: 10px;
            border: none;
            background: url(images/loading_static.gif) no-repeat right 50%;
            width: 300px;
        }

        /*The css class below contains the animated loading image .this will be added on the dom later with Jquery*/
        .faqsearchinputbox input.loading {
            background: url(images/loading_animate.gif) no-repeat right 50%;
        }
    </style>

</head>
<body>
<div id='wrapper'>
    <div id='top'>
        <div id='logo'></div>
    </div>
    <div id='content'>
        <h1>INNOVAPATH, INC. - Avatar</h1>

        <br/>
        <br/>

        <div id='left-nav'><?php include($_SERVER["DOCUMENT_ROOT"] . "/project/admin/left-nav.php"); ?></div>
        <div id='main'>

            <?php
            if (!empty($_POST)) {
                $vendorid = $_POST['vendorid'];
                $clients = $_POST['clients'];
                $email = $_POST['email'];

                if ($vendorid) {
                    if ($clients) {
                        $updatesql = "update vendor p set p.clients = '$clients' where p.email = '$vendorid'";
                        $retval = $mysqli->query($updatesql);
                    }
                }
            }
            ?>


            <form action="vendorsearch.php" method="post">
                <div class="prod-content">
                    <div class="faqsearch">
                        <div class="faqsearchinputbox">
                            <input name="query" type="text" id="faq_search_input" value="<?php print $email; ?>"/>
                        </div>

                        <div class="both">
                            <h1 id="show_heading">&nbsp;</h1>

                            <div id="show_candidate">
                                <img src="/images/loader.gif" style="margin-top:8px; float:left" id="loader"
                                     alt=""/>
                            </div>
                        </div>

                    </div>
                </div>


            </form>
        </div>
        <?php
        $mysqli->close();
        ?>
        <div id='bottom'></div>
    </div>
    <br/>
    <br/>
</body>
</html>