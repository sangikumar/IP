<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridincludes.php");

// Create the jqGrid instance
$grid = new jqGridRender($DB);
// Write the SQL Query
$grid->SelectCommand = 'SELECT id, vendorid, candidateid , name, url, type FROM agreement';
$grid->table = 'agreement';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->setColModel();
$grid->setUrl('../grids/agreement.php');
$grid->setColProperty("id", array("editable"=>false, "width"=>25, "fixed"=>true, "label"=>"ID"));
$grid->setColProperty("vendorid", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Vendor", "edittype"=>"select"));
$grid->setSelect("vendorid", "select '' as id, '' as name from dual union SELECT distinct id as id, companyname as name FROM vendor order by name");
$grid->setColProperty("candidateid", array("editable"=>true, "frozen"=>true, "width"=>200, "fixed"=>true, "label"=>"Candidate Name", "edittype"=>"select"));
$grid->setSelect("candidateid", "select '' as id , '  None' as name from dual union SELECT distinct candidateid as id, name as name FROM candidate where status = 'Placed' order by name ");
$grid->setColProperty("name", array("editable"=>true, "width"=>100, "fixed"=>true, "label"=>"Name"));
$grid->setColProperty("url", array("editable"=>true, "width"=>120, "fixed"=>true, "formatter"=>"link","label"=>"Url"));
$grid->setColProperty("type", array("editable"=>true, "width"=>70, "fixed"=>true, "label"=>"Type", "edittype"=>"select"));
$grid->setSelect("type", $agreementtype , false, true, true, array(""=>"All"));
$grid->setGridOptions(array(
    "sortable"=>true,
    "width"=>1024,
    "height"=>250,
    "caption"=>"Agreement Management",
    "rownumbers"=>true,
    "rowNum"=>1000,
    "footerrow"=>true,
    "userDataOnFooter"=>true,
    "shrinkToFit"=>false,
    "sortname"=>"id",
    "sortorder"=>"desc",
    "toppager"=>true,
    "rowList"=>array(10,50,100,500,1000),
));
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf"=>true,"excel"=>true,"add"=>true,"edit"=>true,"del"=>false,"view"=>true, "search"=>true));
$grid->setNavOptions('view',array("width"=>750, "dataheight"=>500, "viewCaption"=>"Agreement Management"));
$grid->setNavOptions('add',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterAdd"=>true, "addCaption"=>"Add Agreement","reloadAfterSubmit"=>false));
$grid->setNavOptions('edit',array("width"=>750, "dataheight"=>500, "closeOnEscape"=>true, "closeAfterEdit"=>true,"editCaption"=>"Update Agreement","reloadAfterSubmit"=>false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys =<<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid','#pager',true, $summaryrows, null, true,true);
$DB = null;
?>
<?php
/**
 * Created by PhpStorm.
 * User: Shilpi
 * Date: 2/23/2015
 * Time: 4:40 PM
 */