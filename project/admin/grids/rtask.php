<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$username = $_GET['username'];
$status = $_GET['status'];
$employeeid = $_GET['employeeid'];
// Create the jqGrid instance
$grid = new jqGridRender($DB);

$grid->SelectCommand = 'SELECT id, description, startdate, priority,  employee, manager, shadow, shadow2, shadow3, duedate, status, pctcomplete, closedate, notes FROM task where ("all" = "'. $status .'" or status = "'. $status .'") and (employee = "'. $employeeid .'" or manager = "'. $employeeid .'" or shadow2 = "'. $employeeid .'" or shadow3 = "'. $employeeid .'" or shadow = "'. $employeeid .'")';
$grid->table = 'task';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('startdate', 'duedate', 'closedate');
$grid->setUserDate("Y-m-d"); 
$grid->setColModel();
$grid->setUrl('../grids/rtask.php?username='.$username.'&status='.$status.'&employeeid='.$employeeid);
$grid->setColProperty("id", array("editable"=>false, "hidden"=>true, "label"=>"ID"));
$grid->setColProperty("startdate", array("formatter"=>"date", "width"=>70, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"Start Date", 
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
$grid->setColProperty("description", array("editable"=>true, "width"=>300, "edittype"=>"text","editoptions"=>array("size"=>100, "maxlength"=>400), "fixed"=>true, "label"=>"Description"));		
$grid->setColProperty("priority", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Priority", "edittype"=>"select"));
$grid->setSelect("priority", $taskpriority, false, true, true, array(""=>"All"));						
$grid->setColProperty("status", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", $taskstatus, false, true, true, array(""=>"All"));	
$grid->setColProperty("employee", array("editable"=>true, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Assigned To", "edittype"=>"select"));
$grid->setSelect("employee", "SELECT distinct id, name FROM employee where status = '0Active' order by name");
$grid->setColProperty("manager", array("editable"=>true, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Manager", "edittype"=>"select"));
$grid->setSelect("manager", "SELECT distinct id, name FROM employee where status = '0Active' order by name");
$grid->setColProperty("shadow", array("editable"=>true, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Shadow", "edittype"=>"select"));
$grid->setSelect("shadow", "SELECT distinct id, name FROM employee where status = '0Active' order by name");
$grid->setColProperty("shadow2", array("editable"=>true, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Shadow 2", "edittype"=>"select"));
$grid->setSelect("shadow2", "SELECT distinct id, name FROM employee where status = '0Active' order by name");
$grid->setColProperty("shadow3", array("editable"=>true, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Shadow 3", "edittype"=>"select"));
$grid->setSelect("shadow3", "SELECT distinct id, name FROM employee where status = '0Active' order by name");
$grid->setColProperty("duedate", array("formatter"=>"date", "width"=>70, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"Due Date", 
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
$grid->setColProperty("closedate", array("formatter"=>"date", "width"=>70, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"Close Date", 
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
$grid->setColProperty("pctcomplete", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"% Complete", "edittype"=>"select"));
$grid->setSelect("pctcomplete", $taskpct, false, true, true, array(""=>"All"));																	 															 
$grid->setColProperty("notes", array("editable"=>true, "width"=>400, "fixed"=>true, "edittype"=>"textarea","editoptions"=>array("rows"=>6, "cols"=> 80), "label"=>"Notes"));
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Task Management",		
		"rownumbers"=>true,										
    "rowNum"=>30,
		"shrinkToFit"=>false,
    "sortname"=>"duedate desc, status",
		"sortorder"=>"asc",
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100),
    "grouping"=>true,
    "groupingView"=>array(
		"groupCollapse"=>true,
    "groupField" => array('employee'),
    "groupColumnShow" => array(true),
    "groupOrder" => array('asc'),
    "groupText" =>array('<b>{0}</b>'),
    "groupDataSorted" => true)					
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Task Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Task","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Task","reloadAfterSubmit"=>false));
//$grid->toolbarfilter = true;
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$DB = null;
?>
