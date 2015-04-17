<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");

// Create the jqGrid instance
$grid = new jqGridRender($DB);
// Write the SQL Query
$grid->SelectCommand = 'SELECT id, name, startdate, email, phone, priority, status, source, relocation, preferredlocation, experience, expectedsalary, resumeurl, address, secondaryemail, calls, companyname, companyemail, companyphone, recruitername, recruiteremail, recruiterphone, closedate, notes  FROM recruit';
// Set the table to where we add the data
$grid->table = 'recruit';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('startdate','closedate');
$grid->setUserDate("Y-m-d"); 
// Let the grid create the model from SQL query
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('../grids/recruiting.php');
// Change some property of the field(s)

$grid->setColProperty("id", array("editable"=>false, "width"=>25, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("name", array("editable"=>true, "width"=>200, "fixed"=>true, "label"=>"Name"));
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
$grid->setColProperty("phone", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Phone"));
$grid->setAutocomplete("phone",null,"select phone, phone from (SELECT distinct phone FROM leads union select distinct phone from candidate union select distinct phone from recruit) p where phone like ? ORDER BY phone",null,true,true);
$grid->setColProperty("email", array("editable"=>true, "width"=>200, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>true), "label"=>"Email"));
$grid->setAutocomplete("email",null,"select email, email from (SELECT distinct email FROM leads union select distinct email from candidate union select distinct email from recruit) p where email like ? ORDER BY email",null,true,true);
$grid->setColProperty("priority",array("editable"=>true, "width"=>70, "fixed"=>true,  "label"=>"Priority", "edittype"=>"select"));
$grid->setSelect("priority", array("P3"=>"P3", "P1"=>"P1", "P2"=>"P2"), false, true, true, array(""=>"All"));
$grid->setColProperty("status", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", array("Open"=>"Open", "In-Progress"=>"In-Progress", "Future"=>"Future", "Rejected"=>"Rejected", "Closed"=>"Closed"), false, true, true, array(""=>"All"));
$grid->setColProperty("source", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Source", "edittype"=>"select"));
$grid->setSelect("source", array("Dice"=>"Dice", "DesiOPT"=>"DesiOPT"), false, true, true, array(""=>"All"));
$grid->setColProperty("relocation", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Relocation", "edittype"=>"select"));
$grid->setSelect("relocation", $yesno , false, true, true, array(""=>"All"));		
$grid->setColProperty("preferredlocation", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Pref. Location"));
$grid->setColProperty("experience", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Experience"));
$grid->setColProperty("expectedsalary", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Expected Salary"));			
$grid->setColProperty("resumeurl", array("editable"=>true, "frozen"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "formatter"=>"link", "fixed"=>true, "editrules"=>array("url"=>true, "required"=>false), "label"=>"Resume Url"));
$grid->setColProperty("address", array("editable"=>true, "width"=>150, "fixed"=>true, "label"=>"Address"));
$grid->setColProperty("secondaryemail", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Sec Email"));
$grid->setColProperty("calls", array("editable"=>true, "width"=>70, "fixed"=>true, "editrules"=>array("minValue"=>0, "maxValue"=>10), "label"=>"Calls"));
$grid->setColProperty("companyname", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Company Name"));
$grid->setColProperty("companyemail", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Company Email"));
$grid->setColProperty("companyphone", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Company Phone"));
$grid->setColProperty("recruitername", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Recruiter Name"));
$grid->setColProperty("recruiteremail", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Recruiter Email"));
$grid->setColProperty("recruiterphone", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Recruiter Phone"));
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
$grid->setColProperty("notes", array("editable"=>true, "width"=>400, "fixed"=>true, "edittype"=>"textarea", "editoptions"=>array("rows"=>6, "cols"=> 60), "label"=>"Notes"));
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Recruiting Management",		
		"rownumbers"=>true,										
    "rowNum"=>100,
    "sortname"=>"startdate",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100),
    ));		
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Recruiting Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Lead","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Lead","reloadAfterSubmit"=>false));
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