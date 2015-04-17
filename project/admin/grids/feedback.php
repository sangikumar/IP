<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);
$grid->SelectCommand = 'SELECT id, name, email, phone, trainingmessage, companymessage, improvemessage, refer, usefeedback FROM feedback';
$grid->table = 'feedback';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->setColModel();
$grid->setUrl('../grids/feedback.php');
$grid->setColProperty("id", array("editable"=>false, "width"=>25, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("name", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Name"));
$grid->setColProperty("email", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>true), "label"=>"Email"));
$grid->setColProperty("phone", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Phone"));
$grid->setColProperty("trainingmessage", array("editable"=>true, "hidden"=>true, "edittype"=>"textarea","editrules"=>array("edithidden"=>true, "required"=>false), "editoptions"=>array("rows"=>6, "cols"=> 80), "label"=>"Training Message"));
$grid->setColProperty("companymessage", array("editable"=>true, "hidden"=>true, "edittype"=>"textarea","editrules"=>array("edithidden"=>true, "required"=>false), "editoptions"=>array("rows"=>6, "cols"=> 80), "label"=>"Company Message"));
$grid->setColProperty("improvemessage", array("editable"=>true, "hidden"=>true, "edittype"=>"textarea","editrules"=>array("edithidden"=>true, "required"=>false), "editoptions"=>array("rows"=>6, "cols"=> 80), "label"=>"Improve Message"));
$grid->setColProperty("refer", array("editable"=>true, "label"=>"Refer", "width"=>50, "fixed"=>true,  "edittype"=>"select"));
$grid->setSelect("refer", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("usefeedback", array("editable"=>true, "label"=>"Use Feedback", "width"=>50, "fixed"=>true,  "edittype"=>"select"));
$grid->setSelect("usefeedback", $yesno , false, true, true, array(""=>"All"));
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Feedback Management",		
		"rownumbers"=>true,										
    "rowNum"=>100,
    "footerrow"=>true,
    "userDataOnFooter"=>true,
		"shrinkToFit"=>false,
    "sortname"=>"id",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(10,50,100,500,1000),
    ));		
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Feedback Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Feedback","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Feedback","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true,null, null, true,true);
$DB = null;
?>
