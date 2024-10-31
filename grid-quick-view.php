<?php
/**
 * Plugin Name: Responsive Grid Quick View Posts for WordPress
 * Plugin URI: http://codecanyon.net/user/smartcms
 * Description: Creating grid quick view posts
 * Version: 1.0
 * Author: SmartCms Team
 * Author URI: http://codecanyon.net/user/smartcms
 * License: GPLv2 or later
 */
define ( 'SMARTCMS_QVPLUGIN_URL', plugin_dir_url(__FILE__));
define( 'WP_DEBUG', true );
add_action( 'widgets_init', 'create_smartcms_grid_quick_view' );
function create_smartcms_grid_quick_view() {
	register_widget('SmartCms_Grid_Quick_View');
}

add_action( 'admin_menu', 'smartcms_quick_view_admin_menu' );
add_action( 'admin_init', 'smartcms_quick_view_settings_init' );
add_action( 'plugins_loaded', 'smartcms_quick_view_load' );

function smartcms_quick_view_load() {
        global $mfpd;
        $mfpd = new SmartCms_Grid_Quick_View();
}
function smartcms_quick_view_admin_menu() {
    add_menu_page(
        'Responsive Grid Quick View Posts',
        'Responsive Grid Quick View Posts',
        'manage_options',
        'grid-quick-view',
        'smartcms_quick_view_options_page'
    );
}
function smartcms_quick_view_options_page(  ) { 
	?>
	<h2>SmartCms Responsive Grid Quick View Posts</h2>
	<?php
	settings_fields( 'QVpluginPage' );
	do_settings_sections( 'QVpluginPage' );
	submit_button();
}
function smartcms_quick_view_settings_init() {
	register_setting( 'QVpluginPage', 'smartcms_quick_view_settings' );
	add_settings_section(
		'smartcms_QV_section', __( '', 'wordpress' ), '', 'QVpluginPage'
	);
	add_settings_field( 
		'','',
		'smartcms_quic_view_parameters', 
		'QVpluginPage', 
		'smartcms_QV_section' 
	);
}

