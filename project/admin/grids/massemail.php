<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);
$grid->SelectCommand = 'select id, email, name, phone, remove, lastmoddatetime from massemail ';
$grid->table = 'massemail';
$grid->gSQLMaxRows = 100000;
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->setColModel();
$grid->setUrl('../grids/massemail.php');
$grid->setColProperty("id", array("editable"=>false, "hidden"=>true, "label"=>"ID"));
$grid->setColProperty("email", array("editable"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>true), "label"=>"Email"));
$grid->setColProperty("name", array("editable"=>true, "frozen"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Name"));
$grid->setColProperty("phone", array("editable"=>true, "width"=>400, "fixed"=>true, "edittype"=>"textarea", "editoptions"=>array("rows"=>6, "cols"=> 60), "label"=>"Phone"));
$grid->setColProperty("remove", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Remove", "edittype"=>"select"));
$grid->setSelect("remove", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("lastmoddatetime", array("editable"=>false, "hidden"=>false, "label"=>"lastmoddatetime"));
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Mass Email Management",		
		"rownumbers"=>true,										
    "rowNum"=>1000,
		"shrinkToFit"=>false,
    "sortname"=>"lastmoddatetime",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(10,100,500,1000,10000),
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>250, "viewCaption"=>"Mass Email Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>250, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Mass Email","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>250, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Mass Email","reloadAfterSubmit"=>false));
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