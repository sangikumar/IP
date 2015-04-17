<?php
include_once ("../../ip-config.php");
require_once '../../jq-config.php';
require_once ABSPATH."php/jqGrid.php";
require_once ABSPATH."php/jqAutocomplete.php";
require_once ABSPATH."php/jqGridPdo.php";
$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);
$conn->query("SET NAMES utf8");
$type = $_GET['type'];
$grid = new jqGridRender($conn);

if($type == "vendor" || $type == "list")
{
	$grid->SelectCommand = 'SELECT id,name,email,phone,designation,vendorid,(select ifnull(companyname, " ") from vendor where id = vendorid) comp, status,dob,personalemail,skypeid,linkedin,twitter,facebook,review,notes FROM recruiter where clientid = 0 ';
}

if($type == "client" || $type == "clist")
{
	$grid->SelectCommand = 'SELECT id,name,email,phone,designation,clientid,(select ifnull(companyname, " ") from client where id = clientid) comp, status,dob,personalemail,skypeid,linkedin,twitter,facebook,review,notes FROM recruiter where vendorid = 0 ';
}

if($type == "placement")
{
	$grid->SelectCommand = 'SELECT id,name,email,phone,designation,vendorid,(select ifnull(companyname, " ") from vendor where id = vendorid) comp,status,dob,personalemail,skypeid,linkedin,twitter,facebook,review,notes FROM recruiter where clientid = 0  and vendorid in (select distinct vendorid from placement where vendorid <> 0) ';
}

if($type == "cplacement")
{
	$grid->SelectCommand = 'SELECT id,name,email,phone,designation,clientid,(select ifnull(companyname, " ") from client where id = clientid) comp,status,dob,personalemail,skypeid,linkedin,twitter,facebook,review,notes FROM recruiter where vendorid = 0  and clientid in (select distinct clientid from placement where clientid <> 0) ';
}

if($type == "work")
{
	$grid->SelectCommand = 'SELECT id,name,email,phone,designation,vendorid,(select ifnull(companyname, " ") from vendor where id = vendorid) comp, status,dob,personalemail,skypeid,linkedin,twitter,facebook,review,notes FROM recruiter where clientid = 0 and vendorid <> 0 and (name is not null and length(name) > 1) and (phone is not null and length(phone) > 1) and (designation is not null and length(designation) > 1) ';
}

if($type == "cwork")
{
	$grid->SelectCommand = 'SELECT id,name,email,phone,designation,clientid,(select ifnull(companyname, " ") from client where id = clientid) comp, status,dob,personalemail,skypeid,linkedin,twitter,facebook,review,notes FROM recruiter where vendorid = 0 and clientid <> 0 and (name is not null and length(name) > 1) and (phone is not null and length(phone) > 1) and (designation is not null and length(designation) > 1) ';
}

