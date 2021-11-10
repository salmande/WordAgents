<?php
require '../../../../constants.php';

require BASE_DIR . '/db_connection.php';
require BASE_DIR . '/functions.php';

$orders_per_page = wad_get_option('orders_per_page');

$current_timestamp_minus_24_hours = time() - 24*60*60;

$query_from 	= "orders";
$query_select 	= "*";
$query_where	= "((UNIX_TIMESTAMP() > due_in_end AND status='2') OR ({$current_timestamp_minus_24_hours} > writer_submit_time_end AND status='17') OR ({$current_timestamp_minus_24_hours} > editor_claim_time_end AND status='12'))";

$generalSearch = isset($_POST['query']['generalSearch']) ? trim($_POST['query']['generalSearch']) : '';
if( $generalSearch )
{	
	if( $query_where )
		$query_where .= ' AND ';
		
	$query_where .= "(order_title LIKE '%{$generalSearch}%' || order_id LIKE '%{$generalSearch}%')";
}

$missing_doc_link = (isset($_REQUEST['missing_doc_link']) && $_REQUEST['missing_doc_link']) ? true : false;
if( $missing_doc_link )
{	
	if( $query_where )
		$query_where .= ' AND ';
		
	$query_where .= "(doc_link IS NULL OR doc_link = '')";
}

$page = isset($_POST['pagination']['page']) ? $_POST['pagination']['page'] : 1;
$pages = isset($_POST['pagination']['pages']) ? $_POST['pagination']['pages'] : 1;
$perpage = isset($_POST['pagination']['perpage']) ? $_POST['pagination']['perpage'] : $orders_per_page;
$total = wad_get_total_count($query_from,$query_where);

$offset = ($page-1)*$perpage;

$field = isset($_POST['sort']['field']) ? $_POST['sort']['field'] : 'started';
$sort = isset($_POST['sort']['sort']) ? $_POST['sort']['sort'] : 'ASC';

$query_orderby 	= ( $field && $sort ) ? "ORDER BY {$field} {$sort} " : "";
$query_orderby	.= "LIMIT $offset,$perpage";

$orders_result = wad_select_query( $query_from, $query_select, $query_where, $query_orderby);
$orders = mysqli_fetch_all($orders_result, MYSQLI_ASSOC);

foreach( $orders as &$order)
{
	$order_id = $order['order_id'];
	$order_status = $order['status'];

	$order['article_info'] = wad_get_order_info_html($order);
	
	if( $order['doc_link'] )
	$order['doc_link'] = sprintf('<a href="%s" target="_blank">Open Doc</a>', $order['doc_link']);
	
	$assigned_writers_editors = wad_get_assigned_writers_and_editors($order_id, array('name','spp_id'));
	$assigned_writers = $assigned_writers_editors['writers'];
	$assigned_editors = $assigned_writers_editors['editors'];

	$assigned_writers_array = $assigned_editors_array = array();
	foreach($assigned_writers as $assigned_writer){
		$assigned_writers_array[] = sprintf('<a href="%s">%s</a>', BASE_URL.'/users/edit/'.$assigned_writer['spp_id'], $assigned_writer['name']);
	}
	foreach($assigned_editors as $assigned_editor){
		$assigned_editors_array[] = sprintf('<a href="%s">%s</a>', BASE_URL.'/users/edit/'.$assigned_editor['spp_id'], $assigned_editor['name']);
	}
	
	$order['assigned_writers'] = empty($assigned_writers_array) ? '-' : implode(", ", $assigned_writers_array);
	$order['assigned_editors'] = empty($assigned_editors_array) ? '-' : implode(", ", $assigned_editors_array);
	
	$order['reason'] = ($order_status == 2) ? 'No one picked' : "Overdue";
	
	switch($order_status){
		case 17: $overdue_timestamp = $order['writer_submit_time_end']; break;
		case 12: $overdue_timestamp = $order['editor_claim_time_end']; break;
		case 2: $overdue_timestamp = $order['due_in_end']; break;
	}
	$overdue_datetime = date('Y-m-d H:i:s', $overdue_timestamp);
	$order['overdue'] = '<span title="'.wad_time_elapsed_string($overdue_datetime,true).'">'.wad_time_elapsed_string($overdue_datetime).'</span>';
	
	$order['status'] = wad_get_status_label($order_status);
	
	
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