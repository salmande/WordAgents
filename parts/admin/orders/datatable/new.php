<?php
require '../../../../constants.php';

require BASE_DIR . '/db_connection.php';
require BASE_DIR . '/functions.php';

$orders_per_page = wad_get_option('orders_per_page');

$query_from 	= "orders";
$query_select 	= "*";
$query_where	= "status=2";

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

$field = isset($_POST['sort']['field']) ? $_POST['sort']['field'] : 'due_in_end';
$sort = isset($_POST['sort']['sort']) ? $_POST['sort']['sort'] : 'ASC';

$query_orderby 	= ( $field && $sort ) ? "ORDER BY {$field} {$sort} " : "";
$query_orderby	.= "LIMIT $offset,$perpage";

$orders_result = wad_select_query( $query_from, $query_select, $query_where, $query_orderby);
$orders = mysqli_fetch_all($orders_result, MYSQLI_ASSOC);

$i=1;
foreach( $orders as &$order)
{
	$order_id = $order['order_id'];
	$order['article_info'] = wad_get_order_info_html($order);
	
	$order['pay_rate'] = '$'.wad_get_order_earning($order);
	
	$writers = wad_get_users("name, spp_id","role='writer'");
	
	ob_start();
	?>
	<form method="post" class="form-assign-writer form-assign-writer-new-order">
		<div class="form-group mb-0">
			<div class="input-group">
				<select name="employee_id" class="form-control dropdown-writers" data-live-search="true" required="required">
					<option value="">Select Writer</option>
					<?php foreach($writers as $writer): ?>
						<option value="<?php echo $writer['spp_id']; ?>"><?php echo $writer['name']; ?></option>
					<?php endforeach; ?>
				</select>
				<div class="input-group-append">
					<button class="btn btn-primary btn-assign-writer btn-assign-writer-new-order" type="submit">Assign</button>
				</div>
				<input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
				<input type="hidden" name="action" value="admin_assign_writer_new_order" />
			</div>
		</div>
	</form>
	<?php

	$order['assigned_writers'] = ob_get_clean();
	
	$order['due_in'] = wad_get_due_in( $order['due_in_end'] );

	if( $order['doc_link'] )
	$order['doc_link'] = sprintf('<a href="%s" target="_blank">Open Doc</a>', $order['doc_link']);
	
	$i++;
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