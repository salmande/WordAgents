<?php
wad_header();

$order_ids = isset($_REQUEST['order_ids']) ? $_REQUEST['order_ids'] : '';


?>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="d-flex flex-column-fluid">
		<div class="container">
			
			<?php if( (isset($_REQUEST['submit'])) && !empty($order_ids) ) :
				
				$order_ids_array = explode(',',$order_ids);
				
				foreach($order_ids_array as $order_id){
				
					$order_id = trim($order_id);
					
					wad_delete_order($order_id);
					
					echo $order_id .' has been deleted successfully<br>';
				
				}
			
			
			endif; ?>
	
				<h2 class="mb-6">Delete orders completely including logs etc</h2>
				<form method="post">
					<div class="row">
						<div class="col-xl-12 mb-10">
							<h3>Enter Order Ids:</h3>
							<input type="text" class="form-control" autofocus tabindex="2" name="order_ids" value="<?php echo $order_ids; ?>"/>
							<span>comma seperated order numbers</span>
						</div>
					</div>
					<input type="submit" name="submit" class="btn btn-danger btn-lg btn-block"  tabindex="4"  value="Submit" />
				</form>
		</div>
	</div>
</div>
<?php echo wad_footer(); ?>