<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);
$grid->SelectCommand = 'select employeeid, machinename, tvid, tvpassword, notes from empmachine';
$grid->table = 'empmachine';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->setUserDate("Y-m-d"); 
$grid->setColModel();
$grid->setUrl('../grids/empmachine.php');
$grid->setColProperty("employeeid", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Employee", "edittype"=>"select"));
$grid->setSelect("employeeid", "select 0 as id, 'None' as name from dual union select id, name from employee where status = '0Active'");
$grid->setColProperty("machinename", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Machine Name"));
$grid->setColProperty("tvid", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"TV ID"));
$grid->setColProperty("tvpassword", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"TV Password"));
$grid->setColProperty("notes", array("editable"=>true, "width"=>400, "fixed"=>true, "edittype"=>"textarea","editoptions"=>array("rows"=>6, "cols"=> 80), "label"=>"Notes"));

$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Employee Machine Management",		
		"rownumbers"=>true,										
    "rowNum"=>30,
    "sortname"=>"machinename",
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100),
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>true,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Employee Machine Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Employee Machine","bSubmit"=>"Add Machine", "reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Employee Machine","bSubmit"=>"Update Machine", "reloadAfterSubmit"=>false));
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