<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
// Create the jqGrid instance
$candidateID = $loggedInUser->candidateid;
$grid = new jqGridRender($DB);

// Write the SQL Query 

$q = 'select s.client, s.vendorcall, s.positiondate, u.name manager from position s, employee u where s.mmid = u.id and s.candidateid = '.$candidateID; 

$grid->SelectCommand = $q;
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->setColModel();
$grid->setUrl('../grids/candidatepositions.php');
$grid->setColProperty("client", array("editable"=>false, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Client"));
$grid->setColProperty("vendorcall", array("editable"=>false, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Vendor Call"));
$grid->setColProperty("positiondate", array("editable"=>false, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Position Date"));
$grid->setColProperty("manager", array("editable"=>false, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Manager"));




						
// Set alternate background using altRows property
$grid->setGridOptions(array(
		"sortable"=>true,
	    "width"=>1024,
		"height"=>250,
		"caption"=>"Positions",		
		"rownumbers"=>true,										
    "rowNum"=>50,
		"shrinkToFit"=>false,
    "sortname"=>"positiondate",
		"sortorder"=>"desc",
    //"altRows"=>true,
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100,500),
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>false,"edit"=>false,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Positions"));

$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$DB = null;
?>