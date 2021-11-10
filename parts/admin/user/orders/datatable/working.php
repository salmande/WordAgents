<?php
require '../../../../../constants.php';

require BASE_DIR . '/db_connection.php';
require BASE_DIR . '/functions.php';

$orders_per_page = wad_get_option('orders_per_page');

$user = wad_get_user_by_id($_POST['user_spp_id']);
$assigned_orders_array = wad_explode_assigned_orders($user['assigned_orders']);
$order_ids_IN = wad_set_get_order_id_IN($assigned_orders_array);

$query_from 	= "orders";
$query_select 	= "*";
$status = "(status='5')"; //Working
$query_where = "order_id IN ({$order_ids_IN}) AND {$status}";

$generalSearch = isset($_POST['query']['generalSearch']) ? trim($_POST['query']['generalSearch']) : '';
if( $generalSearch )
{	
	if( $query_where )
		$query_where .= ' AND ';
		
	$query_where .= "order_title LIKE '%{$generalSearch}%'";
}

$page = isset($_POST['pagination']['page']) ? $_POST['pagination']['page'] : 1;
$pages = isset($_POST['pagination']['pages']) ? $_POST['pagination']['pages'] : 1;
$perpage = isset($_POST['pagination']['perpage']) ? $_POST['pagination']['perpage'] : $orders_per_page;
$total = wad_get_total_count($query_from,$query_where);

$offset = ($page-1)*$perpage;

$field = isset($_POST['sort']['field']) ? $_POST['sort']['field'] : 'assigned_end';
$sort = isset($_POST['sort']['sort']) ? $_POST['sort']['sort'] : 'ASC';

$query_orderby 	= ( $field && $sort ) ? "ORDER BY {$field} {$sort} " : "";
$query_orderby	.= "LIMIT $offset,$perpage";

$orders_result = wad_select_query( $query_from, $query_select, $query_where, $query_orderby);
$orders = mysqli_fetch_all($orders_result, MYSQLI_ASSOC);

foreach( $orders as &$order)
{
	$order_id = $order['order_id'];
	$order_words = ( $order['order_words'] ) ? $order['order_words'] : 0;
	$order_title = $order['order_title'];
	$order_status = $order['status'];
	$order_pay_rate = wad_get_pay_rate($order);
	$order_earning = wad_get_order_earning($order);
	
	$due_in_timestamp = wad_get_due_in_timestamp($order);
	$order_due_in = wad_get_due_in( $due_in_timestamp );

	$order_date_due = date('F d, Y', $order['date_due']);
	
	$order['article_info'] = wad_get_order_info_html($order);
	
	$order['pay_rate'] = '$'.$order_earning;

	$order['due_in'] = $order_due_in;
	
	$order['date_due'] = $order_date_due;
	
	$order['doc_link'] = sprintf('<a href="%s">Open Doc</a>', $order['doc_link']);
	
	
	$order['status'] = wad_get_status_label($order['status']);	
}

$response = array();

$response['meta']['page'] = $page;
$response['meta']['pages'] = $pages;
$response['meta']['perpage'] = $perpage;
$response['meta']['total'] = $total;
$response['meta']['sort'] = $sort;
$response['meta']['field'] = $field;

$response['data'] = $orders;

echo json_encode($response);
?>