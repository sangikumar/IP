<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");

// Create the jqGrid instance
$grid = new jqGridRender($DB);
// Write the SQL Query
$grid->SelectCommand = 'SELECT id, name, dbsql from ip_email_group';
// Set the table to where we add the data
$grid->table = 'ip_email_group';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
// set the ouput format to json
$grid->dataType = 'json';
// Let the grid create the model from SQL query
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('../grids/email_group.php');
// Change some property of the field(s)
$grid->setColProperty("id", array("editable"=>false, "hidden"=>true, "width"=>25, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("name", array("editable"=>true, "width"=>100, "fixed"=>true, "label"=>"Name"));
$grid->setColProperty("dbsql", array("editable"=>true, "edittype"=>"textarea",  "label"=>"SQL", "width"=>750, "fixed"=>true , "editoptions"=>array("rows"=>10, "cols"=> 80)));
// Set alternate background using altRows property
$grid->setGridOptions(array(
    "sortable"=>true,
    "width"=>1024,
    "height"=>250,
    "caption"=>"Email Group Management",
    "rownumbers"=>true,
    "rowNum"=>30,
    "sortname"=>"name",
    "sortorder"=>"asc",
    "toppager"=>true,
    "rowList"=>array(10,20,30,50,100),
));
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Email Group Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Course","bSubmit"=>"Add Email Group", "reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Course","bSubmit"=>"Update Email Group", "reloadAfterSubmit"=>false));
//$grid->toolbarfilter = true;
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
GLOBAL $htmlcode;
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) {

                    var rowData = jQuery('#grid').jqGrid ('getRowData', rowid);
} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$DB = null;

?>
