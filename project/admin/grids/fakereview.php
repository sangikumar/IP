<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);
$grid->SelectCommand = 'select id, review from fake_review ';
$grid->table = 'fake_review';
$grid->gSQLMaxRows = 100000;
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->setColModel();
$grid->setUrl('../grids/fakereview.php');
$grid->setColProperty("id", array("editable"=>false, "hidden"=>true, "label"=>"ID"));
$grid->setColProperty("review", array("editable"=>true, "width"=>400, "fixed"=>true, "edittype"=>"textarea", "editoptions"=>array("rows"=>6, "cols"=> 60), "label"=>"Reviews"));
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Fake Reviews Management",		
		"rownumbers"=>true,										
    "rowNum"=>1000,
		"shrinkToFit"=>false,
    "sortname"=>"id",
		"sortorder"=>"asc",
		"toppager"=>true,
    "rowList"=>array(10,100,500,1000,10000),
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>250, "viewCaption"=>"Fake Reviews Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>250, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Fake Review","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>250, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Edit Fake Review","reloadAfterSubmit"=>false));
//$grid->toolbarfilter = true;
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$DB = null;
?>