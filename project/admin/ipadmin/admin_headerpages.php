<?php
include_once ("../ip-config.php");
require_once '../jq-config.php';
require_once ABSPATH."php/jqGrid.php";
require_once ABSPATH."php/jqGridPdo.php";
$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);
$conn->query("SET NAMES utf8");
$grid = new jqGridRender($conn);

$grid->SelectCommand = 'select id, pageid, headerid, label, sortorder from uc_header_pages t';
$grid->table = 'uc_header_pages';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->setColModel();
$grid->setUrl('admin_headerpages.php');
$grid->setColProperty("id", array("editable"=>false, "width"=>25, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("label", array("editable"=>true, "frozen"=>true, "width"=>100, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Label"));
$grid->setColProperty("headerid", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Header", "edittype"=>"select"));
$grid->setSelect("headerid", "select id, TRIM(LEADING '->' FROM label) from (SELECT distinct id, concat(ifnull((select concat(ifnull((select concat(ifnull((select label from uc_header uh3 where id = uh2.parentid), ''), '->', label) as label from uc_header uh2 where id = uh1.parentid), ''), '->', label)as label from uc_header uh1 where id = uh.parentid), ''), '->', label) as label FROM uc_header uh order by label) t");
$grid->setColProperty("pageid", array("editable"=>true, "frozen"=>true, "width"=>250, "fixed"=>true, "label"=>"Page", "edittype"=>"select"));
$grid->setSelect("pageid", "select id, concat(page, ' - ', IFNULL(label, '')) as label1 from uc_pages up order by label1");
$grid->setColProperty("sortorder", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"SortOrder"));
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Header Pages Management",		
		"rownumbers"=>true,										
    "rowNum"=>100,
    "sortname"=>"headerid asc, sortorder",
		"sortorder"=>"asc",
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100),
    ));		
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>true,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>250, "viewCaption"=>"Header Pages Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>250, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Header Page","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>250, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Header Page","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, $summaryrows, null, true,true);
$conn = null;
?>