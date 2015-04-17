<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/
echo "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title>".$page_title."</title>
<link href='$template' rel='stylesheet' type='text/css' />
<script src='models/funcs.js' type='text/javascript'></script>
<link rel='stylesheet' href='http://code.jquery.com/ui/1.10.3/themes/start/jquery-ui.css' />
<link rel='stylesheet' type='text/css' media='screen' href='/project/themes/ui.jqgrid.css'  />
<link rel='stylesheet' type='text/css' media='screen' href='/project/themes/ui.multiselect.css'/>
<link href='models/site-templates/default.css' rel='stylesheet' type='text/css' />

<link rel='stylesheet' href='http://gregfranko.com/jquery.selectBoxIt.js/css/jquery.selectBoxIt.css' />
<link href='exam/js/datepicker/zebra_datepicker.css' rel='stylesheet' type='text/css' />
<link href='http://hayageek.github.io/jQuery-Upload-File/uploadfile.min.css' rel='stylesheet'>
<script src='http://code.jquery.com/jquery-1.9.1.js'></script>
<script src='http://code.jquery.com/ui/1.10.3/jquery-ui.js'></script>
<script src='exam/js/i18n/grid.locale-en.js' type='text/javascript'></script>
<script src='models/funcs.js'  type='text/javascript'></script>

<script src='http://gregfranko.com/jquery.selectBoxIt.js/js/jquery.selectBoxIt.min.js'></script>
<script src='http://js.nicedit.com/nicEdit-latest.js' type='text/javascript'></script>
<script src='exam/js/datepicker/zebra_datepicker.js' type='text/javascript'></script>
<script src='exam/js/numericInput.min.js' type='text/javascript'></script>

<script src='exam/js/jquery.jqGrid.min.js' type='text/javascript'></script>

<script src='http://hayageek.github.io/jQuery-Upload-File/jquery.uploadfile.min.js'></script>
<script>   $(function() {     $( '#mymenu' ).menu(); $('input').addClass('ui-corner-all');   });   </script>
<style>  .ui-menu { width: 130px; }  </style>
<script type='text/javascript'>
//<![CDATA[
  $.jgrid.no_legacy_api = true;
  $.jgrid.useJSON = true;
//]]>
</script>
<script type='text/javascript'>
//<![CDATA[
	$(document).ready(function(){
		$('.link').button();
		$('#mymenu').menu();
		//$('#mymenu').overlay();
	});
//]]>
</script>
</head>";

?>
