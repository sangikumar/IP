<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");

// Create the jqGrid instance
$grid = new jqGridRender($DB);
// Write the SQL Query
$grid->SelectCommand = 'SELECT id, candidateid, candidateid as cid, mmid, mmid as mid, type,  interviewdate, interviewhour, interviewminute, interviewdivision,status, rate, clientname, clientlocation, vendor1, vendor1email, vendor2, vendor2email, client1email, client2email, client3email,  vendor3email, reference, interviewers, interviewersphone, result, performance, uploaded, portal, reclink, questions, questionslink, notes FROM interview';
// Set the table to where we add the data
$grid->table = 'interview';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('interviewdate');
$grid->setUserDate("Y-m-d"); 
$grid->setColModel();
$grid->setUrl('../grids/interview.php');
$grid->setColProperty("id", array("editable"=>false, "hidden"=>true, "label"=>"ID"));
$grid->setColProperty("cid", array("editable"=>false, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Candidate Name", "edittype"=>"select"));
$grid->setSelect("cid", "SELECT distinct candidateid as id, name as name FROM candidate order by name");
$grid->setColProperty("candidateid", array("editable"=>true, "hidden"=>true, "editrules"=>array("edithidden"=>true, "required"=>false), "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Candidate Name", "edittype"=>"select"));
$grid->setSelect("candidateid", "SELECT distinct candidateid as id, name as name FROM candidate where status in ('Marketing', 'Placed', 'OnProject-Mkt') order by name");
$grid->setColProperty("mid", array("editable"=>false, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Manager", "edittype"=>"select"));
$grid->setSelect("mid", "SELECT distinct id, name FROM employee order by name");
$grid->setColProperty("mmid", array("editable"=>true, "hidden"=>true, "editrules"=>array("edithidden"=>true, "required"=>false), "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Manager", "edittype"=>"select"));
$grid->setSelect("mmid", "SELECT distinct id, name FROM employee where status = '0Active' order by name");

$grid->setColProperty("interviewdate", array("formatter"=>"date", "width"=>80, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d", "elmprefix"=>" ", "rowpos"=>5, "colpos"=>1), "editable"=>true, "label"=>"Date",
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
$grid->setColProperty("interviewhour", array("editable"=>true, "width"=>50, "fixed"=>true, "label"=>"TimeHR", "formoptions"=>array("elmprefix"=>" ", "rowpos"=>5, "colpos"=>1), "edittype"=>"select"));
$grid->setSelect("interviewhour", $interviewhour , false, true, true, array(""=>"All"));				
$grid->setColProperty("interviewminute", array("editable"=>true, "width"=>50, "fixed"=>true, "label"=>"TimeMin", "formoptions"=>array("elmprefix"=>" ", "rowpos"=>5, "colpos"=>1), "edittype"=>"select"));
$grid->setSelect("interviewminute", $interviewtime , false, true, true, array(""=>"All"));	
$grid->setColProperty("interviewdivision", array("editable"=>true, "width"=>50, "fixed"=>true, "label"=>"AM/PM", "formoptions"=>array("elmprefix"=>" ", "rowpos"=>5, "colpos"=>1), "edittype"=>"select"));
$grid->setSelect("interviewdivision", $interviewdivision , false, true, true, array(""=>"All"));														 
$grid->setColProperty("interviewtime", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Time"));																	 
$grid->setColProperty("type", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Type", "edittype"=>"select"));
$grid->setSelect("type", $interviewtype , false, true, true, array(""=>"All"));
$grid->setColProperty("invitation", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Invitation", "edittype"=>"select"));
$grid->setSelect("invitation", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("status", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", $interviewstatus , false, true, true, array(""=>"All"));
$grid->setColProperty("rate", array("editable"=>true, "width"=>90, "formatter"=>"currency", "formatoptions"=>array("decimalPlaces"=>2,"thousandsSeparator"=>",","prefix"=>"$"), "sorttype"=>"currency", "fixed"=>true, "label"=>"Rate"));
$grid->setColProperty("clientname", array("editable"=>true, "editoptions"=>array("size"=>75, "maxlength"=>200), "width"=>90, "fixed"=>true, "label"=>"Client Name"));
//$grid->setAutocomplete("clientname",null,"select companyname from (select v.companyname from vendor v union select c.companyname from client c union select distinct client from position union select distinct vendor1 from position union select distinct vendor2 from position union select distinct vendor3 from position) p  where companyname like ? ORDER BY companyname",null,true,true);
$grid->setColProperty("clientlocation", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Client Location"));
$grid->setColProperty("interviewers", array("editable"=>true, "width"=>90, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Interviewers"));
$grid->setColProperty("interviewersphone", array("editable"=>true, "width"=>90, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Int. Phone"));
$grid->setColProperty("result", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Result", "edittype"=>"select"));
$grid->setSelect("result", $interviewresult, false, true, true, array(""=>"All"));
$grid->setColProperty("performance", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Performance", "edittype"=>"select"));
$grid->setSelect("performance", $interviewperf , false, true, true, array(""=>"All"));
$grid->setColProperty("client1email", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Client1 Email"));
//$grid->setAutocomplete("client1email",null,"select email, email from (SELECT email FROM massemail union select distinct vendor1email from position union select distinct vendor2email from position union select distinct vendor3email from position union select v.email from vendor v union select r.email from recruiter r) p where email like ? ORDER BY email",null,true,true);
$grid->setColProperty("client2email", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Client2 Email"));
//$grid->setAutocomplete("client2email",null,"select email, email from (SELECT email FROM massemail union select distinct vendor1email from position union select distinct vendor2email from position union select distinct vendor3email from position union select v.email from vendor v union select r.email from recruiter r) p where email like ? ORDER BY email",null,true,true);
$grid->setColProperty("client3email", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Client3 Email"));
//$grid->setAutocomplete("client3email",null,"select email, email from (SELECT email FROM massemail union select distinct vendor1email from position union select distinct vendor2email from position union select distinct vendor3email from position union select v.email from vendor v union select r.email from recruiter r) p where email like ? ORDER BY email",null,true,true);
$grid->setColProperty("vendor1", array("editable"=>true, "width"=>90, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Vendor1"));
//$grid->setAutocomplete("vendor1",null,"select companyname from (select v.companyname from vendor v union select c.companyname from client c union select distinct vendor1 from position union select distinct vendor2 from position union select distinct vendor3 from position) p  where companyname like ? ORDER BY companyname",null,true,true);
$grid->setColProperty("vendor1email", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Vendor1 Email"));
//$grid->setAutocomplete("vendor1email",null,"select email, email from (SELECT email FROM massemail union select distinct vendor1email from position union select distinct vendor2email from position union select distinct vendor3email from position union select v.email from vendor v union select r.email from recruiter r) p where email like ? ORDER BY email",null,true,true);
$grid->setColProperty("vendor2", array("editable"=>true, "width"=>90, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Vendor2"));
//$grid->setAutocomplete("vendor2",null,"select companyname from (select v.companyname from vendor v union select c.companyname from client c union select distinct vendor1 from position union select distinct vendor2 from position union select distinct vendor3 from position) p  where companyname like ? ORDER BY companyname",null,true,true);
$grid->setColProperty("vendor2email", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Vendor2 Email"));
//$grid->setAutocomplete("vendor2email",null,"select email, email from (SELECT email FROM massemail union select distinct vendor1email from position union select distinct vendor2email from position union select distinct vendor3email from position union select v.email from vendor v union select r.email from recruiter r) p where email like ? ORDER BY email",null,true,true);
$grid->setColProperty("vendor3email", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Vendor3 Email"));
//$grid->setAutocomplete("vendor3email",null,"select email, email from (SELECT email FROM massemail union select distinct vendor1email from position union select distinct vendor2email from position union select distinct vendor3email from position union select v.email from vendor v union select r.email from recruiter r) p where email like ? ORDER BY email",null,true,true);
$grid->setColProperty("reference", array("editable"=>true, "width"=>90, "fixed"=>true, "editoptions"=>array("size"=>75, "maxlength"=>200), "label"=>"References"));
$grid->setColProperty("uploaded", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Uploaded", "edittype"=>"select"));
$grid->setSelect("uploaded", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("portal", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Portal", "edittype"=>"select"));
$grid->setSelect("portal", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("reclink", array("editable"=>true, "frozen"=>true, "width"=>400, "formatter"=>"link", "fixed"=>true, "editoptions"=>array("size"=>75, "maxlength"=>200), "editrules"=>array("url"=>true, "required"=>false), "label"=>"Recording Link"));
$grid->setColProperty("questionslink", array("editable"=>true, "frozen"=>true, "width"=>400, "formatter"=>"link", "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "editrules"=>array("url"=>true, "required"=>false), "label"=>"Ques Link"));
$grid->setColProperty("questions", array("editable"=>true, "hidden"=>true, "edittype"=>"textarea","editrules"=>array("edithidden"=>true, "required"=>false), "editoptions"=>array("rows"=>6, "cols"=> 80), "label"=>"Questions"));
$grid->setColProperty("notes", array("editable"=>true, "width"=>70, "fixed"=>true, "edittype"=>"textarea","editrules"=>array("edithidden"=>true, "required"=>false), "editoptions"=>array("rows"=>6, "cols"=> 80), "label"=>"Notes"));
						
// Set alternate background using altRows property
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>500,
		"caption"=>"Interview Management",		
		"rownumbers"=>true,										
    "rowNum"=>50,
    //"userDataOnFooter"=>true,
    //"footerrow"=>true,
		"shrinkToFit"=>false,
    "sortname"=>"interviewdate",
		"sortorder"=>"desc",
    //"altRows"=>true,
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100,500),
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Interview Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Interview","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Interview","reloadAfterSubmit"=>false));
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