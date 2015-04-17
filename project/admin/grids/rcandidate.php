<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
// Create the jqGrid instance
$grid = new jqGridRender($DB);
// Write the SQL Query
$grid->SelectCommand = 'SELECT candidateid, name, email, phone, course, batchname, enrolleddate,status, statuschangedate, processflag, diceflag, workstatus, education, workexperience, ssn, dob, portalid, agreement, promissory, driverslicense, workpermit, wpexpirationdate,  offerletter, ssnvalidated, secondaryemail, secondaryphone, address, city, state, country, zip, emergcontactname, emergcontactemail,  emergcontactphone, emergcontactaddrs, guidelines, term, feepaid, feedue, referralid, salary0, salary6, salary12,originalresume,  contracturl, empagreementurl, offerletterurl, dlurl, workpermiturl, ssnurl, notes FROM candidate';
$grid->table = 'candidate';
$grid->setPrimaryKeyId('candidateid');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('enrolleddate','wpexpirationdate','dob');
$grid->setUserDate("Y-m-d"); 
$grid->setColModel();
$grid->setUrl('../grids/candidate.php');
$grid->setColProperty("candidateid", array("editable"=>false, "width"=>25, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("name", array("editable"=>true, "frozen"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Name"));
$grid->setAutocomplete("name",null,"select name, name from (SELECT distinct name FROM leads union select distinct name from candidate union select distinct name from recruit) p where name like ? ORDER BY name",null,true,true);
$grid->setColProperty("enrolleddate", array("formatter"=>"date", "width"=>70, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), 
																	 "editable"=>true, "label"=>"Enrolled Date", 
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
$grid->setColProperty("email", array("editable"=>true, "width"=>150, "fixed"=>true, "editoptions"=>array("size"=>75, "maxlength"=>150), "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>true), "label"=>"Email"));
$grid->setAutocomplete("email",null,"select email, email from (SELECT distinct email FROM leads union select distinct email from candidate union select distinct email from recruit) p where email like ? ORDER BY email",null,true,true);
$grid->setColProperty("phone", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Phone"));
$grid->setAutocomplete("phone",null,"select phone, phone from (SELECT distinct phone FROM leads union select distinct phone from candidate union select distinct phone from recruit) p where phone like ? ORDER BY phone",null,true,true);
$grid->setColProperty("course", array("editable"=>true, "label"=>"Course", "width"=>40, "fixed"=>true,  "edittype"=>"select"));
$grid->setSelect("course", $courses , false, true, true, array(""=>"All"));
$grid->setColProperty("status", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", $candidatestatus , false, true, true, array(""=>"All"));
$grid->setColProperty("statuschangedate", array("formatter"=>"date", "hidden"=>true, "editrules"=>array("edithidden"=>true, "required"=>false), "width"=>70, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), 
																	 "editable"=>true, "label"=>"Status Change Date", 
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
$grid->setColProperty("processflag", array("editable"=>true, "hidden"=>true, "editrules"=>array("edithidden"=>true, "required"=>false), "label"=>"Process", "width"=>50, "fixed"=>true, "edittype"=>"select"));
$grid->setSelect("processflag", $yesno , false, true, true, array(""=>"All"));		
$grid->setColProperty("diceflag", array("editable"=>true, "editrules"=>array("edithidden"=>true, "required"=>false), "label"=>"Dice Candidate", "width"=>50, "fixed"=>true, "edittype"=>"select"));
$grid->setSelect("diceflag", $yesno , false, true, true, array(""=>"All"));																	 

															 
$grid->setColProperty("workstatus", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"US Status", "edittype"=>"select"));
$grid->setSelect("workstatus", $workauthtype , false, true, true, array(""=>"All"));
$grid->setColProperty("education", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Education"));
$grid->setColProperty("workexperience", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Work Experience"));
$grid->setColProperty("ssn", array("editable"=>true, "hidden"=>true, "editrules"=>array("edithidden"=>true, "required"=>false), "width"=>90, "fixed"=>true, "label"=>"SSN"));
$grid->setColProperty("dob", array("formatter"=>"date", "width"=>70, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), 
																	 "editable"=>true, "label"=>"Birth Date", 
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
$grid->setColProperty("portalid", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Portal ID", "edittype"=>"select"));
$grid->setSelect("portalid", "select '' as id, '' as name from dual union SELECT distinct id, concat(fullname, '-', uname) as name FROM authuser order by name");							
$grid->setColProperty("agreement", array("editable"=>true, "label"=>"Agreement", "width"=>50, "fixed"=>true,  "edittype"=>"select"));
$grid->setSelect("agreement", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("promissory", array("editable"=>true, "label"=>"Promissory", "width"=>50, "fixed"=>true,  "edittype"=>"select"));
$grid->setSelect("promissory", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("driverslicense", array("editable"=>true, "label"=>"DL", "width"=>50, "fixed"=>true,  "edittype"=>"select"));
$grid->setSelect("driverslicense", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("workpermit", array("editable"=>true, "label"=>"Work Permit", "width"=>50, "fixed"=>true,  "edittype"=>"select"));
$grid->setSelect("workpermit", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("wpexpirationdate", array("formatter"=>"date", "width"=>70, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), 
																	 "editable"=>true, "label"=>"Work Auth Exp Date", 
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
$grid->setColProperty("offerletter", array("editable"=>true, "label"=>"Offer Letter", "width"=>50, "fixed"=>true,  "edittype"=>"select"));
$grid->setSelect("offerletter", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("ssnvalidated", array("editable"=>true, "label"=>"SSN Valid", "width"=>50, "fixed"=>true,  "edittype"=>"select"));
$grid->setSelect("ssnvalidated", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("secondaryemail", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Sec Email"));
$grid->setColProperty("secondaryphone", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Secondary Phone"));
$grid->setColProperty("address", array("editable"=>true, "width"=>150, "fixed"=>true, "label"=>"Address"));
$grid->setColProperty("city", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"City"));
$grid->setAutocomplete("city",null,"select name, name from (select distinct city as name from city) p where name like ? ORDER BY name",null,true,true);
$grid->setColProperty("state", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"State"));
$grid->setAutocomplete("state",null,"select name, name from (SELECT distinct name FROM state)p where name like ? ORDER BY name",null,true,true);
$grid->setColProperty("country", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Country"));
$grid->setAutocomplete("country",null,"select name, name from (SELECT distinct short_name as name FROM country) p where name like ? ORDER BY name",null,true,true);
$grid->setColProperty("zip", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Zip"));
$grid->setAutocomplete("zip",null,"select name, name from (select zip city as name from city) p where name like ? ORDER BY name",null,true,true);
$grid->setColProperty("emergcontactname", array("editable"=>true, "width"=>150, "fixed"=>true, "label"=>"Emeg: Contact Name"));
$grid->setColProperty("emergcontactemail", array("editable"=>true, "width"=>150, "fixed"=>true, "label"=>"Emeg: Contact Email"));
$grid->setColProperty("emergcontactphone", array("editable"=>true, "width"=>150, "fixed"=>true, "label"=>"Emeg: Contact Phone"));
$grid->setColProperty("emergcontactaddrs", array("editable"=>true, "width"=>150, "fixed"=>true, "label"=>"Emeg: Contact Address"));
$grid->setColProperty("guidelines", array("editable"=>true, "label"=>"Guidelines", "width"=>50, "fixed"=>true,  "edittype"=>"select"));
$grid->setSelect("guidelines", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("term", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Term"));
$grid->setColProperty("feepaid", array("editable"=>true, "width"=>90, 
											"formatter"=>"currency", "hidden"=>true, "editrules"=>array("edithidden"=>true, "required"=>false), 
        							"formatoptions"=>array("decimalPlaces"=>2,"thousandsSeparator"=>",","prefix"=>"$"), 
											"sorttype"=>"currency", "fixed"=>true, "label"=>"Fee Paid"));
$grid->setColProperty("feedue", array("editable"=>true, "width"=>90, 
											"formatter"=>"currency", "hidden"=>true, "editrules"=>array("edithidden"=>true, "required"=>false), 
        							"formatoptions"=>array("decimalPlaces"=>2,"thousandsSeparator"=>",","prefix"=>"$"), 
											"sorttype"=>"currency", "fixed"=>true, "label"=>"Fee Due"));
$grid->setColProperty("referralid", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Referral ID", "edittype"=>"select"));
$grid->setSelect("referralid", "select '' as id, '' as name from dual union SELECT distinct candidateid, name FROM candidate order by name");							
$grid->setColProperty("salary0", array("editable"=>true, "label"=>"Salary0-6", "width"=>70, "fixed"=>true,  "edittype"=>"select"));
$grid->setSelect("salary0", $salary , false, true, true, array(""=>"All"));				
$grid->setColProperty("salary6", array("editable"=>true, "label"=>"Salary6-12", "width"=>70, "fixed"=>true,  "edittype"=>"select"));
$grid->setSelect("salary6", $salary , false, true, true, array(""=>"All"));							
$grid->setColProperty("salary12", array("editable"=>true, "label"=>"Salary12+", "width"=>70, "fixed"=>true,  "edittype"=>"select"));
$grid->setSelect("salary12", $salary , false, true, true, array(""=>"All"));	
$grid->setColProperty("originalresume", array("editable"=>true, "frozen"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "formatter"=>"link", "fixed"=>true, "editrules"=>array("url"=>true, "required"=>false), "label"=>"Resume Url"));
										
$grid->setColProperty("contracturl", array("editable"=>true, "frozen"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "formatter"=>"link", "fixed"=>true, "editrules"=>array("url"=>true, "required"=>false), "label"=>"Contract Url"));
$grid->setColProperty("empagreementurl", array("editable"=>true, "frozen"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "formatter"=>"link", "fixed"=>true, "editrules"=>array("url"=>true, "required"=>false), "label"=>"Emp Agreement Url"));
$grid->setColProperty("offerletterurl", array("editable"=>true, "frozen"=>true, "hidden"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "formatter"=>"link", "fixed"=>true, "editrules"=>array("edithidden"=>true, "url"=>true, "required"=>false), "label"=>"Offer Letter Url"));
$grid->setColProperty("dlurl", array("editable"=>true, "frozen"=>true, "hidden"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "formatter"=>"link", "fixed"=>true, "editrules"=>array("edithidden"=>true, "url"=>true, "required"=>false), "label"=>"DL Url"));
$grid->setColProperty("workpermiturl", array("editable"=>true, "frozen"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "formatter"=>"link", "fixed"=>true, "editrules"=>array("url"=>true, "required"=>false), "label"=>"Work Permit Url"));
$grid->setColProperty("ssnurl", array("editable"=>true, "frozen"=>true, "width"=>200, "hidden"=>true, "editoptions"=>array("size"=>75, "maxlength"=>200), "formatter"=>"link", "fixed"=>true, "editrules"=>array("edithidden"=>true, "url"=>true, "required"=>false), "label"=>"SSN Url"));
$grid->setColProperty("notes", array("editable"=>true, "width"=>400, "fixed"=>true, "edittype"=>"textarea", "editoptions"=>array("rows"=>6, "cols"=> 60), "label"=>"Notes"));
$grid->setColProperty("batchname", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Batch Name", "edittype"=>"select"));
$grid->setSelect("batchname", "select batchname as id, batchname as name from batch", false, true, true);
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Candidate Management",		
		"rownumbers"=>true,										
    "rowNum"=>1000,
		"shrinkToFit"=>false,
    "sortname"=>"status asc, name asc, enrolleddate",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(10,50,100,500,1000),
    "grouping"=>true,
    "groupingView"=>array(
		"groupCollapse"=>false,
    "groupField" => array('batchname'),
    "groupColumnShow" => array(true),
    "groupOrder" => array('desc'),
    "groupText" =>array('<b>{0}</b>'),
    "groupDataSorted" => true)
    ));		
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Candidate Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Candidate","reloadAfterSubmit"=>true));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Candidate","reloadAfterSubmit"=>true));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$DB = null;
?>
