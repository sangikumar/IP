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
$userid = $_GET['userid'];
$grid = new jqGridRender($conn);

$grid->SelectCommand = 'SELECT td.id, td.poid, DATE_SUB(weekenddate, INTERVAL WEEKDAY(weekenddate) DAY) as weekstartdate, td.weekenddate, td.monday, td.tuesday, td.wednesday, td.thursday, td.friday, td.saturday, td.sunday, case when (td.monday+td.tuesday+td.wednesday+td.thursday+td.friday+td.saturday+td.sunday) - 40 > 0 then (td.monday+td.tuesday+td.wednesday+td.thursday+td.friday+td.saturday+td.sunday) - 40 else 0 end as overtime, (td.monday+td.tuesday+td.wednesday+td.thursday+td.friday+td.saturday+td.sunday) as total, td.notes FROM timesheetdetail td, po o, placement p, candidate c where td.poid = o.id and o.placementid = p.id and p.candidateid = c.candidateid and c.portalid = "'. $userid .'"';
$grid->table = 'timesheetdetail';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('tdate');
$grid->setUserDate("Y-m-d"); 
$grid->setColModel();
$grid->setUrl('timesheetdetail.php?userid='.$userid);
$grid->setColProperty("id", array("editable"=>false, "width"=>25, "fixed"=>true, "hidden"=>true, "label"=>"ID"));
$grid->setColProperty("poid", array("editable"=>true, "frozen"=>true, "hidden"=>false, "width"=>45, "fixed"=>true, "label"=>"PID", "edittype"=>"select"));
$grid->setSelect("poid", "select max(o.id) as id, max(o.id) as name from candidate c, placement p, po o where c.candidateid = p.candidateid and o.placementid = p.id and c.portalid = $userid and o.begindate < CURDATE()");
$grid->setColProperty("weekstartdate", array("editable"=>false, "width"=>120, "fixed"=>true, "hidden"=>false, "label"=>"Week Start Date"));
$grid->setColProperty("weekenddate", array("formatter"=>"date", "width"=>120, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"Week End Date <span style='color:red'><b>(Should be Sunday)</b></span>", 
																	 "editoptions"=>array("alt"=>"This should be Sunday always", "dataInit"=>
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
$grid->setColProperty("monday", array("editable"=>true, "width"=>60, "fixed"=>true, "formatter"=>"integer", "editrules"=>array("minValue"=>0, "maxValue"=>12), "label"=>"Monday"));
$grid->setColProperty("tuesday", array("editable"=>true, "width"=>60, "fixed"=>true, "formatter"=>"integer", "editrules"=>array("minValue"=>0, "maxValue"=>12), "label"=>"Tuesday"));
$grid->setColProperty("wednesday", array("editable"=>true, "width"=>60, "fixed"=>true, "formatter"=>"integer", "editrules"=>array("minValue"=>0, "maxValue"=>12), "label"=>"Wednesday"));
$grid->setColProperty("thursday", array("editable"=>true, "width"=>60, "fixed"=>true, "formatter"=>"integer", "editrules"=>array("minValue"=>0, "maxValue"=>12), "label"=>"Thursday"));
$grid->setColProperty("friday", array("editable"=>true, "width"=>60, "fixed"=>true, "formatter"=>"integer", "editrules"=>array("minValue"=>0, "maxValue"=>12), "label"=>"Friday"));
$grid->setColProperty("saturday", array("editable"=>true, "width"=>60, "fixed"=>true, "formatter"=>"integer", "editrules"=>array("minValue"=>0, "maxValue"=>12), "label"=>"Saturday"));
$grid->setColProperty("sunday", array("editable"=>true, "width"=>60, "fixed"=>true, "formatter"=>"integer", "editrules"=>array("minValue"=>0, "maxValue"=>12), "label"=>"Sunday"));
$grid->setColProperty("overtime", array("editable"=>false, "width"=>60, "fixed"=>true, "label"=>"Overtime"));
$grid->setColProperty("total", array("editable"=>false, "summaryType"=>"sum", "width"=>70, "fixed"=>true, "hidden"=>false, "label"=>"Total"));
$grid->setColProperty("notes", array("editable"=>true, "width"=>400, "fixed"=>true, "edittype"=>"textarea", "editoptions"=>array("rows"=>6, "cols"=>20), "label"=>"Notes"));
$summaryrows = array("total"=>array("monday+tuesday+wednesday+thursday+friday+saturday+sunday"=>"SUM"));		
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Timesheet Hours",		
		"rownumbers"=>true,										
    "rowNum"=>500,
    "footerrow"=>true,
    "userDataOnFooter"=>true,
		"shrinkToFit"=>false,		
    "sortname"=>"weekenddate",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(100,500,1000,2000),
    ));		
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>400, "dataheight"=>350, "viewCaption"=>"Timesheet Management"));
$grid->setNavOptions('add',array("width"=>400, "dataheight"=>350, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Time","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>400, "dataheight"=>350, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Time","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, $summaryrows, null, true,true);
$conn = null;
?>
