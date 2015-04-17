<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$status = $_GET['status'];
$grid = new jqGridRender($DB);
$grid->SelectCommand = 'SELECT id, description, startdate, priority, status, assignedto, assignedto at, manager, manager mgr, shadow, shadow sh, closedate, notes FROM issue where "all" = "'. $status .'" or status = "'. $status .'"';
$grid->table = 'issue';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('startdate', 'closedate');
$grid->setUserDate("Y-m-d"); 
$grid->setColModel();
$grid->setUrl('../grids/issue.php?status='.$status);
$grid->setColProperty("id", array("editable"=>false, "hidden"=>true, "label"=>"ID"));
$grid->setColProperty("startdate", array("formatter"=>"date", "width"=>70, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), 
																	 "editable"=>true, "label"=>"Start Date", 
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
$grid->setColProperty("assignedto", array("editable"=>false, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Assigned To", "edittype"=>"select"));
$grid->setSelect("assignedto", "SELECT distinct id, name FROM employee order by name");
$grid->setColProperty("at", array("editable"=>true, "hidden"=>true, "editrules"=>array("edithidden"=>true, "required"=>false), "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Assigned To", "edittype"=>"select"));
$grid->setSelect("at", "SELECT distinct id, name FROM employee where status = '0Active' order by name");
$grid->setColProperty("manager", array("editable"=>false, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Manager", "edittype"=>"select"));
$grid->setSelect("manager", "SELECT distinct id, name FROM employee order by name");
$grid->setColProperty("mgr", array("editable"=>true, "hidden"=>true, "editrules"=>array("edithidden"=>true, "required"=>false), "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Manager", "edittype"=>"select"));
$grid->setSelect("mgr", "select '' as id, 'None' as name from dual union SELECT distinct id, name FROM employee where status = '0Active' order by name");
$grid->setColProperty("shadow", array("editable"=>false, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Shadow", "edittype"=>"select"));
$grid->setSelect("shadow", "SELECT distinct id, name FROM employee order by name");
$grid->setColProperty("sh", array("editable"=>true, "hidden"=>true, "editrules"=>array("edithidden"=>true, "required"=>false), "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Shadow", "edittype"=>"select"));
$grid->setSelect("sh", "select '' as id, 'None' as name from dual union SELECT distinct id, name FROM employee where status = '0Active' order by name");
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
$grid->setColProperty("notes", array("editable"=>true, "width"=>400, "fixed"=>true, "edittype"=>"textarea","editoptions"=>array("rows"=>6, "cols"=> 80), "label"=>"Notes"));
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>300,
		"caption"=>"Issue Management",		
		"rownumbers"=>true,										
    "rowNum"=>100,
		"shrinkToFit"=>false,
    "sortname"=>"status asc, startdate asc, manager",
		"sortorder"=>"asc",
		"toppager"=>true,
    "rowList"=>array(100,500,1000),
    "grouping"=>true,
    "groupingView"=>array(
		"groupCollapse"=>false,
    "groupField" => array('assignedto'),
    "groupColumnShow" => array(true),
    "groupOrder" => array('asc'),
    "groupText" =>array('<b>{0}</b>'),
    "groupDataSorted" => true)				
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>true,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Issue Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Issue","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Issue","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$DB = null;
?>
