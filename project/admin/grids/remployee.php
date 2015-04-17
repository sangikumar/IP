<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);
$grid->SelectCommand = 'SELECT id, name, email, phone, personalemail, personalphone, mgrid, dob, address, city, state, country, zip, skypeid FROM employee where status = "0Active"';
$grid->table = 'employee';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->setColModel();
$grid->setUrl('../grids/remployee.php');
$grid->setColProperty("id", array("editable"=>false, "width"=>25, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("name", array("editable"=>false, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Name"));
$grid->setColProperty("email", array("editable"=>false, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>true), "label"=>"Email"));
$grid->setColProperty("phone", array("editable"=>false, "width"=>90, "fixed"=>true, "label"=>"Phone"));
$grid->setColProperty("personalemail", array("editable"=>false, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Personal Email"));
$grid->setColProperty("personalphone", array("editable"=>false, "width"=>90, "fixed"=>true, "label"=>"Personal Phone"));
$grid->setColProperty("mgrid", array("editable"=>false, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Manager", "edittype"=>"select"));
$grid->setSelect("mgrid", "select '' as id, '' as name from dual union SELECT distinct id, name FROM employee where status = '0Active' order by name");
$grid->setColProperty("dob", array("formatter"=>"date", "width"=>70, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), 
																	 "editable"=>false, "label"=>"Birth Date", 
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
$grid->setColProperty("address", array("editable"=>false, "width"=>150, "fixed"=>true, "label"=>"Address"));
$grid->setColProperty("city", array("editable"=>false, "width"=>90, "fixed"=>true, "label"=>"City"));
$grid->setColProperty("state", array("editable"=>false, "width"=>90, "fixed"=>true, "label"=>"State"));
$grid->setColProperty("country", array("editable"=>false, "width"=>90, "fixed"=>true, "label"=>"Country"));
$grid->setColProperty("zip", array("editable"=>false, "width"=>90, "fixed"=>true, "label"=>"Zip"));
$grid->setColProperty("skypeid", array("editable"=>false, "width"=>90, "fixed"=>true, "label"=>"Skype"));
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>400,
		"caption"=>"Employee List",		
		"rownumbers"=>true,										
    "rowNum"=>100,
    "sortname"=>"type asc, name",
		"sortorder"=>"asc",
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100),
    ));		
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>false,"excel"=>true,"add"=>false,"edit"=>false,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Employee List"));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, $summaryrows, null, true,true);
$DB = null;
?>