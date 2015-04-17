<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");

// Create the jqGrid instance
$grid = new jqGridRender($DB);
// Write the SQL Query
$grid->SelectCommand = 'SELECT id, candidateid, type, first1000, second1000, third1000, everifynumber, resstateid, wrkstateid FROM candidatepayment';
// Set the table to where we add the data
$grid->table = 'candidatepayment';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
// set the ouput format to json
$grid->dataType = 'json';
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('../grids/cpaymentsetup.php');
// Change some property of the field(s)
$grid->setColProperty("id", array("editable"=>false, "hidden"=>true, "label"=>"ID"));
$grid->setColProperty("candidateid", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Candidate Name", "edittype"=>"select"));
$grid->setSelect("candidateid", "SELECT distinct candidateid as id, name as name FROM candidate where candidateid in (select distinct candidateid from placement) order by name");
$grid->setColProperty("type", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Type", "edittype"=>"select"));
$grid->setSelect("type", $paymenttype , false, true, true, array(""=>"All"));																	 
$grid->setColProperty("first1000", array("editable"=>true, "width"=>90, "formatter"=>"currency", "formatoptions"=>array("decimalPlaces"=>2,"thousandsSeparator"=>",","prefix"=>"$"),  "sorttype"=>"currency", "fixed"=>true, "label"=>"First 1000"));
$grid->setColProperty("second1000", array("editable"=>true, "width"=>90, "formatter"=>"currency", "formatoptions"=>array("decimalPlaces"=>2,"thousandsSeparator"=>",","prefix"=>"$"),  "sorttype"=>"currency", "fixed"=>true, "label"=>"Second 1000"));
$grid->setColProperty("third1000", array("editable"=>true, "width"=>90, "formatter"=>"currency", "formatoptions"=>array("decimalPlaces"=>2,"thousandsSeparator"=>",","prefix"=>"$"),  "sorttype"=>"currency", "fixed"=>true, "label"=>"Third 1000"));
$grid->setColProperty("everifynumber", array("editable"=>true, "width"=>150, "fixed"=>true, "label"=>"eVerify"));
$grid->setColProperty("resstateid", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Residence State", "edittype"=>"select"));
$grid->setSelect("resstateid", "SELECT distinct id, name FROM state order by name");
$grid->setColProperty("wrkstateid", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Work State", "edittype"=>"select"));
$grid->setSelect("wrkstateid", "SELECT distinct id, name FROM state order by name");
						
// Set alternate background using altRows property
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Candidate Payment Setup",		
		"rownumbers"=>true,										
    "rowNum"=>100,
		"shrinkToFit"=>false,
    "sortname"=>"candidateid",
		"sortorder"=>"asc",
		"toppager"=>true,
    "rowList"=>array(100,500,1000),
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>300, "viewCaption"=>"Candidate Payment Setup"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>300, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Candidate Payment Setup","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>300, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Candidate Payment Setup","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, null, null,true,true);
$DB = null;
?>