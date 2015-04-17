<?php
/**
 * Created by PhpStorm.
 * User: Shilpi
 * Date: 2/17/2015
 * Time: 4:10 PM
 */
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");
// Create the jqGrid instance
$grid = new jqGridRender($DB);
// Write the SQL Query
$grid->SelectCommand = 'SELECT id, candidateid, name, email, phone, address, city, state, zip, education, workexperience,approved from candidateupdatedpersonalinfo';
$grid->table = 'candidateupdatedpersonalinfo';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->setColModel();
$grid->setUrl('../grids/candidate_updated_personal_info.php');
$grid->setColProperty("id", array("editable"=>false, "width"=>25, "fixed"=>true, "label"=>"CandidateId"));
$grid->setColProperty("candidateid", array("editable"=>false, "width"=>25, "fixed"=>true, "label"=>"CandidateId"));
$grid->setColProperty("name", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Name"));
$grid->setColProperty("email", array("editable"=>true, "width"=>150, "fixed"=>true, "formatter"=>"email", "label"=>"Email"));
$grid->setColProperty("phone", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Phone"));
$grid->setColProperty("education", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Education"));
$grid->setColProperty("workexperience", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Work Experience"));
$grid->setColProperty("address", array("editable"=>true, "width"=>150, "fixed"=>true, "label"=>"Address"));
$grid->setColProperty("city", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"City"));
$grid->setColProperty("state", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"State"));
$grid->setColProperty("country", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Country"));
$grid->setAutocomplete("country",null,"select name, name from (SELECT distinct short_name as name FROM country) p where name like ? ORDER BY name",null,true,true);
$grid->setColProperty("zip", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Zip"));
$grid->setColProperty("approved", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Approved"));
$grid->setSelect("approved", $yesno , false, true, true, array(""=>"All"));

$grid->setGridOptions(array(
    "sortable"=>true,
    "width"=>1024,
    "height"=>250,
    "caption"=>"Candidate Updated Personal Info ",
    "rownumbers"=>true,
    "rowNum"=>30,
    "sortname"=>"id",
    "sortorder"=>"desc",
    "toppager"=>true,
    "rowList"=>array(10,20,30,50,100),

));
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Candidate Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Candidate","reloadAfterSubmit"=>true));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Candidate","reloadAfterSubmit"=>true));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$DB = null;
?>
