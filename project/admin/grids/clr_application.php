<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
$grid = new jqGridRender($DB);
$grid->SelectCommand = 'SELECT id, (select url from clr_position cp where cp.id = positionid) url, email, applicationdate, autoapply, candidate from clr_applications';
$grid->table = 'clr_applications';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->setColModel();
$grid->setUrl('../grids/clr_application.php');
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
$grid->setColProperty("url", array("editable"=>false, "frozen"=>true, "width"=>500, "editoptions"=>array("size"=>75, "maxlength"=>200), "formatter"=>"link", "formatoptions"=>array("target"=>"_blank"), "fixed"=>true, "editrules"=>array("url"=>true, "required"=>false), "label"=>"Url"));
$grid->setColProperty("email", array("editable"=>false, "frozen"=>true, "width"=>140, "editoptions"=>array("size"=>75, "maxlength"=>200), "fixed"=>true, "label"=>"Email"));
$grid->setColProperty("applicationdate", array("formatter"=>"date", "width"=>70, "fixed"=>true, "formatoptions"=>array("srcformat"=>"Y-m-d", "newformat"=>"Y-m-d"),
    "editable"=>false, "label"=>"Appl Date",
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
$grid->setColProperty("autoapply", array("editable"=>true, "label"=>"Auto Apply", "width"=>50, "fixed"=>true, "edittype"=>"select"));
$grid->setSelect("autoapply", array("M"=>"M"), false, true, true, array(""=>"All"));
$grid->setColProperty("candidate", array("editable"=>true, "label"=>"Candidate", "width"=>50, "fixed"=>true,  "edittype"=>"select"));
$grid->setSelect("candidate", array("Y"=>"Y","N"=>"N"), false, true, true, array(""=>"All"));
$grid->setGridOptions(array(
    "sortable"=>true,
    "width"=>1024,
    "height"=>400,
    "caption"=>"Crawler Applications",
    "rownumbers"=>true,
    "rowNum"=>1000,
    "sortname"=>"applicationdate desc, id",
    "sortorder"=>"desc",
    "toppager"=>true,
    "rowList"=>array(1000,5000,10000,25000,50000),
));
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>300, "viewCaption"=>"Crawler Applications Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>300, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Crawler Applications","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>300, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Crawler Applications","reloadAfterSubmit"=>false));
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

