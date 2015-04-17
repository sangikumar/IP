<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);
$grid->SelectCommand = 'SELECT id, type, amount, employertaxes, check_number, paiddate, periodbegindate, periodenddate, paystuburl, notes, poid from payment';
$grid->table = 'payment';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('paiddate','periodbegindate','periodenddate');
$grid->setUserDate("Y-m-d"); 
$grid->setColModel();
$grid->setUrl('../grids/payment.php');
$grid->setColProperty("id", array("editable"=>false, "width"=>50 , "fixed"=>true, "hidden"=>false, "label"=>"PID"));
$grid->setColProperty("type", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Type", "edittype"=>"select"));
$grid->setSelect("type", $paymenttype, false, true, true, array(""=>"All"));
$grid->setColProperty("amount", array("editable"=>true, "width"=>100, "fixed"=>true, "summaryType"=>"sum", summaryTpl=>"Paid: {0}", "formatter"=>"currency", "formatoptions"=>array("decimalPlaces"=>2,"thousandsSeparator"=>",","prefix"=>"$"),"sorttype"=>"currency", "label"=>"Amount"));
$summaryrows = array("amount"=>array("amount"=>"SUM"));		
$grid->setColProperty("employertaxes", array("editable"=>true, "width"=>80, "fixed"=>true, "formatter"=>"currency", "formatoptions"=>array("decimalPlaces"=>2,"thousandsSeparator"=>",","prefix"=>"$"),"sorttype"=>"currency", "label"=>"Emp. Taxes"));
$grid->setColProperty("check_number", array("editable"=>true, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Check No."));
$grid->setColProperty("paiddate", array("formatter"=>"date", "width"=>120, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"Paid Date", 
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
$grid->setColProperty("poid", array("editable"=>true, "frozen"=>true, "hidden"=>false, "width"=>250, "fixed"=>true, "label"=>"POID", "edittype"=>"select"));
$grid->setSelect("poid", "select 0 as id, 'None' as name from dual union select o.id, concat(c.name, '-', v.companyname, '-', cl.companyname) as name from candidate c, placement p, po o, vendor v, client cl where c.candidateid = p.candidateid and o.placementid = p.id and p.vendorid = v.id and p.clientid = cl.id");
$grid->setColProperty("periodbegindate", array("formatter"=>"date", "width"=>120, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"Begin Date", 
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
$grid->setColProperty("periodenddate", array("formatter"=>"date", "width"=>120, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"End Date", 
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
$grid->setColProperty("paystuburl", array("editable"=>true, "frozen"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "formatter"=>"link", "formatoptions"=>array("target"=>"_blank"), "fixed"=>true, "editrules"=>array("url"=>true, "required"=>false), "label"=>"Paystub Url"));																	 
$grid->setColProperty("notes", array("editable"=>true, "width"=>400, "fixed"=>true, "hidden"=>true, "edittype"=>"textarea","editrules"=>array("edithidden"=>true, "required"=>false), "editoptions"=>array("rows"=>6, "cols"=>60), "label"=>"Notes"));
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Payment Management",		
		"rownumbers"=>true,										
    "rowNum"=>500,
    "footerrow"=>true,
    "userDataOnFooter"=>true,
		"shrinkToFit"=>false,		
    "sortname"=>"paiddate",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(10,100,500,1000,2000),
    "grouping"=>true,
    "groupingView"=>array(
		"groupCollapse"=>true,
    "groupField" => array('poid'),
    "groupColumnShow" => array(true),
    "groupOrder" => array('desc'),
		"groupSummary" => array(true),
    "groupText" =>array('<b>{0}</b>'),
    "groupDataSorted" => true)		
		));		
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>700, "dataheight"=>350, "viewCaption"=>"Payment Management"));
$grid->setNavOptions('add',array("width"=>700, "dataheight"=>350, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Payment","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>700, "dataheight"=>350, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Payment","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, $summaryrows, null, true,true);
$DB = null;
?>
