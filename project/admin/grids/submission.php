<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);
$grid->SelectCommand = 'SELECT id, candidateid, employeeid, submissiondate, type, name, email, phone, url, notes FROM mkt_submission p';
$grid->table = 'mkt_submission';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('submissiondate');
$grid->setUserDate("Y-m-d"); 
$grid->setColModel();
$grid->setUrl('../grids/submission.php');
$grid->cacheCount = true;
$grid->setColProperty("id", array("editable"=>false, "hidden"=>true, "label"=>"ID"));
$grid->setColProperty("candidateid", array("editable"=>true, "editrules"=>array("edithidden"=>true, "required"=>false), "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Candidate Name", "edittype"=>"select"));
$grid->setSelect("candidateid", "SELECT distinct candidateid as id, name as name FROM candidate where status in ('Marketing', 'Placed', 'OnProject-Mkt') order by name");
$grid->setColProperty("employeeid", array("editable"=>true, "editrules"=>array("edithidden"=>true, "required"=>false), "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Submitter", "edittype"=>"select"));
$grid->setSelect("employeeid", "SELECT distinct id, name FROM employee where status = '0Active' order by name");
$grid->setColProperty("submissiondate", array("formatter"=>"date", "width"=>100, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"Submission Date", 
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
$grid->setColProperty("type", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Type", "edittype"=>"select"));
$grid->setSelect("type", array(""=>"None", "Dice"=>"Dice", "Inbox"=>"Inbox", "CB"=>"CB"), false, true, true, array(""=>"All"));																	 
$grid->setColProperty("name", array("editable"=>true, "width"=>150, "fixed"=>true, "editoptions"=>array("size"=>75, "maxlength"=>200), "label"=>"Name"));
$grid->setColProperty("email", array("editable"=>true, "width"=>150, "fixed"=>true, "editoptions"=>array("size"=>75, "maxlength"=>200), "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Email"));
$grid->setColProperty("phone", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Phone"));
$grid->setColProperty("url", array("editable"=>true, "frozen"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "formatter"=>"link", "formatoptions"=>array("target"=>"_blank"), "fixed"=>true, "editrules"=>array("url"=>true, "required"=>false), "label"=>"Url"));
$grid->setColProperty("notes", array("editable"=>true, "width"=>70, "fixed"=>true, "edittype"=>"textarea","editoptions"=>array("rows"=>6, "cols"=> 80), "label"=>"Notes"));
						
// Set alternate background using altRows property
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Submission Management",		
		"rownumbers"=>true,										
    "rowNum"=>100,
		"hoverrows"=>true, 
		"shrinkToFit"=>false,
    "sortname"=>"submissiondate desc, employeeid asc, candidateid",
		"sortorder"=>"asc",
		"toppager"=>true,
    "rowList"=>array(100,500,1000,5000),
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>400, "viewCaption"=>"Submission Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>400, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Submission","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>400, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Submission","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, null, null,true,true);
$DB = null;
?>