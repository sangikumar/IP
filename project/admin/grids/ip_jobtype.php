<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);
$job_type = $_GET['type'];

if ($job_type == "C") {
    $grid->SelectCommand = 'select id, name, frequency, nextrundate, isactive, priority, description, type from ip_jobtypes where type = "C"';
} else if ($job_type == "N") {
    $grid->SelectCommand = 'select id, name, frequency, nextrundate, isactive, priority, description, type from ip_jobtypes where type = "N"';
} else if ($job_type == "AB") {
    $grid->SelectCommand = 'select id, name, frequency, nextrundate, isactive, priority, description, type from ip_jobtypes where type in ("A","B")';
}

$grid->table = 'ip_jobtypes';
$grid->gSQLMaxRows = 100000;
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('nextrundate');
$grid->setUserDate("Y-m-d");
$grid->setColModel();
$grid->setUrl('../grids/ip_jobtype.php?type=' . $job_type);
$grid->setColProperty("id", array("editable" => false, "hidden" => true, "label" => "ID"));
$grid->setColProperty("name", array("editable" => true, "frozen" => true, "width" => 200, "editoptions" => array("size" => 75, "maxlength" => 200), "fixed" => true, "label" => "Name"));
$grid->setColProperty("frequency", array("editable" => true, "frozen" => true, "width" => 70, "fixed" => true, "label" => "Frequency"));
$grid->setColProperty("nextrundate", array("formatter" => "date", "width" => 80, "fixed" => true, "formatoptions" => array("srcformat" => "Y-m-d", "newformat" => "Y-m-d"), "editable" => true, "label" => "Next Run Date",
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
$grid->setColProperty("isactive", array("editable" => true, "width" => 70, "fixed" => true, "label" => "Active", "edittype" => "select"));
$grid->setSelect("isactive", $yesno, false, true, true, array("" => "All"));
$grid->setColProperty("priority", array("editable" => true, "frozen" => true, "width" => 50, "fixed" => true, "label" => "Priority"));
$grid->setColProperty("description", array("editable" => true, "frozen" => true, "width" => 400, "editoptions" => array("size" => 75, "maxlength" => 200), "fixed" => true, "label" => "Description"));
$grid->setColProperty("type", array("editable" => true, "frozen" => true, "width" => 50, "fixed" => true, "label" => "Type"));
$grid->setGridOptions(array(
    "sortable" => true,
    "width" => 1024,
    "height" => 250,
    "caption" => "Job Type Management",
    "rownumbers" => true,
    "rowNum" => 1000,
    "shrinkToFit" => false,
    "sortname" => "priority",
    "sortorder" => "asc",
    "toppager" => true,
    "rowList" => array(10, 100, 500, 1000, 10000),
));
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf" => true, "excel" => true, "add" => true, "edit" => true, "del" => true, "view" => true, "search" => true));
$grid->setNavOptions('view', array("width" => 750, "dataheight" => 250, "viewCaption" => "Job Type Management"));
$grid->setNavOptions('add', array("width" => 750, "dataheight" => 250, "closeOnEscape" => true, "closeAfterAdd" => true, "addCaption" => "Add Job Type", "reloadAfterSubmit" => false));
$grid->setNavOptions('edit', array("width" => 750, "dataheight" => 250, "closeOnEscape" => true, "closeAfterEdit" => true, "editCaption" => "Update Job Type", "reloadAfterSubmit" => false));
//$grid->toolbarfilter = true;
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys = <<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid', '#pager', true, null, null, true, true);
$DB = null;
?>