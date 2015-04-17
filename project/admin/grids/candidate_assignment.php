<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/project/admin/ip-includes/gridincludes.php");

// Create the jqGrid instance
$grid = new jqGridRender($DB);
// Write the SQL Query
$grid->SelectCommand = 'SELECT id, question, categoryid, subcategoryid  FROM ip_assignment where priority = "Test"';

// Set the table to where we add the data
$grid->table = 'ip_assignment';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->setColModel();
$grid->setUserDate("Y-m-d"); 
$grid->setUrl('../grids/candidate_assignment.php');
$grid->setColProperty("id", array("editable"=>false, "hidden"=>true, "label"=>"ID"));
$grid->setColProperty("question", array("editable"=>true, "width"=>700, "fixed"=>true, "edittype"=>"textarea", "editoptions"=>array("rows"=>6, "cols"=> 60), "label"=>"Question"));

$grid->setColProperty("categoryid", array("editable"=>true,"frozen"=>true, "width"=>100,"fixed"=>true, "label" =>"Subject" , "edittype"=>"select"));
$grid->setSelect("categoryid", "SELECT distinct id, concat(id,category)  FROM ip_subjectcategory order by id");

$grid->setColProperty("subcategoryid", array("editable"=>true,"frozen"=>true, "width"=>60,"fixed"=>true, "label" =>"Category" , "edittype"=>"select"));
$grid->setSelect("subcategoryid", "SELECT distinct id, concat(categoryid,subcategory)  FROM ip_subjectsubcategory order by id");


$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>400,
		"caption"=>"Test Management",		
		"rownumbers"=>true,										
    "rowNum"=>1000,
		"shrinkToFit"=>false,
    "sortname"=>"categoryid",
		"sortorder"=>"asc",
		"toppager"=>true,
    "rowList"=>array(10,100,500,1000,10000,20000),
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>false,"edit"=>false,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>300, "viewCaption"=>"Test Management"));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, null, null,true,true);
$DB = null;
?>



