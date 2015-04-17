<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$userid = $_GET['userid'];
$grid = new jqGridRender($DB);
$grid->SelectCommand = 'SELECT pc.id, pc.candidateid, pc.positiondate, pc.status, pc.vendorcompany, pc.vendoremail, pc.client, pc.clientemail, pc.solicitation, pc.notes FROM positioncalls pc where pc.candidateid = (select candidateid from candidate where portalid = "'. $userid .'")';
$grid->table = 'positioncalls';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('positiondate');
$grid->setUserDate("Y-m-d"); 
$grid->setColModel();
$grid->setUrl('../grids/positioncall.php?userid='.$userid);
$grid->setColProperty("id", array("editable"=>false, "hidden"=>true, "label"=>"ID"));
$grid->setColProperty("candidateid", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Candidate Name", "edittype"=>"select"));
$grid->setSelect("candidateid", "SELECT distinct candidateid as id, name as name FROM candidate where portalid = $userid");
$grid->setColProperty("positiondate", array("formatter"=>"date", "width"=>100, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"Position Date", 
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
$grid->setColProperty("status", array("editable"=>true, "width"=>120, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", array("Cleared"=>"Cleared", "Rejected by Me"=>"Rejected by Me", "Rejected By Vendor"=>"Rejected By Vendor", "Rejected By Client"=>"Rejected By Client"), false, true, true, array(""=>"All"));
$grid->setColProperty("vendorcompany", array("editable"=>true, "width"=>120, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Vendor1"));
$grid->setAutocomplete("vendorcompany",null,"select companyname from (select v.companyname from vendor v union select c.companyname from client c union select distinct vendor1 from position union select distinct vendor2 from position union select distinct vendor3 from position) p  where companyname like ? ORDER BY companyname",null,true,true);
$grid->setColProperty("vendoremail", array("editable"=>true, "width"=>200, "fixed"=>true, "editoptions"=>array("size"=>75, "maxlength"=>200), "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Vendor1 Email"));
$grid->setAutocomplete("vendoremail",null,"select email, email from (SELECT email FROM massemail union select distinct vendor1email from position union select distinct vendor2email from position union select distinct vendor3email from position union select v.email from vendor v union select r.email from recruiter r) p where email like ? ORDER BY email",null,true,true);
$grid->setColProperty("client", array("editable"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Client"));
$grid->setAutocomplete("client",null,"select companyname from (select v.companyname from vendor v union select c.companyname from client c union select distinct client from position union select distinct vendor1 from position union select distinct vendor2 from position union select distinct vendor3 from position) p  where companyname like ? ORDER BY companyname",null,true,true);
$grid->setColProperty("clientemail", array("editable"=>true, "width"=>150, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Client Email"));
$grid->setAutocomplete("clientemail",null,"select email, email from (SELECT email FROM massemail union select distinct vendor1email from position union select distinct vendor2email from position union select distinct vendor3email from position union select v.email from vendor v union select r.email from recruiter r) p where email like ? ORDER BY email",null,true,true);
$grid->setColProperty("solicitation", array("editable"=>true, "label"=>"Solicitation - (Did vendor<br>asked to join their company)", "hidden"=>true, "editrules"=>array("edithidden"=>true, "required"=>false), "width"=>50, "fixed"=>true,  "edittype"=>"select"));
$grid->setSelect("solicitation", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("notes", array("editable"=>true, "width"=>70, "fixed"=>true, "edittype"=>"textarea","editoptions"=>array("rows"=>6, "cols"=> 80), "label"=>"Notes"));
						
// Set alternate background using altRows property
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Call List <span style='color:red'><b>(Click + to add a call information)</b>",		
		"rownumbers"=>true,										
    "rowNum"=>30,
    "sortname"=>"positiondate",
		"sortorder"=>"desc",
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100),
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>350, "viewCaption"=>"Position List"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>350, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Call","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>350, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Call","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, null, null,true,true);
$DB = null;
?>
