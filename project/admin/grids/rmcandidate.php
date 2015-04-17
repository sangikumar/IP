<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");

// Create the jqGrid instance
$grid = new jqGridRender($DB);
// Write the SQL Query
$grid->SelectCommand = 'SELECT candidateid, name, email, phone, secondaryemail, secondaryphone, portalid, status, workstatus, education, workexperience, workpermiturl, batchname, RIGHT(ssn, 4) as ssn FROM candidate where status in ("Active", "Mocks", "Marketing", "Placed", "Placed", "OnProject-Mkt")';
// Set the table to where we add the data
$grid->table = 'candidate';
//$grid->setPrimaryKeyId('candidateid');
$grid->serialKey = false;
// set the ouput format to json
$grid->dataType = 'json';
//$grid->datearray = array('enrolleddate','wpexpirationdate');
$grid->setUserDate("Y-m-d"); 
// Let the grid create the model from SQL query
$grid->setColModel();
$grid->setUrl('../grids/rmcandidate.php');
$grid->setColProperty("candidateid", array("editable"=>false, "frozen"=>true, "width"=>25, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("name", array("editable"=>false, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Name"));
$grid->setColProperty("email", array("editable"=>false, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>true), "label"=>"Email"));
$grid->setColProperty("phone", array("editable"=>false, "width"=>90, "fixed"=>true, "label"=>"Phone"));
$grid->setColProperty("status", array("editable"=>false, "width"=>70, "fixed"=>true, "label"=>"Status"));
$grid->setSelect("status", $candidatestatus , false, true, true, array(""=>"All"));
$grid->setColProperty("workstatus", array("editable"=>false, "width"=>70, "fixed"=>true, "label"=>"US Status"));
$grid->setSelect("workstatus", $workauthtype , false, true, true, array(""=>"All"));
$grid->setColProperty("education", array("editable"=>false, "width"=>90, "fixed"=>true, "label"=>"Education"));
$grid->setColProperty("workexperience", array("editable"=>false, "width"=>90, "fixed"=>true, "label"=>"Work Experience"));
$grid->setColProperty("ssn", array("editable"=>false, "width"=>90, "fixed"=>true, "label"=>"SSN"));
$grid->setColProperty("secondaryemail", array("editable"=>false, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Secondary Email"));
$grid->setColProperty("secondaryphone", array("editable"=>false, "width"=>90, "fixed"=>true, "label"=>"Secondary Phone"));
$grid->setColProperty("portalid", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Portal ID", "edittype"=>"select"));
$grid->setSelect("portalid", "select '' as id, '' as name from dual union SELECT distinct id, concat(fullname, '-', uname) as name FROM authuser order by name");							
$grid->setColProperty("workpermiturl", array("editable"=>false, "frozen"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>400), "formatter"=>"link", "fixed"=>true, "editrules"=>array("url"=>true, "required"=>false), "label"=>"Work Permit Url"));
$grid->setColProperty("batchname", array("editable"=>false, "width"=>90, "fixed"=>true, "label"=>"Batch Name"));
$grid->setSelect("batchname", "select distinct batchname as id, batchname as name from batch", false, true, true);				
// Set alternate background using altRows property
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Candidates List",		
		"rownumbers"=>true,										
    "rowNum"=>500,
    "sortname"=>"name",
		"sortorder"=>"asc",
    //"altRows"=>true,
		"toppager"=>true,
    "rowList"=>array(500,1000,5000),
		"grouping"=>true,
    "groupingView"=>array(
    "groupField" => array('batchname'),
    "groupColumnShow" => array(true),
    "groupOrder" => array('desc'),
    "groupText" =>array('<b>{0}</b>'),
    "groupDataSorted" => true)
    ));		
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>false,"excel"=>true,"add"=>false,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>300, "viewCaption"=>"Candidate Management"));
$grid->setNavOptions('edit',array("width"=>500, "dataheight"=>300, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Candidate","reloadAfterSubmit"=>false));
//$grid->toolbarfilter = true;
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, $summaryrows, null, true,true);
$DB = null;
?>
