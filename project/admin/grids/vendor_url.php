<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);
$grid->SelectCommand = 'select id, url from sales_url_db';
$grid->table = 'sales_url_db';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->setUserDate("Y-m-d"); 
$grid->setColModel();
$grid->setUrl('../grids/vendor_url.php');
$grid->setColProperty("id", array("editable"=>false, "frozen"=>true, "hidden"=>true, "width"=>40, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("url", array("editable"=>true, "frozen"=>true, "width"=>700, "editoptions"=>array("size"=>75, "maxlength"=>400), "formatter"=>"link", "formatoptions"=>array("target"=>"_blank"), "fixed"=>true, "editrules"=>array("url"=>true, "required"=>false), "label"=>"URL"));
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Vendor URL Management",		
		"rownumbers"=>true,										
    "rowNum"=>1000,
    "sortname"=>"id",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(1000,5000,10000,50000),
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>250, "viewCaption"=>"Vendor URL Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>250, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Crawler","bSubmit"=>"Add Site", "reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>250, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Crawler","bSubmit"=>"Update Site", "reloadAfterSubmit"=>false));
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