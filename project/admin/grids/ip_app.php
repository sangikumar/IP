<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");

$grid = new jqGridRender($DB);
// Write the SQL Query
$grid->SelectCommand = 'SELECT id, appname, machinename, start_ts + INTERVAL -8 HOUR as start_ts, active, heartbeat_ts + INTERVAL -8 HOUR as heartbeat_ts, heartbeat_flag from ip_app_mgmt ';
// Set the table to where we add the data
$grid->table = 'ip_app_mgmt';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
// set the ouput format to json
$grid->dataType = 'json';
$grid->setColModel();
$grid->setUrl('../grids/ip_app.php');
$grid->setColProperty("id", array("editable"=>false, "width"=>25, "hidden"=>true, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("appname", array("editable"=>true, "editoptions"=>array("size"=>120, "maxlength"=>200), "frozen"=>true, "width"=>300, "fixed"=>true, "label"=>"AppName"));
$grid->setColProperty("machinename", array("editable"=>true, "width"=>250, "fixed"=>true, "label"=>"MachineName"));
$grid->setColProperty("start_ts", array("editable"=>false, "width"=>140, "fixed"=>true, "label"=>"Start Time"));
$grid->setColProperty("active", array("editable"=>true, "width"=>30, "fixed"=>true, "label"=>"Active", "edittype"=>"select"));
$grid->setSelect("active", $yesno, false, true, true, array(""=>"All"));
$grid->setColProperty(" heartbeat_ts", array("editable"=>false, "fixed"=>true, "width"=>140,  "label"=>"HeartBeat TS"));
$grid->setColProperty("heartbeat_flag", array("editable"=>true, "width"=>30, "fixed"=>true, "label"=>"HB Flag", "edittype"=>"select"));
$grid->setSelect("heartbeat_flag", $yesno, false, true, true, array(""=>"All"));

$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1000,
		"height"=>250,
		"caption"=>"App Management",		
		"rownumbers"=>true,										
    "rowNum"=>100,
    "sortname"=>"appname",
		"toppager"=>true,
    "rowList"=>array(10,100,500),
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>true, "view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"App Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add App","bSubmit"=>"Add App", "reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update App","bSubmit"=>"Update App", "reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
//$conn = null;
$DB=null;
?>