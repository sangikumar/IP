<?php

if($_REQUEST)
{
$id 	= $_REQUEST['parent_id'];
	if($id != '0')
	{
		echo "<tr>
    <td>&nbsp;</td>
    <td>";
		echo "<br /><iframe width=\"450\" height=\"259\"  src=\"http://www.youtube-nocookie.com/embed/$id?rel=0&amp;hl=en_US&amp;hd=1&amp;modestbranding=1&ampautohide=1&amp;enablejsapi=1&amp;origin=whiteboxqa.com&amp;showinfo=0&amp;autoplay=1\" frameborder=\"0\" allowfullscreen></iframe></p>";
		echo "</td></tr>";
	}
}	
?>
