<?php
global $current_user;
get_currentuserinfo();

	
nmFileUploader::makeUploadDirectory();

/*
 delete file
*/
if(isset($_GET['fid']))
{
	if(nmFileUploader::deleteFile(intval($_GET['fid'])))
	{
		echo "<div class=\"red\">". get_option('nm_file_deleted_msg') ."</div>";
	}

}

/*$wpdb->show_errors();
 $wpdb->print_error(); */

/*
 save file
*/
if(isset($_POST['nm-submit']))
{
	
	nmFileUploader::$file_name 	= sanitize_text_field($_POST['file-name']);
	nmFileUploader::$desc		= sanitize_text_field($_POST['description']);
	nmFileUploader::$file_type	= "." . nmFileUploader::getFileExtension(sanitize_text_field($_POST['file-name']));

	if(nmFileUploader::saveFile())
	{
		echo "<div class=\"green\">". get_option('nm_file_uploaded_msg') ."</div>";
	}

}
?>


<div id="nm-upload-container">
<p style="text-align:center">
<strong><?php _e('Upload file(s):', nmFileUploader::$short_name)?></strong>
<span style="font-style: italic"><?php _e('click button below and browse for your file(s), then click "Save"', nmFileUploader::$short_name)?></span>
</p>
<div id="error"></div>
<form method="post" onSubmit="return validate('<?php echo plugins_url('', __FILE__);?>')" id="frm_upload">
<input type="hidden" name="file-name" id="file-name">


<div class="nm-uploader-area">
	
  <input id="file_upload" name="file_upload" type="file" />
  <span id="upload-response"></span>
</div>

<table>

<tr>
	<td style="width: 25%"><?php _e('File description', nmFileUploader::$short_name)?></td>
    <td><textarea name="description" style="width:90%;height:70px" class="" id="description"></textarea></td>
</tr>

<!-- saving button -->
<tr>
<td colspan="2" style="text-align: center">
<input class="nm-submit-button" type="submit" value="<?php _e('Save', 'nm_file_uploader_pro')?>" name="nm-submit" id="nm-upload">
    <div id="working-area" style="display:none">
		<?php
			echo "<img src=".plugins_url( 'images/loading.gif' , __FILE__)." />";
		?>
    </div>	
</td>
</tr>
</table>

</form>

<div style="clear:both"></div>
</div>

<script type="text/javascript">
		fileuploader_vars.current_user = '<?php echo $current_user -> user_nicename?>';
		setupUploader();
</script>


<?php
//file list
//check if displayFiles is True
	$list_path = dirname(__FILE__).'/_template_uploader.php';
	include ($list_path);

?>