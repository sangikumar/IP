<?php 
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$userId = $loggedInUser->user_id;
$candidateID = $loggedInUser->candidateid;
if(!userIdExists($userId)){header("Location:login.php"); die();}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Candidate Timesheet</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" />
<link rel="stylesheet" href="http://gregfranko.com/jquery.selectBoxIt.js/css/jquery.selectBoxIt.css" />
<link href="/project/admin/models/site-templates/default.css" rel='stylesheet' type='text/css' />
<link href="/project/js/datepicker/zebra_datepicker.css" rel='stylesheet' type='text/css' />
<link href="http://hayageek.github.io/jQuery-Upload-File/uploadfile.min.css" rel="stylesheet">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script src="http://gregfranko.com/jquery.selectBoxIt.js/js/jquery.selectBoxIt.min.js"></script>
<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script src="/project/js/datepicker/zebra_datepicker.js" type="text/javascript"></script>
<script src="/project/js/numericInput.min.js" type="text/javascript"></script>
<script src="http://hayageek.github.io/jQuery-Upload-File/jquery.uploadfile.min.js"></script>
<style>  
.ui-menu { width: 130px; }  
.selectboxit-container .selectboxit-options {
    width: 250px;
    max-height: 240px;
  }
</style>
<script type="text/javascript">
  $(document).ready(function(){
      $(".link").button();
			$('#mymenu').menu();
			$('#loader').hide();
			$('#show_heading').hide();
			$('#show_content').hide();
			$('select').selectBoxIt();
			
			$('#timesheet').change(function(){
				$('#show_content').fadeOut();
				if(inp.val().length > 0){          		
          		$('#loader').show();
				$.post("../ajax-content/get-can-timesheet.php", {
          			parent_id: $('#timesheet').val(),
          		}, function(response){          			
          			setTimeout("finishAjax('show_content', '"+escape(response)+"')", 400);
          		});			
				}
          		return false;
          	});		
						
        		var inp = $("#timesheet");
            	if (inp.val().length > 0){
            		$('#show_content').fadeOut();
            		$('#loader').show();						
            		$.post("../ajax-content/get-can-timesheet.php", {
            			parent_id: $('#timesheet').val()
            		}, function(response){          			
            			setTimeout("finishAjax('show_content', '"+escape(response)+"')", 400);
            		});							
              }							
										
        });
//]]>

function finishAjax(id, response){
	$('#loader').hide();
	$('#show_heading').show();
	$('#show_heading').empty();
	$('#'+id).html(unescape(response));
	$('#'+id).fadeIn();
	new nicEditor({maxHeight : 300}).panelInstance('notes');
	$('input').addClass("ui-corner-all");
	$('select').addClass("ui-corner-all");
	$('#send').button();	
	$('#weekenddate').Zebra_DatePicker({
	  disabled_dates: ['* * * 1,2,3,4,5,6']   // all days, all monts, all years as long
	});
	$(".timesheetday").numericInput({ allowFloat: true, allowNegative: false });
  $("#fileuploader").uploadFile({
		url:"../utils/upload.php",
		fileName:"myfile",
		dragDropStr: "<span><b>Upload or Drop timesheets here...</b></span>",
		formData: {"type":"timesheet","poid":$('#assignment').val(),"timesheetid":$('#timesheet').val()}
  });
} 

</script>
</head>
<body>
<div id='wrapper'>
<div id='top'>
  <div id='logo'></div>
</div>
<div id='content'><br />
  <div id='left-nav'>
<?php 
		include($_SERVER["DOCUMENT_ROOT"] ."/project/admin/left-nav.php");  
