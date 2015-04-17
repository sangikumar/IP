<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");

// Create the jqGrid instance
$grid = new jqGridRender($DB);
// Write the SQL Query
$grid->SelectCommand = 'SELECT id, companyname, status, tier, solicited, minrate, hirebeforeterm, hireafterterm, latepayments, totalnetterm, defaultedpayment, url, email, phone, fax, address, city, state, country, zip, hrname, hremail, hrphone, accountnumber, managername, manageremail, managerphone, secondaryname, secondaryemail, secondaryphone FROM vendor where id in (select distinct vendorid from placement)';
// Set the table to where we add the data
$grid->table = 'vendor';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->setColModel();
$grid->dataType = 'json';
$grid->setUrl('../grids/rvendor.php');
$grid->setColProperty("id", array("editable"=>false, "hidden"=>true, "width"=>40, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("companyname", array("editable"=>true, "frozen"=>true, "width"=>250, "editoptions"=>array("size"=>75, "maxlength"=>250, "style"=>"text-transform: uppercase"), "fixed"=>true, "label"=>"Company Name"));
$grid->setColProperty("status", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", $vendorstatus , false, true, true, array(""=>"All"));	
$grid->setColProperty("tier", array("editable"=>true, "width"=>50, "fixed"=>true, "label"=>"Tier", "edittype"=>"select"));
$grid->setSelect("tier", $vendortier , false, true, true, array(""=>"All"));
$grid->setColProperty("solicited", array("editable"=>true, "label"=>"Solicited", "width"=>50, "fixed"=>true, "edittype"=>"select"));
$grid->setSelect("solicited", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("minrate", array("editable"=>true, "width"=>50, "formatter"=>"currency", "formatoptions"=>array("decimalPlaces"=>2,"thousandsSeparator"=>",","prefix"=>"$"), "sorttype"=>"currency", "fixed"=>true, "label"=>"Rate"));
$grid->setColProperty("hirebeforeterm", array("editable"=>true, "label"=>"HBT", "width"=>50, "fixed"=>true, "edittype"=>"select"));
$grid->setSelect("hirebeforeterm", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("hireafterterm", array("editable"=>true, "label"=>"HAT", "width"=>50, "fixed"=>true, "edittype"=>"select"));
$grid->setSelect("hireafterterm", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("latepayments", array("editable"=>true, "label"=>"Late Pay", "width"=>50, "fixed"=>true, "edittype"=>"select"));
$grid->setSelect("latepayments", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("totalnetterm", array("editable"=>true, "width"=>70, "fixed"=>true, "editrules"=>array("minValue"=>0, "maxValue"=>80), "label"=>"Net"));
$grid->setColProperty("defaultedpayment", array("editable"=>true, "label"=>"Defaulted", "width"=>50, "fixed"=>true, "edittype"=>"select"));
$grid->setSelect("defaultedpayment", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("url", array("editable"=>true, "frozen"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200), "formatter"=>"link", "formatoptions"=>array("target"=>"_blank"), "fixed"=>true, "editrules"=>array("url"=>true, "required"=>false), "label"=>"Url"));
$grid->setColProperty("accountnumber", array("editable"=>true, "width"=>90, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Acct. No"));			
$grid->setColProperty("email", array("editable"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>250, "style"=>"text-transform: lowercase"), "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>true), "label"=>"Email"));
$grid->setColProperty("phone", array("editable"=>true, "width"=>150, "editoptions"=>array("size"=>75, "maxlength"=>250),"fixed"=>true, "label"=>"Phone"));
$grid->setColProperty("fax", array("editable"=>true, "width"=>150, "editoptions"=>array("size"=>75, "maxlength"=>250),"fixed"=>true, "label"=>"Fax"));
$grid->setColProperty("address", array("editable"=>true, "width"=>150, "editoptions"=>array("size"=>75, "maxlength"=>250), "fixed"=>true, "label"=>"Address"));
$grid->setColProperty("city", array("editable"=>true, "width"=>120, "editoptions"=>array("size"=>75, "maxlength"=>250), "fixed"=>true, "label"=>"City"));
$grid->setAutocomplete("city",null,"select name, name from (select distinct city as name from city) p where name like ? ORDER BY name",null,true,true);
$grid->setColProperty("state", array("editable"=>true, "width"=>120, "editoptions"=>array("size"=>75, "maxlength"=>250), "fixed"=>true, "label"=>"State"));
$grid->setAutocomplete("state",null,"select name, name from (SELECT distinct name FROM state)p where name like ? ORDER BY name",null,true,true);
$grid->setColProperty("country", array("editable"=>true, "width"=>120, "editoptions"=>array("size"=>75, "maxlength"=>250), "fixed"=>true, "label"=>"Country"));
$grid->setAutocomplete("country",null,"select name, name from (SELECT distinct short_name as name FROM country) p where name like ? ORDER BY name",null,true,true);
$grid->setColProperty("zip", array("editable"=>true, "width"=>120, "editoptions"=>array("size"=>75, "maxlength"=>250), "fixed"=>true, "label"=>"Zip"));
$grid->setAutocomplete("zip",null,"select name, name from (select zip as name from city) p where name like ? ORDER BY name",null,true,true);
$grid->setColProperty("hrname", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"HR Name"));
$grid->setColProperty("hremail", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"HR Email"));
$grid->setColProperty("hrphone", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"HR Phone"));
$grid->setColProperty("managername", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Mgr Name"));
$grid->setColProperty("manageremail", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Mgr Email"));
$grid->setColProperty("managerphone", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Mgr Phone"));
$grid->setColProperty("secondaryname", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Sec Name"));
$grid->setColProperty("secondaryemail", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Sec Email"));
$grid->setColProperty("secondaryphone", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Secondary Phone"));
$grid->setGridOptions(array(
		"sortable"=>true,
	  "width"=>1024,
		"height"=>250,
		"caption"=>"Vendor List",		
		"rownumbers"=>true,										
    "rowNum"=>100,
    "sortname"=>"status asc, companyname",
		"sortorder"=>"asc",
		"toppager"=>true,
    "rowList"=>array(10,20,30,50,100),
    ));		
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>false,"excel"=>false,"add"=>false,"edit"=>false,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Vendor Management"));
//$grid->toolbarfilter = true;
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
//$grid->setJSCode($bindkeys);
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true,null, null, true,true);
$DB = null;
?>