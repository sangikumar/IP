<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");

// Create the jqGrid instance
$grid = new jqGridRender($DB);
// Write the SQL Query
$grid->SelectCommand = 'SELECT id, type, name, policynumber, effectivedate, insurancelimit, applytype, price, enddate, link, notes FROM insurance';
$grid->table = 'insurance';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('purchasedate','retiredate');
$grid->setUserDate("Y-m-d"); 
$grid->setColModel();
$grid->setUrl('../grids/insurance.php');
$grid->setColProperty("id", array("editable"=>false, "width"=>25, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("type", array("editable"=>true, "width"=>250, "fixed"=>true, "label"=>"Type"));
$grid->setColProperty("name", array("editable"=>true, "width"=>250, "fixed"=>true, "label"=>"Name"));
$grid->setColProperty("policynumber", array("editable"=>true, "width"=>120, "fixed"=>true, "label"=>"Policy No."));
$grid->setColProperty("effectivedate", array("formatter"=>"date", "width"=>90, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), 
																	 "editable"=>true, "label"=>"Effective Date", 
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
$grid->setColProperty("insurancelimit", array("editable"=>true, "width"=>120, "fixed"=>true, "label"=>"Limit"));
$grid->setColProperty("applytype", array("editable"=>true, "width"=>120, "fixed"=>true, "label"=>"Apply Type"));																	 
$grid->setColProperty("price", array("editable"=>true, "width"=>90, 
											"formatter"=>"currency", "summaryType"=>"sum", summaryTpl=>"Sum: {0}",
        							"formatoptions"=>array("decimalPlaces"=>2,"thousandsSeparator"=>",","prefix"=>"$"), 
											"sorttype"=>"currency", "fixed"=>true, "label"=>"Price"));
$summaryrows = array("price"=>array("price"=>"SUM"));		
$grid->setColProperty("enddate", array("formatter"=>"date", "width"=>90, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), 
																	 "editable"=>true, "label"=>"End Date", 
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
$grid->setColProperty("link", array("editable"=>true, "frozen"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "formatter"=>"link", "formatoptions"=>array("target"=>"_blank"), "fixed"=>true, "editrules"=>array("url"=>true, "required"=>false), "label"=>"Link"));																	 
$grid->setColProperty("notes", array("editable"=>true, "width"=>400, "fixed"=>true, "edittype"=>"textarea", "editoptions"=>array("rows"=>6, "cols"=> 60), "label"=>"Notes"));																	 
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Insurance Management",		
		"rownumbers"=>true,										
    "rowNum"=>1000,
    "footerrow"=>true,
    "userDataOnFooter"=>true,
		"shrinkToFit"=>false,
    "sortname"=>"id",
		"sortorder"=>"asc",
		"toppager"=>true,
    "rowList"=>array(10,50,100,500,1000),
    ));		
$grid->setSubGrid("insurancedetail.php", 
        array('id', 'vendor', 'detailprice', 'link', 'notes'), 
        array(60,250,150,200,400), 
        array('left','left','left','left','left')); 		
$grid->showError = true;
$grid->navigator = true;

$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>300, "viewCaption"=>"Insurance Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>300, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Insurance","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>300, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Insurance","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, $summaryrows, null, true,true);
$DB = null;
?>
