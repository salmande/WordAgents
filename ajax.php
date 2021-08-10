<?php

$current_user_spp_id = wad_get_current_user('spp_id');

$action = ( isset($_REQUEST['action']) && $_REQUEST['action'] ) ? $_REQUEST['action'] : '';

if( $action == 'orders'
	|| $action == 'orders-working'
	|| $action == 'orders-editing'
	|| $action == 'orders-revisions'
	|| $action == 'orders-complete'
	|| $action == 'orders-all'
	|| $action == 'accounting-pending'
	|| $action == 'accounting-all'
){
	$data_var = 'orders';

	$page = $_REQUEST['page'];
	$per_page = $_REQUEST['per_page'];
	$offset = $page == 1 ? 0 : $per_page*($page-1);
	
	if( $action == 'orders-working')
	{		
		$current_user_spp_id = wad_get_current_user('spp_id');
		
		$status = "(o.status='5')"; //Working
		
		$query_from = "users u, orders o, order_assigned_user ou";
		$query_select = "o.*";
		$query_where = "u.spp_id = ou.spp_id AND o.order_id = ou.order_id AND u.spp_id='{$current_user_spp_id}' AND ( {$status} )";
		$query_order = "ORDER BY assigned_end ASC LIMIT $offset,$per_page";
		
		$result = wad_select_query( $query_from,$query_select,$query_where,$query_order);
		$total = $globals['working_orders_count'];
		
		if( $total ){
			$pagination = wad_pagination($page, $total, $per_page, 2, "page=%d&per_page=%d&action=orders-working", "orders-working");
		}
	}else if( $action == 'accounting-pending')
	{
		$status = "(o.status='5')"; //Working
		if( is_editor() ){
		$status = "(o.status='12')"; //Editing
		}
		$current_user_spp_id = wad_get_current_user('spp_id');

		$query_from = "users u, orders o, order_assigned_user ou";
		$query_select = "o.*";
		$query_where = "u.spp_id = ou.spp_id AND o.order_id = ou.order_id AND u.spp_id='{$current_user_spp_id}' AND ( {$status} )";
		$query_order = "ORDER BY started ASC LIMIT $offset,$per_page";
		
		$result = wad_select_query( $query_from,$query_select,$query_where,$query_order);
		$total = wad_get_total_count($query_from,$query_where);
		
		if( $total ){
			$pagination = wad_pagination($page, $total, $per_page, 2, "page=%d&per_page=%d&action=accounting-pending", "accounting-pending");
		}
	}else if( $action == 'orders-editing')
	{
		$current_user_spp_id = wad_get_current_user('spp_id');
		$sort = 'started';
		$status = "(o.status='17' OR o.status='12')"; //Ready to Edit || Editing
		if( is_editor() ){
			$sort = 'editor_claim_time_end';
			$status = "(o.status='12')"; // Editing
		}
		
		$query_from = "users u, orders o, order_assigned_user ou";
		$query_select = "o.*";
		$query_where = "u.spp_id = ou.spp_id AND o.order_id = ou.order_id AND u.spp_id='{$current_user_spp_id}' AND ( {$status} )";
		$query_order = "ORDER BY {$sort} ASC LIMIT $offset,$per_page";
		
		$result = wad_select_query( $query_from,$query_select,$query_where,$query_order);
		$total = $globals['editing_orders_count'];
		
		if( $total ){
			$pagination = wad_pagination($page, $total, $per_page, 2, "page=%d&per_page=%d&action=orders-editing", "orders-editing");
		}
	}else if( $action == 'orders-revisions')
	{		
		$current_user_spp_id = wad_get_current_user('spp_id');
		
		$status = "(o.status='6' OR o.status='9')"; //Editor Revision || Revisions

		$query_from = "users u, orders o, order_assigned_user ou";
		$query_select = "o.*";
		$query_where = "u.spp_id = ou.spp_id AND o.order_id = ou.order_id AND u.spp_id='{$current_user_spp_id}' AND ( {$status} )";
		$query_order = "ORDER BY started ASC LIMIT $offset,$per_page";
		
		$result = wad_select_query( $query_from,$query_select,$query_where,$query_order);
		$total = $globals['revision_orders_count'];
		
		if( $total ){
			$pagination = wad_pagination($page, $total, $per_page, 2, "page=%d&per_page=%d&action=orders-revisions", "orders-revisions");
		}
	}else if( $action == 'orders-complete')
	{
		$current_user_spp_id = wad_get_current_user('spp_id');
		$status = "(o.status='3')";
	
		$query_from = "users u, orders o, order_assigned_user ou";
		$query_select = "o.*";
		$query_where = "u.spp_id = ou.spp_id AND o.order_id = ou.order_id AND u.spp_id='{$current_user_spp_id}' AND ( {$status} )";
		$query_order = "ORDER BY started ASC LIMIT $offset,$per_page";
		
		$result = wad_select_query( $query_from,$query_select,$query_where,$query_order);
		$total = $globals['complete_orders_count'];
		
		if( $total ){
			$pagination = wad_pagination($page, $total, $per_page, 2, "page=%d&per_page=%d&action=orders-complete", "orders-complete");
		}
	}else if( $action == 'accounting-all')
	{
		$status = "o.status='3' OR o.status='5' OR o.status='17' OR o.status='12'"; //Complete, Working, ReadyToEdit OR Editing
		if( is_editor() ){
			$status = "o.status='3' OR o.status='12'"; //Complete OR Editing
		}
		$current_user_spp_id = wad_get_current_user('spp_id');
	
		$query_from = "users u, orders o, order_assigned_user ou";
		$query_select = "o.*";
		$query_where = "u.spp_id = ou.spp_id AND o.order_id = ou.order_id AND u.spp_id='{$current_user_spp_id}' AND ( {$status} )";
		$query_order = "ORDER BY started ASC LIMIT $offset,$per_page";
		
		$result = wad_select_query( $query_from,$query_select,$query_where,$query_order);
		$total = wad_get_total_count($query_from,$query_where);
		
		if( $total ){
			$pagination = wad_pagination($page, $total, $per_page, 2, "page=%d&per_page=%d&action=accounting-all", "accounting-all");
		}
	}else if( $action == 'orders-all')
	{		
		$current_user_spp_id = wad_get_current_user('spp_id');

		$status = "o.status='5' OR o.status='6' OR o.status='9' OR o.status='12' OR o.status='3' OR o.status='17'"; //Working, EditorRevision, Revision, Editing, Complete OR ReadyToEdit
		if( is_editor() ){
			$status = "o.status='6' OR o.status='9' OR o.status='12' OR o.status='3'"; //EditorRevision, Revision, Editing, Complete
		}
		
		$query_from = "users u, orders o, order_assigned_user ou";
		$query_select = "o.*";
		$query_where = "u.spp_id = ou.spp_id AND o.order_id = ou.order_id AND u.spp_id='{$current_user_spp_id}' AND ( {$status} )";
		$query_order = "ORDER BY started ASC LIMIT $offset,$per_page";
		
		$result = wad_select_query( $query_from,$query_select,$query_where,$query_order);
		$total = $globals['all_orders_count'];
		
		if( $total ){
			$pagination = wad_pagination($page, $total, $per_page, 2, "page=%d&per_page=%d&action=orders-all", "orders-all");
		}
	}else
	{
		$current_user_spp_id = wad_get_current_user('spp_id');
		
		$sort = 'due_in_end';
		$status = 2;
		if( is_editor() ){
			$sort = 'writer_submit_time_end';
			$status = 17; // Ready to Edit
		}
		
		// $total = $globals['new_orders_count'];
		$total = $_SESSION['new_orders_count_with_date_due'];
		$date_due_timestamp_for_new_orders = time()+(60*60*24*$globals['no_of_days_for_new_orders']);
		// $beginOfDay = strtotime("01 Apr 2021", time());
		$endOfDay   = strtotime("tomorrow", $date_due_timestamp_for_new_orders) - 1;
		
		$query_from = "orders";
		$query_select = "*";
		$query_where = "status='{$status}'";
		// if( !wad_test() ){// remove this condition to check orders based on due date
			if( $total && $total > 3 ){
				$query_where .= " AND date_due <= {$endOfDay}";					
				// $query_where .= " AND date_due BETWEEN {$beginOfDay} and {$endOfDay}";				
			}
		// }
		
		if( !wad_test() )
		$query_where .= " AND order_title != 'TWH TEST - PLEASE IGNORE'";
		
		$query_where .= " AND orders.order_id NOT IN (SELECT user_rejected_order.order_id FROM user_rejected_order WHERE user_rejected_order.spp_id = '{$current_user_spp_id}')";
		$query_order = "ORDER BY {$sort} ASC LIMIT $offset,$per_page";

		$result = wad_select_query( $query_from,$query_select,$query_where,$query_order);
		
		if( !$total || $total < 4){
			$total = $globals['new_orders_count'] = $_SESSION['new_orders_count'] = wad_get_total_count($query_from, $query_where);
		}

		if( $total ){
			$pagination = wad_pagination($page, $total, $per_page, 2, "page=%d&per_page=%d&action=orders", "orders");
		}
		

		if( wad_test()){
			// echo '<pre>';
			// print_r($globals);
			// print_r($_SESSION);
			
			// $result = wad_select_query( $query_from,$query_select,$query_where,$query_order, true);
			// echo $result;
			// echo '</pre>';
		}
		
		
	}
	
	$orders_all = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
	${"$data_var"} = array();

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
		
		if( $action == 'orders-complete' || $action == 'accounting-pending' || $action == 'accounting-all'){
			${$data_var}[$i]['pay_rate'] = '$'.($order_pay_rate);
		}else{
			${$data_var}[$i]['pay_rate'] = '$'.$order_earning;
		}
		${$data_var}[$i]['due_in'] = $order_due_in;
		${$data_var}[$i]['doc_link'] = $order_doc_link;
		${$data_var}[$i]['date_due'] = $order_date_due;
		
		$i++;
	}
		
	ob_start();
	
	switch( $action ){
		
		case "orders-working":
			require 'parts/orders/table/working.php'; break;
		
		case "accounting-pending":
			require 'parts/accounting/table/pending.php'; break;
		
		case "orders-editing":
			require 'parts/orders/table/editing.php'; break;
		
		case "orders-revisions":
			require 'parts/orders/table/revisions.php'; break;
		
		case "orders-complete":
			require 'parts/orders/table/complete.php'; break;
		
		case "accounting-all":
			require 'parts/accounting/table/all.php'; break;
		
		case "orders-all":
			require 'parts/orders/table/all.php'; break;
		
		default:
			require 'parts/orders/table/orders.php';
		
	}
	
	echo ob_get_clean();

}

// writer claim order - START
if( $action == 'writer_claim_order')
{
	wad_writer_claim_order();
	die();
}
// END - writer claim order

// editor claim order - START
if( $action == 'editor_claim_order')
{
	wad_editor_claim_order();
	die();
}
// END - editor claim order

// Order Details Modal Content - START
if( $action == 'order_details_modal_content_ajax')
{
	if( ! $_REQUEST['order_id'] )
		die();
	
	$current_page_url = $_REQUEST['current_page_url'];
	
	echo order_details_modal_content_ajax($_REQUEST['order_id'], $current_page_url);
	die();
}
// END - Order Details Modal Content