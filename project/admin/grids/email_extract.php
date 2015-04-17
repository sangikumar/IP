<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);
$grid->SelectCommand = 'SELECT id, email, password, deleteemails, deleteage, uidvalidity, largestuid, lastmoddatetime from emailextract';
$grid->table = 'emailextract';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->setColModel();
$grid->setUrl('../grids/email_extract.php');
$grid->setColProperty("id", array("editable"=>false, "width"=>50, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("email", array("editable"=>true, "width"=>150, "fixed"=>true, "editoptions"=>array("size"=>75, "maxlength"=>150), "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>true), "label"=>"Email"));
$grid->setColProperty("password", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Password"));
$grid->setColProperty("deleteemails", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Delete Old"));
$grid->setColProperty("deleteage", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Delete Age"));
$grid->setColProperty("uidvalidity", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"UID"));
$grid->setColProperty("largestuid", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"LUID"));
$grid->setColProperty("lastmoddatetime", array("editable"=>false, "label"=>"Last Modified", "width"=>170, "fixed"=>true));
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Email Extraction Management",		
		"rownumbers"=>true,										
    "rowNum"=>1000,
    "sortname"=>"id",
		"sortorder"=>"asc",
		"toppager"=>true,
    "rowList"=>array(10,50,100,500,1000),
    ));		
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>false,"excel"=>false,"add"=>true,"edit"=>true,"del"=>true,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>200, "viewCaption"=>"Email Extraction Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>200, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Email Extraction","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>200, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Email Extraction","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true,null, null, true,true);
$DB = null;
?>
