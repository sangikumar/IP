<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");

$grid = new jqGridRender($DB);

$grid->SelectCommand = 'SELECT id,category,description,type,filetype,link,status,iscandidate FROM document';
$grid->table = 'document';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('classdate');
$grid->setUserDate("Y-m-d"); 
$grid->setColModel();
$grid->setUrl('../grids/document.php');
$grid->setColProperty("id", array("editable"=>false, "width"=>25, "hidden"=>true, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("category", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Category", "edittype"=>"select"));
$grid->setSelect("category", array("Candidate"=>"Candidate", "Employee"=>"Employee", "Vendor"=>"Vendor", "Client"=>"Client"), false, true, true, array(""=>"All"));
$grid->setColProperty("description", array("editable"=>true, "frozen"=>true, "width"=>300, "editoptions"=>array("size"=>75, "maxlength"=>250), "fixed"=>true, "label"=>"Description"));
$grid->setColProperty("type", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Type", "edittype"=>"select"));
$grid->setSelect("type", array("Agreement"=>"Agreement", "HowTo"=>"HowTo", "Guidelines"=>"Guidelines", "Payment"=>"Payment"), false, true, true, array(""=>"All"));
$grid->setColProperty("filetype", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"File Type", "edittype"=>"select"));
$grid->setSelect("filetype", array("doc"=>"doc", "docx"=>"docx", "pdf"=>"pdf"), false, true, true, array(""=>"All"));
$grid->setColProperty("link", array("editable"=>true, "frozen"=>true, "width"=>300, "editoptions"=>array("size"=>75, "maxlength"=>300), "formatter"=>"link", "formatoptions"=>array("target"=>"_blank"), "fixed"=>true, "editrules"=>array("url"=>true, "required"=>false), "label"=>"Url"));
$grid->setColProperty("status", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", array("active"=>"active", "inactive"=>"inactive"), false, true, true, array(""=>"All"));
$grid->setColProperty("iscandidate", array("editable"=>true, "label"=>"Is Candidate", "width"=>90, "fixed"=>true,  "edittype"=>"select"));
$grid->setSelect("iscandidate", $yesno, false, true, true, array(""=>"All"));
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Document Management",		
		"rownumbers"=>true,										
    "rowNum"=>100,
    "sortname"=>"type asc, description",
		"sortorder"=>"asc",
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100,500),
    ));			
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>false,"excel"=>false,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>350, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Document","reloadAfterSubmit"=>false));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>350, "viewCaption"=>"Document Management"));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>350, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Document","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true,null, null, true,true);
$DB = null;
?>