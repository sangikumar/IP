<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);
$grid->SelectCommand = 'SELECT id, name, eventdate, status, type, fee, address, contactname, contactemail, contactphone, feedback, leadscount, notes FROM event';
$grid->table = 'event';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('eventdate');
$grid->setUserDate("Y-m-d"); 
$grid->setColModel();
$grid->setUrl('../grids/event.php');
$grid->setColProperty("id", array("editable"=>false, "width"=>25, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("name", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Name"));
$grid->setColProperty("eventdate", array("formatter"=>"date", "width"=>80, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"Event Date", 
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
$grid->setColProperty("status", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", $eventstatus , false, true, true, array(""=>"All"));			
$grid->setColProperty("type", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Type", "edittype"=>"select"));
$grid->setSelect("type", $eventtype , false, true, true, array(""=>"All"));		
$grid->setColProperty("fee", array("editable"=>true, "width"=>90, "formatter"=>"currency", "formatoptions"=>array("decimalPlaces"=>2,"thousandsSeparator"=>",","prefix"=>"$"), "sorttype"=>"currency", "fixed"=>true, "label"=>"Fee"));
$grid->setColProperty("address", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Address"));
$grid->setColProperty("contactname", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Contact Name"));
$grid->setColProperty("contactemail", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Contact Email"));
$grid->setColProperty("contactphone", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Contact Phone"));
$grid->setColProperty("feedback", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Feedback", "edittype"=>"select"));
$grid->setSelect("feedback", $eventfeedback , false, true, true, array(""=>"All"));
$grid->setColProperty("leadscount", array("editable"=>true, "frozen"=>true, "width"=>50, "fixed"=>true, "label"=>"Leads Count"));
$grid->setColProperty("notes", array("editable"=>true, "width"=>400, "fixed"=>true, "edittype"=>"textarea", "editoptions"=>array("rows"=>6, "cols"=> 60), "label"=>"Notes"));

$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Event Management",		
		"rownumbers"=>true,										
    "rowNum"=>100,
    "sortname"=>"eventdate",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100),
    ));		
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Event Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Event","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Event","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true,null, null, true,true);
$DB = null;
?>