function smartcms_quic_view_parameters(  ) {
	$options = get_option( 'smartcms_quick_view_settings' );
	$categories = get_categories();
	$select_cat = $options["select_cat"];
	//echo "<pre>".print_r($select_cat,1)."</pre>";
	$show_title = $options["show_title"];
	if(!$show_title) $show_title = 0;

	$show_date = $options["show_date"];
	if(!$show_date) $show_date = 0;
	
	$show_author = $options["show_author"];
	if(!$show_author) $show_author = 0;
	
	$show_des = $options["show_des"];
	if(!$show_des) $show_des = 0;
	?>
	<div class="wrap">
		<table class="widefat smartcms_number_pins">
			<tr><td width="150"><span class="field_name">Select Categories</span></td>
				<td>
					<select class="select_cat_option" name="smartcms_quick_view_settings[select_cat][]" multiple="multiple">
					<?php
					foreach($categories as $cat){
						$selected = in_array( $cat->cat_ID, $options['select_cat'] ) ? ' selected="selected" ' : '';
						?>
						<option <?php echo $selected; ?> value="<?php echo $cat->cat_ID ?>"><?php echo $cat->cat_name ?></option>
						<?php
					}
					?>
					</select>
				</td>
			</tr>
			<tr><td width="150"><span class="field_name">Number of Posts</span></td>
				<td>
					<input type='text' name='smartcms_quick_view_settings[number_posts]' value='<?php echo $options['number_posts']; ?>'>
				</td>
			</tr>
			<tr><td width="150"><span class="field_name">Number of Columns</span></td>
				<td>
					<input type='text' name='smartcms_quick_view_settings[number_columns]' value='<?php echo $options['number_columns']; ?>'>
				</td>
			</tr>
			<tr><td width="150"><span class="field_name">Show Title</span></td>
				<td>
					<label for="show_title_option1">Yes</label>
					<input <?php if($show_title) echo 'checked="checked"'; ?> id="show_title_option1" class="show_title_option" type='radio' name='smartcms_quick_view_settings[show_title]' value='1'>
					<label for="show_title_option0">No</label>
					<input <?php if(!$show_title || $show_title == 0) echo 'checked="checked"'; ?> id="show_title_option0" class="show_title_option" type='radio' name='smartcms_quick_view_settings[show_title]' value='0'>
				</td>
			</tr>
			<tr><td width="150"><span class="field_name">Title character limit</span></td>
				<td>
					<input type='text' name='smartcms_quick_view_settings[title_limit]' value='<?php echo $options['title_limit']; ?>'>
				</td>
			</tr>
			<tr><td width="150"><span class="field_name">Show date created</span></td>
				<td>
					<label for="show_date_option1">Yes</label>
					<input <?php if($show_date) echo 'checked="checked"'; ?> id="show_date_option1" class="show_date_option" type='radio' name='smartcms_quick_view_settings[show_date]' value='1'>
					<label for="show_date_option0">No</label>
					<input <?php if(!$show_date || $show_date == 0) echo 'checked="checked"'; ?> id="show_date_option0" class="show_date_option" type='radio' name='smartcms_quick_view_settings[show_date]' value='0'>
				</td>
			</tr>
			<tr><td width="150"><span class="field_name">Show author</span></td>
				<td>
					<label for="show_author_option1">Yes</label>
					<input <?php if($show_author) echo 'checked="checked"'; ?> id="show_author_option1" class="show_author_option" type='radio' name='smartcms_quick_view_settings[show_author]' value='1'>
					<label for="show_author_option0">No</label>
					<input <?php if(!$show_author || $show_author == 0) echo 'checked="checked"'; ?> id="show_author_option0" class="show_author_option" type='radio' name='smartcms_quick_view_settings[show_author]' value='0'>
				</td>
			</tr>
			<tr><td width="150"><span class="field_name">Show description</span></td>
				<td>
					<label for="show_des_option1">Yes</label>
					<input <?php if($show_des) echo 'checked="checked"'; ?> id="show_des_option1" class="show_des_option" type='radio' name='smartcms_quick_view_settings[show_des]' value='1'>
					<label for="show_des_option0">No</label>
					<input <?php if(!$show_des || $show_des == 0) echo 'checked="checked"'; ?> id="show_des_option0" class="show_des_option" type='radio' name='smartcms_quick_view_settings[show_des]' value='0'>
				</td>
			</tr>
			<tr><td width="150"><span class="field_name">Description character limit</span></td>
				<td>
					<input type='text' name='smartcms_quick_view_settings[des_limit]' value='<?php echo $options['des_limit']; ?>'>
				</td>
			</tr>
			<tr><td width="150"><span class="field_name">Quick View button</span></td>
				<td>
					<input type='text' name='smartcms_quick_view_settings[qv_text]' value='<?php echo $options['qv_text']; ?>'>
				</td>
			</tr>
		</table>
	</div>
	<?php
}

class SmartCms_Grid_Quick_View extends WP_Widget {

