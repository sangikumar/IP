<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");

// Create the jqGrid instance
$grid = new jqGridRender($DB);
// Write the SQL Query
$grid->SelectCommand = 'select id, email, password, type, lastuseddate, masteremail, forwardingemail, status from clr_emails';
// Set the table to where we add the data
$grid->table = 'clr_emails';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
// set the ouput format to json
$grid->dataType = 'json';
$grid->setUserDate("Y-m-d"); 
// Let the grid create the model from SQL query
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('../grids/clr_email.php');
// Change some property of the field(s)
$grid->setColProperty("id", array("editable"=>false, "frozen"=>true, "width"=>40, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("email", array("editable"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>true), "label"=>"Email"));
$grid->setColProperty("password", array("editable"=>true, "width"=>90, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Password"));
$grid->setColProperty("type", array("editable"=>true, "width"=>40, "fixed"=>true, "label"=>"Type"));
$grid->setColProperty("masteremail", array("editable"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>true), "label"=>"Master Email"));
$grid->setColProperty("forwardingemail", array("editable"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>true), "label"=>"Fwd Email"));
$grid->setColProperty("status", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("lastuseddate", array("formatter"=>"date", "width"=>70, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"),
	"editable"=>false, "label"=>"Last Used Date",
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
$grid->setGridOptions(array(
	"sortable"=>true,
	"width"=>1024,
	"height"=>500,
	"caption"=>"Crawler Email Management",
	"rownumbers"=>true,
	"rowNum"=>100,
	"sortname"=>"lastuseddate",
	"sortorder"=>"desc",
	"toppager"=>true,
	"rowList"=>array(10,20,30,50,100,500),
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>300, "viewCaption"=>"Crawler Email Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>300, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Crawler","bSubmit"=>"Add Crawler Email", "reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>300, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Crawler","bSubmit"=>"Update Crawler Email", "reloadAfterSubmit"=>false));
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
