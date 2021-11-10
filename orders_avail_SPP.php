<?php
wad_header();

$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 5;
$offset = isset($_REQUEST['offset']) ? $limit*$_REQUEST['offset'] : 0;

$order_id = isset($_REQUEST['order']) ? $_REQUEST['order'] : null;

if($order_id!=null)
$orders = wad_query_with_fetch("SELECT * FROM orders WHERE order_id='{$order_id}'");
else
$orders = wad_query_with_fetch("SELECT * FROM orders LIMIT {$offset},{$limit}");

$start = $offset+1;
$end = isset($_REQUEST['offset']) ? ($_REQUEST['offset']+1)*$limit : '';

?>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="d-flex flex-column-fluid">
		<div class="container">
		
			<h2>Checking orders exist in SPP or not</h2>
			
			<?php if( !empty($orders)):  ?>
			
			<?php echo $start.'-'.$end.'<br><br>';
			echo 'updated'; 
			?>
			<div class="row">
				<div class="col-xl-12">
					<h3>Orders:</h3>
					<div class="checkbox-list">
					<?php foreach($orders as $order):
					
					$order_id = $order['order_id'];
					$order_info = wad_get_spp_order_info($order_id);
					$spp_order_status = isset($order_info['status']) ? $order_info['status'] : '';
					if( $spp_order_status=='error' ){
						?>
						<p class="text-danger">
						<a class="text-danger" href="https://app.wordagents.com/orders/<?php echo $order_id; ?>" target="_blank"><?php echo $order_id; ?></a>
						</p>

						<?php
					
					}else{
						?>
						<p class="text-success2">
						<?php echo $order['id'] . '. '; ?>
						<a class="text-success2" href="https://app.wordagents.com/orders/<?php echo $order_id; ?>" target="_blank"><?php echo $order_id; ?></a>
						--- Exists
						</p>
						<?php
					}
					
					
					endforeach; ?>
					</div>
				</div>
			</div>
			
			<?php else: ?>
			
			Not found
			
			<?php endif; ?>
			
		</div>
	</div>
</div>
<?php echo wad_footer(); ?>