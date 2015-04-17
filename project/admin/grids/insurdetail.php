<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);
// Write the SQL Query
$grid->SelectCommand = 'select id, insuranceid, vendorid, detailprice, link, notes from insurancedetail';
$grid->table = 'insurancedetail';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->setColModel();
$grid->setUrl('../grids/insurdetail.php');
$grid->setColProperty("id", array("editable"=>false, "width"=>25, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("insuranceid", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Insurance", "edittype"=>"select"));
$grid->setSelect("insuranceid", "select '' as id, '' as name from dual union SELECT distinct id as id, name as name FROM insurance order by name");
$grid->setColProperty("vendorid", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Vendor", "edittype"=>"select"));
$grid->setSelect("vendorid", "select '' as id, '' as name from dual union SELECT distinct id as id, companyname as name FROM vendor order by name");
$grid->setColProperty("detailprice", array("editable"=>true, "width"=>90, 
											"formatter"=>"currency", "summaryType"=>"sum", summaryTpl=>"Sum: {0}",
        							"formatoptions"=>array("decimalPlaces"=>2,"thousandsSeparator"=>",","prefix"=>"$"), 
											"sorttype"=>"currency", "fixed"=>true, "label"=>"Price"));
$summaryrows = array("detailprice"=>array("detailprice"=>"SUM"));			
$grid->setColProperty("link", array("editable"=>true, "frozen"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "formatter"=>"link", "fixed"=>true, "editrules"=>array("url"=>true, "required"=>false), "label"=>"Link"));								
$grid->setColProperty("notes", array("editable"=>true, "width"=>400, "fixed"=>true, "edittype"=>"textarea", "editoptions"=>array("rows"=>6, "cols"=> 60), "label"=>"Notes"));																	 
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Insurance Detail Management",		
		"rownumbers"=>true,										
    "rowNum"=>1000,
    "footerrow"=>true,
    "userDataOnFooter"=>true,
		"shrinkToFit"=>false,
    "sortname"=>"detailprice",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(10,50,100,500,1000),
    ));		
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>300, "viewCaption"=>"Insurance Detail Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>300, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Insurance Detail","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>300, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Insurance Detail","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, $summaryrows, null, true,true);
$DB = null;
?>
