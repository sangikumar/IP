<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");

// Create the jqGrid instance
$grid = new jqGridRender($DB);
// Write the SQL Query
$grid->SelectCommand = 'select leadid, name, startdate, email, phone, workstatus, address, city, state, country, zip from leads where status <> "Rejected"';
// Set the table to where we add the data
$grid->table = 'leads';
$grid->setPrimaryKeyId('leadid');
$grid->serialKey = false;
// set the ouput format to json
$grid->dataType = 'json';
$grid->setUserDate("Y-m-d"); 
// Let the grid create the model from SQL query
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('../grids/orientation.php');
// Change some property of the field(s)
$grid->setColProperty("leadid", array("editable"=>false, "hidden"=>true, "label"=>"ID"));
$grid->setColProperty('startdate',   
        array("editable"=>false,"width"=>70, "fixed"=>true,"formatter"=>"date", "label"=>"Start Date", 
				"formatoptions"=>array("srcformat"=>"Y-m-d HH:MM:SS", "newformat"=>"m/d/Y"),
				"searchoptions"=>array("dataInit"=>
			        "js:function(elm){setTimeout(function(){
					 jQuery(elm).datepicker({dateFormat:'yy-mm-dd'});
					 jQuery('.ui-datepicker').css({'font-size':'75%'});
			 },200);}")
				));
$grid->setColProperty("name", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Name"));
$grid->setColProperty("phone", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Phone"));
$grid->setColProperty("email", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>true), "label"=>"Email"));
$grid->setColProperty("workstatus", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"US Status", "edittype"=>"select"));
$grid->setSelect("workstatus", $workauthtype , false, true, true, array(""=>"All"));

																	 
$grid->setColProperty("address", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Address"));
$grid->setColProperty("city", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"City"));
$grid->setColProperty("state", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"State"));
$grid->setColProperty("country", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Country"));
$grid->setColProperty("zip", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Zip"));

					
// Set alternate background using altRows property
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Orientation List",		
		"rownumbers"=>true,										
    "rowNum"=>1000,
    //"userDataOnFooter"=>true,
    //"footerrow"=>true,
    "sortname"=>"startdate",
		"sortorder"=>"desc",
    //"altRows"=>true,
		"toppager"=>true,
    "rowList"=>array(10,50,100,500,1000),
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>false,"edit"=>false,"del"=>false,"view"=>true, "search"=>true));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Orientation List"));
//$grid->toolbarfilter = true;
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$DB = null;
?>
