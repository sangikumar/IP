<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$userid = $_GET['userid'];
$grid = new jqGridRender($DB);

$grid->SelectCommand = 'SELECT l.id,name,username,password,site,status,type, permissionid8,notes FROM login l, uc_user_permission_matches up where (l.permissionid1 = up.permission_id or l.permissionid2 = up.permission_id  or l.permissionid3 = up.permission_id  or l.permissionid4 = up.permission_id  or l.permissionid5 = up.permission_id  or l.permissionid6 = up.permission_id  or l.permissionid7 = up.permission_id  or l.permissionid8 = up.permission_id) and up.user_id = "'. $userid .'"';
$grid->table = 'login';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->setColModel();
$grid->setUrl('../grids/rlogins.php?userid='.$userid);
$grid->setColProperty("id", array("editable"=>false, "width"=>25, "hidden"=>true, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("name", array("editable"=>true, "frozen"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Name"));
$grid->setColProperty("username", array("editable"=>true, "frozen"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Username"));
$grid->setColProperty("password", array("editable"=>true, "frozen"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Password"));
$grid->setColProperty("site", array("editable"=>true, "frozen"=>true, "width"=>400, "editoptions"=>array("size"=>75, "maxlength"=>200), "formatter"=>"link", "fixed"=>true, "editrules"=>array("url"=>true, "required"=>false), "label"=>"Site"));
$grid->setColProperty("status", array("editable"=>true, "width"=>100, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", $loginstatus , false, true, true, array(""=>"All"));	
$grid->setColProperty("type", array("editable"=>true, "width"=>100, "fixed"=>true, "label"=>"Type", "edittype"=>"select"));
$grid->setSelect("type", $logintype , false, true, true, array(""=>"All"));	
$grid->setColProperty("permissionid8", array("editable"=>true, "width"=>200, "fixed"=>true, "label"=>"Permission", "edittype"=>"select"));
$grid->setSelect("permissionid8", "SELECT distinct up.id, up.name FROM uc_permissions up, uc_user_permission_matches upm where upm.permission_id = up.id and upm.user_id = $userid order by name");
$grid->setColProperty("notes", array("editable"=>true, "width"=>400, "fixed"=>true, "edittype"=>"textarea", "editoptions"=>array("rows"=>6, "cols"=> 60), "label"=>"Notes"));

$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Login List",		
		"rownumbers"=>true,										
    "rowNum"=>100,
    "sortname"=>"id",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100),
    ));		
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>false,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>250, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Login","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>250, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Login","reloadAfterSubmit"=>false));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>250, "viewCaption"=>"Login Management"));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true,null, null, true,true);
$DB = null;
?>