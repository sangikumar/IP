<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);

$grid->SelectCommand = 'SELECT id, candidateid, agencyid, employeeid, status, startdate, agencystartdate, amountdue, amountclosed, agencyamount, closeddate, reason, comments FROM candidatedefault';
$grid->table = 'candidatedefault';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->setColModel();
$grid->dataType = 'json';
$grid->setUrl('../grids/candidatedefault.php');
$grid->setColProperty("id", array("editable"=>false, "hidden"=>true, "width"=>40, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("candidateid", array("editable"=>true, "editrules"=>array("edithidden"=>true, "required"=>false), "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Candidate Name", "edittype"=>"select"));
$grid->setSelect("candidateid", "SELECT distinct candidateid as id, name as name FROM candidate order by name");
$grid->setColProperty("agencyid", array("editable"=>true, "editrules"=>array("edithidden"=>true, "required"=>false), "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Agency", "edittype"=>"select"));
$grid->setSelect("agencyid", "select 0 as id, '' as name from dual union SELECT distinct id as id, companyname as name FROM collection_agency order by name");
$grid->setColProperty("employeeid", array("editable"=>true, "editrules"=>array("edithidden"=>true, "required"=>false), "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Employee", "edittype"=>"select"));
$grid->setSelect("employeeid", "select 0 as id, '' as name from dual union SELECT distinct id, name FROM employee order by name");
$grid->setColProperty("status", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", array("Current"=>"Current", "Closed"=>"Closed", "Rejected"=>"Rejected"), false, true, true, array(""=>"All"));	
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
$grid->setColProperty("agencystartdate", array("formatter"=>"date", "width"=>90, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), 
																	 "editable"=>true, "label"=>"Agency Start Date", 
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
$grid->setColProperty("amountdue", array("editable"=>true, "width"=>90, 
											"formatter"=>"currency", "formatoptions"=>array("decimalPlaces"=>2,"thousandsSeparator"=>",","prefix"=>"$"), 
											"sorttype"=>"currency", "fixed"=>true, "label"=>"Amount Due"));
$grid->setColProperty("amountclosed", array("editable"=>true, "width"=>90, 
											"formatter"=>"currency", "formatoptions"=>array("decimalPlaces"=>2,"thousandsSeparator"=>",","prefix"=>"$"), 
											"sorttype"=>"currency", "fixed"=>true, "label"=>"Amount Closed"));
$grid->setColProperty("agencyamount", array("editable"=>true, "width"=>90, 
											"formatter"=>"currency", "formatoptions"=>array("decimalPlaces"=>2,"thousandsSeparator"=>",","prefix"=>"$"), 
											"sorttype"=>"currency", "fixed"=>true, "label"=>"Agency Amount"));											
$grid->setColProperty("closeddate", array("formatter"=>"date", "width"=>70, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), 
																	 "editable"=>true, "label"=>"Closed Date", 
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

$grid->setColProperty("reason", array("editable"=>true, "width"=>400, "fixed"=>true, "edittype"=>"textarea", "editoptions"=>array("rows"=>6, "cols"=> 60), "label"=>"Reason"));
$grid->setColProperty("comments", array("editable"=>true, "width"=>400, "fixed"=>true, "edittype"=>"textarea", "editoptions"=>array("rows"=>6, "cols"=> 60), "label"=>"Comments"));
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>500,
		"caption"=>"Default Management",		
		"rownumbers"=>true,										
    "rowNum"=>500,
    "sortname"=>"candidateid",
		"sortorder"=>"asc",
		"toppager"=>true,
    "rowList"=>array(500,1000,5000,10000),
    ));		
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Default Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Default Case","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Default Case","reloadAfterSubmit"=>false));
//$grid->toolbarfilter = true;
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true,null, null, true,true);
$DB = null;
?>
