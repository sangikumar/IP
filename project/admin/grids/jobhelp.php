<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);
$grid->SelectCommand = 'select "Innovapath" as name, "all@innova-path.com" as email, "925-400-7330" as phone from dual union select name, email, phone from candidate where status in ("Placed", "OnProject-Mkt", "Placed", "Marketing")';
$grid->dataType = 'json';
$grid->setColModel();
$grid->setUrl('../grids/jobhelp.php');
$grid->setColProperty("name", array("editable"=>false, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Name"));
$grid->setColProperty("phone", array("editable"=>false, "width"=>200, "fixed"=>true, "label"=>"Phone"));
$grid->setColProperty("email", array("editable"=>false, "width"=>200, "fixed"=>true, "formatter"=>"email", "label"=>"Email"));
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Job Help List",		
		"rownumbers"=>true,										
    "rowNum"=>100,
    "sortname"=>"name",
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100,500),
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>false,"excel"=>true,"add"=>false,"edit"=>false,"del"=>false,"view"=>true, "search"=>true));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Job Help List"));
//$grid->toolbarfilter = true;
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$DB = null;
?>
