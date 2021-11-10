<?php
wad_header();

$order_ids_arr = isset($_REQUEST['order']) ? $_REQUEST['order'] : array();

if( isset($_REQUEST['submit']) ) {
	wad_set_time_for_rejected_orders_from_logs($order_ids_arr);
}


$result = wad_select_query("user_rejected_order","*","(time is NULL OR time=0 ) AND missed='0'");
$rejected_orders = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="d-flex flex-column-fluid">
		<div class="container">
				<h2>Set rejected orders time from logs</h2>
				<form method="post">
					<div class="row">
						<div class="col-xl-12">
							<h3>Orders:</h3>
							<div class="checkbox-list">
							<?php foreach($rejected_orders as $order): ?>
								<label class="checkbox checkbox-outline checkbox-md">
									<input type="checkbox" <?php if( in_array($order['order_id'], $order_ids_arr)) { echo "checked=checked"; } ?> name="order[]" value="<?php echo $order['order_id']; ?>" class="rejected-order"/>
									<span></span>
									<?php echo $order['order_id']; ?>
								</label>
							<?php endforeach; ?>
							</div>
						</div>
					</div>
					<input type="submit" name="submit" class="btn btn-primary btn-lg btn-block"/>
				</form>
			
		</div>
	</div>
</div>
<?php echo wad_footer(); ?>