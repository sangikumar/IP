<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$employeeid = $loggedInUser->employeeid;

$grid = new jqGridRender($DB);
$grid->SelectCommand = 'SELECT vc.id, vc.employeeid, vc.recruiterid, r.name, r.phone, vc.meetdate, vc.status, case when r.vendorid = 0 then (select c.companyname from client c where c.id = r.clientid) else (select v.companyname from vendor v where v.id = r.clientid) end as companyname, vc.notes, vc.lastmoddatetime  FROM vendormeet vc inner join recruiter r on vc.recruiterid = r.id';
$grid->table = 'vendormeet';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('meetdate');
$grid->setUserDate("Y-m-d"); 
$grid->setColModel();
$grid->setUrl('../grids/salemeet.php');
$grid->setColProperty("id", array("editable"=>false, "width"=>25, "hidden"=>true, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("recruiterid", array("editable"=>false, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Recruiter", "edittype"=>"select"));
$grid->setSelect("recruiterid", "select null as id, '' as name from dual union SELECT id, email as name FROM recruiter order by name");
$grid->setColProperty("name", array("editable"=>false, "frozen"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Name"));
$grid->setColProperty("phone", array("editable"=>false, "frozen"=>true, "width"=>140, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Phone"));
$grid->setColProperty("companyname", array("editable"=>false, "frozen"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Company Name"));
$grid->setColProperty("employeeid", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Employee", "edittype"=>"select"));
$grid->setSelect("employeeid", "select '' as id, '' as name from dual union SELECT distinct id, name FROM employee where status = '0Active' order by name");
$grid->setColProperty("meetdate", array("formatter"=>"date", "width"=>70, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d", "elmprefix"=>" ", "rowpos"=>5, "colpos"=>1), 
																	 "editable"=>true, "label"=>"Meet Date", 
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
$grid->setColProperty("status", array("editable"=>true, "width"=>50, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", $interviewstatus, false, true, true, array(""=>"All"));	
$grid->setColProperty("notes", array("editable"=>true, "width"=>400, "fixed"=>true,"hidden"=>true, "edittype"=>"textarea","editrules"=>array("edithidden"=>true, "required"=>false), "editoptions"=>array("rows"=>6, "cols"=> 60), "label"=>"Notes"));
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Sale Meets Management",		
		"rownumbers"=>true,										
    "rowNum"=>100,
    "sortname"=>"lastmoddatetime",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100),
    ));		
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>false,"edit"=>false,"del"=>true,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>300, "viewCaption"=>"Sale Meets Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>300, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Sale Meet","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>300, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Sale Meet","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true,null, null, true,true);
$DB = null;
?>