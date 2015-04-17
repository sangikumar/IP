<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);
$grid->SelectCommand = 'SELECT i.id, i.poid, i.invoicenumber, i.startdate, i.enddate, i.invoicedate, DATE_FORMAT(invoicedate, "%Y-%c-%M") as invmonth, i.quantity, i.otquantity, p.rate, p.overtimerate, i.`status`, i.emppaiddate, i.candpaymentstatus, i.reminders, ((i.quantity * p.rate) + (i.otquantity * p.overtimerate)) as amountexpected, DATE_ADD(i.invoicedate, INTERVAL p.invoicenet DAY)as expecteddate, i.amountreceived, i.receiveddate, i.releaseddate, i.checknumber, i.invoiceurl, i.checkurl, p.freqtype, p.invoicenet, v.companyname, v.fax vendorfax, v.phone vendorphone, v.email vendoremail, v.timsheetemail, v.hrname, v.hremail, v.hrphone, v.managername, v.manageremail, v.managerphone, v.secondaryname, v.secondaryemail, v.secondaryphone, c.name candidatename, c.phone candidatephone, c.email candidateemail, pl.wrkemail, pl.wrkphone, r.name recruitername, r.phone recruiterphone, r.email recruiteremail, i.notes from invoice i, po p, placement pl, candidate c, vendor v, recruiter r where i.poid = p.id and p.placementid = pl.id and pl.candidateid = c.candidateid and pl.vendorid = v.id and pl.recruiterid = r.id and i.status <> "Delete"';
$grid->table = 'invoice';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
//$grid->debug = true;
$grid->datearray = array('startdate','enddate','invoicedate','expecteddate','receiveddate','releaseddate');
$grid->setUserDate("Y-m-d"); 
$grid->setColModel();
$grid->setUrl('../grids/invoicebymonth.php');
$grid->setColProperty("id", array("editable"=>false, "width"=>50 , "fixed"=>true, "hidden"=>false, "label"=>"PKID"));
$grid->setColProperty("poid", array("editable"=>true, "frozen"=>true, "hidden"=>false, "width"=>200, "fixed"=>true, "label"=>"POID", "edittype"=>"select"));
$grid->setSelect("poid", "select null as id, '' as pname from dual union select o.id, concat(c.name, '-', v.companyname, '-', cl.companyname, '-', o.id) as pname from candidate c, placement p, po o, vendor v, client cl where c.candidateid = p.candidateid and o.placementid = p.id and p.vendorid = v.id and p.clientid = cl.id order by pname");
$grid->setColProperty("invoicenumber", array("editable"=>true, "frozen"=>true, "width"=>60, "fixed"=>true, "label"=>"Invoice No."));
$grid->setColProperty("startdate", array("formatter"=>"date", "width"=>100, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"Start Date", 
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
$grid->setColProperty("enddate", array("formatter"=>"date", "width"=>100, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"End Date", 
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
$grid->setColProperty("invoicedate", array("formatter"=>"date", "width"=>100, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"Invoice Date", 
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
$grid->setColProperty("invmonth", array("editable"=>false, "width"=>70, "fixed"=>true, "hidden"=>false, "label"=>"Inv. Month"));														 															 
$grid->setColProperty("quantity", array("editable"=>true, "summaryType"=>"sum", summaryTpl=>"Q: {0}", "width"=>60, "fixed"=>true, "formatter"=>"integer", "editrules"=>array("minValue"=>0, "maxValue"=>1000), "label"=>"Quantity"));
$grid->setColProperty("otquantity", array("editable"=>true, "summaryType"=>"sum", summaryTpl=>"Q: {0}", "width"=>80, "fixed"=>true, "formatter"=>"integer", "editrules"=>array("minValue"=>0, "maxValue"=>1000), "label"=>"OT Quantity"));
$grid->setColProperty("status", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", $invoicestatus , false, true, true, array(""=>"All"));
$grid->setColProperty("reminders", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Reminders", "edittype"=>"select"));
$grid->setSelect("reminders", array("Y"=>"Y", "N"=>"N"), false, true, true, array(""=>"All"));
$grid->setColProperty("amountexpected", array("editable"=>false, "summaryType"=>"sum", summaryTpl=>"E: {0}", "width"=>150, "fixed"=>true, "formatter"=>"currency", "formatoptions"=>array("decimalPlaces"=>2,"thousandsSeparator"=>",","prefix"=>"$"), "label"=>"Expected"));
$grid->setColProperty("expecteddate", array("editable"=>false, "width"=>120, "fixed"=>true, "hidden"=>false, "label"=>"Expected Date"));
$grid->setColProperty("amountreceived", array("editable"=>true, "summaryType"=>"sum", summaryTpl=>"R: {0}", "width"=>150, "fixed"=>true, "formatter"=>"currency", "formatoptions"=>array("decimalPlaces"=>2,"thousandsSeparator"=>",","prefix"=>"$"), "label"=>"Received"));
$summaryrows = array("quantity"=>array("quantity"=>"SUM"), "amountreceived"=>array("amountreceived"=>"SUM"), "amountexpected"=>array("quantity * rate"=>"SUM"));		
$grid->setColProperty("releaseddate", array("formatter"=>"date", "width"=>120, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"Released Date", 
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
$grid->setColProperty("receiveddate", array("formatter"=>"date", "width"=>120, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"Received Date", 
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
$grid->setColProperty("checknumber", array("editable"=>true, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Check No."));
$grid->setColProperty("invoiceurl", array("editable"=>true, "frozen"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "formatter"=>"link", "formatoptions"=>array("target"=>"_blank"), "fixed"=>true, "editrules"=>array("url"=>true, "required"=>false), "label"=>"Invoice Url"));
$grid->setColProperty("checkurl", array("editable"=>true, "frozen"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "formatter"=>"link", "formatoptions"=>array("target"=>"_blank"), "fixed"=>true, "editrules"=>array("url"=>true, "required"=>false), "label"=>"Check Url"));
$grid->setColProperty("emppaiddate", array("formatter"=>"date", "width"=>150, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"Candidate Payed Date", 
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
$grid->setColProperty("candpaymentstatus", array("editable"=>true, "width"=>150, "fixed"=>true, "label"=>"Cand. Payment Status", "edittype"=>"select"));
$grid->setSelect("candpaymentstatus", array("Open"=>"Open", "Pending"=>"Pending", "Suspended"=>"Suspended", "Closed"=>"Closed"), false, true, true, array(""=>"All"));
$grid->setColProperty("rate", array("editable"=>false, "frozen"=>true, "width"=>70, "fixed"=>true, "label"=>"Rate"));
$grid->setColProperty("overtimerate", array("editable"=>false, "frozen"=>true, "width"=>80, "fixed"=>true, "label"=>"OT Rate"));
$grid->setColProperty("freqtype", array("editable"=>false, "frozen"=>true, "width"=>40, "fixed"=>true, "label"=>"Freq"));
$grid->setColProperty("invoicenet", array("editable"=>false, "frozen"=>true, "width"=>40, "fixed"=>true, "label"=>"Net"));
$grid->setColProperty("companyname", array("editable"=>false, "frozen"=>true, "width"=>150, "fixed"=>true, "label"=>"Company Name"));
$grid->setColProperty("vendorfax", array("editable"=>false, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Vendor Fax"));
$grid->setColProperty("vendorphone", array("editable"=>false, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Vendor Phone"));
$grid->setColProperty("vendoremail", array("editable"=>false, "frozen"=>true, "width"=>150, "fixed"=>true, "label"=>"Vendor Email"));
$grid->setColProperty("timsheetemail", array("editable"=>false, "frozen"=>true, "width"=>150, "fixed"=>true, "label"=>"Timesheet Email"));
$grid->setColProperty("hrname", array("editable"=>false, "frozen"=>true, "width"=>150, "fixed"=>true, "label"=>"HR Name"));
$grid->setColProperty("hremail", array("editable"=>false, "frozen"=>true, "width"=>150, "fixed"=>true, "label"=>"HR Email"));
$grid->setColProperty("hrphone", array("editable"=>false, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"HR Phone"));
$grid->setColProperty("managername", array("editable"=>false, "frozen"=>true, "width"=>150, "fixed"=>true, "label"=>"Mgr Name"));
$grid->setColProperty("manageremail", array("editable"=>false, "frozen"=>true, "width"=>150, "fixed"=>true, "label"=>"Mgr Email"));
$grid->setColProperty("managerphone", array("editable"=>false, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Mgr Phone"));
$grid->setColProperty("secondaryname", array("editable"=>false, "frozen"=>true, "width"=>150, "fixed"=>true, "label"=>"Sec Name"));
$grid->setColProperty("secondaryemail", array("editable"=>false, "frozen"=>true, "width"=>150, "fixed"=>true, "label"=>"Sec Email"));
$grid->setColProperty("secondaryphone", array("editable"=>false, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Sec Phone"));
$grid->setColProperty("candidatename", array("editable"=>false, "frozen"=>true, "width"=>150, "fixed"=>true, "label"=>"Cand Name"));
$grid->setColProperty("candidatephone", array("editable"=>false, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Cand Phone"));
$grid->setColProperty("candidateemail", array("editable"=>false, "frozen"=>true, "width"=>150, "fixed"=>true, "label"=>"Cand Email"));
$grid->setColProperty("wrkemail", array("editable"=>false, "frozen"=>true, "width"=>150, "fixed"=>true, "label"=>"Wrk Email"));
$grid->setColProperty("wrkphone", array("editable"=>false, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Wrk Phone"));
$grid->setColProperty("recruitername", array("editable"=>false, "frozen"=>true, "width"=>150, "fixed"=>true, "label"=>"Recruiter Name"));
$grid->setColProperty("recruiterphone", array("editable"=>false, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Recruiter Ph"));
$grid->setColProperty("recruiteremail", array("editable"=>false, "frozen"=>true, "width"=>150, "fixed"=>true, "label"=>"Recruiter Email"));
$grid->setColProperty("notes", array("editable"=>true, "width"=>400, "fixed"=>true, "hidden"=>true, "edittype"=>"textarea","editrules"=>array("edithidden"=>true, "required"=>false), "editoptions"=>array("rows"=>6, "cols"=>60), "label"=>"Notes"));
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Invoice Management",		
		"rownumbers"=>true,										
    "rowNum"=>1000,
    "footerrow"=>true,
    "userDataOnFooter"=>true,
		"shrinkToFit"=>false,		
    "sortname"=>"invoicedate",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(1000,2000,5000,10000),
    "grouping"=>true,
    "groupingView"=>array(
		"groupCollapse"=>true,
    "groupField" => array('invmonth'),
    "groupColumnShow" => array(false),
    "groupOrder" => array('desc'),
		"groupSummary" => array(true),
    "groupText" =>array('<b>{0}</b>'),
    "groupDataSorted" => false)		
		));		
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>700, "dataheight"=>500, "viewCaption"=>"Invoice Management"));
$grid->setNavOptions('add',array("width"=>700, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Invoice","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>700, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Invoice","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, $summaryrows, null, true,true);
$DB = null;
?>
