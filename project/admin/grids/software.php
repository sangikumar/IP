<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");

$grid = new jqGridRender($DB);
$grid->SelectCommand = 'SELECT id, name, version, softkey, type, status, link, notes FROM software';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->setColModel();
$grid->setUrl('../grids/software.php');

$grid->setColProperty("id", array("editable"=>false, "width"=>25, "hidden"=>true, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("name", array("editable"=>true, "editoptions"=>array("size"=>75, "maxlength"=>200), "frozen"=>true, "width"=>300, "fixed"=>true, "label"=>"Name"));
$grid->setColProperty("version", array("editable"=>true, "editoptions"=>array("size"=>75, "maxlength"=>50), "frozen"=>true, "width"=>50, "fixed"=>true, "label"=>"Version"));
$grid->setColProperty("softkey", array("editable"=>true, "editoptions"=>array("size"=>75, "maxlength"=>200), "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Key"));
$grid->setColProperty("type", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Type", "edittype"=>"select"));
$grid->setSelect("type", $softwaretype, false, true, true, array(""=>"All"));
$grid->setColProperty("status", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", array("Active"=>"Active", "Inactive"=>"Inactive"), false, true, true, array(""=>"All"));
$grid->setColProperty("link", array("editable"=>true, "frozen"=>true, "width"=>400, "editoptions"=>array("size"=>75, "maxlength"=>200), "formatter"=>"link", "fixed"=>true, "editrules"=>array("url"=>true, "required"=>false), "label"=>"Link"));
$grid->setColProperty("notes", array("editable"=>true, "width"=>70, "fixed"=>true, "edittype"=>"textarea","editoptions"=>array("rows"=>6, "cols"=> 80), "label"=>"Notes"));

$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Software Management",		
		"rownumbers"=>true,										
    "rowNum"=>100,
    "sortname"=>"name",
		"toppager"=>true,
    "rowList"=>array(10,100,500),
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>true,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>400, "viewCaption"=>"Software Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>400, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Software","bSubmit"=>"Add Software", "reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>400, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Software","bSubmit"=>"Update Software", "reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, null, null, true,true);

$DB=null;
?>