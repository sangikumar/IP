<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$userid = $_GET['userid'];
$grid = new jqGridRender($DB);

$grid->SelectCommand = 'SELECT p.id, employeeid, ptodate, offhours, extrahours, ptohours, p.type, approvedby, EXTRACT(YEAR_MONTH FROM ptodate) as yearmonth FROM pto p, employee e where p.employeeid = e.id and e.loginid = "'. $userid .'"';
$grid->table = 'pto';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('ptodate');
$grid->setUserDate("Y-m-d"); 
$grid->setColModel();
$grid->setUrl('../grids/rpto.php?userid='.$userid);
$grid->setColProperty("id", array("editable"=>false, "width"=>25, "hidden"=>true, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("employeeid", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Employee", "edittype"=>"select"));
$grid->setSelect("employeeid", "select '' as id, '' as name from dual union SELECT distinct id, name FROM employee order by name");
$grid->setColProperty("ptodate", array("formatter"=>"date", "width"=>80, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"Date", 
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
$grid->setColProperty("offhours", array("editable"=>true, "width"=>70, "fixed"=>true, "editrules"=>array("minValue"=>0, "maxValue"=>8), "label"=>"Hours Off"));
$grid->setColProperty("extrahours", array("editable"=>true, "width"=>70, "fixed"=>true, "editrules"=>array("minValue"=>0, "maxValue"=>8), "label"=>"Extra Hours"));	
$grid->setColProperty("ptohours", array("editable"=>true, "width"=>70, "fixed"=>true, "editrules"=>array("minValue"=>0, "maxValue"=>8), "label"=>"Paid Hours"));
$grid->setColProperty("type", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Type", "edittype"=>"select"));
$grid->setSelect("type", $ptotype, false, true, true, array(""=>"All"));			
$grid->setColProperty("approvedby", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Approved By", "edittype"=>"select"));
$grid->setSelect("approvedby", "select '' as id, '' as name from dual union SELECT distinct id, name FROM employee order by name");
$grid->setColProperty("notes", array("editable"=>true, "width"=>400, "fixed"=>true, "edittype"=>"textarea", "editoptions"=>array("rows"=>6, "cols"=> 60), "label"=>"Notes"));
$grid->setColProperty("yearmonth", array("editable"=>false, "width"=>90, "fixed"=>true, "label"=>"Year Month"));
$grid->setGridOptions(array(
"sortable"=>true,
"width"=>1024,
"height"=>250,
"caption"=>"PTO List",		
"rownumbers"=>true,										
"rowNum"=>100,
"sortname"=>"ptodate",
"sortorder"=>"desc",
//"altRows"=>true,
"toppager"=>true,
"rowList"=>array(10,20,30,50,100),
"grouping"=>true,
"groupingView"=>array(
"groupField" => array('yearmonth'),
"groupColumnShow" => array(true),
"groupOrder" => array('desc'),
"groupText" =>array('<b>{0}</b>'),
"groupDataSorted" => true)
));		
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>false,"excel"=>false,"add"=>false,"edit"=>false,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>300, "viewCaption"=>"PTO Management"));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$DB = null;
?>
