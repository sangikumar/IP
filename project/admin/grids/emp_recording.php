<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);

$grid->SelectCommand = 'SELECT id,employeeid,description,sessiondate,link,videoid,status,category FROM emp_recording';
$grid->table = 'emp_recording';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('sessiondate');
$grid->setUserDate("Y-m-d"); 
$grid->setColModel();
$grid->setUrl('../grids/emp_recording.php');
$grid->setColProperty("id", array("editable"=>false, "width"=>25, "hidden"=>true, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("employeeid", array("editable"=>true, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Employee", "edittype"=>"select"));
$grid->setSelect("employeeid", "SELECT distinct id, name FROM employee order by name");
$grid->setColProperty("description", array("editable"=>true, "frozen"=>true, "width"=>250, "editoptions"=>array("size"=>75, "maxlength"=>250), "fixed"=>true, "label"=>"Description"));
$grid->setColProperty("sessiondate", array("formatter"=>"date", "width"=>80, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"Session Date", 
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
$grid->setColProperty("link", array("editable"=>true, "frozen"=>true, "width"=>300, "editoptions"=>array("size"=>75, "maxlength"=>300), "formatter"=>"link", "fixed"=>true, "editrules"=>array("url"=>true, "required"=>false), "label"=>"Url"));
$grid->setColProperty("videoid", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Video ID"));																	 
$grid->setColProperty("status", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", array("active"=>"active", "inactive"=>"inactive"), false, true, true, array(""=>"All"));
$grid->setColProperty("category", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Subject", "edittype"=>"select"));
$grid->setSelect("category", $teams, false, true, true, array(""=>"All"));
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>500,
		"caption"=>"Employee Recording Management",		
		"rownumbers"=>true,										
    "rowNum"=>100,
    "sortname"=>"sessiondate desc, description",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100,500),
    ));			
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>false,"excel"=>false,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>250, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Recording","reloadAfterSubmit"=>false));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>250, "viewCaption"=>"Recording Management"));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>250, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Recording","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true,null, null, true,true);
$DB = null;
?>
