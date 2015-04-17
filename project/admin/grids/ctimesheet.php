<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$userid = $_GET['userid'];
$grid = new jqGridRender($DB);

$grid->SelectCommand = 'SELECT td.id, td.poid, DATE_SUB(weekenddate, INTERVAL WEEKDAY(weekenddate) DAY) as weekstartdate, td.weekenddate, td.monday, td.tuesday, td.wednesday, td.thursday, td.friday, td.saturday, td.sunday, case when (td.monday+td.tuesday+td.wednesday+td.thursday+td.friday+td.saturday+td.sunday) - 40 > 0 then (td.monday+td.tuesday+td.wednesday+td.thursday+td.friday+td.saturday+td.sunday) - 40 else 0 end as overtime, (td.monday+td.tuesday+td.wednesday+td.thursday+td.friday+td.saturday+td.sunday) as total, td.status, td.notes FROM timesheetdetail td, po o, placement p, candidate c where td.poid = o.id and o.placementid = p.id and p.candidateid = c.candidateid';
$grid->table = 'timesheetdetail';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('tdate');
$grid->setUserDate("Y-m-d"); 
$grid->setColModel();
$grid->setUrl('../grids/ctimesheet.php');
$grid->setColProperty("id", array("editable"=>false, "width"=>25, "fixed"=>true, "hidden"=>true, "label"=>"ID"));
$grid->setColProperty("poid", array("editable"=>true, "frozen"=>true, "hidden"=>false, "width"=>45, "fixed"=>true, "label"=>"POID", "edittype"=>"select"));
$grid->setSelect("poid", "select o.id, concat(c.name, '-', v.companyname, '-', cl.companyname) as name from candidate c, placement p, po o, vendor v, client cl where c.candidateid = p.candidateid and o.placementid = p.id and p.vendorid = v.id and p.clientid = cl.id order by name");
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
$grid->setColProperty("monday", array("editable"=>true, "width"=>40, "fixed"=>true, "formatter"=>"integer", "editrules"=>array("minValue"=>0, "maxValue"=>12), "label"=>"Mon"));
$grid->setColProperty("tuesday", array("editable"=>true, "width"=>40, "fixed"=>true, "formatter"=>"integer", "editrules"=>array("minValue"=>0, "maxValue"=>12), "label"=>"Tue"));
$grid->setColProperty("wednesday", array("editable"=>true, "width"=>40, "fixed"=>true, "formatter"=>"integer", "editrules"=>array("minValue"=>0, "maxValue"=>12), "label"=>"Wed"));
$grid->setColProperty("thursday", array("editable"=>true, "width"=>40, "fixed"=>true, "formatter"=>"integer", "editrules"=>array("minValue"=>0, "maxValue"=>12), "label"=>"Thu"));
$grid->setColProperty("friday", array("editable"=>true, "width"=>40, "fixed"=>true, "formatter"=>"integer", "editrules"=>array("minValue"=>0, "maxValue"=>12), "label"=>"Fri"));
$grid->setColProperty("saturday", array("editable"=>true, "width"=>40, "fixed"=>true, "formatter"=>"integer", "editrules"=>array("minValue"=>0, "maxValue"=>12), "label"=>"Sat"));
$grid->setColProperty("sunday", array("editable"=>true, "width"=>40, "fixed"=>true, "formatter"=>"integer", "editrules"=>array("minValue"=>0, "maxValue"=>12), "label"=>"Sun"));
$grid->setColProperty("overtime", array("editable"=>false, "width"=>40, "fixed"=>true, "label"=>"OT"));
$grid->setColProperty("total", array("editable"=>false, "summaryType"=>"sum", summaryTpl=>"S: {0}", "width"=>70, "fixed"=>true, "hidden"=>false, "label"=>"Total"));
$grid->setColProperty("notes", array("editable"=>true, "width"=>400, "fixed"=>true, "hidden"=>true, "edittype"=>"textarea","editrules"=>array("edithidden"=>true, "required"=>false), "editoptions"=>array("rows"=>6, "cols"=>60), "label"=>"Notes"));
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
    "grouping"=>true,
    "groupingView"=>array(
		"groupCollapse"=>true,
    "groupField" => array('poid'),
    "groupColumnShow" => array(true),
		"groupSummary" => array(true),
    "groupOrder" => array('desc'),
    "groupText" =>array('<b>{0}</b>'),
    "groupDataSorted" => true)
		    ));		
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Timesheet Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Time","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Time","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, $summaryrows, null, true,true);
$DB = null;
?>
