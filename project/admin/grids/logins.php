<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");

// Create the jqGrid instance
$grid = new jqGridRender($DB);
// Write the SQL Query
$grid->SelectCommand = 'SELECT id,name,username,password,site,status,type,recoveryemail, altemail, phone, permissionid1,permissionid2,permissionid3,permissionid4,permissionid5,permissionid6,permissionid7,permissionid8,notes FROM login';
$grid->table = 'login';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->setColModel();
$grid->setUrl('../grids/logins.php');
$grid->setColProperty("id", array("editable"=>false, "width"=>25, "hidden"=>true, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("name", array("editable"=>true, "frozen"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Name"));
$grid->setColProperty("username", array("editable"=>true, "frozen"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Username"));
$grid->setColProperty("password", array("editable"=>true, "frozen"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Password"));
$grid->setColProperty("site", array("editable"=>true, "frozen"=>true, "width"=>400, "editoptions"=>array("size"=>75, "maxlength"=>200), "formatter"=>"link", "formatoptions"=>array("target"=>"_blank"), "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "editrules"=>array("url"=>true, "required"=>false), "label"=>"Site"));
$grid->setColProperty("status", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", $loginstatus , false, true, true, array(""=>"All"));	
$grid->setColProperty("type", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Type", "edittype"=>"select"));
$grid->setSelect("type", $logintype , false, true, true, array(""=>"All"));	
$grid->setColProperty("recoveryemail", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Recovery Email"));
$grid->setColProperty("altemail", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Alt Email"));
$grid->setColProperty("phone", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Phone"));			
$grid->setColProperty("permissionid1", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Permissionid1", "edittype"=>"select"));
$grid->setSelect("permissionid1", "select '' as id, '' as name from dual union SELECT distinct id, name FROM uc_permissions order by name");
$grid->setColProperty("permissionid2", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Permissionid2", "edittype"=>"select"));
$grid->setSelect("permissionid2", "select '' as id, '' as name from dual union SELECT distinct id, name FROM uc_permissions order by name");
$grid->setColProperty("permissionid3", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Permissionid3", "edittype"=>"select"));
$grid->setSelect("permissionid3", "select '' as id, '' as name from dual union SELECT distinct id, name FROM uc_permissions order by name");
$grid->setColProperty("permissionid4", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Permissionid4", "edittype"=>"select"));
$grid->setSelect("permissionid4", "select '' as id, '' as name from dual union SELECT distinct id, name FROM uc_permissions order by name");
$grid->setColProperty("permissionid5", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Permissionid5", "edittype"=>"select"));
$grid->setSelect("permissionid5", "select '' as id, '' as name from dual union SELECT distinct id, name FROM uc_permissions order by name");
$grid->setColProperty("permissionid6", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Permissionid6", "edittype"=>"select"));
$grid->setSelect("permissionid6", "select '' as id, '' as name from dual union SELECT distinct id, name FROM uc_permissions order by name");
$grid->setColProperty("permissionid7", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Permissionid7", "edittype"=>"select"));
$grid->setSelect("permissionid7", "select '' as id, '' as name from dual union SELECT distinct id, name FROM uc_permissions order by name");
$grid->setColProperty("permissionid8", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Permissionid8", "edittype"=>"select"));
$grid->setSelect("permissionid8", "select '' as id, '' as name from dual union SELECT distinct id, name FROM uc_permissions order by name");
$grid->setColProperty("notes", array("editable"=>true, "width"=>400, "fixed"=>true, "edittype"=>"textarea", "editoptions"=>array("rows"=>6, "cols"=> 60), "label"=>"Notes"));
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Login Management",		
		"rownumbers"=>true,										
    "rowNum"=>100,
    "sortname"=>"id",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100),
    ));		
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>400, "viewCaption"=>"Login Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>400, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Login","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>400, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Login","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true,null, null, true,true);
$DB = null;
?>