<?php
wad_header();

$spp_id = $current_user['spp_id'];

if( isset($_POST['updateSettings']) ){
	
	$create_order = isset($_POST['create_order']) ? $_POST['create_order'] : '';
	wad_update_option('create_order',$create_order);

	$send_emails = isset($_POST['send_emails']) ? $_POST['send_emails'] : '';
	wad_update_option('send_emails',$send_emails);

	$save_log = isset($_POST['save_log']) ? $_POST['save_log'] : '';
	wad_update_option('save_log',$save_log);

	$orders_per_page = isset($_POST['orders_per_page']) ? $_POST['orders_per_page'] : '';
	wad_update_option('orders_per_page',$orders_per_page);

	$orders_per_page_dropdown = isset($_POST['orders_per_page_dropdown']) ? $_POST['orders_per_page_dropdown'] : '';
	wad_update_option('orders_per_page_dropdown',$orders_per_page_dropdown);

	$reject_order = isset($_POST['reject_order']) ? $_POST['reject_order'] : '';
	wad_update_option('reject_order',$reject_order);
	
	$reset_orders_counters = isset($_POST['reset_orders_counters']) ? $_POST['reset_orders_counters'] : '';
	wad_update_option('reset_orders_counters',$reset_orders_counters);
	
	$no_of_days_for_new_orders = isset($_POST['no_of_days_for_new_orders']) ? $_POST['no_of_days_for_new_orders'] : '';
	wad_update_option('no_of_days_for_new_orders',$no_of_days_for_new_orders);
	
	if( wad_get_option('reset_orders_counters') == 'yes' )
	{
		//Set orders counters(all, new, working, editing, revision and complete) for all writers and editors.
		reset_orders_counter();
		wad_update_option('reset_orders_counters',"no");
	}
}

$create_order = wad_get_option('create_order');
$send_emails = wad_get_option('send_emails');
$save_log = wad_get_option('save_log');
$orders_per_page = wad_get_option('orders_per_page');
$orders_per_page_dropdown = wad_get_option('orders_per_page_dropdown');
$reject_order = wad_get_option('reject_order');
$reset_orders_counters = wad_get_option('reset_orders_counters');
$no_of_days_for_new_orders = wad_get_option('no_of_days_for_new_orders');

?>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="d-flex flex-column-fluid">
		<div class="container">
			<h2 class="mb-6">Settings</h2>
			<form method="post">
				<div class="form-group">
					<div class="radio-inline">
						<label class="mr-4">Create Order?</label>
						<label class="radio">
							<input type="radio" <?php if( isset($create_order) && $create_order == 'yes') { echo 'checked'; } ?> name="create_order" value="yes" />
							<span></span>
							Yes
						</label>
						<label class="radio">
							<input type="radio" <?php if( isset($create_order) && $create_order == 'no') { echo 'checked'; } ?> name="create_order" value="no" />
							<span></span>
							No
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="radio-inline">
						<label class="mr-4">Send Emails?</label>
						<label class="radio">
							<input type="radio" <?php if( isset($send_emails) && $send_emails == 'yes') { echo 'checked'; } ?> name="send_emails" value="yes" />
							<span></span>
							Yes
						</label>
						<label class="radio">
							<input type="radio" <?php if( isset($send_emails) && $send_emails == 'no') { echo 'checked'; } ?> name="send_emails" value="no" />
							<span></span>
							No
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="radio-inline">
						<label class="mr-4">Save History/Log?</label>
						<label class="radio">
							<input type="radio" <?php if( isset($save_log) && $save_log == 'yes') { echo 'checked'; } ?> name="save_log" value="yes" />
							<span></span>
							Yes
						</label>
						<label class="radio">
							<input type="radio" <?php if( isset($save_log) && $save_log == 'no') { echo 'checked'; } ?> name="save_log" value="no" />
							<span></span>
							No
						</label>
					</div>
				</div>
				<div class="form-group">
				<div class="radio-inline">
					<label class="mr-4">Reject Order Auto</label>
					<label class="radio">
						<input type="radio" <?php if( isset($reject_order) && $reject_order == 'yes') { echo 'checked'; } ?> name="reject_order" value="yes" <?php if($spp_id == '3653'){ echo ' disabled';} ?>/>
						<span></span>
						Yes
					</label>
					<label class="radio">
						<input type="radio" <?php if( isset($reject_order) && $reject_order == 'no') { echo 'checked'; } ?> name="reject_order" value="no" <?php if($spp_id == '3653'){ echo 'disabled';} ?>/>
						<span></span>
						No
					</label>
				</div>
				<?php if($spp_id == '3653'): ?>
				<span class="text-muted">It is disabled for our test Admin</span>
				<?php endif; ?>
				</div>
				<div class="form-group">
				<div class="radio-inline">
					<label class="mr-4">Reset Orders Counters</label>
					<label class="radio">
						<input type="radio" <?php if( isset($reset_orders_counters) && $reset_orders_counters == 'yes') { echo 'checked'; } ?> name="reset_orders_counters" value="yes" />
						<span></span>
						Yes
					</label>
					<label class="radio">
						<input type="radio" <?php if( isset($reset_orders_counters) && $reset_orders_counters == 'no') { echo 'checked'; } ?> name="reset_orders_counters" value="no" />
						<span></span>
						No
					</label>
				</div>
				<span class="text-muted">It will be processed and disabled on update.</span>
				</div>
				<div class="form-group">
					<label>No. of days for New Orders</label>
					<input type="number" min="4" name="no_of_days_for_new_orders" class="form-control" placeholder="4" value="<?php echo $no_of_days_for_new_orders; ?>" />
				</div>
				<div class="form-group">
					<label>Orders/Users per page</label>
					<input type="text" name="orders_per_page" class="form-control" placeholder="10" value="<?php echo $orders_per_page; ?>" />
				</div>
				<div class="form-group">
					<label>Orders/Users per page dropdown</label>
					<input type="text" name="orders_per_page_dropdown" class="form-control" placeholder="2,5,10,25,50,100" value="<?php echo $orders_per_page_dropdown; ?>" />
				</div>
				<input type="submit" name="updateSettings" class="btn btn-primary" value="Update">
			</form>
		</div>
	</div>
</div>
<?php echo wad_footer(); ?>