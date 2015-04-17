<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);
$grid->SelectCommand = 'SELECT id, candidateid, loandate, amount, type, status, description, notes FROM loan';
$grid->table = 'loan';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('loandate');
$grid->setUserDate("Y-m-d");
$grid->setColModel();
$grid->setUrl('../grids/loan.php');
$grid->setColProperty("id", array("editable"=>false, "width"=>25, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("candidateid", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Candidate", "edittype"=>"select"));
$grid->setSelect("candidateid", "select '' as id, '' as name from dual union SELECT distinct candidateid as id, name as name FROM candidate order by name");
$grid->setColProperty("loandate", array("formatter"=>"date", "width"=>80, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"Loan Date", 
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
$grid->setColProperty("amount", array("editable"=>true, "width"=>90, "formatter"=>"currency", "formatoptions"=>array("decimalPlaces"=>2,"thousandsSeparator"=>",","prefix"=>"$"), "sorttype"=>"currency", "fixed"=>true, "label"=>"Amount"));
$grid->setColProperty("status", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", $loanstatus, false, true, true, array(""=>"All"));			
$grid->setColProperty("type", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Type", "edittype"=>"select"));
$grid->setSelect("type", $loantype, false, true, true, array(""=>"All"));					
$grid->setColProperty("description", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Description"));
$grid->setColProperty("notes", array("editable"=>true, "width"=>400, "fixed"=>true, "edittype"=>"textarea", "editoptions"=>array("rows"=>6, "cols"=> 60), "label"=>"Notes"));
$summaryrows = array("amount"=>array("amount"=>"SUM"));	
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Loan Management",		
		"rownumbers"=>true,										
    "rowNum"=>100,
    "footerrow"=>true,
    "userDataOnFooter"=>true,
		"shrinkToFit"=>false,		
    "sortname"=>"status asc, type",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100,500),
    "grouping"=>true,
    "groupingView"=>array(
		"groupCollapse"=>true,
    "groupField" => array('candidateid'),
    "groupColumnShow" => array(true),
    "groupOrder" => array('desc'),
    "groupText" =>array('<b>{0}</b>'),
    "groupDataSorted" => true)		
    ));			
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>300, "viewCaption"=>"Loan Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>300, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Loan","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>300, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Loan","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true,$summaryrows, null, true,true);
$DB = null;
?>