	function __construct() {
		parent::__construct (
			  'smartcms_grid_quick_view', // id của widget
			  'SmartCms Responsive Grid Quick View Posts', // tên của widget
			  array(
				  'description' => 'Creating grid quick view posts' // mô tả
			  )
		);
		add_shortcode( 'smartcms_grid_quick_view' , array(&$this, 'smartcms_grid_quick_view_func') );
	}
	function smartcms_grid_quick_view_func($atts = array(), $content = null) {
		global $wpdb;
		$options = get_option( 'smartcms_quick_view_settings' );
		$catids = $options["select_cat"];
		$posts = query_posts( 'cat='. json_encode($catids, 1) );
		$showtitle = $options["show_title"];
		$title_limit = $options["title_limit"];
		$showdate = $options["show_date"];
		$showauthor = $options["show_author"];
		$showdes = $options["show_des"];
		$des_limit = $options["des_limit"];
		$numberpots = $options["number_posts"];
		$columns = $options["number_columns"];
		$qv_text = $options["qv_text"];
		
		wp_register_style( 'quick-view-style', SMARTCMS_QVPLUGIN_URL .'css/style.css' );
		wp_enqueue_style( 'quick-view-style' );
		wp_register_style( 'quick-view-style-colorbox', SMARTCMS_QVPLUGIN_URL .'colorbox/colorbox.css' );
		wp_enqueue_style( 'quick-view-style-colorbox' );
		wp_register_script('quick-view-script-colorbox', SMARTCMS_QVPLUGIN_URL .'colorbox/jquery.colorbox.js');
		wp_enqueue_script('quick-view-script-colorbox');
		wp_register_script('smartcms-qvjs-script', SMARTCMS_QVPLUGIN_URL .'js/script.js.php?column='.$columns);
		wp_enqueue_script('smartcms-qvjs-script');
		
		if($posts){
			?>
			<div class="smartcms_grid">
				<div class="smartcms_grid_layout">
			<?php
			foreach($posts as $key=>$pot){
				$potId = $pot->ID;
				if (has_post_thumbnail($potId)){
					$image = wp_get_attachment_image_src( get_post_thumbnail_id($potId), 'single-post-thumbnail' );
					$imgsrc = $image[0];
				}else
					$imgsrc = "";
				$authorid = $pot->post_author;
				$title = $pot->post_title;
				$post_date = $pot->post_date;
				$des = $pot->post_content;
				$url = $pot->guid;
				
				$newkey = $key + 1;
				?>
				<div class="smartcms_grid_item_block">
				<div class="smartcms_grid_item smartcms_column<?php echo $columns ?>">
					<div class="smartcms_grid_img">
						<img src="<?php echo $imgsrc ?>">
						<div class="smartcms_grid_img_hover">
							<a class="smartcms_colorbox" href="#inline_content<?php echo $key?>"><?php echo $qv_text ?></a>
							<div style='display:none'>
								<div id='inline_content<?php echo $key?>' style='padding:10px; background:#fff;'>
									<div class="smartcms_content_left">
										<img src="<?php echo $imgsrc ?>">
									</div>
									<div class="smartcms_content_right">
										<span class="content_right_title">
											<?php echo $title ?>
										</span>
										<span class="content_right_des">
											<?php echo $des ?>
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php if($showtitle){?>
						<div class="smartcms_grid_title">
							<a href="<?php echo $url ?>">
							<?php 
								if(strlen($title) <= $title_limit)
									$atitle = $title;
								else
									$atitle = substr($title, 0, $title_limit)."...";
								echo $atitle;
							?>
							</a>
						</div>
					<?php } ?>
					<div class="smartcms_grid_info">
						<?php if($showdate) {?>
							<span class="smartcms_grid_info_create"><?php echo substr($post_date, 0, 10) ?></span>
						<?php } ?>
						<?php if($showauthor){ ?>
							<span class="smartcms_grid_info_createby"><?php echo the_author_meta( 'user_nicename' , $authorid ) ?></span>
						<?php } ?>
					</div>
					<?php if($showdes){?>
					<div class="smartcms_grid_des">
						<?php echo substr(strip_tags($des), 0, $des_limit)."..." ?>
					</div>
					<?php } ?>
				</div>
				</div>
				<?php
					if($newkey % $columns == 0){
						?>
						</div>
						<div class="smartcms_grid_layout">
						<?php
					}	
				}
			?>
				</div>
			</div>
			<?php
		}else{
			echo "There are no article to show";
		}
	}
	function form( $instance ) {
	}

	/* save widget form */
   function update( $new_instance, $old_instance ) {
		parent::update( $new_instance, $old_instance );
		$instance = $old_instance;
		return $instance;
	}

