<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");

// Create the jqGrid instance
$grid = new jqGridRender($DB);
// Write the SQL Query
$grid->SelectCommand = 'select leadid, name, startdate,course,workexperience, email, phone, secondaryemail, secondaryphone, status, priority, workstatus,spousename,spouseemail,spousephone,spouseoccupationinfo, attendedclass, siteaccess, faq, closedate, assignedto,  intent, callsmade, source, sourcename, address, city, state, country, zip, notes from leads';
// Set the table to where we add the data
$grid->table = 'leads';
$grid->gSQLMaxRows = 100000;
$grid->setPrimaryKeyId('leadid');
$grid->serialKey = false;
// set the ouput format to json
$grid->dataType = 'json';
$grid->datearray = array('closedate');
$grid->setUserDate("Y-m-d"); 
// Let the grid create the model from SQL query
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('../grids/leads.php');
// Change some property of the field(s)
$grid->setColProperty("leadid", array("editable"=>false, "hidden"=>true, "label"=>"ID"));
$grid->setColProperty("name", array("editable"=>true, "frozen"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Name*"));
$grid->setAutocomplete("name",null,"select name, name from (SELECT distinct name FROM leads union select distinct name from candidate union select distinct name from recruit) p where name like ? ORDER BY name",null,true,true);
$grid->setColProperty('startdate',   
        array("editable"=>false,"width"=>70, "fixed"=>true,"formatter"=>"date", "label"=>"Start Date", 
				"formatoptions"=>array("srcformat"=>"Y-m-d HH:MM:SS", "newformat"=>"m/d/Y"),
				"searchoptions"=>array("dataInit"=>
			        "js:function(elm){setTimeout(function(){
					 jQuery(elm).datepicker({dateFormat:'yy-mm-dd'});
					 jQuery('.ui-datepicker').css({'font-size':'75%'});
			 },200);}")
				));
$grid->setColProperty("course", array("editable"=>true, "label"=>"Course", "width"=>40, "fixed"=>true,  "edittype"=>"select"));
$grid->setSelect("course", $courses , false, true, true, array(""=>"All"));
$grid->setColProperty("workexperience", array("editable"=>true, "width"=>100, "fixed"=>true, "label"=>"Experience"));
$grid->setColProperty("phone", array("editable"=>true, "width"=>90, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Phone*"));
$grid->setAutocomplete("phone",null,"select phone, phone from (SELECT distinct phone FROM leads union select distinct phone from candidate union select distinct phone from recruit) p where phone like ? ORDER BY phone",null,true,true);
$grid->setColProperty("email", array("editable"=>true, "width"=>150, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>true), "label"=>"Email*"));
$grid->setAutocomplete("email",null,"select email, email from (SELECT distinct email FROM leads union select distinct email from candidate union select distinct email from recruit) p where email like ? ORDER BY email",null,true,true);
$grid->setColProperty("secondaryphone", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Secondary Phone"));
$grid->setColProperty("secondaryemail", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Secondary Email"));

$grid->setColProperty("priority",array("editable"=>true, "width"=>70, "fixed"=>true,  "label"=>"Priority", "edittype"=>"select"));
$grid->setSelect("priority", $priorities , false, true, true, array(""=>"All"));

$grid->setColProperty("status", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", $leadstatus , false, true, true, array(""=>"All"));
$grid->setColProperty("spousename", array("editable"=>true, "width"=>120, "fixed"=>true, "label"=>"Spouse Name"));
$grid->setColProperty("spouseemail", array("editable"=>true, "width"=>150, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Spouse Email"));
$grid->setColProperty("spousephone", array("editable"=>true, "width"=>90, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Spouse Phone"));
$grid->setColProperty("spouseoccupationinfo", array("editable"=>true, "width"=>400, "fixed"=>true, "edittype"=>"textarea","editoptions"=>array("rows"=>4, "cols"=> 80), "label"=>"Spouse Occupation Info"));

$grid->setColProperty("attendedclass", array("editable"=>true, "width"=>50, "fixed"=>true,  "label"=>"Class", "edittype"=>"select"));
$grid->setSelect("attendedclass", $yesno , false, true, true, array(""=>"All"));

$grid->setColProperty("siteaccess", array("editable"=>true, "width"=>50, "fixed"=>true,  "label"=>"Access", "edittype"=>"select"));
$grid->setSelect("siteaccess", $yesno , false, true, true, array(""=>"All"));

$grid->setColProperty("faq", array("editable"=>true, "label"=>"FAQ", "width"=>50, "fixed"=>true,  "edittype"=>"select"));
$grid->setSelect("faq", $yesno , false, true, true, array(""=>"All"));

$grid->setColProperty("source", array("editable"=>true, "label"=>"Source*", "width"=>70, "fixed"=>true,  "edittype"=>"select"));
$grid->setSelect("source", $referral , false, true, true, array(""=>"All"));

$grid->setColProperty("sourcename", array("editable"=>true, "width"=>120, "fixed"=>true, "label"=>"Source N"));

$grid->setColProperty("assignedto", array("editable"=>true, "width"=>100, "fixed"=>true, "label"=>"Assigned To", "edittype"=>"select"));
$grid->setSelect("assignedto", $completeteam , false, true, true, array(""=>"All"));


$grid->setColProperty("intent", array("editable"=>true, "width"=>100, "fixed"=>true, "label"=>"Intent", "edittype"=>"select"));
$grid->setSelect("intent", $candidateintent , false, true, true, array(""=>"All"));

$grid->setColProperty("callsmade", array("editable"=>true, "width"=>70, "fixed"=>true, "editrules"=>array("minValue"=>0, "maxValue"=>10), "label"=>"Calls"));

$grid->setColProperty("workstatus", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"US Status*", "edittype"=>"select"));
$grid->setSelect("workstatus", $workauthtype , false, true, true, array(""=>"All"));

$grid->setColProperty("closedate", array("formatter"=>"date", "width"=>70, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"Close Date", 
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
																	 
$grid->setColProperty("address", array("editable"=>true, "width"=>170, "fixed"=>true, "label"=>"Address"));
$grid->setColProperty("city", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"City*"));
$grid->setAutocomplete("city",null,"select name, name from (select distinct city as name from city) p where name like ? ORDER BY name",null,true,true);
$grid->setColProperty("state", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"State"));
$grid->setAutocomplete("state",null,"select name, name from (SELECT distinct name FROM state)p where name like ? ORDER BY name",null,true,true);
$grid->setColProperty("country", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Country"));
$grid->setAutocomplete("country",null,"select name, name from (SELECT distinct short_name as name FROM country) p where name like ? ORDER BY name",null,true,true);
$grid->setColProperty("zip", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Zip"));
$grid->setAutocomplete("zip",null,"select name, name from (select zip as name from city) p where name like ? ORDER BY name",null,true,true);

$grid->setColProperty("notes", array("editable"=>true, "width"=>400, "fixed"=>true, "edittype"=>"textarea","editoptions"=>array("rows"=>6, "cols"=> 80), "label"=>"Notes"));
						
// Set alternate background using altRows property
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Lead Management",		
		"rownumbers"=>true,										
    "rowNum"=>100,
		"shrinkToFit"=>false,
    "sortname"=>"startdate",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100,500),
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Lead Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Lead","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Lead","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$DB = null;
?>
