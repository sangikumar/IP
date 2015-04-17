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
$grid->SelectCommand = 'select cp.id, c.name, cp.type, communication, cp.assesment, c.batchname, cp.candidateid from candidateprogress cp, candidate c where c.candidateid = cp.candidateid and c.status = "Active"';
$grid->table = 'candidateprogress';
$grid->dataType = 'json';
$grid->setPrimaryKeyId('id');
$grid->setColModel();
$grid->setUserDate("Y-m-d"); 
$grid->setUrl('candidateprogress.php');
$grid->setColProperty("id", array("editable"=>false, "frozen"=>true, "hidden"=>true, "label"=>"ID"));
$grid->setColProperty("name", array("editable"=>false, "width"=>150, "fixed"=>true, "formatter"=>"email", "label"=>"Name"));
$grid->setColProperty("candidateid", array("editable"=>true, "frozen"=>true, "width"=>30, "fixed"=>true, "label"=>"Candidate Name", "edittype"=>"select"));
$grid->setSelect("candidateid", "SELECT distinct candidateid as id, name FROM candidate c where status = 'Active' and NOT EXISTS ( select cp.candidateid from candidateprogress cp where cp.candidateid = c.candidateid) order by name");
$grid->setColProperty("type", array("editable"=>true, "frozen"=>true, "width"=>70, "fixed"=>true, "label"=>"Type", "edittype"=>"select"));
$grid->setSelect("type", $progresstype , false, true, true, array(""=>"All"));
$grid->setColProperty("communication", array("editable"=>true, "editoptions"=>array("size"=>75, "maxlength"=>200), "width"=>150, "fixed"=>true, "label"=>"Communication"));
$grid->setColProperty("assesment", array("editable"=>true, "width"=>450, "fixed"=>true, "edittype"=>"textarea","editoptions"=>array("rows"=>6, "cols"=> 80), "label"=>"Feedback"));
$grid->setColProperty("batchname", array("editable"=>false, "width"=>90, "fixed"=>true, "label"=>"Batch Name"));
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Candidate Assesment Management",		
		"rownumbers"=>true,										
    "rowNum"=>30,
		"shrinkToFit"=>false,
    "sortname"=>"candidateid asc, id",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100),
    "grouping"=>true,
    "groupingView"=>array(
    "groupField" => array('batchname'),
    "groupColumnShow" => array(true),
    "groupOrder" => array('desc'),
    "groupText" =>array('<b>{0}</b>'),
    "groupDataSorted" => true)		
    ));	
	
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>300, "viewCaption"=>"Candidate Assesment Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>300, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Assesment","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>300, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Assesment","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$conn = null;
?>