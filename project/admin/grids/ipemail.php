<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");

// Create the jqGrid instance
$grid = new jqGridRender($DB);
// Write the SQL Query
$grid->SelectCommand = 'select id, Name, email, phone, password, status, masteremail, forwardingemail, phonestatus, notes from ipemail';
// Set the table to where we add the data
$grid->table = 'ipemail';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
// set the ouput format to json
$grid->dataType = 'json';
$grid->setUserDate("Y-m-d"); 
// Let the grid create the model from SQL query
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('../grids/ipemail.php');
// Change some property of the field(s)
$grid->setColProperty("id", array("editable"=>false, "frozen"=>true, "width"=>40, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("Name", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Name"));
$grid->setColProperty("email", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>true), "label"=>"Email"));
$grid->setColProperty("phone", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Phone"));
$grid->setColProperty("password", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Password"));
$grid->setColProperty("status", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", $ipemailstatus , false, true, true, array(""=>"All"));
$grid->setColProperty("masteremail", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>true), "label"=>"Master Email"));
$grid->setColProperty("forwardingemail", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>true), "label"=>"Fwd Email"));
$grid->setColProperty("phonestatus", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Phone Status", "edittype"=>"select"));
$grid->setSelect("phonestatus", $ipphonestatus , false, true, true, array(""=>"All"));
$grid->setColProperty("notes", array("editable"=>true, "width"=>70, "fixed"=>true, "edittype"=>"textarea","editoptions"=>array("rows"=>6, "cols"=> 80), "label"=>"Notes"));

						
// Set alternate background using altRows property
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"IP Email Management",		
		"rownumbers"=>true,										
    "rowNum"=>100,
    //"userDataOnFooter"=>true,
    //"footerrow"=>true,
		//"shrinkToFit"=>false,
    "sortname"=>"id",
		"sortorder"=>"desc",
    //"altRows"=>true,
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100,500),
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"IP Email Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add IPEmail","bSubmit"=>"Add IP Email", "reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update IPEmail","bSubmit"=>"Update IP Email", "reloadAfterSubmit"=>false));
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
