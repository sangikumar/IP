<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);
$grid->SelectCommand = 'select id, site, status, crawl, crawldate from rec_crawler_site';
$grid->table = 'rec_crawler_site';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->setUserDate("Y-m-d"); 
$grid->setColModel();
$grid->setUrl('../grids/rec_crawler.php');
$grid->setColProperty("id", array("editable"=>false, "frozen"=>true, "hidden"=>true, "width"=>40, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("site", array("editable"=>true, "frozen"=>true, "width"=>600, "editoptions"=>array("size"=>75, "maxlength"=>400), "formatter"=>"link", "formatoptions"=>array("target"=>"_blank"), "fixed"=>true, "editrules"=>array("url"=>true, "required"=>false), "label"=>"Site"));
$grid->setColProperty("status", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", array("A"=>"A", "N"=>"N"), false, true, true, array(""=>"All"));
$grid->setColProperty("crawl", array("editable"=>true, "width"=>120, "fixed"=>true, "label"=>"Crawl Domain", "edittype"=>"select"));
$grid->setSelect("crawl", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("crawldate", array("formatter"=>"date", "width"=>70, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), 
																	 "editable"=>true, "label"=>"Crawl Date", 
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
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Crawler Site Management",		
		"rownumbers"=>true,										
    "rowNum"=>100,
    "sortname"=>"id",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100,500),
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>250, "viewCaption"=>"Crawler Site Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>250, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Crawler","bSubmit"=>"Add Crawler Site", "reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>250, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Crawler","bSubmit"=>"Update Crawler Site", "reloadAfterSubmit"=>false));
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
