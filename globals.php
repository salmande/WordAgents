<?php

$current_user = wad_get_current_user();
$current_user = wad_get_user_by_id($current_user['spp_id']);
$current_user_spp_id = $current_user['spp_id'];

$globals['new_orders_count'] = $current_user['new_orders_count'];
$globals['all_orders_count'] = $current_user['all_orders_count'];
$globals['working_orders_count'] = $current_user['working_orders_count'];
$globals['editing_orders_count'] = $current_user['editing_orders_count'];
$globals['revision_orders_count'] = $current_user['revision_orders_count'];
$globals['complete_orders_count'] = $current_user['complete_orders_count'];
$globals['all_orders_weekly_words_count'] = number_format($current_user['words_weekly'], 0, '.', ',');
$globals['no_of_days_for_new_orders'] = wad_get_option('no_of_days_for_new_orders') ? wad_get_option('no_of_days_for_new_orders') : 4;

$globals['order_complete_client_email_templates'] = array("Standard Order","Optimization add on");

$is_new_orders_page = $wad_url == 'orders';

if( isset($_SESSION['new_orders_count']) && !$is_new_orders_page ){
	$globals['new_orders_count'] = $_SESSION['new_orders_count'];
}else{
	$status = 2;
	if( is_editor($current_user_spp_id) ){
		$status = 17; // Ready to Edit
	}
	
	$date_due_timestamp_for_new_orders = time()+(60*60*24*$globals['no_of_days_for_new_orders']);
	// $beginOfDay = strtotime("01 Apr 2021", time());
	$endOfDay   = strtotime("tomorrow", $date_due_timestamp_for_new_orders) - 1;
	
	$query_from = "orders";
	$query_select = "*";
	$query_where = "status='{$status}'";
	
	// if( !wad_test() ){// remove this condition to check orders based on due date
		$query_where .= " AND date_due <= {$endOfDay}";
		// $query_where .= " AND date_due BETWEEN {$beginOfDay} and {$endOfDay}";
	// }

	if( !wad_test() )
	$query_where .= " AND order_title != 'TWH TEST - PLEASE IGNORE'";

	$query_where .= " AND orders.order_id NOT IN (SELECT user_rejected_order.order_id FROM user_rejected_order WHERE user_rejected_order.spp_id = '{$current_user_spp_id}')";

	$globals['new_orders_count'] = $_SESSION['new_orders_count'] = $_SESSION['new_orders_count_with_date_due'] = wad_get_total_count($query_from,$query_where);	
}


if( wad_test()){
	// echo $date_due_timestamp_for_new_orders;
}