<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");

// Create the jqGrid instance
$grid = new jqGridRender($DB);
// Write the SQL Query
$grid->SelectCommand = 'SELECT id, candidateid, mmid, interviewdate, type, clientname, clientlocation, result, performance, reclink,  questions, questionslink, notes FROM interview';
// Set the table to where we add the data
$grid->table = 'interview';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
// set the ouput format to json
$grid->dataType = 'json';
$grid->datearray = array('interviewdate');
$grid->setUserDate("Y-m-d"); 
// Let the grid create the model from SQL query
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('../grids/interview.php');
// Change some property of the field(s)
$grid->setColProperty("id", array("editable"=>false, "hidden"=>true, "label"=>"ID"));
$grid->setColProperty("candidateid", array("editable"=>false, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Candidate Name", "edittype"=>"select"));
$grid->setSelect("candidateid", "SELECT distinct candidateid as id, name as name FROM candidate order by name");
$grid->setColProperty("mmid", array("editable"=>true, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Manager", "edittype"=>"select"));
$grid->setSelect("mmid", "SELECT distinct id, name FROM employee order by name");
$grid->setColProperty("interviewdate", array("formatter"=>"date", "width"=>80, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"Date", 
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
												 
$grid->setColProperty("type", array("editable"=>false, "width"=>70, "fixed"=>true, "label"=>"Type", "edittype"=>"select"));
$grid->setSelect("type", $interviewtype , false, true, true, array(""=>"All"));
$grid->setColProperty("clientname", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Client Name"));
$grid->setColProperty("clientlocation", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Client Location"));
$grid->setColProperty("result", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Result", "edittype"=>"select"));
$grid->setSelect("result", $interviewresult, false, true, true, array(""=>"All"));
$grid->setColProperty("performance", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Performance", "edittype"=>"select"));
$grid->setSelect("performance", $interviewperf , false, true, true, array(""=>"All"));
$grid->setColProperty("reclink", array("editable"=>true, "frozen"=>true, "width"=>400, "formatter"=>"link", "formatoptions"=>array("target"=>"_blank"), "fixed"=>true, "editrules"=>array("url"=>true, "required"=>false), "label"=>"Recording Link"));
$grid->setColProperty("questionslink", array("editable"=>true, "frozen"=>true, "width"=>400, "formatter"=>"link", "formatoptions"=>array("target"=>"_blank"), "fixed"=>true, "editrules"=>array("url"=>true, "required"=>false), "label"=>"Ques Link"));
$grid->setColProperty("questions", array("editable"=>true, "hidden"=>true, "edittype"=>"textarea","editrules"=>array("edithidden"=>true, "required"=>false), "editoptions"=>array("rows"=>6, "cols"=> 80), "label"=>"Questions"));
$grid->setColProperty("notes", array("editable"=>true, "width"=>70, "fixed"=>true, "edittype"=>"textarea","editrules"=>array("edithidden"=>true, "required"=>false), "editoptions"=>array("rows"=>6, "cols"=> 80), "label"=>"Notes"));

$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"All Interviews",		
		"rownumbers"=>true,										
    "rowNum"=>100,
		"shrinkToFit"=>false,
    "sortname"=>"interviewdate",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100,500),
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>false,"excel"=>false,"add"=>false,"edit"=>false,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"All Interviews"));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$DB = null;
?>