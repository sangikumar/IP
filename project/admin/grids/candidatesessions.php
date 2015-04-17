<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
// Create the jqGrid instance
$candidateID = $loggedInUser->candidateid;
$grid = new jqGridRender($DB);

// Write the SQL Query 

$q = 'select s.type, s.subject, s.sessiondate, u.name Instructor, s.status, s.feedback from session s ,employee u where s.instructorid = u.id and ((s.candidateid  = '.$candidateID.') or (s.candidate2id  = '.$candidateID.') or (s.candidate3id = '.$candidateID.') or (s.candidate4id  = '.$candidateID.') or  (s.candidate5id  = '.$candidateID.' )) '; 

$grid->SelectCommand = $q;
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->setColModel();
$grid->setUrl('../grids/candidatesessions.php');
$grid->setColProperty("type", array("editable"=>false, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Session Type"));
$grid->setColProperty("subject", array("editable"=>false, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Subject"));
$grid->setColProperty("sessiondate", array("editable"=>false, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Session Date"));
$grid->setColProperty("Instructor", array("editable"=>false, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Instructor"));
$grid->setColProperty("status", array("editable"=>false, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Status"));
$grid->setColProperty("feedback", array("editable"=>false, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Feedback"));



						
// Set alternate background using altRows property
$grid->setGridOptions(array(
		"sortable"=>true,
	    "width"=>1024,
		"height"=>250,
		"caption"=>"Sessions",		
		"rownumbers"=>true,										
    "rowNum"=>50,
		"shrinkToFit"=>false,
    "sortname"=>"sessiondate",
		"sortorder"=>"desc",
    //"altRows"=>true,
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100,500),
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>false,"edit"=>false,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Sessions"));

$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$DB = null;
?>