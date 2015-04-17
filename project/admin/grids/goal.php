<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$status = $_GET['status'];
// Create the jqGrid instance
$grid = new jqGridRender($DB);
// Write the SQL Query
$grid->SelectCommand = 'SELECT id, description, startdate, enddate, status, employeeid  FROM goal where "all" = "'. $status .'" or status = "'. $status .'"';
// Set the table to where we add the data
$grid->table = 'goal';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
// set the ouput format to json
$grid->dataType = 'json';
$grid->datearray = array('startdate', 'enddate');
$grid->setUserDate("Y-m-d"); 
// Let the grid create the model from SQL query
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('../grids/goal.php?status='.$status);
// Change some property of the field(s)
$grid->setColProperty("id", array("editable"=>false, "hidden"=>true, "label"=>"ID"));
$grid->setColProperty("startdate", array("formatter"=>"date", "width"=>80, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"Start Date", 
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
$grid->setColProperty("description", array("editable"=>true, "width"=>400, "edittype"=>"text","editoptions"=>array("size"=>100, "maxlength"=>400), "fixed"=>true, "label"=>"Description"));		
$grid->setColProperty("employeeid", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Assigned To", "edittype"=>"select"));
$grid->setSelect("employeeid", "select '' as id, 'None' as name from dual union select id, name from employee where status = '0Active'");
$grid->setColProperty("status", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", $taskstatus, false, true, true, array(""=>"All"));	
$grid->setColProperty("enddate", array("formatter"=>"date", "width"=>80, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"Due Date", 
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
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>300,
		"caption"=>"Goal Management",		
		"rownumbers"=>true,										
    "rowNum"=>100,
		"shrinkToFit"=>false,
    "sortname"=>"enddate asc, startdate asc, employeeid",
		"sortorder"=>"asc",
		"toppager"=>true,
    "rowList"=>array(100,500,1000),
    "grouping"=>true,
    "groupingView"=>array(
		"groupCollapse"=>true,
    "groupField" => array('employeeid'),
    "groupColumnShow" => array(true),
    "groupOrder" => array('asc'),
    "groupText" =>array('<b>{0}</b>'),
    "groupDataSorted" => true)				
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>true,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>300, "viewCaption"=>"Goal Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>300, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Goal","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>300, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Goal","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$DB = null;
?>
