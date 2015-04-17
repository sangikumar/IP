<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);
$grid->SelectCommand = 'select id, name, subject, fromEmail, toEmail,showtable, appointment, message, template, description, dbsql from ip_notification';
$grid->table = 'ip_notification';
$grid->gSQLMaxRows = 100000;
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->setColModel();
$grid->setUrl('../grids/ip_notification.php');
$grid->setColProperty("id", array("editable" => false, "hidden" => false, "label" => "ID", "width" => 40));
$grid->setColProperty("name", array("editable" => true, "frozen" => true, "width" => 150, "editoptions" => array("size" => 75, "maxlength" => 200), "fixed" => true, "label" => "Name"));
$grid->setColProperty("description", array("editable" => true, "frozen" => true, "width" => 200, "editoptions" => array("size" => 75, "maxlength" => 200), "fixed" => true, "label" => "Description"));
$grid->setColProperty("fromEmail", array("editable" => true, "frozen" => true, "width" => 200, "editoptions" => array("size" => 75, "maxlength" => 200), "fixed" => true, "editrules" => array("required" => false), "label" => "FromEmail"));
$grid->setColProperty("toEmail", array("editable" => true, "frozen" => true, "width" => 200, "editoptions" => array("size" => 75, "maxlength" => 200), "fixed" => true, "editrules" => array("required" => false), "label" => "ToEmail"));
$grid->setColProperty("subject", array("editable" => true, "frozen" => true, "width" => 300, "editoptions" => array("size" => 75, "maxlength" => 200), "fixed" => true, "label" => "Subject"));
$grid->setColProperty("showtable", array("editable" => true, "label" => "Table", "width" => 50, "fixed" => true, "edittype" => "select"));
$grid->setSelect("showtable", $yesno, false, true, true, array("" => "All"));
$grid->setColProperty("appointment", array("editable" => true, "label" => "Appointment", "width" => 50, "fixed" => true, "edittype" => "select"));
$grid->setSelect("appointment", $yesno, false, true, true, array("" => "All"));
$grid->setColProperty("message", array("editable"=>true, "hidden"=>true, "edittype"=>"textarea","editrules"=>array("edithidden"=>true, "required"=>false), "editoptions"=>array("rows"=>6, "cols"=> 80), "label"=>"Message"));
$grid->setColProperty("template", array("editable" => true, "frozen" => true, "width" => 100, "fixed" => true, "label" => "Template"));
$grid->setColProperty("dbsql", array("editable"=>true, "hidden"=>true, "edittype"=>"textarea","editrules"=>array("edithidden"=>true, "required"=>false), "editoptions"=>array("rows"=>6, "cols"=> 80), "label"=>"DbSql"));

$grid->setGridOptions(array(
    "sortable" => true,
    "width" => 1024,
    "height" => 300,
    "caption" => "Notification Management",
    "rownumbers" => true,
    "rowNum" => 1000,
    "shrinkToFit" => false,
    "sortname" => "showtable asc, appointment asc, message asc, name",
    "sortorder" => "asc",
    "toppager" => true,
    "rowList" => array(10, 100, 500, 1000, 10000),
));
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf" => true, "excel" => true, "add" => true, "edit" => true, "del" => true, "view" => true, "search" => true));
$grid->setNavOptions('view', array("width" => 750, "dataheight" => 250, "viewCaption" => "Notification Management"));
$grid->setNavOptions('add', array("width" => 750, "dataheight" => 250, "closeOnEscape" => true, "closeAfterAdd" => true, "addCaption" => "Add Notification", "reloadAfterSubmit" => true));
$grid->setNavOptions('edit', array("width" => 750, "dataheight" => 250, "closeOnEscape" => true, "closeAfterEdit" => true, "editCaption" => "Update Notification", "reloadAfterSubmit" => true));
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