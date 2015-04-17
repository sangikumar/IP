<?php
include_once ("../ip-config.php");
require_once '../jq-config.php';
// include the jqGrid Class
require_once ABSPATH."php/jqGrid.php";
// include the driver class
require_once ABSPATH."php/jqGridPdo.php";
// Connection to the server
$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);
$conn->query("SET NAMES utf8");
$grid = new jqGridRender($conn);
$grid->SelectCommand = 'select poid, nextinvoicedate from (select p.id as poid, DATE_ADD(p.invoicestartdate, INTERVAL p.invoicefreq DAY) as nextinvoicedate from po p  where p.invoicestartdate is not null  and p.id not in (select i.poid from invoice i)) inv where inv.nextinvoicedate <= CURDATE() union select poid,  nextinvoicedate from ( select i.poid, DATE_ADD(i.invoicedate, INTERVAL p.invoicefreq DAY) as nextinvoicedate   from invoice i, po p  where i.poid = p.id  and i.invoicedate = (SELECT max(invoicedate) FROM invoice where poid = i.poid)) inv  where inv.nextinvoicedate <= CURDATE()';
$grid->table = 'invoice';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('nextinvoicedate');
$grid->setUserDate("Y-m-d"); 
$grid->setColModel();
$grid->setUrl('invoicetodo.php');
$grid->setColProperty("poid", array("editable"=>true, "frozen"=>true, "hidden"=>false, "width"=>400, "fixed"=>true, "label"=>"POID", "edittype"=>"select"));
$grid->setSelect("poid", "select o.id, concat(c.name, '-', v.companyname, '-', cl.companyname) as name from candidate c, placement p, po o, vendor v, client cl where c.candidateid = p.candidateid and o.placementid = p.id and p.vendorid = v.id and p.clientid = cl.id");
$grid->setColProperty("nextinvoicedate", array("formatter"=>"date", "width"=>120, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>false, "label"=>"Todo Date", 
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
		"caption"=>"Invoice Todo Management",		
		"rownumbers"=>true,										
    "rowNum"=>100,
    "sortname"=>"nextinvoicedate",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(10,100,500),
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>false,"edit"=>false,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>700, "dataheight"=>500, "viewCaption"=>"Invoice Todo Management"));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$conn = null;
?>
