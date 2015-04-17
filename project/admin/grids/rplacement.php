<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);

$grid->SelectCommand = 'SELECT id, candidateid, mmid, recruiterid,vendorid,clientid,startdate,wrklocation,wrkdesignation,wrkemail,wrkphone,mgrname,mgremail,mgrphone,hiringmgrname,hiringmgremail,hiringmgrphone,reference FROM placement p where status = "0Active"';
$grid->table = 'placement';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('startdate');
$grid->setUserDate("Y-m-d"); 
$grid->setColModel();
$grid->setUrl('../grids/rplacement.php');
$grid->setColProperty("id", array("editable"=>false, "width"=>25, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("candidateid", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Candidate Name", "edittype"=>"select"));
$grid->setSelect("candidateid", "SELECT distinct candidateid as id, name as name FROM candidate order by name");
$grid->setColProperty("mmid", array("editable"=>true, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Manager", "edittype"=>"select"));
$grid->setSelect("mmid", "SELECT distinct id, name FROM employee order by name");
$grid->setColProperty("recruiterid", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Recruiter", "edittype"=>"select"));
$grid->setSelect("recruiterid", "select '' as id, '' as name from dual union SELECT distinct id as id, name as name FROM recruiter order by name");
$grid->setColProperty("vendorid", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Vendor", "edittype"=>"select"));
$grid->setSelect("vendorid", "select '' as id, '' as name from dual union SELECT distinct id as id, companyname as name FROM vendor order by name");
$grid->setColProperty("clientid", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Client", "edittype"=>"select"));
$grid->setSelect("clientid", "select '' as id, '' as name from dual union SELECT distinct id as id, companyname as name FROM client order by name");

$grid->setColProperty("startdate", array("formatter"=>"date", "width"=>80, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"Start Date", 
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
$grid->setColProperty("wrklocation", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Wrk Location"));
$grid->setColProperty("wrkdesignation", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Wrk Designation"));
$grid->setColProperty("wrkemail", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Wrk Email"));
$grid->setColProperty("wrkphone", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Wrk Phone"));
$grid->setColProperty("mgrname", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Mgr Name"));
$grid->setColProperty("mgremail", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Mgr Email"));
$grid->setColProperty("mgrphone", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Mgr Phone"));
$grid->setColProperty("hiringmgrname", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Hiring Mgr Name"));
$grid->setColProperty("hiringmgremail", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Hiring Mgr Email"));
$grid->setColProperty("hiringmgrphone", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Hiring Mgr Phone"));
$grid->setColProperty("reference", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Reference", "edittype"=>"select"));
$grid->setSelect("reference", $yesno, false, true, true, array(""=>"All"));	
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Placement List",		
		"rownumbers"=>true,										
    "rowNum"=>100,
    "footerrow"=>true,
    "userDataOnFooter"=>true,
		"shrinkToFit"=>false,
    "sortname"=>"startdate",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100),
    ));		
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>false,"excel"=>false,"add"=>false,"edit"=>false,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Placement List"));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true,null, null, true,true);
$DB = null;
?>
