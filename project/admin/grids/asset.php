<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");

// Create the jqGrid instance
$grid = new jqGridRender($DB);
// Write the SQL Query
$grid->SelectCommand = 'SELECT id, category, model, serialno, purchasedate, purchaseprice, status, owner, retiredate, notes FROM asset';
$grid->table = 'asset';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('purchasedate','retiredate');
$grid->setUserDate("Y-m-d"); 
$grid->setColModel();
$grid->setUrl('../grids/asset.php');
$grid->setColProperty("id", array("editable"=>false, "width"=>25, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("category", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("category", array("Phone"=>"Phone", "Laptop"=>"Laptop", "Furniture"=>"Furniture", "Vonage"=>"Vonage"), false, true, true, array(""=>"All"));
$grid->setColProperty("model", array("editable"=>true, "width"=>100, "fixed"=>true, "label"=>"Model"));
$grid->setColProperty("serialno", array("editable"=>true, "width"=>120, "fixed"=>true, "label"=>"Serial No."));
$grid->setColProperty("purchasedate", array("formatter"=>"date", "width"=>90, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), 
																	 "editable"=>true, "label"=>"Purchase Date", 
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
$grid->setColProperty("purchaseprice", array("editable"=>true, "width"=>90, 
											"formatter"=>"currency", "summaryType"=>"sum", summaryTpl=>"Sum: {0}",
        							"formatoptions"=>array("decimalPlaces"=>2,"thousandsSeparator"=>",","prefix"=>"$"), 
											"sorttype"=>"currency", "fixed"=>true, "label"=>"Purchase Price"));
$grid->setColProperty("status", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", array("Active"=>"Active", "Lost"=>"Lost", "Damaged"=>"Damaged"), false, true, true, array(""=>"All"));
$summaryrows = array("purchaseprice"=>array("purchaseprice"=>"SUM"));		
$grid->setColProperty("owner", array("editable"=>true, "frozen"=>true, "width"=>150, "fixed"=>true, "label"=>"Owner", "edittype"=>"select"));
$grid->setSelect("owner", "select '' as id, '' as name from dual union SELECT distinct id, name FROM employee where status = '0Active' order by name");			
$grid->setColProperty("retiredate", array("formatter"=>"date", "width"=>90, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), 
																	 "editable"=>true, "label"=>"Retired Date", 
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
$grid->setColProperty("notes", array("editable"=>true, "width"=>400, "fixed"=>true, "edittype"=>"textarea", "editoptions"=>array("rows"=>6, "cols"=> 60), "label"=>"Notes"));																	 
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Asset Management",		
		"rownumbers"=>true,										
    "rowNum"=>1000,
    "footerrow"=>true,
    "userDataOnFooter"=>true,
		"shrinkToFit"=>false,
    "sortname"=>"purchasedate",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(10,50,100,500,1000),
    ));		
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Asset Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Asset","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Asset","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, $summaryrows, null, true,true);
$DB = null;
?>
