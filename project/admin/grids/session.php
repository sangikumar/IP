<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");

// Create the jqGrid instance
$grid = new jqGridRender($DB);
// Write the SQL Query
$grid->SelectCommand = 'select sessionid, instructorid, candidateid, title, status, sessiondate, type, candidate2id, candidate3id, candidate4id, candidate5id, subject, performance, feedback, recorded, uploaded, link, videoid, notes from session';
// Set the table to where we add the data
$grid->table = 'session';
$grid->setPrimaryKeyId('sessionid');
$grid->serialKey = false;
// set the ouput format to json
$grid->dataType = 'json';
$grid->datearray = array('sessiondate');
$grid->setUserDate("Y-m-d"); 
// Let the grid create the model from SQL query
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('../grids/session.php');
// Change some property of the field(s)
$grid->setColProperty("sessionid", array("editable"=>false, "hidden"=>true, "label"=>"ID"));
$grid->setColProperty("candidateid", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Candidate Name", "edittype"=>"select"));
$grid->setSelect("candidateid", "select '' as id, ' Group Mock' as name from dual union SELECT distinct candidateid as id, name as name FROM candidate where status not in ('Discontinued' , 'Completed' , 'Defaulted') order by name");
$grid->setColProperty("candidate2id", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Candidate2 Name", "edittype"=>"select"));
$grid->setSelect("candidate2id", "select null as id, '' as name from dual union SELECT distinct candidateid as id, name as name FROM candidate where status not in ('Discontinued' , 'Completed' , 'Defaulted') order by name");
$grid->setColProperty("candidate3id", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Candidate3 Name", "edittype"=>"select"));
$grid->setSelect("candidate3id", "select null as id, '' as name from dual union SELECT distinct candidateid as id, name as name FROM candidate where status not in ('Discontinued' , 'Completed' , 'Defaulted') order by name");
$grid->setColProperty("candidate4id", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Candidate4 Name", "edittype"=>"select"));
$grid->setSelect("candidate4id", "select null as id, '' as name from dual union SELECT distinct candidateid as id, name as name FROM candidate where status not in ('Discontinued' , 'Completed' , 'Defaulted') order by name");
$grid->setColProperty("candidate5id", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Candidate5 Name", "edittype"=>"select"));
$grid->setSelect("candidate5id", "select null as id, '' as name from dual union SELECT distinct candidateid as id, name as name FROM candidate where status not in ('Discontinued' , 'Completed' , 'Defaulted') order by name");
$grid->setColProperty("instructorid", array("editable"=>true, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Instructor Name", "edittype"=>"select"));
$grid->setSelect("instructorid", "select id, name from employee where designationid in (1,2,9,12) order by name");
$grid->setColProperty("title", array("editable"=>true, "frozen"=>true, "width"=>400, "editoptions"=>array("size"=>75, "maxlength"=>300), "fixed"=>true, "editrules"=>array("required"=>false), "label"=>"Title"));
$grid->setColProperty("status", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", $sessionstatus , false, true, true, array(""=>"All"));
$grid->setColProperty("sessiondate", array("formatter"=>"date", "width"=>70, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"Session Date", 
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
$grid->setColProperty("type", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Session Type", "edittype"=>"select"));
$grid->setSelect("type", $sessiontype , false, true, true, array(""=>"All"));					
$grid->setColProperty("subject", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Subject", "edittype"=>"select"));
$grid->setSelect("subject", $sessionsubject , false, true, true, array(""=>"All"));								
$grid->setColProperty("performance", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Performance", "edittype"=>"select"));
$grid->setSelect("performance", $progress , false, true, true, array(""=>"All"));				
$grid->setColProperty("feedback", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Feedback", "edittype"=>"select"));
$grid->setSelect("feedback", $sessionfeedback , false, true, true, array(""=>"All"));				
$grid->setColProperty("recorded", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Recorded", "edittype"=>"select"));
$grid->setSelect("recorded", $yesno , false, true, true, array(""=>"All"));							
$grid->setColProperty("uploaded", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Uploaded", "edittype"=>"select"));
$grid->setSelect("uploaded", $yesno , false, true, true, array(""=>"All"));	
$grid->setColProperty("link", array("editable"=>true, "frozen"=>true, "width"=>400, "editoptions"=>array("size"=>75, "maxlength"=>300), "formatter"=>"link", "fixed"=>true, "editrules"=>array("url"=>true, "required"=>false), "label"=>"Link"));
$grid->setColProperty("videoid", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Video ID"));
$grid->setColProperty("notes", array("editable"=>true, "width"=>70, "fixed"=>true, "edittype"=>"textarea","editoptions"=>array("rows"=>6, "cols"=> 80), "label"=>"Notes"));
						
// Set alternate background using altRows property
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Session Management",		
		"rownumbers"=>true,										
    "rowNum"=>100,
		"shrinkToFit"=>false,
    "sortname"=>"sessiondate",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(100,500,1000,5000),
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Session Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Session","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Session","reloadAfterSubmit"=>false));
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