$grid->table = 'recruiter';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('dob');
$grid->setUserDate("Y-m-d"); 
$grid->setColModel();
$grid->setUrl('../grids/allrecruiters.php?type='.$type);
$grid->setColProperty("id", array("editable"=>false, "width"=>40, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("comp", array("editable"=>false, "width"=>40, "hidden"=>true, "label"=>"Vendor"));
$grid->setColProperty("name", array("editable"=>true, "frozen"=>true, "width"=>250, "editoptions"=>array("size"=>75, "maxlength"=>250, "style"=>"text-transform: uppercase"), "fixed"=>true, "label"=>"Name"));
$grid->setColProperty("email", array("editable"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>250, "style"=>"text-transform: lowercase"), "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>true), "label"=>"Email"));
$grid->setColProperty("phone", array("editable"=>true, "width"=>150, "editoptions"=>array("size"=>75, "maxlength"=>250),"fixed"=>true, "label"=>"Phone"));
$grid->setColProperty("designation", array("editable"=>true, "frozen"=>true, "width"=>250, "editoptions"=>array("size"=>75, "maxlength"=>250, "style"=>"text-transform: uppercase"), "fixed"=>true, "label"=>"Designation"));
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
$grid->setColProperty("personalemail", array("editable"=>true, "width"=>150, "fixed"=>true, "editoptions"=>array("size"=>75, "maxlength"=>200), "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Personal Email"));
$grid->setColProperty("status", array("editable"=>true, "label"=>"Status", "width"=>50, "fixed"=>true,  "edittype"=>"select"));
$grid->setSelect("status", array("A"=>"Active", "I"=>"Inactive", "D"=>"Delete", "R"=>"Rejected", "N"=>"Not Interested", "E"=>"Excellent"), false, true, true, array(""=>"All"));
$grid->setColProperty("skypeid", array("editable"=>true, "frozen"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Skype"));
$grid->setColProperty("linkedin", array("editable"=>true, "frozen"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"LinkedIN"));
$grid->setColProperty("twitter", array("editable"=>true, "frozen"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Twitter"));
$grid->setColProperty("facebook", array("editable"=>true, "frozen"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Facebook"));
$grid->setColProperty("review", array("editable"=>true, "label"=>"Review", "width"=>50, "fixed"=>true,  "edittype"=>"select"));
$grid->setSelect("review", $yesno , false, true, true, array(""=>"All"));
if($type == "vendor" || $type == "list" || $type == "placement" || $type == "work")
{
	$grid->setColProperty("vendorid", array("editable"=>true, "frozen"=>true, "width"=>250, "fixed"=>true, "label"=>"Vendor ID", "edittype"=>"select"));
	$grid->setSelect("vendorid", "select 0 as id, '  Vendor not selected...' as name from dual union SELECT distinct id, companyname as name FROM vendor order by name");
}
else
{
	$grid->setColProperty("clientid", array("editable"=>true, "frozen"=>true, "width"=>250, "fixed"=>true, "label"=>"Client ID", "edittype"=>"select"));
	$grid->setSelect("clientid", "select 0 as id, '  Client not selected...' as name from dual union SELECT distinct id, companyname as name FROM client order by name");
}
$grid->setColProperty("notes", array("editable"=>true, "width"=>400, "fixed"=>true, "edittype"=>"textarea", "editoptions"=>array("rows"=>6, "cols"=> 60), "label"=>"Notes"));
if($type == "vendor" || $type == "placement")
{
	$grid->setGridOptions(array(
			"sortable"=>true,
			"width"=>1024,
			"height"=>250,
			"caption"=>"Recruiters Management",		
			"rownumbers"=>true,										
			"rowNum"=>1000,
			"sortname"=>"comp asc, status",
			"sortorder"=>"asc",
			"toppager"=>true,
			"rowList"=>array(1000,5000,10000,20000),
			"grouping"=>true,
			"groupingView"=>array(
			"groupCollapse"=>true,
			"groupField" => array('vendorid'),
			"groupColumnShow" => array(true),
			"groupOrder" => array('desc'),
			"groupSummary" => array(true),
			"groupText" =>array('<b>{0}</b>'),
			"groupDataSorted" => false)
	));	
}
if($type == "client" || $type == "cplacement")
{
	$grid->setGridOptions(array(
			"sortable"=>true,
			"width"=>1024,
			"height"=>250,
			"caption"=>"Recruiters Management",		
			"rownumbers"=>true,										
			"rowNum"=>1000,
			"sortname"=>"comp asc, status",
			"sortorder"=>"asc",
			"toppager"=>true,
			"rowList"=>array(1000,5000,10000,20000),
			"grouping"=>true,
			"groupingView"=>array(
			"groupCollapse"=>true,
			"groupField" => array('clientid'),
			"groupColumnShow" => array(true),
			"groupOrder" => array('desc'),
			"groupSummary" => array(true),
			"groupText" =>array('<b>{0}</b>'),
			"groupDataSorted" => false)
	));	
}
if($type == "list" || $type == "work" || $type == "clist" || $type == "cwork")
{
	$grid->setGridOptions(array(
			"sortable"=>true,
			"width"=>1024,
			"height"=>250,
			"caption"=>"Recruiters Management",		
			"rownumbers"=>true,										
			"rowNum"=>1000,
			"sortname"=>"status asc, email",
			"sortorder"=>"asc",
			"toppager"=>true,
			"rowList"=>array(1000,5000,10000,20000),
	));	
}	
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"All Recruiters Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Recruiter","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Recruiter","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true,null, null, true,true);
$conn = null;
?>
