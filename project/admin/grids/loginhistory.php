<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);
$grid->SelectCommand = 'select lh.lastmoddatetime, lh.ipaddress, lh.useragent, b.batchname, c.name from loginhistory lh, authuser au, candidate c, batch b where lh.loginid = au.id and c.portalid = au.id and c.batchname = b.batchname';
$grid->table = 'loginhistory';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('lastmoddatetime');
$grid->setUserDate("Y-m-d"); 
$grid->setColModel();
$grid->setUrl('../grids/loginhistory.php');
$grid->setColProperty("batchname", array("editable"=>false, "frozen"=>true, "width"=>200, "hidden"=>true, "fixed"=>true, "label"=>"batchname"));
$grid->setColProperty("name", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Name", "edittype"=>"select"));
$grid->setSelect("candidateid", "select '' as id, '' as name from dual union SELECT distinct name as id, name as name FROM candidate order by name");
$grid->setColProperty("lastmoddatetime", array("formatter"=>"date", "width"=>100, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>false, "label"=>"Login Date", 
																	 "editoptions"=>array("dataInit"=>
                									 "js:function(elm){setTimeout(function(){
                    							 jQuery(elm).datepicker({dateFormat:'yy-mm-dd'});
                    							 jQuery('.ui-datepicker').css({'font-size':'75%'});
                									 },200);}"),
																	 "searchoptions"=>array("dataInit"=>
                									 "js:function(elm){setTimeout(function(){
                    							 jQuery(elm).datepicker({dateFormat:'yy-mm-dd'});
                    							 jQuery('.ui-datepicker').css({'font-size':'75%'});
                									 },200);}")
																	 ));
$grid->setColProperty("ipaddress", array("editable"=>false, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"IP Address"));
$grid->setColProperty("useragent", array("editable"=>false, "frozen"=>true, "width"=>400, "fixed"=>true, "label"=>"Info"));		
																	 
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Login History",		
		"rownumbers"=>true,										
    "rowNum"=>100000,
    "sortname"=>"name desc, lastmoddatetime",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(100000,500000,1000000),
    "grouping"=>true,
    "groupingView"=>array(
		"groupCollapse"=>true,
    "groupField" => array('name'),
    "groupOrder" => array('asc'),
    "groupText" =>array('<b>{0}</b>'),
    "groupDataSorted" => true)		
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>false,"edit"=>false,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>700, "dataheight"=>500, "viewCaption"=>"Login History"));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$DB = null;
?>
