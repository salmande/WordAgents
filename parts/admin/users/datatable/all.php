<?php

require '../../../../constants.php';

require BASE_DIR . '/db_connection.php';
require BASE_DIR . '/functions.php';

$query_from 	= "users";
$query_select 	= "name, email, role, assigned_orders, spp_id";
$query_where	= "(spp_id IS NOT NULL AND spp_id != 0)";

$generalSearch = isset($_POST['query']['generalSearch']) ? trim($_POST['query']['generalSearch']) : '';
if( $generalSearch ){
	if( $query_where )
		$query_where .= ' AND ';
	
	$query_where .= "name LIKE '%{$generalSearch}%'";
}

$orders_per_page = wad_get_option('orders_per_page');
$page = isset($_POST['pagination']['page']) ? $_POST['pagination']['page'] : 1;
$pages = isset($_POST['pagination']['pages']) ? $_POST['pagination']['pages'] : 1;
$perpage = isset($_POST['pagination']['perpage']) ? $_POST['pagination']['perpage'] : $orders_per_page;
$total = wad_get_total_count($query_from,$query_where);

$field = isset($_POST['sort']['field']) ? $_POST['sort']['field'] : '';
$sort = isset($_POST['sort']['sort']) ? $_POST['sort']['sort'] : '';

$offset = ($page-1)*$perpage;

$query_orderby 	= ( $field && $sort ) ? "ORDER BY {$field} {$sort} " : "";
$query_orderby	.= "LIMIT $offset,$perpage";

$all_users_result = wad_select_query( $query_from, $query_select, $query_where, $query_orderby);
$all_users = mysqli_fetch_all($all_users_result, MYSQLI_ASSOC);

$all_orders = wad_get_orders("order_id, order_words, is_tool, status");

$i=0;
foreach($all_users as &$user)
{
	$spp_id = $user['spp_id'];
	
	if( ! $spp_id ){
		continue;
	}

	$user_role = $user['role'];
	$assigned_orders_array = wad_explode_assigned_orders($user['assigned_orders']);
	
	$earning_total = $earning_pending = $orders_pending_total = $orders_complete_total = 0;
	$earning_total_status = array(3,5); //Complete OR Working
	$earning_pending_status = array(5); //Working
	$orders_complete_status = array(3,12); //Complete OR Editing
	if( $user_role == 'Editor' ){
		$earning_total_status = array(3,12); //Complete OR Editing
		$earning_pending_status = array(12); //Editing
		$orders_complete_status = array(3); //Complete OR Editing
	}
	
	foreach($all_orders as $order)
	{
		$order_id = $order['order_id'];
		$status = $order['status'];
		
		if( in_array($order_id, $assigned_orders_array) )
		{
			//Total Earnings
			if( in_array($status, $earning_total_status) ){
				$earning_total += wad_get_order_earning($order, $spp_id);
			}
			
			//Pending Earnings and Pending Orders
			if( in_array($status, $earning_pending_status) ){
				//Pending Earnings
				$earning_pending += wad_get_order_earning($order, $spp_id);
				
				//Pending Orders
				$orders_pending_total += 1;
			}
			
			//Total Earnings
			if( in_array($status, $orders_complete_status) ){
				$orders_complete_total += 1;
			}
		}
	}
	
	$user['sign_in_as_user'] = ( $user_role == 'Writer' || $user_role == 'Editor' ) ? true : false;
	$user['pending_earnings'] = '$'.$earning_pending;
	$user['total_earnings'] = '$'.$earning_total;	
	$user['order_pending'] = $orders_pending_total;
	$user['order_completed'] = $orders_complete_total;
	$user['total_orders_rejected'] = $user['total_orders_missed'] = '-';
	if( $user_role == 'Writer' || $user_role == 'Editor' ){
		$user['total_orders_rejected'] = wad_get_rejected_orders_by_id($spp_id, true);
		$user['total_orders_missed'] = wad_get_missed_orders_by_id($spp_id, true);
	}
	
	$i++;
}

$response = array();
$response['meta']['page'] = $page;
$response['meta']['pages'] = $pages;
$response['meta']['perpage'] = $perpage;
$response['meta']['total'] = $total;
$response['meta']['sort'] = $sort;
$response['meta']['field'] = $field;
$response['data'] = $all_users;

echo json_encode($response);
?>