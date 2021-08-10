<?php wad_header(); ?>
<?php 
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

}

$create_order = wad_get_option('create_order');
$send_emails = wad_get_option('send_emails');
$save_log = wad_get_option('save_log');
$orders_per_page = wad_get_option('orders_per_page');
$orders_per_page_dropdown = wad_get_option('orders_per_page_dropdown');

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
					<label>Orders per page</label>
					<input type="text" name="orders_per_page" class="form-control" placeholder="10" value="<?php echo $orders_per_page; ?>" />
				</div>
				<div class="form-group">
					<label>Orders per page dropdown</label>
					<input type="text" name="orders_per_page_dropdown" class="form-control" placeholder="2,5,10,25,50,100" value="<?php echo $orders_per_page_dropdown; ?>" />
				</div>
				<input type="submit" name="updateSettings" class="btn btn-primary" value="Update">
			</form>
		</div>
	</div>
</div>