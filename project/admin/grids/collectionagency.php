<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");

$grid = new jqGridRender($DB);
$grid->SelectCommand = 'SELECT id, companyname, status, rank, email, phone, fax, address, managername, manageremail, managerphone, notes FROM collection_agency';
$grid->table = 'collection_agency';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->setColModel();
$grid->dataType = 'json';
$grid->setUrl('../grids/collectionagency.php');
$grid->setColProperty("id", array("editable"=>false, "hidden"=>true, "width"=>40, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("companyname", array("editable"=>true, "frozen"=>true, "width"=>250, "editoptions"=>array("size"=>75, "maxlength"=>250, "style"=>"text-transform: uppercase"), "fixed"=>true, "label"=>"Company Name"));
$grid->setColProperty("status", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", $vendorstatus , false, true, true, array(""=>"All"));	
$grid->setColProperty("rank", array("editable"=>true, "width"=>50, "fixed"=>true, "label"=>"Tier", "edittype"=>"Rank"));
$grid->setSelect("rank", $vendortier , false, true, true, array(""=>"All"));
$grid->setColProperty("email", array("editable"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>250, "style"=>"text-transform: lowercase"), "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>true), "label"=>"Email"));
$grid->setColProperty("phone", array("editable"=>true, "width"=>150, "editoptions"=>array("size"=>75, "maxlength"=>250),"fixed"=>true, "label"=>"Phone"));
$grid->setColProperty("fax", array("editable"=>true, "width"=>150, "editoptions"=>array("size"=>75, "maxlength"=>250),"fixed"=>true, "label"=>"Fax"));
$grid->setColProperty("address", array("editable"=>true, "width"=>150, "editoptions"=>array("size"=>75, "maxlength"=>250), "fixed"=>true, "label"=>"Address"));
$grid->setColProperty("managername", array("editable"=>true, "frozen"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Mgr Name"));
$grid->setColProperty("manageremail", array("editable"=>true, "width"=>150, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Mgr Email"));
$grid->setColProperty("managerphone", array("editable"=>true, "width"=>90, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Mgr Phone"));
$grid->setColProperty("notes", array("editable"=>true, "width"=>400, "fixed"=>true, "edittype"=>"textarea", "editoptions"=>array("rows"=>6, "cols"=> 60), "label"=>"Notes"));
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>500,
		"caption"=>"Collection Agency Management",		
		"rownumbers"=>true,										
    "rowNum"=>500,
    "sortname"=>"companyname",
		"sortorder"=>"asc",
		"toppager"=>true,
    "rowList"=>array(500,1000,5000,10000),
    ));		
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Collection Agencydor Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Collection Agency","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Collection Agency","reloadAfterSubmit"=>false));
//$grid->toolbarfilter = true;
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true,null, null, true,true);
$DB = null;
?>
