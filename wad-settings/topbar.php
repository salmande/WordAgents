<?php
wad_header();

$spp_id = $current_user['spp_id'];
$topbar_bg_color_default = '#f58320';

if( isset($_POST['updateTopbarSettings']) ){
	
	$topbar_text = isset($_POST['topbar_text']) ? $_POST['topbar_text'] : '';
	wad_update_option('topbar_text',$topbar_text);
	
	$topbar_visibility = isset($_POST['topbar_visibility']) ? $_POST['topbar_visibility'] : array();
	wad_update_option('topbar_visibility',json_encode($topbar_visibility));
	
	$topbar_bg_color = isset($_POST['topbar_bg_color']) ? $_POST['topbar_bg_color'] : $topbar_bg_color_default;
	wad_update_option('topbar_bg_color',$topbar_bg_color);
}

$topbar_text = wad_get_option('topbar_text');
$topbar_visibility = json_decode(wad_get_option('topbar_visibility'),true);
$topbar_bg_color = wad_get_option('topbar_bg_color');
if( empty($topbar_bg_color) )
	$topbar_bg_color = $topbar_bg_color_default;

?>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="d-flex flex-column-fluid">
		<div class="container">
			<h2 class="mb-6">Topbar</h2>
			<form method="post">
				<div class="form-group row">
					<label class="col-lg-2 col-form-label text-lg-left">Visibilitiy?</label>
					<div class="col-lg-10">
						<div class="checkbox-inline">
							<label class="checkbox">
								<input type="checkbox" <?php if( isset($topbar_visibility) && in_array('writer',$topbar_visibility) ) { echo 'checked'; } ?> name="topbar_visibility[]" value="writer"/>
								<span></span>
								Writers
							</label>
							<label class="checkbox">
								<input type="checkbox" <?php if( isset($topbar_visibility) &&  in_array('editor',$topbar_visibility) ) { echo 'checked'; } ?> name="topbar_visibility[]" value="editor" />
								<span></span>
								Editors
							</label>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-lg-2 col-form-label text-lg-left">Topbar Text:</label>
					<div class="col-lg-10">
						<textarea name="topbar_text" class="tinymce topbar-text"><?php echo $topbar_text;?></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-lg-2 col-form-label text-lg-left">Background color:</label>
					<div class="col-lg-10">
						<input class="form-control" type="color" name="topbar_bg_color" value="<?php echo $topbar_bg_color; ?>"/>
					</div>
				</div>
				<input type="submit" name="updateTopbarSettings" class="btn btn-primary" value="Update">
			</form>
		</div>
	</div>
</div>
<?php echo wad_footer(); ?>