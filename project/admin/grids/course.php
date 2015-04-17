<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");

// Create the jqGrid instance
$grid = new jqGridRender($DB);
// Write the SQL Query
$grid->SelectCommand = 'SELECT name, alias , description, syllabus from course ';
// Set the table to where we add the data
$grid->table = 'course';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
// set the ouput format to json
$grid->dataType = 'json';

// Let the grid create the model from SQL query
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('../grids/course.php');
// Change some property of the field(s)
$grid->setColProperty("name", array("editable"=>true, "width"=>250, "fixed"=>true, "label"=>"Name"));
$grid->setColProperty("alias", array("editable"=>true,  "label"=>"Alias", "width"=>100, "fixed"=>true));
$grid->setColProperty("description", array("editable"=>true,"editoptions" => array("size" => 75, "maxlength" => 200), "label"=>"Description", "width"=>250, "fixed"=>true));
$grid->setColProperty("syllabus", array("editable"=>true, "editoptions" => array("size" => 75, "maxlength" => 200),"label"=>"Syllabus", "width"=>500, "fixed"=>true));
// Set alternate background using altRows property
$grid->setGridOptions(array(
    "sortable"=>true,
    "width"=>1024,
    "height"=>250,
    "caption"=>"Course Management",
    "rownumbers"=>true,
    "rowNum"=>30,
    "sortname"=>"name",
    "sortorder"=>"desc",
    "toppager"=>true,
    "rowList"=>array(10,20,30,50,100),
));
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Course Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Course","bSubmit"=>"Add Course", "reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Course","bSubmit"=>"Update Course", "reloadAfterSubmit"=>false));
//$grid->toolbarfilter = true;
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
GLOBAL $htmlcode;
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) {

                   alert("You enter a row with id:"+rowid + rowData.name);
                     } } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$DB = null;

?>
