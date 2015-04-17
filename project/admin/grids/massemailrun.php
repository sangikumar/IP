<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);
$grid->SelectCommand = 'SELECT id, ipkey, value from massemailrun';
$grid->table = 'massemailrun';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->setColModel();
$grid->setUrl('../grids/massemailrun.php');
$grid->setColProperty("id", array("editable" => false, "width" => 50, "fixed" => true, "label" => "ID"));
$grid->setColProperty("ipkey", array("editable" => true, "frozen" => true, "width" => 200, "fixed" => true, "label" => "Key"));
$grid->setColProperty("value", array("editable" => true, "width" => 400, "fixed" => true, "edittype" => "textarea", "editoptions" => array("rows" => 6, "cols" => 60), "label" => "Value"));
$grid->setGridOptions(array(
    "sortable" => true,
    "width" => 1024,
    "height" => 250,
    "caption" => "Mass Email Run Management",
    "rownumbers" => true,
    "rowNum" => 1000,
    "sortname" => "ipkey",
    "sortorder" => "asc",
    "toppager" => true,
    "rowList" => array(10, 50, 100, 500, 1000),
));
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf" => false, "excel" => false, "add" => true, "edit" => true, "del" => false, "view" => true, "search" => true));
$grid->setNavOptions('view', array("width" => 750, "dataheight" => 200, "viewCaption" => "Mass Email Management"));
$grid->setNavOptions('add', array("width" => 750, "dataheight" => 200, "closeOnEscape" => true, "closeAfterAdd" => true, "addCaption" => "Add Mass Email", "bSubmit" => "Add Mass Email", "reloadAfterSubmit" => false));
$grid->setNavOptions('edit', array("width" => 750, "dataheight" => 200, "closeOnEscape" => true, "closeAfterEdit" => true, "editCaption" => "Update Mass Email", "reloadAfterSubmit" => false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys = <<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid', '#pager', true, null, null, true, true);
$DB = null;
?>
