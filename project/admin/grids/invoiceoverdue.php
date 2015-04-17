<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);
$grid->SelectCommand = 'select i.id, i.poid, i.invoicenumber, i.invoicedate, i.quantity, p.rate, DATE_ADD(i.invoicedate, INTERVAL p.invoicenet DAY)as expecteddate, ((i.quantity * p.rate) + (i.otquantity * p.overtimerate)) as amountexpected, i.startdate, i.enddate, i.status, i.remindertype, i.amountreceived, i.receiveddate, i.releaseddate, i.checknumber, i.invoiceurl, i.checkurl, v.companyname, v.fax vendorfax, v.phone vendorphone, v.email vendoremail, v.timsheetemail, v.hrname, v.hremail, v.hrphone, v.managername, v.manageremail, v.managerphone, v.secondaryname, v.secondaryemail, v.secondaryphone, c.name candidatename, c.phone candidatephone, c.email candidateemail, pl.wrkemail, pl.wrkphone, r.name recruitername, r.phone recruiterphone, r.email recruiteremail, i.notes from invoice i, po p, placement pl, candidate c, vendor v, recruiter r  where i.poid = p.id and i.status not in ("Void", "Closed") and DATE_ADD(i.invoicedate, INTERVAL p.invoicenet DAY) <= CURDATE() and p.placementid = pl.id and pl.candidateid = c.candidateid and pl.vendorid = v.id and pl.recruiterid = r.id';
$grid->table = 'invoice';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('expecteddate');
$grid->setUserDate("Y-m-d"); 
$grid->setColModel();
$grid->setUrl('../grids/invoiceoverdue.php');
$grid->setColProperty("id", array("editable"=>false, "width"=>50 , "fixed"=>true, "hidden"=>false, "label"=>"PKID"));
$grid->setColProperty("poid", array("editable"=>false, "frozen"=>true, "hidden"=>false, "width"=>400, "fixed"=>true, "label"=>"POID", "edittype"=>"select"));
$grid->setSelect("poid", "select o.id, concat(c.name, '-', v.companyname, '-', cl.companyname) as name from candidate c, placement p, po o, vendor v, client cl where c.candidateid = p.candidateid and o.placementid = p.id and p.vendorid = v.id and p.clientid = cl.id");
$grid->setColProperty("invoicenumber", array("editable"=>false, "frozen"=>true, "width"=>50, "fixed"=>true, "label"=>"No."));
$grid->setColProperty("invoicedate", array("editable"=>false, "formatter"=>"date", "width"=>100, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>false, "label"=>"Invoiced Date", 
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
$grid->setColProperty("quantity", array("editable"=>false, "frozen"=>true, "width"=>50, "fixed"=>true, "label"=>"Quantity"));
$grid->setColProperty("rate", array("editable"=>false, "frozen"=>true, "width"=>50, "fixed"=>true, "label"=>"Rate"));																	 
$grid->setColProperty("expecteddate", array("editable"=>false, "formatter"=>"date", "width"=>100, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>false, "label"=>"Expected Date", 
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
$grid->setColProperty("amountexpected", array("editable"=>false, "summaryType"=>"sum", summaryTpl=>"Sum: {0}", "width"=>100, "fixed"=>true, "label"=>"Expected"));
$summaryrows = array("amountexpected"=>array("quantity * rate"=>"SUM"));			
$grid->setColProperty("startdate", array("editable"=>false, "frozen"=>true, "label"=>"startdate"));
$grid->setColProperty("enddate", array("editable"=>false, "frozen"=>true, "label"=>"enddate"));
$grid->setColProperty("companyname", array("editable"=>false, "frozen"=>true, "label"=>"companyname"));
$grid->setColProperty("vendorfax", array("editable"=>false, "frozen"=>true, "label"=>"vendorfax"));
$grid->setColProperty("vendorphone", array("editable"=>false, "frozen"=>true, "label"=>"vendorphone"));
$grid->setColProperty("vendoremail", array("editable"=>false, "frozen"=>true, "label"=>"vendoremail"));
$grid->setColProperty("timsheetemail", array("editable"=>false, "frozen"=>true, "label"=>"timsheetemail"));
$grid->setColProperty("hrname", array("editable"=>false, "frozen"=>true, "label"=>"hrname"));
$grid->setColProperty("hremail", array("editable"=>false, "frozen"=>true, "label"=>"hremail"));
$grid->setColProperty("hrphone", array("editable"=>false, "frozen"=>true, "label"=>"hrphone"));
$grid->setColProperty("managername", array("editable"=>false, "frozen"=>true, "label"=>"managername"));
$grid->setColProperty("candidatename", array("editable"=>false, "frozen"=>true, "label"=>"candidatename"));
$grid->setColProperty("candidatephone", array("editable"=>false, "frozen"=>true, "label"=>"candidatephone"));
$grid->setColProperty("candidateemail", array("editable"=>false, "frozen"=>true, "label"=>"candidateemail"));
$grid->setColProperty("wrkemail", array("editable"=>false, "frozen"=>true, "label"=>"wrkemail"));
$grid->setColProperty("wrkphone", array("editable"=>false, "frozen"=>true, "label"=>"wrkphone"));
$grid->setColProperty("recruitername", array("editable"=>false, "frozen"=>true, "label"=>"recruitername"));
$grid->setColProperty("recruiterphone", array("editable"=>false, "frozen"=>true, "label"=>"recruiterphone"));
$grid->setColProperty("recruiteremail", array("editable"=>false, "frozen"=>true, "label"=>"recruiteremail"));
$grid->setColProperty("manageremail", array("editable"=>false, "frozen"=>true, "label"=>"manageremail"));
$grid->setColProperty("managerphone", array("editable"=>false, "frozen"=>true, "label"=>"managerphone"));
$grid->setColProperty("secondaryname", array("editable"=>false, "frozen"=>true, "label"=>"secondaryname"));
$grid->setColProperty("secondaryemail", array("editable"=>false, "frozen"=>true, "label"=>"secondaryemail"));
$grid->setColProperty("secondaryphone", array("editable"=>false, "frozen"=>true, "label"=>"secondaryphone"));
$grid->setColProperty("status", array("editable"=>true, "width"=>70, "hidden"=>true, "editrules"=>array("edithidden"=>true, "required"=>false),"fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", $invoicestatus , false, true, true, array(""=>"All"));
$grid->setColProperty("remindertype", array("editable"=>true, "width"=>200, "hidden"=>true, "editrules"=>array("edithidden"=>true, "required"=>false), "fixed"=>true, "label"=>"Reminder Type", "edittype"=>"select"));
$grid->setSelect("remindertype", array("Open"=>"Open", "Warning"=>"Warning", "Warn-Candidate"=>"Warn-Candidate", "Warn-Client"=>"Warn-Client", "Warn-CollectionAgency"=>"Warn-CollectionAgency", "Final-Warning"=>"Final-Warning"), false, true, true, array(""=>"All"));
$grid->setColProperty("amountreceived", array("editable"=>true,  "width"=>150, "hidden"=>true,  "editrules"=>array("edithidden"=>true, "required"=>false),"fixed"=>true, "formatter"=>"currency", "formatoptions"=>array("decimalPlaces"=>2,"thousandsSeparator"=>",","prefix"=>"$"), "label"=>"Received"));
$grid->setColProperty("releaseddate", array("formatter"=>"date", "width"=>120, "hidden"=>true, "editrules"=>array("edithidden"=>true, "required"=>false),"fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"Released Date", 
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
$grid->setColProperty("receiveddate", array("formatter"=>"date", "width"=>120, "hidden"=>true, "editrules"=>array("edithidden"=>true, "required"=>false),"fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"Received Date", 
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
$grid->setColProperty("checknumber", array("editable"=>true, "frozen"=>true, "width"=>100, "hidden"=>true, "editrules"=>array("edithidden"=>true, "required"=>false),"fixed"=>true, "label"=>"Check No."));
$grid->setColProperty("invoiceurl", array("editable"=>true, "frozen"=>true, "width"=>200, "hidden"=>true, "editrules"=>array("edithidden"=>true, "required"=>false),"editoptions"=>array("size"=>75, "maxlength"=>200), "formatter"=>"link", "formatoptions"=>array("target"=>"_blank"), "fixed"=>true, "editrules"=>array("url"=>true, "required"=>false), "label"=>"Invoice Url"));
$grid->setColProperty("checkurl", array("editable"=>true, "frozen"=>true, "width"=>200, "hidden"=>true, "editrules"=>array("edithidden"=>true, "required"=>false),"editoptions"=>array("size"=>75, "maxlength"=>200), "formatter"=>"link", "formatoptions"=>array("target"=>"_blank"), "fixed"=>true, "editrules"=>array("url"=>true, "required"=>false), "label"=>"Check Url"));
$grid->setColProperty("notes", array("editable"=>true, "width"=>400, "fixed"=>true, "hidden"=>true, "edittype"=>"textarea","editrules"=>array("edithidden"=>true, "required"=>false), "editoptions"=>array("rows"=>6, "cols"=>60), "label"=>"Notes"));
														 														 
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Invoice Overdue Management",		
		"rownumbers"=>true,										
    "rowNum"=>100,
    "sortname"=>"expecteddate",
		"sortorder"=>"desc",
    "footerrow"=>true,
    "userDataOnFooter"=>true,
		"shrinkToFit"=>false,				
		"toppager"=>true,
    "rowList"=>array(10,100,500),
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>false,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>700, "dataheight"=>300, "viewCaption"=>"Invoice Overdue Management"));
$grid->setNavOptions('edit',array("width"=>700, "dataheight"=>300, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Invoice","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, $summaryrows, null, true,true);
$DB = null;
?>
