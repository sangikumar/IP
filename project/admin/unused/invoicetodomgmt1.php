<?php 
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$userId = $loggedInUser->user_id;
if(!userIdExists($userId)){
  header("Location: invoicetodomgmt.php"); die();
}
//require_once '../tabs.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Invoices ToDo</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" />
<link rel="stylesheet" type="text/css" media="screen" href="../themes/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="../themes/ui.multiselect.css" />
<link href="models/site-templates/default.css" rel='stylesheet' type='text/css' />
<style type="text">
<![CDATA[
        html, body {
        margin: 0;      /* Remove body margin/padding */
        padding: 0;
        overflow: hidden; /* Remove scroll bars on browser window */
        font-size: 75%;
        }
]]>
</style>
<script src="http://code.jquery.com/jquery-1.9.1.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="../js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src='models/funcs.js' type='text/javascript'></script>
<script type="text/javascript">
//<![CDATA[
  $.jgrid.no_legacy_api = true;
  $.jgrid.useJSON = true;
//]]>
</script>
<script src="../js/jquery.jqGrid.min.js" type="text/javascript"></script>
<style>  .ui-menu { width: 130px; }  </style>
<script type="text/javascript">
//<![CDATA[
        $(document).ready(function(){
            $(".link").button();
						$('#mymenu').menu();
						$( "#accordion" ).accordion();
        });
