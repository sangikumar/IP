<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");

// Create the jqGrid instance
$grid = new jqGridRender($DB);
// Write the SQL Query
$grid->SelectCommand = 'select machinename, type, ipaddress, teamviewerid, teamviewerpass, adminuser, adminpass, vm, vmtvid, vmtvpass, notes from lab';
// Set the table to where we add the data
$grid->table = 'lab';
$grid->setPrimaryKeyId('machinename');
$grid->serialKey = false;
// set the ouput format to json
$grid->dataType = 'json';
$grid->setUserDate("Y-m-d"); 
// Let the grid create the model from SQL query
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('../grids/lab.php');
// Change some property of the field(s)
$grid->setColProperty("machinename", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Name"));
$grid->setColProperty("type", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Type", "edittype"=>"select"));
$grid->setSelect("type", $machinetype , false, true, true, array(""=>"All"));
$grid->setColProperty("ipaddress", array("editable"=>true, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"IP Address"));
$grid->setColProperty("teamviewerid", array("editable"=>true, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"TV ID"));
$grid->setColProperty("teamviewerpass", array("editable"=>true, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"TV Password"));
$grid->setColProperty("adminuser", array("editable"=>true, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Admin UserName"));
$grid->setColProperty("adminpass", array("editable"=>true, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Admin Password"));
$grid->setColProperty("vm", array("editable"=>true, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"VM"));
$grid->setColProperty("vmtvid", array("editable"=>true, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"VM TV ID"));
$grid->setColProperty("vmtvpass", array("editable"=>true, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"VM TV Pass"));
$grid->setColProperty("printer", array("editable"=>true, "frozen"=>true, "width"=>70, "fixed"=>true, "label"=>"Printer",  "edittype"=>"select"));
$grid->setSelect("printer", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("skype", array("editable"=>true, "frozen"=>true, "width"=>70, "fixed"=>true, "label"=>"Skype",  "edittype"=>"select"));
$grid->setSelect("skype", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("webinar", array("editable"=>true, "frozen"=>true, "width"=>70, "fixed"=>true, "label"=>"Webinar",  "edittype"=>"select"));
$grid->setSelect("webinar", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("emule", array("editable"=>true, "frozen"=>true, "width"=>70, "fixed"=>true, "label"=>"Emule",  "edittype"=>"select"));
$grid->setSelect("emule", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("oracle", array("editable"=>true, "frozen"=>true, "width"=>70, "fixed"=>true, "label"=>"Oracle",  "edittype"=>"select"));
$grid->setSelect("oracle", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("jdk", array("editable"=>true, "frozen"=>true, "width"=>70, "fixed"=>true, "label"=>"JDK",  "edittype"=>"select"));
$grid->setSelect("jdk", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("eclipse", array("editable"=>true, "frozen"=>true, "width"=>70, "fixed"=>true, "label"=>"Eclipse",  "edittype"=>"select"));
$grid->setSelect("eclipse", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("soapui", array("editable"=>true, "frozen"=>true, "width"=>70, "fixed"=>true, "label"=>"SOAPUI",  "edittype"=>"select"));
$grid->setSelect("soapui", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("visualstudio", array("editable"=>true, "frozen"=>true, "width"=>70, "fixed"=>true, "label"=>"VisualStudio",  "edittype"=>"select"));
$grid->setSelect("visualstudio", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("qtp", array("editable"=>true, "frozen"=>true, "width"=>70, "fixed"=>true, "label"=>"QTP",  "edittype"=>"select"));
$grid->setSelect("qtp", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("qc", array("editable"=>true, "frozen"=>true, "width"=>70, "fixed"=>true, "label"=>"QC",  "edittype"=>"select"));
$grid->setSelect("qc", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("lr", array("editable"=>true, "frozen"=>true, "width"=>70, "fixed"=>true, "label"=>"LR",  "edittype"=>"select"));
$grid->setSelect("lr", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("api", array("editable"=>true, "frozen"=>true, "width"=>70, "fixed"=>true, "label"=>"API's",  "edittype"=>"select"));
$grid->setSelect("api", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("notes", array("editable"=>true, "width"=>400, "fixed"=>true, "edittype"=>"textarea","editoptions"=>array("rows"=>6, "cols"=> 80), "label"=>"Notes"));

						
// Set alternate background using altRows property
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Lab Management",		
		"rownumbers"=>true,										
    "rowNum"=>30,
    //"userDataOnFooter"=>true,
    //"footerrow"=>true,
		//"shrinkToFit"=>false,
    "sortname"=>"machinename",
    //"altRows"=>true,
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100),
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>true,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Lab Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Machine","bSubmit"=>"Add Machine", "reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Machine","bSubmit"=>"Update Machine", "reloadAfterSubmit"=>false));
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
