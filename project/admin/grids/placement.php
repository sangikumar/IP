<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);

$grid->SelectCommand = 'SELECT id, candidateid, mmid,recruiterid,vendorid,masteragreementid,otheragreementsids,vendor2id,vendor3id,clientid,startdate,enddate,status,paperwork,insurance,wrklocation, wrkdesignation,wrkemail,wrkphone,mgrname,mgremail,mgrphone,hiringmgrname,hiringmgremail,hiringmgrphone,reference,ipemailclear,feedbackid,projectdocs,notes FROM placement p';
$grid->table = 'placement';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
// set the ouput format to json
$grid->dataType = 'json';
$grid->datearray = array('startdate','enddate');
$grid->setUserDate("Y-m-d"); 
// Let the grid create the model from SQL query
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('../grids/placement.php');
// Change some property of the field(s)

$grid->setColProperty("id", array("editable"=>false, "width"=>25, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("candidateid", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Candidate Name", "edittype"=>"select"));
$grid->setSelect("candidateid", "SELECT distinct candidateid as id, name as name FROM candidate order by name");
$grid->setColProperty("mmid", array("editable"=>true, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Manager", "edittype"=>"select"));
$grid->setSelect("mmid", "SELECT distinct id, name FROM employee order by name");
$grid->setColProperty("recruiterid", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Recruiter", "edittype"=>"select"));
$grid->setSelect("recruiterid", "select '' as id, '' as name from dual union SELECT distinct r.id as id, concat(r.name, '-', v.companyname) as name FROM recruiter r, vendor v where r.vendorid = v.id order by name");
$grid->setColProperty("vendorid", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Vendor1", "edittype"=>"select"));
$grid->setSelect("vendorid", "select '' as id, '' as name from dual union SELECT distinct id as id, companyname as name FROM vendor order by name");
$grid->setColProperty("masteragreementid", array("editable"=>true, "width"=>25, "fixed"=>true, "label"=>"MSA ID"));
$grid->setColProperty("otheragreementsids", array("editable"=>true, "width"=>50, "fixed"=>true, "label"=>"Other AgrID"));
$grid->setColProperty("vendor2id", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Vendor2", "edittype"=>"select"));
$grid->setSelect("vendor2id", "select '' as id, '' as name from dual union SELECT distinct id as id, companyname as name FROM vendor order by name");
$grid->setColProperty("vendor3id", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Vendor3", "edittype"=>"select"));
$grid->setSelect("vendor3id", "select '' as id, '' as name from dual union SELECT distinct id as id, companyname as name FROM vendor order by name");
$grid->setColProperty("clientid", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Client", "edittype"=>"select"));
$grid->setSelect("clientid", "select '' as id, '' as name from dual union SELECT distinct id as id, companyname as name FROM client order by name");

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
$grid->setColProperty("enddate", array("formatter"=>"date", "width"=>80, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"End Date", 
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
$grid->setColProperty("status", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", $placementstatus, false, true, true, array(""=>"All"));			
$grid->setColProperty("paperwork", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Paperwork", "edittype"=>"select"));
$grid->setSelect("paperwork", $yesno, false, true, true, array(""=>"All"));							
$grid->setColProperty("insurance", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Insurance", "edittype"=>"select"));
$grid->setSelect("insurance", $yesno, false, true, true, array(""=>"All"));				
$grid->setColProperty("wrklocation", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Wrk Location"));
$grid->setColProperty("wrkdesignation", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Wrk Designation"));
$grid->setColProperty("wrkemail", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Wrk Email"));
$grid->setColProperty("wrkphone", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Wrk Phone"));
$grid->setColProperty("mgrname", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Mgr Name"));
$grid->setColProperty("mgremail", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Mgr Email"));
$grid->setColProperty("mgrphone", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Mgr Phone"));
$grid->setColProperty("hiringmgrname", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Hiring Mgr Name"));
$grid->setColProperty("hiringmgremail", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Hiring Mgr Email"));
$grid->setColProperty("hiringmgrphone", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Hiring Mgr Phone"));
$grid->setColProperty("reference", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Reference", "edittype"=>"select"));
$grid->setSelect("reference", $yesno, false, true, true, array(""=>"All"));	
$grid->setColProperty("ipemailclear", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"IPEmail Clear", "edittype"=>"select"));
$grid->setSelect("ipemailclear", $yesno, false, true, true, array(""=>"All"));	
$grid->setColProperty("projectdocs", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Project Docs", "edittype"=>"select"));
$grid->setSelect("projectdocs", $yesno, false, true, true, array(""=>"All"));
$grid->setColProperty("feedbackid", array("editable"=>true, "frozen"=>true, "width"=>50, "fixed"=>true, "label"=>"Feedback ID", "edittype"=>"select"));
$grid->setSelect("feedbackid", "select '' as id, '' as name from dual union SELECT distinct id, name FROM feedback order by name");
$grid->setColProperty("notes", array("editable"=>true, "width"=>400, "fixed"=>true, "edittype"=>"textarea", "editoptions"=>array("rows"=>6, "cols"=> 60), "label"=>"Notes"));
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>500,
		"caption"=>"Placement Management",		
		"rownumbers"=>true,										
    "rowNum"=>100,
    "sortname"=>"startdate",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100,500),
    ));			
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>false,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Placement Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Placement","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Placement","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true,null, null, true,true);
$DB = null;
?>
