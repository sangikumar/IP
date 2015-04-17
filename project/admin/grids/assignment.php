<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/ip-includes/gridincludes.php");

// Create the jqGrid instance
$grid = new jqGridRender($DB);
// Write the SQL Query
$grid->SelectCommand = 'SELECT id, weeknumber, instructorid, question, categoryid, subcategoryid, priority FROM ip_assignment';

// Set the table to where we add the data
$grid->table = 'ip_assignment';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->setColModel();
$grid->setUserDate("Y-m-d");
$grid->setUrl('../grids/assignment.php');
$grid->setColProperty("id", array("editable" => false, "hidden" => true, "label" => "ID"));
$grid->setColProperty("weeknumber", array("editable" => true, "width" => 30, "fixed" => true, "label" => "Week"));
$grid->setColProperty("instructorid", array("editable" => true, "frozen" => true, "width" => 100, "fixed" => true, "label" => "Instructor", "edittype" => "select"));
$grid->setSelect("instructorid", "SELECT distinct id, name FROM employee order by id");
$grid->setColProperty("question", array("editable" => true, "width" => 450, "fixed" => true, "edittype" => "textarea", "editoptions" => array("rows" => 6, "cols" => 60), "label" => "Question"));

$grid->setColProperty("categoryid", array("editable" => true, "frozen" => true, "width" => 60, "fixed" => true, "label" => "Subject", "edittype" => "select"));
$grid->setSelect("categoryid", "SELECT distinct id, concat(id,category)  FROM ip_subjectcategory order by id");

$grid->setColProperty("subcategoryid", array("editable" => true, "frozen" => true, "width" => 60, "fixed" => true, "label" => "Category", "edittype" => "select"));
$grid->setSelect("subcategoryid", "SELECT distinct id, concat(categoryid,subcategory)  FROM ip_subjectsubcategory order by id");

$grid->setColProperty("priority", array("editable" => true, "width" => 30, "fixed" => true, "label" => "Priority"));

$grid->setGridOptions(array(
    "sortable" => true,
    "width" => 1024,
    "height" => 400,
    "caption" => "Assignment Management",
    "rownumbers" => true,
    "rowNum" => 1000,
    "shrinkToFit" => false,
    "sortname" => "weeknumber",
    "sortorder" => "asc",
    "toppager" => true,
    "rowList" => array(10, 100, 500, 1000, 10000, 20000),
));
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf" => true, "excel" => true, "add" => true, "edit" => true, "del" => true, "view" => true, "search" => true));
$grid->setNavOptions('view', array("width" => 750, "dataheight" => 300, "viewCaption" => "Assignment Management"));
$grid->setNavOptions('add', array("width" => 750, "dataheight" => 300, "closeOnEscape" => true, "closeAfterAdd" => true, "addCaption" => "Add Assignment", "reloadAfterSubmit" => false));
$grid->setNavOptions('edit', array("width" => 750, "dataheight" => 300, "closeOnEscape" => true, "closeAfterEdit" => true, "editCaption" => "Update Assignment", "reloadAfterSubmit" => false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys = <<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid', '#pager', true, null, null, true, true);
$DB = null;
?>



