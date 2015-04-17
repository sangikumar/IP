<?php session_start();
###########################################################
/*
GuestBook Script
Copyright (C) 2012 StivaSoft ltd. All rights Reserved.


This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see http://www.gnu.org/licenses/gpl-3.0.html.

For further information visit:
http://www.phpjabbers.com/
info@phpjabbers.com

Version:  1.0
Released: 2012-03-18
*/
###########################################################

$user = $_REQUEST['user'];
$_SESSION['us'] = $user;
//error_reporting(0);
require("./config.php");
 //$db = JFactory::getDBO();
/// get current month and year and store them in $cMonth and $cYear variables
(intval($_REQUEST["month"])>0) ? $cMonth = $_REQUEST["month"] : $cMonth = date("n");
(intval($_REQUEST["year"])>0) ? $cYear = $_REQUEST["year"] : $cYear = date("Y");

if ($cMonth<10) $cMonth = '0'.$cMonth;

// generate an array with all unavailable dates
$sql = "SELECT * FROM ".$SETTINGS["data_table"]." WHERE `date` LIKE '".$cYear."-".$cMonth."-%'";

//$sql = "SELECT * FROM edsafe_calendar WHERE `date` LIKE '".$cYear."-".$cMonth."-%'";
$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
while ($row = mysql_fetch_assoc($sql_result)) {
	$unavailable[] = $row["date"];
}

// calculate next and prev month and year used for next / prev month navigation links and store them in respective variables
$prev_year = $cYear;
$next_year = $cYear;
$prev_month = intval($cMonth)-1;
$next_month = intval($cMonth)+1;

// if current month is Decembe or January month navigation links have to be updated to point to next / prev years
if ($cMonth == 12 ) {
	$next_month = 1;
	$next_year = $cYear + 1;
} elseif ($cMonth == 1 ) {
	$prev_month = 12;
	$prev_year = $cYear - 1;
}
?>
  <table width="100%">
  <tr>
      <td class="mNav"><a href="javascript:LoadMonth('<?php echo $prev_month; ?>', '<?php echo $prev_year; ?>')">&lt;&lt;</a></td>
      <td colspan="5" class="cMonth"><?php echo date("F, Y",strtotime($cYear."-".$cMonth."-01")); ?></td>
      <td class="mNav"><a href="javascript:LoadMonth('<?php echo $next_month; ?>', '<?php echo $next_year; ?>')">&gt;&gt;</a></td>
  </tr>
  <tr>
      <td class="wDays">M</td>
      <td class="wDays">T</td>
      <td class="wDays">W</td>
      <td class="wDays">T</td>
      <td class="wDays">F</td>
      <td class="wDays">S</td>
      <td class="wDays">S</td>
  </tr>
<?php 
$first_day_timestamp = mktime(0,0,0,$cMonth,1,$cYear); // time stamp for first day of the month used to calculate 
$maxday = date("t",$first_day_timestamp); // number of days in current month
$thismonth = getdate($first_day_timestamp); // find out which day of the week the first date of the month is
  $startday = $thismonth['wday'] ; // 0 is for Sunday and as we want week to start on Mon we subtract 1


$getleave = "select * from edsafe_manageleaves where Isemployee=1 and school_id='".$_SESSION['us']."'";
  $qu = mysql_query($getleave);
 $exidat = array();
  while($resss = mysql_fetch_object($qu)){
  $title = $resss->title;
  $exidat[] =  $resss->end_date;  
  }
 

if (!$thismonth['wday']) $startday = 7;
for ($i=1; $i<($maxday+$startday); $i++) {
	
	if (($i % 7) == 1 ) echo "<tr>";
	
	if ($i < $startday) { echo "<td>&nbsp;</td>"; continue; };
	
	$current_day = $i - $startday + 1;
	
	(in_array($cYear."-".$cMonth."-".$current_day,$unavailable)) ? $css='booked' : $css='available'; // set css class name based on date availability

if(in_array($cYear."-".$cMonth."-".$current_day,$exidat)) { $css='Savailable'; }


// find out the attendance of that day.

 $cd =  $cYear."-".$cMonth."-".$current_day;
 
 $sql = "SELECT * FROM edsafe_employeeattendance  WHERE `date` = '".$cd."'";

 
$sql_date = mysql_query ($sql); 

$abc = 0;
while($res_d = mysql_fetch_object($sql_date)){
$abc = $abc+1;
 
$new_arr = array();
$new_arr = explode('-',$res_d->date);
 
 

}


 

	 $dt=$cYear."-".$cMonth."-".$current_day;  
       $timestamp = strtotime($dt);

     $day_name = date('l', $timestamp);
   if($day_name=='Sunday'){ $css = 'Savailable'; }

   // find date 
    $cudate = date('d', $timestamp);  
     $curren_date = date('d'); 
  if($cudate==$curren_date && $day_name!='Sunday'){
     $css = 'cdate';
   }


  if($new_arr[2]==$current_day){
  
 $css = "attended";
 }
 if($new_arr[2]==$current_day && $cudate==$curren_date && $day_name!='Sunday'){
 $css = "cdatattended";
 }



	echo "<td class='".$css."'><a href='#' onclick='showHint( \"".$dt."\" );lightbox_open();'> ". $current_day . "</a></td>";
	
	if (($i % 7) == 0 ) echo "</tr>";
}
?> 
</table>





