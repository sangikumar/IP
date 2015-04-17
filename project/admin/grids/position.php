<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");

$grid = new jqGridRender($DB);
$grid->SelectCommand = 'SELECT id, candidateid, mmid, positiondate, type, status, vendorcall, vendor1email, vendor1, clientemail, client, vendor2email, vendor2,vendor3email, vendor3, rate, reference, notes FROM position p';
$grid->table = 'position';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('positiondate');
$grid->setUserDate("Y-m-d"); 
$grid->setColModel();
$grid->setUrl('../grids/position.php');
$grid->cacheCount = true;
$grid->setColProperty("id", array("editable"=>false, "hidden"=>true, "label"=>"ID"));
$grid->setColProperty("candidateid", array("editable"=>true, "hidden"=>false, "editrules"=>array("edithidden"=>true, "required"=>false), "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Candidate Name", "edittype"=>"select"));
$grid->setSelect("candidateid", "SELECT distinct candidateid as id, name as name FROM candidate where status in ('Marketing', 'Placed', 'OnProject-Mkt') order by name");
$grid->setColProperty("mmid", array("editable"=>true, "hidden"=>false, "editrules"=>array("edithidden"=>true, "required"=>false), "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Manager", "edittype"=>"select"));
$grid->setSelect("mmid", "SELECT distinct id, name FROM employee order by name");
$grid->setColProperty("positiondate", array("formatter"=>"date", "width"=>80, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"), "editable"=>true, "label"=>"Position Date", 
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
$grid->setSelect("type", $technology , false, true, true, array(""=>"All"));																	 
$grid->setColProperty("status", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", $interviewstatus , false, true, true, array(""=>"All"));
$grid->setColProperty("vendorcall", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Call", "edittype"=>"select"));
$grid->setSelect("vendorcall", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("vendor1email", array("editable"=>true, "width"=>200, "fixed"=>true, "editoptions"=>array("size"=>75, "maxlength"=>200), "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Vendor1 Email"));
$grid->setAutocomplete("vendor1email","#vendor1","select email, email, vendor1 from (select r.email, (select companyname from vendor where id = r.vendorid) vendor1 from recruiter r union select distinct vendor1email as email, vendor1 from position) p where email like ? ORDER BY email",null,true,true);
$grid->setColProperty("vendor1", array("editable"=>true, "width"=>90, "fixed"=>true, "editoptions"=>array("size"=>75, "maxlength"=>200), "label"=>"Vendor1"));
$grid->setAutocomplete("vendor1",null,"select companyname from (select v.companyname from vendor v union select c.companyname from client c union select distinct vendor1 from position) p  where companyname like ? ORDER BY companyname",null,true,true);
$grid->setColProperty("clientemail", array("editable"=>true, "width"=>150, "fixed"=>true, "editoptions"=>array("size"=>75, "maxlength"=>200), "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Client Email"));
$grid->setAutocomplete("clientemail","#client","select email, email, client from (select r.email, (select companyname from vendor where id = r.clientid) client from recruiter r union select distinct clientemail as email, client from position) p where email like ? ORDER BY email",null,true,true);$grid->setColProperty("client", array("editable"=>true, "width"=>200, "fixed"=>true, "editoptions"=>array("size"=>75, "maxlength"=>200), "label"=>"Client"));
$grid->setColProperty("client", array("editable"=>true, "width"=>90, "fixed"=>true, "editoptions"=>array("size"=>75, "maxlength"=>200), "label"=>"Client"));
$grid->setAutocomplete("client",null,"select companyname from (select c.companyname from client c union select distinct client from position) p  where companyname like ? ORDER BY companyname",null,true,true);
$grid->setColProperty("vendor2email", array("editable"=>true, "width"=>200, "fixed"=>true, "formatter"=>"email", "editoptions"=>array("size"=>75, "maxlength"=>200), "editrules"=>array("email"=>true, "required"=>false), "label"=>"Vendor2 Email"));
$grid->setAutocomplete("vendor2email","#vendor2","select email, email, vendor2 from (select r.email, (select companyname from vendor where id = r.vendorid) vendor2 from recruiter r union select distinct vendor1email as email, vendor1 from position) p where email like ? ORDER BY email",null,true,true);$grid->setColProperty("vendor2", array("editable"=>true, "width"=>90, "fixed"=>true, "editoptions"=>array("size"=>75, "maxlength"=>200), "label"=>"Vendor2"));
$grid->setColProperty("vendor2", array("editable"=>true, "width"=>90, "fixed"=>true, "editoptions"=>array("size"=>75, "maxlength"=>200), "label"=>"Vendor2"));
$grid->setAutocomplete("vendor2",null,"select companyname from (select v.companyname from vendor v union select c.companyname from client c union select distinct vendor1 from position) p  where companyname like ? ORDER BY companyname",null,true,true);
$grid->setColProperty("vendor3email", array("editable"=>true, "width"=>200, "fixed"=>true, "formatter"=>"email", "editoptions"=>array("size"=>75, "maxlength"=>200), "editrules"=>array("email"=>true, "required"=>false), "label"=>"Vendor3 Email"));
$grid->setAutocomplete("vendor3email","#vendor3","select email, email, vendor3 from (select r.email, (select companyname from vendor where id = r.vendorid) vendor3 from recruiter r union select distinct vendor1email as email, vendor1 from position) p where email like ? ORDER BY email",null,true,true);$grid->setColProperty("vendor2", array("editable"=>true, "width"=>90, "fixed"=>true, "editoptions"=>array("size"=>75, "maxlength"=>200), "label"=>"Vendor2"));
$grid->setColProperty("vendor3", array("editable"=>true, "width"=>90, "fixed"=>true, "editoptions"=>array("size"=>75, "maxlength"=>200), "label"=>"Vendor3"));
$grid->setAutocomplete("vendor3",null,"select companyname from (select v.companyname from vendor v union select c.companyname from client c union select distinct vendor1 from position) p  where companyname like ? ORDER BY companyname",null,true,true);
$grid->setColProperty("rate", array("editable"=>true, "width"=>90, "formatter"=>"currency", "formatoptions"=>array("decimalPlaces"=>2,"thousandsSeparator"=>",","prefix"=>"$"),  "sorttype"=>"currency", "fixed"=>true, "label"=>"Rate"));
$grid->setColProperty("reference", array("editable"=>true, "width"=>90, "fixed"=>true, "editoptions"=>array("size"=>75, "maxlength"=>200), "label"=>"References"));
$grid->setColProperty("notes", array("editable"=>true, "width"=>70, "fixed"=>true, "edittype"=>"textarea","editoptions"=>array("rows"=>6, "cols"=> 80), "label"=>"Notes"));
						
// Set alternate background using altRows property
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Position Management",		
		"rownumbers"=>true,										
    "rowNum"=>100,
		"hoverrows"=>true, 
		"shrinkToFit"=>false,
    "sortname"=>"positiondate desc, mmid asc, candidateid",
		"sortorder"=>"asc",
		"toppager"=>true,
    "rowList"=>array(100,500,1000,5000),
    ));						
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Position Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Position","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Position","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, null, null,true,true);
$DB = null;
?>