<?php
include_once ("../ip-config.php");
require_once '../jq-config.php';
// include the jqGrid Class
require_once ABSPATH."php/jqGrid.php";
// include the driver class
require_once ABSPATH."php/jqGridPdo.php";
// Connection to the server
$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);
$conn->query("SET NAMES utf8");
$grid = new jqGridRender($conn);

$grid->SelectCommand = 'SELECT id, placementid, mmid1, mm1paymenttype, mmid2, mm2paymenttype, amount, notes FROM mmpo';
$grid->table = 'mmpo';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->setColModel();
$grid->setUrl('mmpo.php');
$grid->setColProperty("id", array("editable"=>false, "width"=>25, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("placementid", array("editable"=>true, "frozen"=>true, "width"=>350, "fixed"=>true, "label"=>"Candidate", "edittype"=>"select"));
$grid->setSelect("placementid", "select '' as id, '' as name from dual union select pl.id, concat(c.name, '---', v.companyname, '---', cl.companyname) as name from placement pl, candidate c, vendor v, client cl  where pl.candidateid = c.candidateid  and pl.vendorid = v.id and pl.clientid = cl.id order by name");
$grid->setColProperty("mmid1", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Manager", "edittype"=>"select"));
$grid->setSelect("mmid1", "select DISTINCT u.id as id, e.name AS name  from employee e, uc_users u, uc_user_permission_matches up where e.loginid = u.id and u.id = up.user_id and up.permission_id in (4,3) order by name");
$grid->setColProperty("mm1paymenttype", array("editable"=>true, "width"=>170, "fixed"=>true, "label"=>"MM1 Payment Type", "edittype"=>"select"));
$grid->setSelect("mm1paymenttype",  array("Amount"=>"A","Percentage"=>"P"), false, true, true, array(""=>"All"));
$grid->setColProperty("mmid2", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Manager", "edittype"=>"select"));
$grid->setSelect("mmid2", "select '' as id, '' as name from dual union select DISTINCT u.id as id, e.name AS name  from employee e, uc_users u, uc_user_permission_matches up where e.loginid = u.id and u.id = up.user_id and up.permission_id in (4,3) order by name");
$grid->setColProperty("mm2paymenttype", array("editable"=>true, "width"=>170, "fixed"=>true, "label"=>"MM1 Payment Type", "edittype"=>"select"));
$grid->setSelect("mm2paymenttype",  array("Amount"=>"A","Percentage"=>"P"), false, true, true, array(""=>"All"));
$grid->setColProperty("amount", array("editable"=>true, "width"=>90, "formatter"=>"currency", "formatoptions"=>array("decimalPlaces"=>2,"thousandsSeparator"=>",","prefix"=>"$"), "sorttype"=>"currency", "fixed"=>true, "label"=>"Rate/Pct"));
$grid->setColProperty("notes", array("editable"=>true, "width"=>400, "fixed"=>true, "edittype"=>"textarea", "editoptions"=>array("rows"=>6, "cols"=> 60), "label"=>"Notes"));
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"MM PO Management",		
		"rownumbers"=>true,										
    "rowNum"=>100,
    "sortname"=>"placementid",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(50,100),
    ));		
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>300, "viewCaption"=>"MM PO Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>300, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add MM PO","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>300, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update MM PO","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true,null, null, true,true);
$conn = null;
?>
