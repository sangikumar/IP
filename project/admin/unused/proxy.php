<?php
include_once ("../ip-config.php");
require_once '../jq-config.php';
require_once ABSPATH."php/jqGrid.php";
require_once ABSPATH."php/jqAutocomplete.php";
require_once ABSPATH."php/jqGridPdo.php";
$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);
$conn->query("SET NAMES utf8");
$grid = new jqGridRender($conn);
$grid->SelectCommand = 'SELECT id, startdate, name, email, phone, wrkemail, wrkphone, status, communication, notes FROM proxy';
$grid->table = 'proxy';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('startdate');
$grid->setUserDate("Y-m-d"); 
$grid->setColModel();
$grid->setUrl('proxy.php');
$grid->setColProperty("id", array("editable"=>false, "width"=>25, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty('startdate',   
        array("editable"=>false,"width"=>70, "fixed"=>true,"formatter"=>"date", "label"=>"Start Date", 
				"formatoptions"=>array("srcformat"=>"Y-m-d HH:MM:SS", "newformat"=>"m/d/Y"),
				"searchoptions"=>array("dataInit"=>
			        "js:function(elm){setTimeout(function(){
					 jQuery(elm).datepicker({dateFormat:'yy-mm-dd'});
					 jQuery('.ui-datepicker').css({'font-size':'75%'});
			 },200);}")
				));
$grid->setColProperty("name", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Name"));
$grid->setAutocomplete("name",null,"select name, name from (SELECT distinct name FROM leads union select distinct name from candidate union select distinct name from recruit) p where name like ? ORDER BY name",null,true,true);
$grid->setColProperty("email", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>true), "label"=>"Email"));
$grid->setAutocomplete("email",null,"select email, email from (SELECT distinct email FROM leads union select distinct email from candidate union select distinct email from recruit) p where email like ? ORDER BY email",null,true,true);
$grid->setColProperty("phone", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Phone"));
$grid->setAutocomplete("phone",null,"select phone, phone from (SELECT distinct phone FROM leads union select distinct phone from candidate union select distinct phone from recruit) p where phone like ? ORDER BY phone",null,true,true);
$grid->setColProperty("wrkemail", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Wrk Email"));
$grid->setAutocomplete("wrkemail",null,"select wrkemail, wrkemail from (SELECT distinct wrkemail FROM placement) p where wrkemail like ? ORDER BY wrkemail",null,true,true);
$grid->setColProperty("wrkphone", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Wrk Phone"));
$grid->setAutocomplete("wrkphone",null,"select wrkphone, wrkphone from (SELECT distinct wrkphone FROM placement) p where wrkphone like ? ORDER BY wrkphone",null,true,true);
$grid->setColProperty("status", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", $referencestatus , false, true, true, array(""=>"All"));
$grid->setColProperty("communication", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Communication", "edittype"=>"select"));
$grid->setSelect("communication", $communication , false, true, true, array(""=>"All"));
$grid->setColProperty("notes", array("editable"=>true, "width"=>400, "fixed"=>true, "edittype"=>"textarea", "editoptions"=>array("rows"=>6, "cols"=> 60), "label"=>"Notes"));

$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Proxy Management",		
		"rownumbers"=>true,										
    "rowNum"=>100,
    "sortname"=>"status asc, startdate",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100),
    ));		
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Proxy Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Proxy","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Proxy","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true,null, null, true,true);
$conn = null;
?>