//]]>
</script>
</head>
<body>
<div id='wrapper'>
<div id='top'>
<div id='logo'></div>
</div>
<div id='content'>
<h1>INNOVAPATH, INC. - Avatar</h1>
<br />
<br />
<br />
<div id='left-nav'><?php include("left-nav.php");  ?></div>
<div id='main'>
<h2 style="text-align:left">Invoices TODO</h2><br>
<?php
include_once ("../../auth.php");
include_once ("../../authconfig.php");
$connection = mysql_connect($dbhost, $dbusername, $dbpass);
$SelectedDB = mysql_select_db($dbname);	
echo "<div id='accordion' style='width:800px'>";

  $rs = mysql_query("select id poid, begindate pobegindate, invoicestartdate, freqtype, frequency, placementid, enddate poenddate, rate, invoicenet, null invoicenumber, invoicestartdate invoicedate, null enddate from po p  where p.invoicestartdate > '1900-01-01' and p.enddate <> p.begindate and (p.enddate is null or p.enddate > CURDATE() - 60)  and p.invoicestartdate < CURDATE() and  p.id not in (select distinct poid from invoice)  union  select i.poid, p.begindate pobegindate, p.invoicestartdate, p.freqtype, p.frequency, p.placementid,  p.enddate poenddate, p.rate, p.invoicenet, i.invoicenumber, i.invoicedate, i.enddate from invoice i, po p  where i.poid  = p.id and p.invoicestartdate > '1900-01-01' and  p.enddate <> p.begindate and  (p.enddate is null or p.enddate > CURDATE() - 60) and i.invoicedate < CURDATE()  and i.id = (select max(iv.id) from invoice iv where iv.poid = i.poid) order by invoicedate asc");
  $num_rows = mysql_num_rows($rs);
	if($num_rows > 0)
  {    
    while($data = mysql_fetch_row($rs)){
				
				$poid = $data[0];
				$pobegindate = $data[1];
				$invoicestartdate = $data[2];		
				$freqtype = $data[3];
				$frequency = $data[4];						
				$placementid = $data[5];
				$poenddate = $data[6];
				$porate = $data[7];				
				$invoicenet = $data[8];		
				$invoicenumber = $data[9];
				$invoicedate = $data[10];				
				$invoiceenddate = $data[11];								
				
        $result = mysql_query("select concat(c.name, '-', v.companyname, '-', cl.companyname) as name from placement pl, candidate c, vendor v, client cl  where pl.candidateid = c.candidateid  and pl.vendorid = v.id and pl.clientid = cl.id and pl.id = $placementid");
        $row = mysql_fetch_array($result);		
				$po = 	$row["name"];			
					
				echo("<h3>$po</h3><div>");				
				echo("<strong id='show_heading'>PO Period: </strong>$pobegindate to $poenddate<br />");
				echo("<strong id='show_heading'>PO ID: </strong>$poid<br />");
				echo("<strong id='show_heading'>Invoice Start Date: </strong>$invoicestartdate<br />");
				echo("<strong id='show_heading'>Rate: </strong>$porate<br />");
				echo("<strong id='show_heading'>Frequency Type: </strong>$freqtype - $frequency<br />");
				echo("<strong id='show_heading'>Net: </strong>$invoicenet<br /><br />");
								
        switch ($freqtype) {
           case "W":
	
    					 if(isset($invoicenumber))
    					 {
    					 	$periodbegindate = strtotime("+1 day", strtotime($invoiceenddate));
    					 }
    					 else
    					 {
    					 	$periodbegindate = strtotime($pobegindate);
    					 }
				      
                $enddate = strtotime("next sunday", $periodbegindate);
								$beginsunday = strtotime("last sunday", $periodbegindate);
                $nextinvoicedate = strtotime("+1 week", $periodbegindate);
                $daynum = date("N", $nextinvoicedate);
                if($daynum != 1)
                {
							 	 $nextinvoicedate = strtotime("previous monday", $nextinvoicedate);
                }
        				$nextinvoicedate = date("Y-m-d", $nextinvoicedate);	
        				$pobegindate = date("Y-m-d", $pobegindate);
        				$enddate = date("Y-m-d", $enddate);	
        				$beginsunday = date("Y-m-d", $beginsunday);				
								
        				echo("<strong id='show_heading'>Invoice Period:</strong> $pobegindate to $enddate<br />");
        				echo("<strong id='show_heading'>Invoice Date:</strong> $nextinvoicedate<br /><br />");
        				
                $rs1 = mysql_query("select sum(monday+tuesday+wednesday+thursday+friday) regular, sum(saturday+sunday) overtime from timesheetdetail t where poid = $poid and t.weekenddate > '$beginsunday' and t.weekenddate <= '$enddate'");
                $row1 = mysql_fetch_array($rs1);	
        				if(isset($row1[0]) && isset($row1[1]))
        				{
          				echo("<strong id='show_heading'>Regular Hours:</strong> $row1[0]<br />");
                  echo("<strong id='show_heading'>Overtime:</strong> $row1[1]<br />");
                }
        				else
        				{
        				 		echo("<strong id='show_heading'>No Timesheets entered.</strong><br />");
        				}								
													
                break;
           case "M":
					       $enddate = date("Y-m-t", strtotime($pobegindate));
								 $nextinvoicedate = strtotime("+1 day", strtotime($enddate));
								 $nextinvoicedate = date("Y-m-d", $nextinvoicedate);	
								 $beginsunday = date("Y-m-d", strtotime("last sunday", strtotime($pobegindate)));
								 $nextsunday = date("Y-m-d", strtotime("next sunday", strtotime($enddate)));		
								 $lastsunday = date("Y-m-d", strtotime("last sunday", strtotime($enddate)));	
        				

								$diff = floor(abs(strtotime($enddate) - strtotime($lastsunday))/(60*60*24));
								
								if($diff == 7)
								{
								 		$isSunday = true;
										$lastsunday = $nextsunday;
								}
								{
								 		$isSunday = false;
								}
								
									
                $rs1 = mysql_query("select sum(monday+tuesday+wednesday+thursday+friday) regular, sum(saturday+sunday) overtime from timesheetdetail t where poid = $poid and t.weekenddate > '$beginsunday' and t.weekenddate <= '$lastsunday'");
                $row1 = mysql_fetch_array($rs1);	
        				if(isset($row1[0]) && isset($row1[1]))
        				{
          				$regularhours = $row1[0];
									$overtimehours = $row1[1];
                }
        				else
        				{
          				$regularhours = 0;
									$overtimehours = 0;
        				}														
								
								if(!$isSunday)
								{
                  switch ($diff) {
                    case 1:
                    		 $sql = "select sum(monday), 0 regular from timesheetdetail t where poid = $poid and t.weekenddate = '$nextsunday'";
                    		 break;
                    case 2:
                    		 $sql = "select sum(monday+tuesday), 0 regular from timesheetdetail t where poid = $poid and t.weekenddate = '$nextsunday'";
                    		 break; 
                    case 3:
                    		 $sql = "select sum(monday+tuesday+wednesday), 0 regular from timesheetdetail t where poid = $poid and t.weekenddate = '$nextsunday'";
                    		 break; 
                    case 4:
                    		 $sql = "select sum(monday+tuesday+wednesday+thursday), 0 regular from timesheetdetail t where poid = $poid and t.weekenddate = '$nextsunday'";
                    		 break; 
                    case 5:
                    		 $sql = "select sum(monday+tuesday+wednesday+thursday+friday), 0 regular from timesheetdetail t where poid = $poid and t.weekenddate = '$nextsunday'";
                    		 break; 
                    case 6:
                    		 $sql = "select sum(monday+tuesday+wednesday+thursday+friday), sum(saturday) regular from timesheetdetail t where poid = $poid and t.weekenddate = '$nextsunday'";
                    		 break; 																																																
									}
                  $row2 = mysql_fetch_array(mysql_query($sql));	
          				if(isset($row2[0]) && isset($row2[1]))
          				{
            				$regularhours = $regularhours + $row2[0];
  									$overtimehours = $overtimehours + $row2[1];
                  }
								}
								$total = $regularhours + $overtimehours;
								$invoiceamount = $total * $porate;
								$invoiceamount1 = money_format('%(#10n', $invoiceamount);
								echo("<strong id='show_heading'>Invoice Period: </strong>$pobegindate to $enddate<br />");
								echo("<strong id='show_heading'>Invoice Amount: </strong>$invoiceamount1<br />");
        				echo("<strong id='show_heading'>Invoice Date: </strong>$nextinvoicedate<br /><br />");									
								
								echo("<strong id='show_heading'>Regular Hours:</strong> $regularhours<br />");
								echo("<strong id='show_heading'>Overtime Hours:</strong> $overtimehours<br />");
								echo("<strong id='show_heading'>Total:</strong> $total<br />");
								break;
					 case "D":
					       $enddate = date("Y-m-d", strtotime("+$frequency day", strtotime($pobegindate)));
								 $nextinvoicedate = date("Y-m-d", strtotime("+1 day", strtotime($enddate)));
								 $beginsunday = date("Y-m-d", strtotime("last sunday", strtotime($pobegindate)));
								 $nextsunday = date("Y-m-d", strtotime("next sunday", strtotime($enddate)));		
								 $lastsunday = date("Y-m-d", strtotime("last sunday", strtotime($enddate)));	
        				

								$diff = floor(abs(strtotime($enddate) - strtotime($lastsunday))/(60*60*24));
								
								if($diff == 7)
								{
								 		$isSunday = true;
										$lastsunday = $nextsunday;
								}
								{
								 		$isSunday = false;
								}
								
									
                $rs1 = mysql_query("select sum(monday+tuesday+wednesday+thursday+friday) regular, sum(saturday+sunday) overtime from timesheetdetail t where poid = $poid and t.weekenddate > '$beginsunday' and t.weekenddate <= '$lastsunday'");
                $row1 = mysql_fetch_array($rs1);	
        				if(isset($row1[0]) && isset($row1[1]))
        				{
          				$regularhours = $row1[0];
									$overtimehours = $row1[1];
                }
        				else
        				{
          				$regularhours = 0;
									$overtimehours = 0;
        				}														
								
								if(!$isSunday)
								{
                  switch ($diff) {
                    case 1:
                    		 $sql = "select sum(monday), 0 regular from timesheetdetail t where poid = $poid and t.weekenddate = '$nextsunday'";
                    		 break;
                    case 2:
                    		 $sql = "select sum(monday+tuesday), 0 regular from timesheetdetail t where poid = $poid and t.weekenddate = '$nextsunday'";
                    		 break; 
                    case 3:
                    		 $sql = "select sum(monday+tuesday+wednesday), 0 regular from timesheetdetail t where poid = $poid and t.weekenddate = '$nextsunday'";
                    		 break; 
                    case 4:
                    		 $sql = "select sum(monday+tuesday+wednesday+thursday), 0 regular from timesheetdetail t where poid = $poid and t.weekenddate = '$nextsunday'";
                    		 break; 
                    case 5:
                    		 $sql = "select sum(monday+tuesday+wednesday+thursday+friday), 0 regular from timesheetdetail t where poid = $poid and t.weekenddate = '$nextsunday'";
                    		 break; 
                    case 6:
                    		 $sql = "select sum(monday+tuesday+wednesday+thursday+friday), sum(saturday) regular from timesheetdetail t where poid = $poid and t.weekenddate = '$nextsunday'";
                    		 break; 																																																
									}
                  $row2 = mysql_fetch_array(mysql_query($sql));	
          				if(isset($row2[0]) && isset($row2[1]))
          				{
            				$regularhours = $regularhours + $row2[0];
  									$overtimehours = $overtimehours + $row2[1];
                  }
								}
								$total = $regularhours + $overtimehours;
								$invoiceamount = $total * $porate;
								$invoiceamount1 = money_format('%(#10n', $invoiceamount);
								echo("<strong id='show_heading'>Invoice Period: </strong>$pobegindate to $enddate<br />");
								echo("<strong id='show_heading'>Invoice Amount: </strong>$invoiceamount1<br />");
        				echo("<strong id='show_heading'>Invoice Date: </strong>$nextinvoicedate<br /><br />");									
								
								echo("<strong id='show_heading'>Regular Hours:</strong> $regularhours<br />");
								echo("<strong id='show_heading'>Overtime Hours:</strong> $overtimehours<br />");
								echo("<strong id='show_heading'>Total:</strong> $total<br />");
								break;
						 
								 
        }			


			
		
				
				echo("</div>");
    }		 
  }

echo("</div>");



?>

</div>
<div id='bottom'></div>
</div>
<br />
<br />
</body>
</html>