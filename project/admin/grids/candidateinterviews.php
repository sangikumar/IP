<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$candidateID = $loggedInUser->candidateid;
$grid = new jqGridRender($DB);

// Write the SQL Query 
$q = 'select s.clientname, s.type, s.interviewdate, s.status, u.name manager from interview s, employee u where s.mmid = u.id and s.candidateid = '.$candidateID; 
$grid->SelectCommand = $q;
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->setColModel();
$grid->setUrl('../grids/candidateinterviews.php');
$grid->setColProperty("clientname", array("editable"=>false, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Client"));
$grid->setColProperty("type", array("editable"=>false, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Type"));
$grid->setColProperty("interviewdate", array("editable"=>false, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Interview Date"));
$grid->setColProperty("status", array("editable"=>false, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Status"));
$grid->setColProperty("manager", array("editable"=>false, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Manager"));
						
// Set alternate background using altRows property
$grid->setGridOptions(array(
		"sortable"=>true,
	    "width"=>1024,
		"height"=>250,
		"caption"=>"Interviews",		
		"rownumbers"=>true,										
    "rowNum"=>50,
		"shrinkToFit"=>false,
    "sortname"=>"interviewdate",
		"sortorder"=>"desc",
    //"altRows"=>true,
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100,500),
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>false,"edit"=>false,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Interviews"));

$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$DB = null;
?>
