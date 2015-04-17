<?php

require_once($_SERVER["SERVER_NAME"] . "/projects/admin/ip-includes/gridincludes.php");


$grid = new jqGridRender($DB);


$grid->SelectCommand = 'SELECT id, name, email, phone, status, startdate, mgrid, designationid, personalemail, personalphone, dob, address, city, state, country, zip, skypeid, salary, commission, commissionrate, type, empagreementurl, offerletterurl, dlurl, workpermiturl, contracturl, enddate, loginid, responsibilities, notes FROM employee';
$grid->table = 'employee';
$grid->setPrimaryKeyId('id');
$grid->serialKey = false;
$grid->dataType = 'json';
$grid->datearray = array('startdate', 'enddate');
$grid->setUserDate("Y-m-d");
$grid->setColModel();
$grid->setUrl('../grids/employee.php');
$grid->setColProperty("id", array("editable" => false, "width" => 25, "fixed" => true, "label" => "ID"));
$grid->setColProperty("name", array("editable" => true, "frozen" => true, "width" => 200, "editoptions" => array("size" => 75, "maxlength" => 200), "fixed" => true, "label" => "Name"));
$grid->setColProperty("startdate", array("formatter" => "date", "width" => 70, "fixed" => true, "formatoptions" => array("srcformat" => "Y-m-d", "newformat" => "Y-m-d"),
    "editable" => true, "label" => "Start Date",
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
$grid->setColProperty("email", array("editable" => true, "width" => 150, "editoptions" => array("size" => 75, "maxlength" => 200), "fixed" => true, "formatter" => "email", "editrules" => array("email" => true, "required" => true), "label" => "Email"));
$grid->setColProperty("phone", array("editable" => true, "width" => 90, "editoptions" => array("size" => 75, "maxlength" => 200), "fixed" => true, "label" => "Phone"));
$grid->setColProperty("status", array("editable" => true, "width" => 70, "fixed" => true, "label" => "Status", "edittype" => "select"));
$grid->setSelect("status", $employeestatus, false, true, true, array("" => "All"));
$grid->setColProperty("personalemail", array("editable" => true, "width" => 150, "editoptions" => array("size" => 75, "maxlength" => 200), "fixed" => true, "formatter" => "email", "editrules" => array("email" => true, "required" => false), "label" => "Personal Email"));
$grid->setColProperty("personalphone", array("editable" => true, "width" => 90, "editoptions" => array("size" => 75, "maxlength" => 200), "fixed" => true, "label" => "Personal Phone"));
$grid->setColProperty("dob", array("formatter" => "date", "width" => 70, "fixed" => true, "formatoptions" => array("srcformat" => "Y-m-d", "newformat" => "Y-m-d"),
    "editable" => true, "label" => "Birth Date",
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
$grid->setColProperty("address", array("editable" => true, "width" => 150, "editoptions" => array("size" => 75, "maxlength" => 200), "fixed" => true, "label" => "Address"));
$grid->setColProperty("city", array("editable" => true, "width" => 90, "editoptions" => array("size" => 75, "maxlength" => 200), "fixed" => true, "label" => "City"));
$grid->setColProperty("state", array("editable" => true, "width" => 90, "editoptions" => array("size" => 75, "maxlength" => 200), "fixed" => true, "label" => "State"));
$grid->setColProperty("country", array("editable" => true, "width" => 90, "editoptions" => array("size" => 75, "maxlength" => 200), "fixed" => true, "label" => "Country"));
$grid->setColProperty("zip", array("editable" => true, "width" => 90, "fixed" => true, "label" => "Zip"));
$grid->setColProperty("skypeid", array("editable" => true, "width" => 90, "fixed" => true, "label" => "Skype"));
$grid->setColProperty("salary", array("editable" => true, "width" => 90, "formatter" => "currency", "formatoptions" => array("decimalPlaces" => 2, "thousandsSeparator" => ",", "prefix" => "$"), "sorttype" => "currency", "fixed" => true, "label" => "Salary"));
$grid->setColProperty("commission", array("editable" => true, "label" => "Commission", "width" => 50, "fixed" => true, "edittype" => "select"));
$grid->setSelect("commission", $yesno, false, true, true, array("" => "All"));
$grid->setColProperty("commissionrate", array("editable" => true, "width" => 70, "fixed" => true, "editrules" => array("minValue" => 0, "maxValue" => 10), "label" => "Comm Rate"));
$grid->setColProperty("type", array("editable" => true, "label" => "Type", "width" => 90, "fixed" => true, "edittype" => "select"));
$grid->setSelect("type", array("Full Time" => "Full Time", "Part Time" => "Part Time"), false, true, true, array("" => "All"));
$grid->setColProperty("contracturl", array("editable" => true, "frozen" => true, "width" => 200, "editoptions" => array("size" => 75, "maxlength" => 200), "formatter" => "link", "formatoptions" => array("target" => "_blank"), "fixed" => true, "editrules" => array("url" => true, "required" => false), "label" => "Contract Url"));
$grid->setColProperty("empagreementurl", array("editable" => true, "frozen" => true, "width" => 200, "editoptions" => array("size" => 75, "maxlength" => 200), "formatter" => "link", "formatoptions" => array("target" => "_blank"), "fixed" => true, "editrules" => array("url" => true, "required" => false), "label" => "Emp Agreement Url"));
$grid->setColProperty("offerletterurl", array("editable" => true, "frozen" => true, "width" => 200, "editoptions" => array("size" => 75, "maxlength" => 200), "formatter" => "link", "formatoptions" => array("target" => "_blank"), "fixed" => true, "editrules" => array("url" => true, "required" => false), "label" => "Offer Letter Url"));
$grid->setColProperty("dlurl", array("editable" => true, "frozen" => true, "width" => 200, "editoptions" => array("size" => 75, "maxlength" => 200), "formatter" => "link", "formatoptions" => array("target" => "_blank"), "fixed" => true, "editrules" => array("url" => true, "required" => false), "label" => "DL Url"));
$grid->setColProperty("workpermiturl", array("editable" => true, "frozen" => true, "width" => 200, "editoptions" => array("size" => 75, "maxlength" => 200), "formatter" => "link", "formatoptions" => array("target" => "_blank"), "fixed" => true, "editrules" => array("url" => true, "required" => false), "label" => "Work Permit Url"));
$grid->setColProperty("mgrid", array("editable" => true, "frozen" => true, "width" => 100, "fixed" => true, "label" => "Manager", "edittype" => "select"));
$grid->setSelect("mgrid", "select '' as id, '' as name from dual union SELECT distinct id, name FROM employee where status = '0Active' order by name");
$grid->setColProperty("designationid", array("editable" => true, "frozen" => true, "width" => 120, "fixed" => true, "label" => "Designation", "edittype" => "select"));
$grid->setSelect("designationid", "select '' as id, '' as name from dual union SELECT distinct id, name FROM designation order by name");
$grid->setColProperty("enddate", array("formatter" => "date", "width" => 70, "fixed" => true, "formatoptions" => array("srcformat" => "Y-m-d", "newformat" => "Y-m-d"),
    "editable" => true, "label" => "End Date",
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
$grid->setColProperty("loginid", array("editable" => true, "frozen" => true, "width" => 170, "fixed" => true, "label" => "Login ID", "edittype" => "select"));
$grid->setSelect("loginid", "select '' as id, '' as name from dual union select distinct u.id as id, concat(u.display_name, '-', u.email) as name from uc_users u, uc_user_permission_matches up where u.id = up.user_id and up.permission_id not in (13,14) order by name");
$grid->setColProperty("responsibilities", array("editable" => true, "hidden" => true, "edittype" => "textarea", "editrules" => array("edithidden" => true, "required" => false), "editoptions" => array("rows" => 6, "cols" => 80), "label" => "Responsibilities"));
$grid->setColProperty("notes", array("editable" => true, "width" => 400, "fixed" => true, "edittype" => "textarea", "editoptions" => array("rows" => 6, "cols" => 60), "label" => "Notes"));
$grid->setGridOptions(array(
    "sortable" => true,
    "width" => 1024,
    "height" => 400,
    "caption" => "Employee Management",
    "rownumbers" => true,
    "rowNum" => 100,
    "sortname" => "status asc, type asc, name asc, startdate",
    "sortorder" => "desc",
    "toppager" => true,
    "rowList" => array(10, 20, 30, 50, 100),
));
$grid->showError = true;
$grid->navigator = true;
$grid->setNavOptions('navigator', array("pdf" => true, "excel" => true, "add" => true, "edit" => true, "del" => false, "view" => true, "search" => true));
$grid->setNavOptions('view', array("width" => 750, "dataheight" => 500, "viewCaption" => "Employee Management"));
$grid->setNavOptions('add', array("width" => 750, "dataheight" => 500, "closeOnEscape" => true, "closeAfterAdd" => true, "addCaption" => "Add Employee", "reloadAfterSubmit" => false));
$grid->setNavOptions('edit', array("width" => 750, "dataheight" => 500, "closeOnEscape" => true, "closeAfterEdit" => true, "editCaption" => "Update Employee", "reloadAfterSubmit" => false));
$grid->callGridMethod('#grid', 'setFrozenColumns');
$grid->callGridMethod('#grid', 'gridResize');
$bindkeys = <<<KEYS
$("#grid").jqGrid('bindKeys', {"onEnter":function( rowid ) { alert("You enter a row with id:"+rowid)} } );
KEYS;
$grid->setJSCode($bindkeys);
$grid->renderGrid('#grid', '#pager', true, $summaryrows, null, true, true);
$DB = null;
?>