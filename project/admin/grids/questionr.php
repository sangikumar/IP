<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");

// Create the jqGrid instance
$grid = new jqGridRender($DB);
// Write the SQL Query
$grid->SelectCommand = 'SELECT id,  category, type, subject,question, answer, keywords FROM questions where category not in ("QA-Must", "Vendor", "Java-Must", ".NET-Must")';
// Set the table to where we add the data
$grid->table = 'questions';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
// set the ouput format to json
$grid->dataType = 'json';
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('../grids/questionr.php');
// Change some property of the field(s)
$grid->setColProperty("id", array("editable"=>false, "hidden"=>true, "label"=>"ID"));
$grid->setColProperty("subject", array("editable"=>true, "width"=>100, "fixed"=>true, "label"=>"Subject", "edittype"=>"select"));
$grid->setSelect("subject", $questionsrsubject , false, true, true, array(""=>"All"));	
$grid->setColProperty("category", array("editable"=>true, "width"=>100, "fixed"=>true, "label"=>"Category", "edittype"=>"select"));
$grid->setSelect("category", $questionsrcategory, false, true, true, array(""=>"All"));
$grid->setColProperty("type", array("editable"=>true, "width"=>100, "fixed"=>true, "label"=>"Type", "edittype"=>"select"));
$grid->setSelect("type", $questionsrtype, false, true, true, array(""=>"All"));
$grid->setColProperty("question", array("editable"=>true, "width"=>800, "fixed"=>true, "edittype"=>"textarea","editoptions"=>array("rows"=>6, "cols"=> 80), "label"=>"Question"));
$grid->setAutocomplete("question",null,"select name, name from (select distinct question as name from questions) p where name like ? ORDER BY name",null,true,true);
$grid->setColProperty("answer", array("editable"=>true, "hidden"=>true, "edittype"=>"textarea","editrules"=>array("edithidden"=>true, "required"=>false), "editoptions"=>array("rows"=>6, "cols"=> 80), "label"=>"Answer"));
$grid->setColProperty("keywords", array("editable"=>true, "hidden"=>true, "edittype"=>"textarea","editrules"=>array("edithidden"=>true, "required"=>false), "editoptions"=>array("rows"=>6, "cols"=> 80), "label"=>"Keywords"));
$grid->setAutocomplete("keywords",null,"select name, name from (select distinct keywords as name from questions) p where name like ? ORDER BY name",null,true,true);
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Interview Questions Management",		
		"rownumbers"=>true,										
    "rowNum"=>1000,
		"shrinkToFit"=>false,
    "sortname"=>"category asc, type asc, subject",
		"sortorder"=>"asc",
		"toppager"=>true,
    "rowList"=>array(10,100,500,1000,10000,20000),
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>true,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Interview Questions Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Question","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Question","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, null, null,true,true);
$DB = null;
?>