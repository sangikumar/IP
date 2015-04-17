<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");

// Create the jqGrid instance
$grid = new jqGridRender($DB);
// Write the SQL Query
$grid->SelectCommand = 'SELECT id,name,email,phone,(select companyname from vendor where id = vendorid) as companyname,personalemail,skypeid,twitter,linkedin,facebook,review,employeeid,vendorid,notes FROM recruiter where id in (select distinct recruiterid from placement)';
// Set the table to where we add the data
$grid->table = 'recruiter';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
// set the ouput format to json
$grid->dataType = 'json';
// Let the grid create the model from SQL query
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('../grids/recruiter.php');
// Change some property of the field(s)

$grid->setColProperty("id", array("editable"=>false, "width"=>40, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("companyname", array("editable"=>false, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Company Name"));
$grid->setColProperty("name", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Name"));
$grid->setColProperty("email", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>true), "label"=>"Email"));
$grid->setColProperty("phone", array("editable"=>true, "width"=>150, "fixed"=>true, "label"=>"Phone"));
$grid->setColProperty("personalemail", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Personal Email"));
$grid->setColProperty("skypeid", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Skype"));
//$grid->setColProperty("linkedin", array("editable"=>true, "label"=>"LinkedIN", "width"=>50, "fixed"=>true,  "edittype"=>"select"));
//$grid->setSelect("linkedin", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("twitter", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Twitter"));
$grid->setColProperty("facebook", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Facebook"));
$grid->setColProperty("linkedin", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Linkedin"));
$grid->setColProperty("review", array("editable"=>true, "label"=>"Review", "width"=>50, "fixed"=>true,  "edittype"=>"select"));
$grid->setSelect("review", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("vendorid", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Vendor ID", "edittype"=>"select"));
$grid->setSelect("vendorid", "select '' as id, '' as name from dual union SELECT distinct id, companyname as name FROM vendor order by name");
$grid->setColProperty("employeeid", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Pref.Employee", "edittype"=>"select"));
$grid->setSelect("employeeid", "select '' as id, '' as name from dual union SELECT distinct id, name FROM employee where status = '0Active' order by name");
$grid->setColProperty("notes", array("editable"=>true, "width"=>400, "fixed"=>true, "edittype"=>"textarea", "editoptions"=>array("rows"=>6, "cols"=> 60), "label"=>"Notes"));
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Recruiter Management",		
		"rownumbers"=>true,										
    "rowNum"=>100,
    "sortname"=>"id",
		"sortorder"=>"desc",
    //"altRows"=>true,
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100,500),
    ));		
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>false,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Recruiter Management"));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Recruiter","reloadAfterSubmit"=>false));
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
