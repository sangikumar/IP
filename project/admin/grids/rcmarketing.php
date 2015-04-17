<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);
$grid->SelectCommand = 'select cm.id, cm.startdate, c.name, c.email, c.phone, cm.mmid,cm.instructorid,cm.submitterid, c.secondaryemail, c.secondaryphone, c.workstatus, cm.status, cm.priority, cm.technology, cm.resumeid, cm.minrate, cm.ipemailid, cm.currentlocation,cm.locationpreference, cm.relocation, cm.skypeid, (select link from resume where id = cm.resumeid) resumelink, (select phone from ipemail where id = ipemailid) ipphone, cm.closedate, cm.suspensionreason, cm.intro, cm.notes from candidatemarketing cm, candidate c where cm.candidateid = c.candidateid and c.status in ("Marketing", "Placed", "OnProject-Mkt") and cm.status not in ("6-Suspended", "5-Closed")';
$grid->table = 'candidatemarketing';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('startdate','closedate');
$grid->setUserDate("Y-m-d"); 
$grid->setColModel();
$grid->setUrl('../grids/rcmarketing.php');
$grid->setColProperty("id", array("editable"=>false, "hidden"=>true, "label"=>"ID"));
$grid->setColProperty('startdate',   
        array("editable"=>false,"width"=>70, "fixed"=>true,"formatter"=>"date", "label"=>"Start Date", 
				"formatoptions"=>array("srcformat"=>"Y-m-d HH:MM:SS", "newformat"=>"m/d/Y"),
				"searchoptions"=>array("dataInit"=>
			        "js:function(elm){setTimeout(function(){
					 jQuery(elm).datepicker({dateFormat:'yy-mm-dd'});
					 jQuery('.ui-datepicker').css({'font-size':'75%'});
			 },200);}")
				));
$grid->setColProperty("name", array("editable"=>false, "width"=>200, "fixed"=>true, "label"=>"C Name"));				
$grid->setColProperty("email", array("editable"=>false, "width"=>200, "fixed"=>true, "formatter"=>"email", "label"=>"Email"));
$grid->setColProperty("phone", array("editable"=>false, "width"=>90, "fixed"=>true, "label"=>"Phone"));
$grid->setColProperty("secondaryemail", array("editable"=>false, "width"=>150, "fixed"=>true, "formatter"=>"email", "label"=>"Secondary Email"));
$grid->setColProperty("secondaryphone", array("editable"=>false, "width"=>90, "fixed"=>true, "label"=>"Secondary Phone"));
$grid->setColProperty("workstatus", array("editable"=>false, "width"=>70, "fixed"=>true, "label"=>"US Status"));
$grid->setColProperty("paperwork", array("editable"=>false, "label"=>"Paperwork", "width"=>50, "fixed"=>true,  "edittype"=>"select"));
$grid->setSelect("paperwork", $paperwork , false, true, true, array(""=>"All"));
$grid->setColProperty("mmid", array("editable"=>false, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Manager", "edittype"=>"select"));
$grid->setSelect("mmid", "SELECT distinct id, name FROM employee where status = '0Active' order by name");
$grid->setColProperty("instructorid", array("editable"=>false, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Instructor", "edittype"=>"select"));
$grid->setSelect("instructorid", "SELECT distinct id, name FROM employee where status = '0Active' order by name");
$grid->setColProperty("submitterid", array("editable"=>true, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Submitter", "edittype"=>"select"));
$grid->setSelect("submitterid", "SELECT distinct id, name FROM employee where status = '0Active' order by name");
$grid->setColProperty("status", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", $marketingstatus, false, true, true, array(""=>"All"));
$grid->setColProperty("priority", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Priority", "edittype"=>"select"));
$grid->setSelect("priority", $priorities, false, true, true, array(""=>"All"));
$grid->setColProperty("technology", array("editable"=>true, "width"=>100, "fixed"=>true, "label"=>"Technology", "edittype"=>"select"));
$grid->setSelect("technology", $technology, false, true, true, array(""=>"All"));
$grid->setColProperty("minrate", array("editable"=>true, "width"=>45, "fixed"=>true, "editrules"=>array("minValue"=>45), "label"=>"Rate"));
$grid->setColProperty("currentlocation", array("editable"=>true, "width"=>100, "fixed"=>true, "label"=>"Current Location"));
$grid->setColProperty("locationpreference", array("editable"=>true, "width"=>100, "fixed"=>true, "label"=>"Location Preference"));
$grid->setColProperty("relocation", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Relocation", "edittype"=>"select"));
$grid->setSelect("relocation", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("closedate", array("formatter"=>"date", "width"=>80, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"Close Date", 
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
$grid->setColProperty("suspensionreason", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Reason", "edittype"=>"select"));
$grid->setSelect("suspensionreason", array("B"=>"Break", "D"=>"Discontinued", "X"=>"Defaulted"), false, true, true, array(""=>"All"));
$grid->setColProperty("resumelink", array("editable"=>false, "width"=>200, "formatter"=>"link", "fixed"=>true, "editrules"=>array("url"=>true), "label"=>"Resume Link"));
$grid->setColProperty("ipemailid", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "label"=>"IP Email", "edittype"=>"select"));
$grid->setSelect("ipemailid", "select '' as id, '' as name from dual union SELECT distinct id, email as name FROM ipemail where email is not null order by name");
$grid->setColProperty("ipphone", array("editable"=>false, "width"=>150, "fixed"=>true, "label"=>"IP Phone"));
$grid->setColProperty("skypeid", array("editable"=>false, "width"=>100, "fixed"=>true, "label"=>"Skype"));
$grid->setColProperty("resumeid", array("editable"=>true, "frozen"=>true, "width"=>150, "fixed"=>true, "label"=>"Resume ID", "edittype"=>"select"));
$grid->setSelect("resumeid", "select '' as id, '' as name from dual union SELECT distinct cr.id, concat(c.name, ' ', r.resumekey) as name FROM resume r, candidateresume cr, candidate c where r.id = cr.resumeid and c.candidateid = cr.candidateid order by name");		
$grid->setColProperty("intro", array("editable"=>true, "hidden"=>true, "edittype"=>"textarea","editrules"=>array("edithidden"=>true, "required"=>false), "editoptions"=>array("rows"=>6, "cols"=> 80), "label"=>"Intro"));
$grid->setColProperty("notes", array("editable"=>true, "hidden"=>true, "edittype"=>"textarea","editrules"=>array("edithidden"=>true, "required"=>false), "editoptions"=>array("rows"=>6, "cols"=> 80), "label"=>"Notes"));

// Set alternate background using altRows property
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>500,
		"caption"=>"Marketing List",		
		"rownumbers"=>true,										
    "rowNum"=>100,
    "sortname"=>"mmid desc, priority",
		"sortorder"=>"asc",
    //"altRows"=>true,
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100,500),
    ));						
//$grid->showError = true;
$grid->navigator = true;
//$grid->toolbarfilter = true; 
//$grid->setFilterOptions(array("searchOperators"=>true)); 
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>false,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Marketing Management"));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Candidate","reloadAfterSubmit"=>false));
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$DB = null;
?>
