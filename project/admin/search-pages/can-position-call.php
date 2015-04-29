<?php 
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$userId = $loggedInUser->user_id;
$candidateID = $loggedInUser->candidateid;
if(!userIdExists($userId)){
  header("Location: login.php"); die();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Candidate Position Call Management</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" />
<link rel="stylesheet" href="http://gregfranko.com/jquery.selectBoxIt.js/css/jquery.selectBoxIt.css" />
<link href="/js/jquery.tagsinput.css" type="text/css" rel="stylesheet"/>
<link href="project/admin/themes/newstyle.css" type="text/css" rel="stylesheet"/>
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
<script src="/js/jquery.tagsinput.js"></script>
<script src="/js/jquery.tagsinput.min.js"></script>
<script src="/project/js/jquery.watermark.js" type="text/javascript"></script>
<script src="/project/admin/models/funcs.js" type='text/javascript'></script>
<style>  
.ui-menu { width: 130px; }  
</style>
<script type="text/javascript">
//<![CDATA[
	$(document).ready(function(){
			$(".link").button();
			$('#mymenu').menu();
			$('#show_heading').hide();
			$('select').selectBoxIt();
			$('input').addClass("ui-corner-all");
			$('select').addClass("ui-corner-all");								
			$('#positioncallid').change(function(){
				$.post("../ajax-content/get-position-call.php", {
				parent_id: $('#positioncallid').val(),
				}, function(response){			
				setTimeout("finishAjax('show_assignment', '"+escape(response)+"')", 400);
			});							
			return false;
		});		
		
    	//return page after save
		var inp = $("#positioncallid");
		if (inp.val() != null){
			$.post("../ajax-content/get-position-call.php", {
				parent_id: $('#positioncallid').val(),
				}, function(response){          			
				setTimeout("finishAjax('show_assignment', '"+escape(response)+"')", 400);
			});							
			return false;
		}										
	});
//]]>

function finishAjax(id, response){
	$('#show_heading').show();
	$('#'+id).html(unescape(response));
	$('#'+id).fadeIn();
	$('input').addClass("ui-corner-all");
	$('select').addClass("ui-corner-all");	
	$('#positiondate').Zebra_DatePicker({
	  direction: false
	});		
	$('#send').button();
	new nicEditor().panelInstance('notes');
	
	$('#vendorcompany').autocomplete({
			source:'../ajax-content/suggest_vendor.php?type=company', minLength:2,
			select: function(event, ui ) {
				$(this).val(ui.item.value);
				return false;
			}	
	});		
	
	$('#vendoremail').autocomplete({
			source:'../ajax-content/suggest_recruiter.php?type=vendor', minLength:3,
			select: function(event, ui ) {
				$(this).val(ui.item.value);
				return false;
			}	
	});		
	
	$('#client').autocomplete({
			source:'../ajax-content/suggest_client.php?type=company', minLength:2,
			select: function(event, ui ) {
				$(this).val(ui.item.value);
				return false;
			}	
	});	
	
	$('#clientemail').autocomplete({
			source:'../ajax-content/suggest_recruiter.php?type=client', minLength:3,
			select: function(event, ui ) {
				$(this).val(ui.item.value);
				return false;
			}	
	});		
} 

</script>
</head>
<body>
<div id='wrapper'>
<div id='top'>
  <div id='logo'></div>
</div>
<div id='content'>
  <h2>Candidate Calls Questions</h2>
  <br />
  <div id='left-nav'>
    <?php include($_SERVER["DOCUMENT_ROOT"] ."/project/admin/left-nav.php");  ?>
  </div>
  <div id='main'>
  </div>
  <div id='main'>
    <?

if (!empty($_POST))
{    
	$positioncallid = $_POST['positioncallid'];
	$positiondate = $_POST['positiondate'];
	$vendorcompany = $_POST['vendorcompany'];
	$vendoremail = $_POST['vendoremail'];
	$solicitation = $_POST['solicitation'];
	$client = $_POST['client'];
	$clientemail = $_POST['clientemail'];
	$notes = $_POST['notes'];
	
/*	echo "positioncallid".$positioncallid;
	echo "positiondate".$positiondate;
	echo "vendorcompany".$vendorcompany;
	echo "vendoremail".$vendoremail;
	echo "solicitation".$solicitation;
	echo "client".$client;
	echo "clientemail".$clientemail;
	echo "candidateID".$candidateID;*/

	
	if($positioncallid) {
		if($vendorcompany || $vendoremail || $client || $clientemail){
		  if($positioncallid == "-1")
		  {
		  	$insertsql = "INSERT INTO positioncalls (candidateid,client,positiondate,vendoremail,vendorcompany,clientemail,solicitation, notes) values ($candidateID, '$client', '$positiondate', '$vendoremail','$vendorcompany','$clientemail','$solicitation','$notes')";
				$retval = $mysqli->query($insertsql);
		    $positioncallid = $mysqli->insert_id;
		  }
		  else
		  {
			  $updatesql = "update positioncalls p set p.positiondate = '$positiondate', p.vendorcompany = '$vendorcompany', p.vendoremail = '$vendoremail', p.solicitation = '$solicitation', p.client = '$client', p.clientemail = '$clientemail', p.notes = '$notes' where p.id = $positioncallid";
		    $retval = $mysqli->query($updatesql);
		  }

		}				
	}
}
?>
    <form action="can-position-call.php" id="form1" name="form1" method="post"  enctype="multipart/form-data">
      <table width="80%" border="0" cellspacing="5" cellpadding="5">
        <thead>
          <tr>
            <td><strong>Calls:</strong></td>
            <td><select name="positioncallid"  id="positioncallid" style="width: 50%;">
			<option value="0">Select or Add calls...</option>
                <?php		
		$query = "select -1 as id, 'Add New Call' as info, CURDATE() - 100000 as positiondate  from dual union select pc.id, concat(pc.positiondate, ' - ', pc.`client`, ' - ', pc.vendorcompany) info, pc.positiondate from positioncalls pc where candidateid = $candidateID order by positiondate";
	  $results = $mysqli->query($query);
	  while ($rows = $results->fetch_assoc())
		{
  		?>
                
<option <?php if($positioncallid == $rows['id']) { echo "selected";}  ?> value="<?php echo $rows['id'];?>"><?php echo $rows['info'];?></option>
                <?php } ?>
              </select>
            </td>
          </tr>
        </thead>
        <tbody id="show_assignment">
        <img src="/images/loader.gif" style="margin-top:8px; float:left" id="loader" alt="" />
        </tbody>
        
        <tfoot>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
        </tfoot>
      </table>
      <div class="both"> </div>
    </form>
    <?
    $mysqli->close();
?>
  </div>
  <div id='bottom'></div>
</div>
<br />
<br />
</body>
</html>