?>
  </div>
  <div id='main'>
    <?php
	// Check if All Work Information is added correctly
	$result1 = $mysqli->query("select cu.approved from candidateupdatedplacementinfo cu join placement p
		        on  cu.placementid = p.id join candidate c on c.candidateid = p.candidateid and c.candidateid = ".$candidateID);
	$rows1 = $result1->fetch_assoc();
	if ($rows1['approved'] == 'N'){
		echo '<div class="error">Verification Pending/ Missing Work Information: </div>';
		echo '<p>If you see this message, please update all your work information and get it approved by HR.
                 The system will not start payment cycle otherwise.</p>';
		die;
	}


   	$result = $mysqli->query("select p.id poid, CONCAT(c.companyname, '- ', DATE_FORMAT(p.begindate,'%m.%d.%Y')) as assignment  from po p, placement pl, client c where p.placementid = pl.id and pl.clientid = c.id and pl.candidateid = $candidateID order by poid desc limit 1");	
  	$row =$result->fetch_row();
  	$po = $row[0];
	
//	echo $po;

if (!empty($_POST))
{    
	$weekenddate = $_POST['weekenddate'];
	$monday = $_POST['monday'];
	$tuesday = $_POST['tuesday'];
	$wednesday = $_POST['wednesday'];
	$thursday = $_POST['thursday'];
	$friday = $_POST['friday'];
	$saturday = $_POST['saturday'];
	$sunday = $_POST['sunday'];
	$notes = $_POST['notes'];
	$timesheetid = $_POST['timesheetid'];
	$assignment = $_POST['assignment'];
	$use = 0;
	if(isset($assignment))
	{
		$po = $assignment;
	}				
	if(isset($weekenddate) and !empty($weekenddate) and $weekenddate != "0000-00-00")
	{
		if($timesheetid != -1)
		{
			$updatesql = "update timesheetdetail p set p.notes = '$notes', p.weekenddate = '$weekenddate', p.monday = '$monday', p.tuesday = '$tuesday', 		p.wednesday = '$wednesday', p.thursday = '$thursday', p.friday = '$friday', p.saturday = '$saturday', p.sunday = '$sunday', p.notification = 'N' where p.id = $timesheetid";
	    $retval = $mysqli->query($updatesql);			
			$use = 1;		
		}
		else
		{
			$insertsql = "INSERT INTO timesheetdetail(poid, weekenddate,notes,monday,tuesday,wednesday,thursday,friday,saturday,sunday) VALUES ('$assignment', '$weekenddate', '$notes', '$monday', '$tuesday', '$wednesday', '$thursday', '$friday', '$saturday', '$sunday')";
	    $retval = $mysqli->query($insertsql);			
	    $timesheetid = $mysqli->insert_id;
			$use = 2;			
		}	
	}
	
}		

?>
    <form action="can-timesheet.php" id="form1" method="post"  enctype="multipart/form-data">
      <table width="80%" border="0" cellpadding="10" cellspacing="1" align="left">
        <tr>
          <td style="text-align:right; font-weight:bolder; width:10%"> Assignment:</td>
          <td><select style="width: 400px;" name="assignment"  id="assignment" onchange="this.form.submit()">
              <?php
    	 $query = "select p.id poid, CONCAT(c.companyname, '- ', DATE_FORMAT(p.begindate,'%m.%d.%Y')) as assignment  from po p, placement pl, client c where p.placementid = pl.id and pl.clientid = c.id and pl.candidateid = $candidateID order by poid desc";
       $results = $mysqli->query($query);	
	     while($rows = $results->fetch_row() )
       {?>
              <option value="<?php echo $rows['poid'];?>" <?php if($po == $rows['poid']) { echo "selected";}  ?>><?php echo $rows['assignment'];?></option>
              <?php
    }?>
            </select></td>
        </tr>
        <tr>
          <td style="text-align:right; font-weight:bolder; width:10%"> Week:</td>
          <td><select name="timesheet" style="width: 400px;" id="timesheet">
              <?php
		      $query = "select -1 as id, 'Add New Week' as weekinfo, CURDATE() + 10000 as weekenddate  from dual union select id, concat('Week of ', DATE_FORMAT(weekenddate, '%D %M %Y')) weekinfo, weekenddate from timesheetdetail t where t.poid = $po order by weekenddate desc;";		
          $results = $mysqli->query($query);

	  echo "<option value=''>Select or Add Week...</option>";
	  while($rows = $results->fetch_assoc())
    {?>
              <option value="<?php echo $rows['id'];?>"<?php if($timesheetid == $rows['id']) { echo "selected";}  ?>><?php echo $rows['weekinfo'];?></option>
              <?php
    }?>
            </select></td>
        </tr>
      </table>
      <div class="both">
        <div id="show_content"> <img src="/images/loader.gif" style="margin-top:8px; float:left" id="loader" alt="" /> </div>
      </div>
    </form>
    <?
    $mysqli->close();	
?>
  </div>
</div>
<br />
<br />
</body>
</html>
