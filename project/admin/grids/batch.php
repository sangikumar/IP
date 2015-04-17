<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");

// Create the jqGrid instance
$grid = new jqGridRender($DB);
// Write the SQL Query
$grid->SelectCommand = 'SELECT batchname,current,orientationdate,subject,startdate,enddate,exams,instructor1,instructor2,instructor3,topicscovered,topicsnotcovered FROM batch';
// Set the table to where we add the data
$grid->table = 'batch';
$grid->setPrimaryKeyId('batchname');
$grid->serialKey = false;
// set the ouput format to json
$grid->dataType = 'json';
$grid->datearray = array('orientationdate','startdate','enddate');
$grid->setUserDate("Y-m-d"); 
// Let the grid create the model from SQL query
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('../grids/batch.php');
// Change some property of the field(s)
$grid->setColProperty("batchname", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Name"));
//$grid->setSelect("batchname", $batches , false, true, true, array(""=>"All"));

$grid->setColProperty("current", array("editable"=>true, "label"=>"Current", "width"=>50, "fixed"=>true, "edittype"=>"select"));
$grid->setSelect("current", $yesno , false, true, true, array(""=>"All"));

$grid->setColProperty("orientationdate", array("formatter"=>"date", "width"=>70, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"Orientation Date", 
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

$grid->setColProperty("subject", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Subject", "edittype"=>"select"));
$grid->setSelect("subject", $courses , false, true, true, array(""=>"All"));

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
$grid->setColProperty("enddate", array("formatter"=>"date", "width"=>70, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"End Date", 
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
$grid->setColProperty("exams", array("editable"=>true, "width"=>70, "fixed"=>true, "editrules"=>array("minValue"=>0, "maxValue"=>10), "label"=>"Exams", "edittype"=>"select"));
$grid->setSelect("exams", $count , false, true, true, array(""=>"All"));

$grid->setColProperty("instructor1", array("editable"=>true, "hidden"=>false, "editrules"=>array("edithidden"=>true, "required"=>false), "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Instructor1", "edittype"=>"select"));
$grid->setSelect("instructor1", "select 0 as id, '' as name from dual union SELECT distinct id, name FROM employee order by name");

$grid->setColProperty("instructor2", array("editable"=>true, "hidden"=>false, "editrules"=>array("edithidden"=>true, "required"=>false), "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Instructor2", "edittype"=>"select"));
$grid->setSelect("instructor2", "select 0 as id, '' as name from dual union SELECT distinct id, name FROM employee order by name");

$grid->setColProperty("instructor3", array("editable"=>true, "hidden"=>false, "editrules"=>array("edithidden"=>true, "required"=>false), "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Instructor3", "edittype"=>"select"));
$grid->setSelect("instructor3", "select 0 as id, '' as name from dual union SELECT distinct id, name FROM employee order by name");

$grid->setColProperty("topicscovered", array("editable"=>true, "width"=>70, "fixed"=>true, "edittype"=>"textarea","editoptions"=>array("rows"=>3, "cols"=> 50), "label"=>"Topics Covered"));

$grid->setColProperty("topicsnotcovered", array("editable"=>true, "width"=>70, "fixed"=>true, "edittype"=>"textarea","editoptions"=>array("rows"=>3, "cols"=> 50), "label"=>"Topics not Covered"));
						
// Set alternate background using altRows property
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Batch Management",		
		"rownumbers"=>true,										
    "rowNum"=>30,
    "sortname"=>"startdate",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100),
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Batch Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Batch","bSubmit"=>"Add Batch", "reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Batch","bSubmit"=>"Update Batch", "reloadAfterSubmit"=>false));
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
