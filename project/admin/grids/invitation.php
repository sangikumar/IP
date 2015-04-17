<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);
$grid->SelectCommand = 'select "Innovapath" as name, "all@innova-path.com" as email, "925-400-7330" as phone, "Enrolled" as status from dual  union  select name, email, phone, "Enrolled" status from candidate where status in ("Active", "Marketing", "OnProject-Mkt") and diceflag like \'N\' union  select name, email, phone, "Lead" status from leads where (status is null and startdate >= NOW() - INTERVAL 7 DAY) or (status = "Open" and startdate >= NOW() - INTERVAL 7 DAY) or (status = "In-Progress" and startdate >= NOW() - INTERVAL 7 DAY)  union  select name, email, phone, "Lead" status from recruit where (status = "In-Progress" and startdate >= NOW() - INTERVAL 7 DAY) union  select name, email, phone, "Enrolled" status from candidate c, placement p where c.candidateid = p.candidateid and p.startdate + 30 >= CURDATE() and c.status = "Placed"';
$grid->dataType = 'json';
$grid->setColModel();
$grid->setUrl('../grids/invitation.php');
$grid->setColProperty("name", array("editable"=>false, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Name"));
$grid->setColProperty("phone", array("editable"=>false, "width"=>200, "fixed"=>true, "label"=>"Phone"));
$grid->setColProperty("email", array("editable"=>false, "width"=>200, "fixed"=>true, "formatter"=>"email", "label"=>"Email"));
$grid->setColProperty("status", array("editable"=>false, "width"=>60, "fixed"=>true, "label"=>"Status"));
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Class List",		
		"rownumbers"=>true,										
    "rowNum"=>500,
    "sortname"=>"status asc, name",
		"toppager"=>true,
    "rowList"=>array(100,500,1000,5000),
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>false,"excel"=>true,"add"=>false,"edit"=>false,"del"=>false,"view"=>true, "search"=>true));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Class List"));
//$grid->toolbarfilter = true;
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$DB = null;
?>
