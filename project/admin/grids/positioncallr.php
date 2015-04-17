<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");

// Create the jqGrid instance
$grid = new jqGridRender($DB);
// Write the SQL Query
$grid->SelectCommand = 'SELECT pc.id, pc.candidateid, pc.positiondate, pc.status, pc.solicitation, pc.vendorcompany, pc.vendoremail, pc.client, pc.clientemail, pc.notes FROM positioncalls pc';
$grid->table = 'positioncalls';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('positiondate');
$grid->setUserDate("Y-m-d"); 
$grid->setColModel();
$grid->setUrl('../grids/positioncallr.php');
$grid->setColProperty("id", array("editable"=>false, "hidden"=>true, "label"=>"ID"));
$grid->setColProperty("candidateid", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Candidate Name", "edittype"=>"select"));
$grid->setSelect("candidateid", "SELECT distinct candidateid as id, name as name FROM candidate");
$grid->setColProperty("positiondate", array("formatter"=>"date", "width"=>100, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"Position Date", 
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
$grid->setColProperty("status", array("editable"=>true, "width"=>120, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", array("Cleared"=>"Cleared", "Rejected by Me"=>"Rejected by Me", "Rejected By Vendor"=>"Rejected By Vendor", "Rejected By Client"=>"Rejected By Client"), false, true, true, array(""=>"All"));
$grid->setColProperty("vendorcompany", array("editable"=>true, "width"=>120, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Vendor1"));
$grid->setColProperty("vendoremail", array("editable"=>true, "width"=>200, "fixed"=>true, "editoptions"=>array("size"=>75, "maxlength"=>200), "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Vendor1 Email"));
$grid->setColProperty("client", array("editable"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Client"));
$grid->setColProperty("clientemail", array("editable"=>true, "width"=>150, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Client Email"));
$grid->setColProperty("solicitation", array("editable"=>true, "label"=>"Solicitation", "width"=>50, "fixed"=>true,  "edittype"=>"select"));
$grid->setSelect("solicitation", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("notes", array("editable"=>true, "width"=>70, "fixed"=>true, "edittype"=>"textarea","editoptions"=>array("rows"=>6, "cols"=> 80), "label"=>"Notes"));

$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Calls Management",		
		"rownumbers"=>true,										
    "rowNum"=>1000,
		"shrinkToFit"=>false,
    "sortname"=>"positiondate",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(500,1000),
    ));		
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>false,"excel"=>false,"add"=>false,"edit"=>false,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Calls List"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Candidate","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Candidate","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$DB = null;
?>
