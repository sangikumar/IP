<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);
$grid->SelectCommand = 'SELECT id,name,description,lastrundate,isactive,extracttype, applicationtype, username, password, passkey, (select count(*) from clr_position p where p.jobid = j.id) as jobcount, lastmoddatetime from clr_job j';
$grid->table = 'clr_job';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('startdate');
$grid->setUserDate("Y-m-d");
$grid->setColModel();
$grid->setUrl('../grids/clr_job.php');
$grid->setColProperty("id", array("editable" => false, "width" => 40, "fixed" => true, "label" => "ID"));
$grid->setColProperty("name", array("editable"=>true, "frozen"=>true, "width"=>150, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Name"));
$grid->setColProperty("description", array("editable"=>true, "frozen"=>true, "width"=>150, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Description"));
$grid->setColProperty("lastrundate", array("formatter" => "date", "width" => 70, "fixed" => true, "formatoptions" => array("srcformat" => "Y-m-d", "newformat" => "Y-m-d"),
    "editable" => true, "label" => "Last Run Date",
    "editoptions" => array("dataInit" =>
        "js:function(elm){setTimeout(function(){
    jQuery(elm).datepicker({dateFormat:'yy-mm-dd'});
    jQuery('.ui-datepicker').css({'font-size':'75%'});
    },200);}"),
    "searchoptions" => array("dataInit" =>
        "js:function(elm){setTimeout(function(){
    jQuery(elm).datepicker({dateFormat:'yy-mm-dd'});
    jQuery('.ui-datepicker').css({'font-size':'75%'});
    },200);}")
));
$grid->setColProperty("isactive", array("editable"=>true, "label"=>"Active", "width"=>50, "fixed"=>true,  "edittype"=>"select"));
$grid->setSelect("isactive", $yesno , false, true, true, array(""=>"All"));
$grid->setColProperty("username", array("editable"=>true, "frozen"=>true, "width"=>120, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Username"));
$grid->setColProperty("password", array("editable"=>true, "frozen"=>true, "width"=>120, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Password"));
$grid->setColProperty("passkey", array("editable"=>true, "frozen"=>true, "width"=>120, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Key"));
$grid->setColProperty("extracttype", array("editable"=>true, "width"=>120, "fixed"=>true, "label"=>"Extractor", "edittype"=>"select"));
$grid->setSelect("extracttype", array("SimpleBrowserDriver"=>"SimpleBrowserDriver", "SimpleBrowser"=>"SimpleBrowser", "FirefoxDriver"=>"FirefoxDriver","REST"=>"REST","XML"=>"XML"), false, true, true, array(""=>"All"));
$grid->setColProperty("applicationtype", array("editable"=>true, "width"=>120, "fixed"=>true, "label"=>"Application", "edittype"=>"select"));
$grid->setSelect("applicationtype", array( "SimpleBrowserDriver"=>"SimpleBrowserDriver", "SimpleBrowser"=>"SimpleBrowser", "FirefoxDriver"=>"FirefoxDriver","REST"=>"REST","XML"=>"XML"), false, true, true, array(""=>"All"));
$grid->setColProperty("jobcount", array("editable" => false, "width" => 40, "fixed" => true, "label" => "Count"));
$grid->setColProperty("lastmoddatetime", array("editable" => false, "width" =>150, "fixed" => true, "label" => "Last Mod Date"));
$grid->setGridOptions(array(
    "sortable" => true,
    "width" => 1024,
    "height" => 300,
    "caption" => "Jobs",
    "rownumbers" => true,
    "rowNum" => 100,
    "sortname" => "name",
    "sortorder" => "asc",
    "toppager" => true,
    "rowList" => array(10, 20, 30, 50, 100, 500),
));
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf" => true, "excel" => true, "add" => true, "edit" => true, "del" => false, "view" => true, "search" => true));
$grid->setNavOptions('view', array("width" => 750, "dataheight" => 300, "viewCaption" => "Crawler Job Management"));
$grid->setNavOptions('add', array("width" => 750, "dataheight" => 300, "closeOnEscape" => true, "closeAfterAdd" => true, "addCaption" => "Add Job", "reloadAfterSubmit" => false));
$grid->setNavOptions('edit', array("width" => 750, "dataheight" => 300, "closeOnEscape" => true, "closeAfterEdit" => true, "editCaption" => "Update Job", "reloadAfterSubmit" => false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$grid->renderGrid('#grid','#pager',true, null, null,true,true);
$DB = null;
?>
