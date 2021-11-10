<?php
wad_header();

$spp_id = $current_user['spp_id'];

$writers = wad_get_users("*", "role='Writer'","ORDER BY id ASC");
$editors = wad_get_users("*", "role='Editor'","ORDER BY id ASC");

$user_spp_ids = isset($_REQUEST['spp_id']) ? $_REQUEST['spp_id'] : array();


?>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="d-flex flex-column-fluid">
		<div class="container">
			
			<?php if( isset($_REQUEST['submit']) ) :
			
				wad_set_previous_assigned_orders_to_users($user_spp_ids[0]);
				
			endif; ?>
			
				<h2 class="mb-6">Storing previously assigned orders + counters for generating report fields<br />
					<span class="font-size-sm">Select single writer or editor and click button below</span>
				</h2>
				<form method="post">
					<div class="row">
						<div class="col-xl-12">
							<h3>Writers:</h3>
							<div class="radio-inline">
							<?php foreach($writers as $writer): ?>
								<label class="radio radio-outline radio-md">
									<input type="radio" <?php if( in_array($writer['spp_id'], $user_spp_ids)) { echo "checked=checked"; } ?> name="spp_id[]" value="<?php echo $writer['spp_id']; ?>" class="radio-writer"/>
									<span></span>
									<?php echo $writer['name']; ?>
								</label>
							<?php endforeach; ?>
							</div>
						</div>
						<div class="col-xl-12 mt-10 mb-10">
							<h3>Editors:</h3>
							<div class="radio-inline">
							<?php foreach($editors as $editor): ?>
								<label class="radio radio-outline  radio-md">
									<input type="radio" name="spp_id[]" <?php if( in_array($editor['spp_id'], $user_spp_ids)) { echo "checked=checked"; } ?> value="<?php echo $editor['spp_id']; ?>" class="radio-editor"/>
									<span></span>
									<?php echo $editor['name']; ?>
								</label>
							<?php endforeach; ?>
							</div>
						</div>
					</div>
					<input type="submit" name="submit" class="btn btn-primary btn-lg btn-block" value="Submit" />
				</form>
		</div>
	</div>
</div>
<?php echo wad_footer(); ?>