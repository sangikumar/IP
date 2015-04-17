<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);
$grid->SelectCommand = 'SELECT id, jobid, url, jobdate, category, status, emailsextracted from clr_position';
$grid->table = 'clr_position';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->setColModel();
$grid->setUrl('../grids/clr_position.php');
$grid->addCol(array(
    "name"=>"Actions",
    "formatter"=>"actions",
    "editable"=>false,
    "sortable"=>false,
    "resizable"=>false,
    "fixed"=>true,
    "width"=>60,
    "formatoptions"=>array("keys"=>true)
), "first");
$grid->setColProperty("id", array("editable" => false, "width" => 40, "fixed" => true, "label" => "ID"));
$grid->setColProperty("jobid", array("editable"=>false, "frozen"=>true, "width"=>100, "fixed"=>true, "label"=>"Job", "edittype"=>"select"));
$grid->setSelect("jobid", "SELECT distinct id, name FROM clr_job order by id");
$grid->setColProperty("url", array("editable"=>false, "frozen"=>true, "width"=>450, "editoptions"=>array("size"=>75, "maxlength"=>200), "formatter"=>"link", "formatoptions"=>array("target"=>"_blank"), "fixed"=>true, "editrules"=>array("url"=>true, "required"=>false), "label"=>"Url"));
$grid->setColProperty("jobdate", array("formatter"=>"date", "width"=>70, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"),
    "editable"=>true, "label"=>"Job Date",
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
$grid->setColProperty("category", array("editable"=>false, "frozen"=>true, "width"=>70, "fixed"=>true, "label"=>"Category", "edittype"=>"select"));
$grid->setSelect("category", "SELECT distinct category, category FROM clr_position order by category");
$grid->setColProperty("category", array("editable"=>true, "frozen"=>true, "width"=>90, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Category"));
$grid->setColProperty("status", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Status", "edittype"=>"select"));
$grid->setSelect("status", array( "Active"=>"Active","Invalid"=>"Invalid","Expired"=>"Expired"), false, true, true, array(""=>"All"));
$grid->setColProperty("emailsextracted", array("editable"=>true, "label"=>"Emails Extract", "width"=>50, "fixed"=>true,  "edittype"=>"select"));
$grid->setSelect("emailsextracted", $yesno , false, true, true, array(""=>"All"));

$grid->setGridOptions(array(
    "sortable"=>true,
    "width"=>1024,
    "height"=>400,
    "caption"=>"Crawler Jobs",
    "rownumbers"=>true,
    "rowNum"=>1000,
    "sortname"=>"jobdate desc, jobid",
    "sortorder"=>"asc",
    "toppager"=>true,
    "rowList"=>array(1000,5000,10000,25000,50000),
));
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>300, "viewCaption"=>"Crawler Job Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>300, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Crawler Job","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>300, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Crawler Job","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
GLOBAL $htmlcode;
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) {

                   alert("You enter a row with id:"+rowid + rowData.name);
                     } } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$DB = null;
?>

