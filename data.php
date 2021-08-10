<?php

$current_user_spp_id = wad_get_current_user('spp_id');

if( $wad_url == 'orders'
	|| $wad_url == 'wad-orders/working'
	|| $wad_url == 'wad-orders/editing'
	|| $wad_url == 'wad-orders/revisions'
	|| $wad_url == 'wad-orders/complete'
	|| $wad_url == 'wad-orders/all' 
	|| $wad_url == 'accounting/pending'
	|| $wad_url == 'accounting/all'
	|| $wad_url == 'order/single'
){
	$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
	$per_page = ( wad_get_option('orders_per_page') ) ? wad_get_option('orders_per_page') : 50;
	$offset = $page == 1 ? 0 : $per_page*($page-1);
	$pagination = '';
	$data_var = 'orders';
	
	if( $wad_url == 'wad-orders/working' ) // Working
	{ 
		$total = $globals['working_orders_count'];
			
		if( $total )
		{
			$assigned_orders_array = wad_explode_assigned_orders($current_user['assigned_orders']);
			$order_ids_IN = wad_set_get_order_id_IN($assigned_orders_array);

			$status = "(status='5')"; //Working
		
			$query_from = 'orders';
			$query_select = '*';
			$query_where = "order_id IN ({$order_ids_IN}) AND {$status}";
			$query_order = "ORDER BY assigned_end ASC LIMIT $per_page";
			
			$result = wad_select_query( $query_from,$query_select,$query_where,$query_order);
			$pagination = wad_pagination($page, $total, $per_page);
		}
	}
	else if( $wad_url == 'accounting/pending') // Pending Earnings
	{
		$status = "(status='5')"; //Working
		if( is_editor() ){
		$status = "(status='12')"; //Editing
		}
		
		$assigned_orders_array = wad_explode_assigned_orders($current_user['assigned_orders']);
		$order_ids_IN = wad_set_get_order_id_IN($assigned_orders_array);

		$query_from = 'orders';
		$query_select = '*';
		$query_where = "order_id IN ({$order_ids_IN}) AND {$status}";
		$query_order = "ORDER BY started ASC LIMIT $per_page";
		
		$total = wad_get_total_count($query_from,$query_where);
		
		if( $total ){
			$result = wad_select_query( $query_from,$query_select,$query_where,$query_order);
			$pagination = wad_pagination($page, $total, $per_page);
		}
	}
	else if( $wad_url == 'wad-orders/editing') // Editing
	{
		$total = $globals['editing_orders_count'];
		if( $total )
		{
			$sort = 'started';
			$status = "(status='17' OR status='12')"; //Ready to Edit || Editing
			if( is_editor() ){
				$status = "(status='12')"; // Editing
				$sort = 'editor_claim_time_end';
			}
			
			$assigned_orders_array = wad_explode_assigned_orders($current_user['assigned_orders']);
			$order_ids_IN = wad_set_get_order_id_IN($assigned_orders_array);
		
			$query_from = 'orders';
			$query_select = '*';
			$query_where = "order_id IN ({$order_ids_IN}) AND {$status}";
			$query_order = "ORDER BY $sort ASC LIMIT $per_page";
			
			$result = wad_select_query( $query_from,$query_select,$query_where,$query_order);
			$pagination = wad_pagination($page, $total, $per_page);
		}
	}
	else if( $wad_url == 'wad-orders/revisions') // Revisions
	{	
		$total = $globals['revision_orders_count'];
		if( $total )
		{
			$status = "(status='6' OR status='9')"; //Editor Revision || Revisions
			
			$assigned_orders_array = wad_explode_assigned_orders($current_user['assigned_orders']);
			$order_ids_IN = wad_set_get_order_id_IN($assigned_orders_array);

			$query_from = 'orders';
			$query_select = '*';
			$query_where = "order_id IN ({$order_ids_IN}) AND {$status}";
			$query_order = "ORDER BY started ASC LIMIT $per_page";
			
			$result = wad_select_query( $query_from,$query_select,$query_where,$query_order);
			$pagination = wad_pagination($page, $total, $per_page);
		}		
	}
	else if( $wad_url == 'wad-orders/complete') // Complete
	{
		$total = $globals['complete_orders_count'];
		
		if( $total )
		{
			$assigned_orders_array = wad_explode_assigned_orders($current_user['assigned_orders']);
			$order_ids_IN = wad_set_get_order_id_IN($assigned_orders_array);

			$query_from = 'orders';
			$query_select = '*';
			$query_where = "order_id IN ({$order_ids_IN}) AND status=3";
			$query_order = "ORDER BY started ASC LIMIT $offset,$per_page";
			
			$result = wad_select_query( $query_from,$query_select,$query_where,$query_order);
			$pagination = wad_pagination($page, $total, $per_page);
		}
		
	}
	else if( $wad_url == 'accounting/all') // All Earnings - Accounting
	{
		$status = "status='3' OR status='5' OR status='17' OR status='12'"; //Complete, Working, ReadyToEdit OR Editing
		if( is_editor() ){
			$status = "status='3' OR status='12'"; //Complete OR Editing
		}
		
		$assigned_orders_array = wad_explode_assigned_orders($current_user['assigned_orders']);
		$order_ids_IN = wad_set_get_order_id_IN($assigned_orders_array);

		$query_from = 'orders';
		$query_select = '*';
		$query_where = "order_id IN ({$order_ids_IN}) AND {$status}";
		$query_order = "ORDER BY started ASC LIMIT $offset,$per_page";
		
		$total = wad_get_total_count($query_from,$query_where);
		
		if( $total ){
			$result = wad_select_query( $query_from,$query_select,$query_where,$query_order);
			$pagination = wad_pagination($page, $total, $per_page);
		}
	}
	else if( $wad_url == 'wad-orders/all') // All Orders
	{	
		$assigned_orders_array = wad_explode_assigned_orders($current_user['assigned_orders']);
		$total = count($assigned_orders_array);
		
		if( $total )
		{
			$order_ids_IN = wad_set_get_order_id_IN($assigned_orders_array);
			
			$query_from = 'orders';
			$query_select = '*';
			$query_where = "order_id IN ({$order_ids_IN})";
			$query_order = "ORDER BY started ASC LIMIT $offset,$per_page";
			
			$result = wad_select_query( $query_from,$query_select,$query_where,$query_order);
			$pagination = wad_pagination($page, $total, $per_page);
		}
	}
	else  // New Orders
	{
		$status = 2;
		$sort = 'due_in_end';
		if( is_editor() ){
			$status = 17; // Ready to Edit
			$sort = 'writer_submit_time_end';
		}
		
		$total = $globals['new_orders_count'];

		$date_due_timestamp_for_new_orders = time()+(60*60*24*$globals['no_of_days_for_new_orders']);
		// $beginOfDay = strtotime("01 Apr 2021", time());
		$endOfDay   = strtotime("tomorrow", $date_due_timestamp_for_new_orders) - 1;
		
		$query_from = "orders";
		$query_select = "*";
		$query_where = "status='{$status}'";
		if( !wad_test() ){ // remove this condition to check orders based on due date
			if( $total && $total > 3 ){
				$query_where .= " AND date_due <= {$endOfDay}";					
				// $query_where .= " AND date_due BETWEEN {$beginOfDay} and {$endOfDay}";
			}
		}
		
		if( !wad_test() )
		$query_where .= " AND order_title != 'TWH TEST - PLEASE IGNORE'";
		
		$query_where .= " AND orders.order_id NOT IN (SELECT user_rejected_order.order_id FROM user_rejected_order WHERE user_rejected_order.spp_id = '{$current_user_spp_id}')";
		$query_order = "ORDER BY {$sort} ASC LIMIT $per_page";

		$result = wad_select_query( $query_from,$query_select,$query_where,$query_order);
		
		if( !$total || $total < 4){
			$total = $globals['new_orders_count'] = $_SESSION['new_orders_count'] = wad_get_total_count($query_from, $query_where);
		}
		
		if( $total ){
			$pagination = wad_pagination($page, $total, $per_page);
		}
	}
	
	if( wad_test() ){
		if( $wad_url == 'order/single'){
			$per_page = -1;
			$result = wad_select_query(
				"orders o",
				"o.*",
				"order_id IN ('FEC64263','901CEA25_5','AAA45900_16','AAA45900_19','EBC2A3E1_4','EBC2A3E1_2','A013AACC_2','98FFBB23_9','C43FAA1C_65','C43FAA1C_58','C43FAA1C_33','EFB73EC6','CB465A54_42','A564FB70_2','AE2E28EE_4','502F2AEB_4','502F2AEB_2','BF074FD9_2','E858B521_39','E858B521_37','E858B521_38','E858B521_35','E858B521_33','E858B521_36','E858B521_32','E858B521_34','E858B521_28','E858B521_22','650569FC_4')"
			);
			$result = wad_select_query(
				"orders o",
				"o.*",
				"order_id IN ('263DC7A6','29406D79','B9F7F5A0_29','AAA45900_19','A013AACC_2','98FFBB23_9','707BFB89_8','273519E7_15','90BC2413_13','69934B0E_2','C4ABB702_6','C4ABB702_4','C4ABB702_3','C4ABB702_2','C4ABB702_1','0362C5B3_1','D2007852','18B28B98_1','717924E1_6','717924E1_5','717924E1_3','717924E1_2','272FB3DC_5','272FB3DC_4','DC0FEF5D_1','B9F7F5A0_49','B9F7F5A0_44','B9F7F5A0_43')"
			);
			$result = wad_select_query(
				"orders o",
				"o.*",
				"order_id IN ('84241ABE')"
			);
			
			$pagination = wad_pagination($page, 28, $per_page, 2, "page=%d&per_page=%d&action=orders-working", "orders-working");
		}
	}
	
	if( isset($result) )
	$orders_all = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
	${"$data_var"} = array();
	
	if( isset($orders_all) && !empty($orders_all) ){
		$i=0;
		foreach($orders_all as $order){
			$order_id = $order['order_id'];
			$order_words = ( $order['order_words'] ) ? $order['order_words'] : 0;
			$order_title = $order['order_title'];
			$order_status = $order['status'];
			$order_doc_link = $order['doc_link'];
			
			$due_in_timestamp = wad_get_due_in_timestamp($order);
			$order_due_in = wad_get_due_in( $due_in_timestamp );
			
			$order_pay_rate = wad_get_pay_rate($order);
			$order_earning = wad_get_order_earning($order);
			
			$order_date_due = date('F d, Y', $order['date_due']);
			
			${$data_var}[$i]['order_id'] = $order_id;		
			${$data_var}[$i]['words_length'] = $order_words;		
			${$data_var}[$i]['title'] = $order_title;
			${$data_var}[$i]['earning'] = '$'.$order_earning;
			${$data_var}[$i]['status'] = $order_status;
			
			if( $wad_url == 'wad-orders/complete' || $wad_url == 'accounting/pending' || $wad_url == 'accounting/all'){
				${$data_var}[$i]['pay_rate'] = '$'.($order_pay_rate);
			}else{
				${$data_var}[$i]['pay_rate'] = '$'.$order_earning;
			}
			${$data_var}[$i]['due_in'] = $order_due_in;
			${$data_var}[$i]['doc_link'] = $order_doc_link;
			${$data_var}[$i]['date_due'] = $order_date_due;
			
			$i++;
		}
	}
}
else if( $wad_url == 'wad-admin/users/all' )
{	// All Users Count
	$all_users_count = wad_get_total_count("users");
}
else if( $wad_url == 'wad-admin/users/writers' )
{	// All Writers Count
	$all_writers_count = wad_get_total_count("users", "role='Writer'");
}
else if( $wad_url == 'wad-admin/users/editors' )
{	// All Editors Count
	$all_editors_count = wad_get_total_count("users", "role='Editor'");
}
else if( $wad_url == 'wad-admin/orders/all' )
{	// All Orders
	$all_orders_count = wad_get_total_count("orders");
}
else if( strpos($wad_url, 'wad-admin/users/edit') !== false){
	$url = $_REQUEST['url']; // "admin/users/edit/123" where 123 is user's SPP ID.
	$spp_id = basename(parse_url($url, PHP_URL_PATH)); //123
	
	$user = wad_get_user_by_id($spp_id);
}