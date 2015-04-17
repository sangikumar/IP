<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);

$grid->SelectCommand = 'select id, label, parentid, sortorder from uc_header';
$grid->table = 'uc_header';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->setColModel();
$grid->setUrl('admin_headers.php');
$grid->setColProperty("id", array("editable"=>false, "width"=>25, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("label", array("editable"=>true, "frozen"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Name"));
$grid->setColProperty("parentid", array("editable"=>true, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Parent", "edittype"=>"select"));
$grid->setSelect("parentid", "select 0 as id, 'None' as label from dual union SELECT distinct id, label FROM uc_header order by label");
$grid->setColProperty("sortorder", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"SortOrder"));
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Headers Management",		
		"rownumbers"=>true,										
    "rowNum"=>100,
    "sortname"=>"parentid asc, sortorder",
		"sortorder"=>"asc",
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100),
    ));		
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>true,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>200, "viewCaption"=>"Headers Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>200, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Header","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>200, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Header","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, $summaryrows, null, true,true);
$DB = null;
?>