	/* Show widget */
	function widget( $args, $instance ) {
		extract( $args );
		//$test_option =  $instance['test_option'];
		echo $before_widget;
		echo $before_title.$title.$after_title;

		global $wpdb;
		$options = get_option( 'smartcms_quick_view_settings' );
		$catids = $options["select_cat"];
		$posts = query_posts( 'cat='. json_encode($catids, 1) );
		$showtitle = $options["show_title"];
		$title_limit = $options["title_limit"];
		$showdate = $options["show_date"];
		$showauthor = $options["show_author"];
		$showdes = $options["show_des"];
		$des_limit = $options["des_limit"];
		$numberpots = $options["number_posts"];
		$columns = $options["number_columns"];
		$qv_text = $options["qv_text"];
		
		wp_register_style( 'quick-view-style', SMARTCMS_QVPLUGIN_URL .'css/style.css' );
		wp_enqueue_style( 'quick-view-style' );
		wp_register_style( 'quick-view-style-colorbox', SMARTCMS_QVPLUGIN_URL .'colorbox/colorbox.css' );
		wp_enqueue_style( 'quick-view-style-colorbox' );
		wp_register_script('quick-view-script-colorbox', SMARTCMS_QVPLUGIN_URL .'colorbox/jquery.colorbox.js');
		wp_enqueue_script('quick-view-script-colorbox');
		wp_register_script('smartcms-qvjs-script', SMARTCMS_QVPLUGIN_URL .'js/script.js.php?column='.$columns);
		wp_enqueue_script('smartcms-qvjs-script');
		
		if($posts){
			?>
			<div class="smartcms_grid">
				<div class="smartcms_grid_layout">
			<?php
			foreach($posts as $key=>$pot){
				$potId = $pot->ID;
				if (has_post_thumbnail($potId)){
					$image = wp_get_attachment_image_src( get_post_thumbnail_id($potId), 'single-post-thumbnail' );
					$imgsrc = $image[0];
				}else
					$imgsrc = "";
				$authorid = $pot->post_author;
				$title = $pot->post_title;
				$post_date = $pot->post_date;
				$des = $pot->post_content;
				$url = $pot->guid;
				
				$newkey = $key + 1;
				?>
				<div class="smartcms_grid_item_block">
				<div class="smartcms_grid_item smartcms_column<?php echo $columns ?>">
					<div class="smartcms_grid_img">
						<img src="<?php echo $imgsrc ?>">
						<div class="smartcms_grid_img_hover">
							<a class="smartcms_colorbox" href="#inline_content<?php echo $key?>"><?php echo $qv_text ?></a>
							<div style='display:none'>
								<div id='inline_content<?php echo $key?>' style='padding:10px; background:#fff;'>
									<div class="smartcms_content_left">
										<img src="<?php echo $imgsrc ?>">
									</div>
									<div class="smartcms_content_right">
										<span class="content_right_title">
											<?php echo $title ?>
										</span>
										<span class="content_right_des">
											<?php echo $des ?>
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php if($showtitle){?>
						<div class="smartcms_grid_title">
							<a href="<?php echo $url ?>">
							<?php 
								if(strlen($title) <= $title_limit)
									$atitle = $title;
								else
									$atitle = substr($title, 0, $title_limit)."...";
								echo $atitle;
							?>
							</a>
						</div>
					<?php } ?>
					<div class="smartcms_grid_info">
						<?php if($showdate) {?>
							<span class="smartcms_grid_info_create"><?php echo substr($post_date, 0, 10) ?></span>
						<?php } ?>
						<?php if($showauthor){ ?>
							<span class="smartcms_grid_info_createby"><?php echo the_author_meta( 'user_nicename' , $authorid ) ?></span>
						<?php } ?>
					</div>
					<?php if($showdes){?>
					<div class="smartcms_grid_des">
						<?php echo substr(strip_tags($des), 0, $des_limit)."..." ?>
					</div>
					<?php } ?>
				</div>
				</div>
				<?php
					if($newkey % $columns == 0){
						?>
						</div>
						<div class="smartcms_grid_layout">
						<?php
					}	
				}
			?>
				</div>
			</div>
			<?php
		}else{
			echo "There are no article to show";
		}
		echo $after_widget;
	}
 
}
?>