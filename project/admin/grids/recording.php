<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);

$grid->SelectCommand = 'SELECT id,batchname,description,type,classdate,link,videoid,status,subject,course,isbest,isjumbo,iscandidate FROM recording';
$grid->table = 'recording';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('classdate');
$grid->setUserDate("Y-m-d");
$grid->setColModel();
$grid->setUrl('../grids/recording.php');
$grid->setColProperty("id", array("editable" => false, "width" => 25, "hidden" => true, "fixed" => true, "label" => "ID"));
$grid->setColProperty("batchname", array("editable" => true, "width" => 90, "fixed" => true, "label" => "Batch Name", "edittype" => "select"));
$grid->setSelect("batchname", "select distinct batchname as id, batchname as name from batch where startdate <= (select max(startdate) from batch where startdate < CURDATE()) order by batchname desc", false, true, true);
$grid->setColProperty("description", array("editable" => true, "frozen" => true, "width" => 250, "editoptions" => array("size" => 75, "maxlength" => 250), "fixed" => true, "label" => "Description"));
$grid->setColProperty("type", array("editable" => true, "width" => 70, "fixed" => true, "label" => "Type", "edittype" => "select"));
$grid->setSelect("type", array("Class" => "Class", "Internal" => "Internal"), false, true, true, array("" => "All"));
$grid->setColProperty("classdate", array("formatter" => "date", "width" => 80, "fixed" => true, "formatoptions" => array("srcformat" => "Y-m-d", "newformat" => "Y-m-d"), "editable" => true, "label" => "Class Date",
    "editoptions" => array("dataInit" =>
        "js:function(elm){setTimeout(function(){
                    							 jQuery(elm).datepicker({dateFormat:'yy-mm-dd'});
                    							 jQuery('.ui-datepicker').css({'font-size':'75%'});
                									 },200);}"),
    "searchoptions" => array("dataInit" =>
        "js:function(elm){setTimeout(function(){
                    							 jQuery(elm).datepicker({dateFormat:'yy-mm-dd'});
                    							 jQuery('.ui-datepicker').css({'font-size':'75%'});
                									 },200);}")
));
$grid->setColProperty("link", array("editable" => true, "frozen" => true, "width" => 300, "editoptions" => array("size" => 75, "maxlength" => 200), "formatter" => "link", "formatoptions" => array("target" => "_blank"), "fixed" => true, "editrules" => array("url" => true, "required" => false), "label" => "Url"));
$grid->setColProperty("videoid", array("editable" => true, "width" => 90, "fixed" => true, "label" => "Video ID"));
$grid->setColProperty("status", array("editable" => true, "width" => 70, "fixed" => true, "label" => "Status", "edittype" => "select"));
$grid->setSelect("status", array("active" => "active", "inactive" => "inactive", "session" => "session", "internal" => "internal", "delete" => "delete"), false, true, true, array("" => "All"));
$grid->setColProperty("subject", array("editable" => true, "width" => 70, "fixed" => true, "label" => "Subject", "edittype" => "select"));
$grid->setSelect("subject", $questionssubject, false, true, true, array("" => "All"));
$grid->setColProperty("course", array("editable" => true, "width" => 70, "fixed" => true, "label" => "Course", "edittype" => "select"));
$grid->setSelect("course", $courses, false, true, true, array("" => "All"));
$grid->setColProperty("isbest", array("editable" => true, "label" => "Is Best", "width" => 50, "fixed" => true, "edittype" => "select"));
$grid->setSelect("isbest", $yesno, false, true, true, array("" => "All"));
$grid->setColProperty("isjumbo", array("editable" => true, "label" => "Is Jumbo", "width" => 50, "fixed" => true, "edittype" => "select"));
$grid->setSelect("isjumbo", $yesno, false, true, true, array("" => "All"));
$grid->setColProperty("iscandidate", array("editable" => true, "label" => "Is Candidate", "width" => 50, "fixed" => true, "edittype" => "select"));
$grid->setSelect("iscandidate", $yesno, false, true, true, array("" => "All"));
$grid->setGridOptions(array(
    "sortable" => true,
    "width" => 1024,
    "height" => 250,
    "caption" => "Recording Management",
    "rownumbers" => true,
    "rowNum" => 100,
    "sortname" => "classdate desc, description",
    "sortorder" => "desc",
    "toppager" => true,
    "rowList" => array(10, 20, 30, 50, 100, 500),
));
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf" => false, "excel" => false, "add" => true, "edit" => true, "del" => false, "view" => true, "search" => true));
$grid->setNavOptions('add', array("width" => 750, "dataheight" => 350, "closeOnEscape" => true, "closeAfterAdd" => true, "addCaption" => "Add Recording", "reloadAfterSubmit" => false));
$grid->setNavOptions('view', array("width" => 750, "dataheight" => 350, "viewCaption" => "Recording Management"));
$grid->setNavOptions('edit', array("width" => 750, "dataheight" => 350, "closeOnEscape" => true, "closeAfterEdit" => true, "editCaption" => "Update Recording", "reloadAfterSubmit" => false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys = <<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid', '#pager', true, null, null, true, true);
$DB = null;
?>
