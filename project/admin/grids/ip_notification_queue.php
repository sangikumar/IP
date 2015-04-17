<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);
$grid->SelectCommand = 'select ipnq.id , ipn.name as name , ipnq.keyid, ipnq.entrydate,ipnq.processed, ipnq.processeddate from ip_notification_queue ipnq , ip_notification ipn where ipnq.notificationid = ipn.id';
$grid->table = 'ip_notification_queue';
$grid->gSQLMaxRows = 100000;
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->setColModel();
$grid->setUrl('../grids/ip_notification_queue.php');
$grid->setColProperty("keyid", array("editable" => true, "frozen" => true, "width" => 50, "fixed" => true, "label" => "Key"));
$grid->setColProperty("processed", array("editable" => true, "width" => 70, "fixed" => true, "label" => "Processed", "edittype" => "select"));
$grid->setSelect("processed", $yesno, false, true, true, array("" => "All"));
$grid->setGridOptions(array(
    "sortable" => true,
    "width" => 1024,
    "height" => 300,
    "caption" => "Notification Queue Management",
    "rownumbers" => true,
    "rowNum" => 1000,
    "shrinkToFit" => false,
    "sortname" => "entrydate",
    "sortorder" => "desc",
    "toppager" => true,
    "rowList" => array(10, 100, 500, 1000, 10000),
));
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf" => true, "excel" => true, "add" => false, "edit" => true, "del" => true, "view" => true, "search" => true));
$grid->setNavOptions('view', array("width" => 750, "dataheight" => 250, "viewCaption" => "Notification Queue Management"));
$grid->setNavOptions('add', array("width" => 750, "dataheight" => 250, "closeOnEscape" => true, "closeAfterAdd" => true, "addCaption" => "Add New Notification", "reloadAfterSubmit" => true));
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