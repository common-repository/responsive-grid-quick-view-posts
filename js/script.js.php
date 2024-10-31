<?php
header("Content-Type: text/css; charset=UTF-8");

$columns = $_GET["column"];
?>

jQuery(document).ready(function(){
	var elwidth = parseInt(jQuery(".smartcms_grid").width());
	var column = <?php echo $columns ?>;
	
	jQuery(".smartcms_grid_item_block").css("width", elwidth / column);
	jQuery(".smartcms_colorbox").colorbox({inline:true, width: "70%"});
});