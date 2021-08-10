<?php
wad_header();

$spp_id = $current_user['spp_id'];

$writers = wad_get_users("*", "role='Writer'");
$editors = wad_get_users("*", "role='Editor'");

$user_spp_ids = isset($_REQUEST['spp_id']) ? $_REQUEST['spp_id'] : array();
$date_start = isset($_REQUEST['date_start']) ? $_REQUEST['date_start'] : '';
$date_end = isset($_REQUEST['date_end']) ? $_REQUEST['date_end'] : '';

?>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="d-flex flex-column-fluid">
		<div class="container">
			
			<?php if( isset($_REQUEST['genr_report']) && !empty($user_spp_ids) ) :
				
				$data = array(
					'date_start' => $date_start,
					'date_end' => $date_end
				);
			
				$reports_array = wad_generate_report($user_spp_ids, $data);
					
				if( !empty($reports_array) ){
					$reports_count = count($reports_array);
					$many = false;
					if( $reports_count > 1 ){
						$many = true;
					}
					
					$reports_heading = 'Report is successfully generated';
					if( $many ){
						$reports_heading = 'Reports are successfully generated';
					}
					
					echo "<h2>{$reports_heading}</h2>";
					
					foreach($reports_array as $report_for => $report_link)
					{
						$string = '<h4>Download %s report, <a href="%s">click here</a></h4>';
						echo sprintf($string, $report_for, $report_link);
					}
					
				} ?>
				
				<h4>Genrate new report, <a href="<?php echo BASE_URL ?>/admin/report">click here</a></h4>
				
			<?php else: ?>
			
				<h2 class="mb-6">Report</h2>
				<form method="post">
					<div class="row">
						<div class="col-xl-12">
						
							<div class="form-group row">
								<div class="col-lg-6 col-md-6 col-xs-12">
								 <div class="input-daterange input-group" id="kt_datepicker_5">
								 <div class="input-group-append">
								   <span class="input-group-text">From</span>
								  </div>
								  <input type="text" class="form-control" name="date_start" placeholder="Start date*" value="<?php echo $date_start; ?>"/>
								  <div class="input-group-append">
								   <span class="input-group-text">To</span>
								  </div>
								  <input type="text" class="form-control" name="date_end" placeholder="End date*" value="<?php echo $date_end; ?>" />
								 </div>
								</div>
							   </div>
						
							<div class="checkbox-inline mb-6">
								<label class="checkbox checkbox-outline checkbox-lg">
									<input type="checkbox" class="select_all_writers" name="select_all_writers" <?php if( isset($_REQUEST['select_all_writers']) ) { echo "checked=checked"; } ?>  value=""/>
									<span></span>
									Select All Writers
								</label>
								<label class="checkbox checkbox-outline checkbox-lg">
									<input type="checkbox" class="select_all_editors" name="select_all_editors" <?php if( isset($_REQUEST['select_all_editors']) ) { echo "checked=checked"; } ?>  value=""/>
									<span></span>
									Select All Editors
								</label>
							</div>

							<h3>Writers*:</h3>
							<div class="checkbox-inline">
							<?php foreach($writers as $writer): ?>
								<label class="checkbox checkbox-outline checkbox-md">
									<input type="checkbox" <?php if( in_array($writer['spp_id'], $user_spp_ids)) { echo "checked=checked"; } ?> name="spp_id[]" value="<?php echo $writer['spp_id']; ?>" class="checkbox-writer"/>
									<span></span>
									<?php echo $writer['name']; ?>
								</label>
							<?php endforeach; ?>
							</div>
						</div>
						<div class="col-xl-12 mt-10 mb-10">
							<h3>Editors*:</h3>
							<div class="checkbox-inline">
							<?php foreach($editors as $editor): ?>
								<label class="checkbox checkbox-outline  checkbox-md">
									<input type="checkbox" name="spp_id[]" <?php if( in_array($editor['spp_id'], $user_spp_ids)) { echo "checked=checked"; } ?> value="<?php echo $editor['spp_id']; ?>" class="checkbox-editor"/>
									<span></span>
									<?php echo $editor['name']; ?>
								</label>
							<?php endforeach; ?>
							</div>
						</div>
					</div>
					<input type="submit" name="genr_report" class="btn btn-primary btn-lg btn-block" value="Generate Report" />
				</form>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php echo wad_footer(); ?>