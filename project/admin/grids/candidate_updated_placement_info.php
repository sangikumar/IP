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
$grid->SelectCommand = 'SELECT cp.id as id, c.name as cname, cp.placementid as pid,  cp.wrkdesignation, cp.wrkstreetaddress, cp.wrkcity,cp.wrkstate,cp.wrkzip, cp.wrkemail, cp.wrkphone, cp.mgrname, cp.mgrphone, cp.mgremail, cp.hiringmgrname, cp.hiringmgremail, cp.hiringmgrphone, cp.projectname, cp.projectdesc, cp.approved from candidateupdatedplacementinfo cp
join candidate c on cp.candidateid = c.candidateid join placement p on cp.placementid = p.id';
$grid->table = 'candidateupdatedplacementinfo';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->setColModel();
$grid->setUrl('../grids/candidate_updated_placement_info.php');
$grid->setColProperty("id", array("editable"=>false, "width"=>25, "fixed"=>true, "label"=>"CandidateId"));
$grid->setColProperty("cname", array("editable"=>false, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"CName"));
$grid->setColProperty("pid", array("editable"=>false, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"PID"));
$grid->setColProperty("wrkdesignation", array("editable"=>true, "width"=>200, "fixed"=>true,  "label"=>"Work Designation"));
$grid->setColProperty("wrkstreetaddress", array("editable"=>true, "width"=>200, "fixed"=>true,  "label"=>"Work Street Address"));
$grid->setColProperty("wrkcity", array("editable"=>true, "width"=>200, "fixed"=>true, "label"=>"Work City"));
$grid->setColProperty("wrkstate", array("editable"=>true, "width"=>200, "fixed"=>true, "label"=>"Work State"));
$grid->setColProperty("wrkzip", array("editable"=>true, "width"=>200, "fixed"=>true,  "label"=>"Work Zip"));
$grid->setColProperty("wrkemail", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Work Email"));
$grid->setColProperty("wrkphone", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Work Phone"));
$grid->setColProperty("mgrname", array("editable"=>true, "width"=>200, "fixed"=>true,  "label"=>"Manager Name"));
$grid->setColProperty("mgremail", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Manager Email"));
$grid->setColProperty("mgrphone", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Manager Phone"));
$grid->setColProperty("hiringmgrname", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Hiring Manager Name"));
$grid->setColProperty("hiringmgremail", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Hiring Manager Email"));
$grid->setColProperty("hiringmgrphone", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Hiring Manager Phone"));
$grid->setColProperty("projectname", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Project Name"));
$grid->setColProperty("projectdesc", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Project Description"));
$grid->setColProperty("approved", array("editable"=>true, "width"=>90, "fixed"=>true, "label"=>"Approved"));
$grid->setSelect("approved", $yesno , false, true, true, array(""=>"All"));

$grid->setGridOptions(array(
    "sortable"=>true,
    "width"=>1024,
    "height"=>250,
    "caption"=>"Candidate Updated Placement Info ",
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
<?php
/**
 * Created by PhpStorm.
 * User: Shilpi
 * Date: 2/18/2015
 * Time: 5:27 PM
 */