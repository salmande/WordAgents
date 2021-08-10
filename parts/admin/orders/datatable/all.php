<?php
require '../../../../constants.php';

require BASE_DIR . '/db_connection.php';
require BASE_DIR . '/functions.php';

$orders_per_page = wad_get_option('orders_per_page');

$query_from 	= "orders";
$query_select 	= "*";
$query_where	= "";

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

$field = isset($_POST['sort']['field']) ? $_POST['sort']['field'] : 'id';
$sort = isset($_POST['sort']['sort']) ? $_POST['sort']['sort'] : 'DESC';

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
	$order_doc_link = $order['doc_link'];
	
	$order['article_info'] = wad_get_order_info_html($order);
	
	$order['date_due'] = ( $order['date_due'] ) ? date('F d, Y', $order['date_due']) : '-';
	
	$order['status'] = wad_get_status_label($order['status']);
	
	$assigned_employees = wad_get_assigned_users($order_id);
	$assigned_writers = $assigned_editors = array();

	$earning_writer = 0;
	$earning_editor = 0;

	if( count($assigned_employees) )
	{
		foreach($assigned_employees as $assigned_employee)
		{
			$employee = wad_get_user_by_id($assigned_employee['spp_id']);
			$pay_rate = wad_get_pay_rate($order, $assigned_employee['spp_id']);
			
			if( $employee['role'] == 'Writer' )
			{
				$assigned_writers[] = $employee['name'];
				$earning_writer += $order_words * $pay_rate;
			}
			
			if( $employee['role'] == 'Editor' )
			{
				$assigned_editors[] = $employee['name'];
				$earning_editor += $order_words * $pay_rate;
			}
			
		}
	}

	$order['earning_writer'] = '$' . ( ( $earning_writer ) ? $earning_writer : 0 );
	
	$order['earning_editor'] = '$' . ( ( $earning_editor ) ? $earning_editor : 0 );

	$order['expense'] = '$' . ( $earning_writer + $earning_editor );

	$order['assigned_writers'] = empty($assigned_writers) ? '-' : implode(", ", $assigned_writers);
	
	$order['assigned_editors'] = empty($assigned_editors) ? '-' : implode(", ", $assigned_editors);
	
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