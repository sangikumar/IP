<?phprequire_once($_SERVER["DOCUMENT_ROOT"] ."/models/config.php");if (!securePage($_SERVER['PHP_SELF'])){die();}$userId = $loggedInUser->user_id;if(!userIdExists($userId)){    header("Location : login.php"); die();}require($_SERVER["DOCUMENT_ROOT"] ."models/db-settings.php");?><!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head>    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />    <title>HTML Templates</title>    <link href='$template' rel='stylesheet' type='text/css' />    <script src='models/funcs.js' type='text/javascript'></script>    <link rel='stylesheet' href='http://code.jquery.com/ui/1.10.3/themes/start/jquery-ui.css' />    <link rel='stylesheet' type='text/css' media='screen' href='/project/themes/ui.jqgrid.css'  />    <link rel='stylesheet' type='text/css' media='screen' href='/project/themes/ui.multiselect.css'/>    <link href='models/site-templates/default.css' rel='stylesheet' type='text/css' />    <script src='http://code.jquery.com/jquery-1.9.1.js'></script>    <script src='http://code.jquery.com/ui/1.10.3/jquery-ui.js'></script>    <script src='exam/js/i18n/grid.locale-en.js' type='text/javascript'></script>    <script src='exam/js/jquery.jqGrid.min.js' type='text/javascript'></script>    <script type="text/javascript" src="myjs/jHtmlArea-0.8.js"></script>    <link rel="Stylesheet" type="text/css" href="mystyle/jHtmlArea.css" />    <script>   $(function() {     $( '#mymenu' ).menu(); $('input').addClass('ui-corner-all');   });   </script>    <style>  .ui-menu { width: 130px; }  </style>    <script type='text/javascript'>        //<![CDATA[        $.jgrid.no_legacy_api = true;        $.jgrid.useJSON = true;        //]]>    </script>    <script type='text/javascript'>        //<![CDATA[        $(document).ready(function(){            $('.link').button();            $('#mymenu').menu();            //$('#mymenu').overlay();        });        //]]>    </script></head><body><div id='wrapper'>    <div id='top'><div id='logo'></div><div id='logo1'></div></div>    <div id='content'>        <div id='left-nav'>            <?php            require ($_SERVER["DOCUMENT_ROOT"]."left-nav.php");            ?>        </div>        <div id='main'>            <?php                require_once($_SERVER["DOCUMENT_ROOT"]."grids/ip_email_template.php");                $htmlcode= $_POST['htmlcode'];                $htmlid=$_POST['id'];                $newhtmlcode = $_POST['txtDefaultHtmlArea'];                if ($newhtmlcode) {                    $query = 'update ip_email_templates set htmlcode = "' . $newhtmlcode . '" where id =' . $htmlid;                    $result = $mysqli->query($query);                    $mysqli->close();                }               // echo $query;            ?>            <br /><hr /><br />            <form id="htmlcode" action="test_html_template.php" method="post">            <input type="hidden" name="id" value="<?php echo $htmlid ?>"/>            <textarea id="txtDefaultHtmlArea" name="txtDefaultHtmlArea" cols="125" rows="50"><?php echo rawurldecode(rawurldecode($htmlcode))?></textarea>            <br/>                <input id="update" type="submit" value="Update HTML" />            </form>                <script type="text/javascript">                // You can do this to perform a global override of any of the "default" options                // jHtmlArea.fn.defaultOptions.css = "jHtmlArea.Editor.css";                $('#update').click(function(){                    var html = $('#txtDefaultHtmlArea').htmlarea('toHtmlString');                    $('#txtDefaultHtmlArea').val(html);                    $('#htmlcode').submit();                });                $(function() {                    //$("textarea").htmlarea(); // Initialize all TextArea's as jHtmlArea's with default values                    $("#txtDefaultHtmlArea").htmlarea(); // Initialize jHtmlArea's with all default values                    $("#txtCustomHtmlArea").htmlarea({                        // Override/Specify the Toolbar buttons to show                        toolbar: [                            ["bold", "italic", "underline", "|", "forecolor"],                            ["p", "h1", "h2", "h3", "h4", "h5", "h6"],                            ["link", "unlink", "|", "image"],                            [{                                // This is how to add a completely custom Toolbar Button                                css: "custom_disk_button",                                text: "Save",                                action: function(btn) {                                    // 'this' = jHtmlArea object                                    // 'btn' = jQuery object that represents the <A> "anchor" tag for the Toolbar Button                                    alert('SAVE!\n\n' + this.toHtmlString());                                }                            }]                        ],                        // Override any of the toolbarText values - these are the Alt Text / Tooltips shown                        // when the user hovers the mouse over the Toolbar Buttons                        // Here are a couple translated to German, thanks to Google Translate.                        toolbarText: $.extend({}, jHtmlArea.defaultOptions.toolbarText, {                            "bold": "fett",                            "italic": "kursiv",                            "underline": "unterstreichen"                        }),                        // Specify a specific CSS file to use for the Editor                        css: "style//jHtmlArea.Editor.css",                        // Do something once the editor has finished loading                        loaded: function() {                            //// 'this' is equal to the jHtmlArea object                            //alert("jHtmlArea has loaded!");                            //this.showHTMLView(); // show the HTML view once the editor has finished loading                        }                    });                });            </script>        </div>    </div>    <br />    <br /></body></html>