<?php
include_once ("../ip-config.php");
require_once '../jq-config.php';
// include the jqGrid Class
require_once ABSPATH."php/jqGrid.php";
// include the driver class
require_once ABSPATH."php/jqGridPdo.php";
// Connection to the server
$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);
// Tell the db that we use utf-8
$conn->query("SET NAMES utf8");

// Create the jqGrid instance
$grid = new jqGridRender($conn);
// Write the SQL Query
$grid->SelectCommand = 'SELECT id, name, startdate, type, email, phone, url, address, secondaryemail, priority, status, calls, relocation, preferredlocation, fee, closedate, notes FROM recruit';
// Set the table to where we add the data
$grid->table = 'recruit';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
// set the ouput format to json
$grid->dataType = 'json';
$grid->datearray = array('startdate','closedate');
$grid->setUserDate("Y-m-d"); 
// Let the grid create the model from SQL query
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('recruit.php');
// Change some property of the field(s)

$grid->setColProperty("id", array("editable"=>false, "width"=>25, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("name", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Name"));
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
$grid->setColProperty("type", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Type", "edittype"=>"select"));
$grid->setSelect("type", $recruittype , false, true, true, array(""=>"All"));		
$grid->setColProperty("email", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Email"));
$grid->setColProperty("phone", array("editable"=>true, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Phone"));
$grid->setColProperty("url", array("editable"=>true, "frozen"=>true, "width"=>400, "formatter"=>"link", "fixed"=>true, "editrules"=>array("url"=>true, "required"=>false), "label"=>"URL"));
$grid->setColProperty("address", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Address"));
$grid->setColProperty("secondaryemail", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Sec Email"));
$grid->setColProperty("priority", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Priority", "edittype"=>"select"));
$grid->setSelect("priority", $recruitpriority , false, true, true, array(""=>"All"));		
$grid->setColProperty("status", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", $recruitstatus , false, true, true, array(""=>"All"));				
$grid->setColProperty("calls", array("editable"=>true, "width"=>70, "fixed"=>true, "editrules"=>array("minValue"=>0, "maxValue"=>10), "label"=>"Calls"));
$grid->setColProperty("relocation", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Relocation", "edittype"=>"select"));
$grid->setSelect("relocation", $yesno , false, true, true, array(""=>"All"));		
$grid->setColProperty("preferredlocation", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Pref. Location"));
$grid->setColProperty("fee", array("editable"=>true, "width"=>70, "fixed"=>true, "editrules"=>array("minValue"=>0, "maxValue"=>10), "label"=>"Fee"));
$grid->setColProperty("closedate", array("formatter"=>"date", "width"=>80, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"Close Date", 
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
		"caption"=>"Recruit Management",		
		"rownumbers"=>true,										
    "rowNum"=>100,
    "footerrow"=>true,
    "userDataOnFooter"=>true,
		"shrinkToFit"=>false,
    "sortname"=>"startdate",
		"sortorder"=>"desc",
    //"altRows"=>true,
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100),
    ));		
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Recruit Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Recruit","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Recruit","reloadAfterSubmit"=>false));
//$grid->toolbarfilter = true;
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true,null, null, true,true);
$conn = null;
?>