<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);
$grid->SelectCommand = 'SELECT id,companyname,email,phone,status,url,fax,address,city,state,country,twitter,linkedin,facebook,zip,manager1name,manager1email,manager1phone,hmname,hmemail,hmphone,hrname,hremail,hrphone,notes FROM client';
$grid->table = 'client';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('startdate');
$grid->setUserDate("Y-m-d"); 
$grid->setColModel();
$grid->setUrl('../grids/client.php');
$grid->setColProperty("id", array("editable"=>false, "width"=>40, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("companyname", array("editable"=>true, "frozen"=>true, "width"=>250, "editoptions"=>array("size"=>75, "maxlength"=>250, "style"=>"text-transform: uppercase"), "fixed"=>true, "label"=>"Company Name"));			
$grid->setColProperty("email", array("editable"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>250, "style"=>"text-transform: lowercase"), "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>true), "label"=>"Email"));
$grid->setColProperty("phone", array("editable"=>true, "width"=>150, "editoptions"=>array("size"=>75, "maxlength"=>250),"fixed"=>true, "label"=>"Phone"));
$grid->setColProperty("status", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", $vendorstatus , false, true, true, array(""=>"All"));
$grid->setColProperty("url", array("editable"=>true, "frozen"=>true, "width"=>200, "editoptions"=>array("size"=>75, "maxlength"=>200, "style"=>"text-transform: lowercase"), "formatter"=>"link", "formatoptions"=>array("target"=>"_blank"), "fixed"=>true, "editrules"=>array("url"=>true, "required"=>false), "label"=>"Url"));	
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
$grid->setColProperty("twitter", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Twitter"));
$grid->setColProperty("facebook", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Facebook"));
$grid->setColProperty("linkedin", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Linkedin"));
$grid->setColProperty("manager1name", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Mgr Name"));
$grid->setColProperty("manager1email", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Mgr Email"));
$grid->setColProperty("manager1phone", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Mgr Phone"));
$grid->setColProperty("hmname", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Hiring Mgr Name"));
$grid->setColProperty("hmemail", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"Hiring Mgr Email"));
$grid->setColProperty("hmphone", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Hiring Mgr Phone"));
$grid->setColProperty("hrname", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"HR Name"));
$grid->setColProperty("hremail", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "editrules"=>array("email"=>true, "required"=>false), "label"=>"HR Email"));
$grid->setColProperty("hrphone", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"HR Phone"));
$grid->setColProperty("notes", array("editable"=>true, "width"=>400, "fixed"=>true, "edittype"=>"textarea", "editoptions"=>array("rows"=>6, "cols"=> 60), "label"=>"Notes"));
$grid->setGridOptions(array(
"sortable"=>true,
"width"=>1024,
"height"=>400,
"caption"=>"Client Management",		
"rownumbers"=>true,										
"rowNum"=>100,
"sortname"=>"companyname",
"sortorder"=>"asc",
"toppager"=>true,
"rowList"=>array(10,20,30,50,100,500),
));		
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Client Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Client","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Client","reloadAfterSubmit"=>false));
//$grid->toolbarfilter = true;
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true,null, null, true,true);
$DB = null;
?>
