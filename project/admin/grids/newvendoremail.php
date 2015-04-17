<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);
$grid->SelectCommand = 'select distinct CONCAT("www.", SUBSTRING(email FROM instr(email, "@")+1)) url, email, positiondate from (select vendor1email as email, positiondate from position where vendor1email is not null union select vendor2email, positiondate from position where vendor2email is not null union select vendor3email, positiondate from position where vendor3email is not null union select client1email, null from interview where client1email is not null union select client2email, null from interview where client2email is not null union select client3email, null from interview where client3email is not null union select vendor1email, interviewdate from interview where vendor1email is not null union select vendor2email, interviewdate from interview where vendor2email is not null union select vendor3email, interviewdate from interview where vendor3email is not null) e ';
$grid->dataType = 'json';
$grid->setColModel();
$grid->setUrl('../grids/newvendoremail.php');
$grid->setColProperty("url", array("editable"=>false, "width"=>300, "fixed"=>true, "formatter"=>"link", "editrules"=>array("url"=>true, "required"=>false), "label"=>"URL"));
$grid->setColProperty("email", array("editable"=>true, "width"=>500, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>true), "label"=>"Email"));
$grid->setColProperty("positiondate", array("editable"=>false, "hidden"=>true, "label"=>"ID"));
						
// Set alternate background using altRows property
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"New Vendor Emails Management",		
		"rownumbers"=>true,										
    "rowNum"=>100,
		"shrinkToFit"=>false,
    "sortname"=>"positiondate",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(10,100,500,1000),
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>false,"edit"=>false,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"New Vendor Email Management"));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$DB = null;
?>