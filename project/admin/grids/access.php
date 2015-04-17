<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
/*
include_once ("../../ip-config.php");
require_once '../../jq-config.php';
// include the jqGrid Class
require_once ABSPATH."php/jqGrid.php";
// include the driver class
require_once ABSPATH."php/jqGridPdo.php";
// Connection to the server
$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);
$conn->query("SET NAMES utf8");
*/
$grid = new jqGridRender($DB);

$grid->SelectCommand = 'SELECT id,uname,level,instructor,override,status,registereddate,lastlogin,logincount,fullname,address,phone,state,zip,city,country,level3date FROM authuser';
$grid->table = 'authuser';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('registereddate','lastlogin');
$grid->setUserDate("Y-m-d"); 
$grid->setColModel();
$grid->setUrl('../grids/access.php');
$grid->setColProperty("id", array("editable"=>false, "width"=>25, "hidden"=>true, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("uname", array("editable"=>false, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"LoginID"));
$grid->setColProperty("level", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Level", "edittype"=>"select"));
$grid->setSelect("level", array("3"=>"3", "2"=>"2"), false, true, true, array(""=>"All"));
$grid->setColProperty("instructor", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Instructor", "edittype"=>"select"));
$grid->setSelect("instructor", $yesno, false, true, true, array(""=>"All"));
$grid->setColProperty("override", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Override", "edittype"=>"select"));
$grid->setSelect("override", $yesno, false, true, true, array(""=>"All"));
$grid->setColProperty("status", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", array("inactive"=>"inactive", "active"=>"active"), false, true, true, array(""=>"All"));
$grid->setColProperty("registereddate", array("formatter"=>"date", "width"=>80, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>false, "label"=>"Reg Date", 
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
$grid->setColProperty("lastlogin", array("formatter"=>"date", "width"=>80, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>false, "label"=>"Last Login", 
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
$grid->setColProperty("logincount", array("editable"=>false, "frozen"=>true, "width"=>50, "fixed"=>true, "label"=>"Login Count"));	
$grid->setColProperty("fullname", array("editable"=>false, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Full Name"));
$grid->setColProperty("address", array("editable"=>false, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Address"));		
$grid->setColProperty("phone", array("editable"=>false, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Phone"));		
$grid->setColProperty("state", array("editable"=>false, "frozen"=>true, "width"=>90, "fixed"=>true, "label"=>"State"));		
$grid->setColProperty("zip", array("editable"=>false, "frozen"=>true, "width"=>50, "fixed"=>true, "label"=>"Zip"));		
$grid->setColProperty("city", array("editable"=>false, "frozen"=>true, "width"=>90, "fixed"=>true, "label"=>"City"));		
$grid->setColProperty("country", array("editable"=>false, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Country"));
$grid->setColProperty("level3date", array("formatter"=>"date", "width"=>80, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"Level3 Date", 
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
		"height"=>400,
		"caption"=>"Access Management",		
		"rownumbers"=>true,										
    "rowNum"=>100,
    "sortname"=>"lastlogin",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100,500),
    ));			
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>false,"excel"=>false,"add"=>false,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Access Management"));
$grid->setNavOptions('edit',array("width"=>200, "dataheight"=>250, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Access","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true,null, null, true,true);
$DB = null;
?>
