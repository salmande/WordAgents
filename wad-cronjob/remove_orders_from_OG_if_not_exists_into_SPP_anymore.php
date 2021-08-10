<?php
$all_orders_ids = wad_get_orders_ids('order_id');
$orders_total = count($all_orders_ids);
if( $orders_total ){
	$i=0;
	$orders_fetched = 0;
	foreach($all_orders_ids as $order_id){
		$order = wad_get_spp_order_info($order_id);
		// $orders_fetched++;
		if( isset($order['message']) && $order['message'] == 'Order not found' ){
			wad_delete_query("orders", "order_id='{$order_id}'");
			wad_delete_query("order_assigned_user", "order_id='{$order_id}'");
			if( wad_get_option('save_log') == 'yes')
			{
				$log_columns = 	array( "from_type", "action", "source", "source_id", "time" );
				$log_values = 	array( "CronJob", "deleted order", "order", $order_id, time() );
				wad_insert_query("logs", $log_columns, $log_values);
			}
		}
		$i++;
		// if( $i==5)
		// break;
	}
}
// echo $orders_fetched;