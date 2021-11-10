<?php
require '../../../../constants.php';

require BASE_DIR . '/db_connection.php';
require BASE_DIR . '/functions.php';

$orders_per_page = wad_get_option('orders_per_page');

$query_from 	= "orders";
$query_select 	= "*";
$query_where	= "status=17";

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

$field = isset($_POST['sort']['field']) ? $_POST['sort']['field'] : 'writer_submit_time_end';
$sort = isset($_POST['sort']['sort']) ? $_POST['sort']['sort'] : 'ASC';

$query_orderby 	= ( $field && $sort ) ? "ORDER BY {$field} {$sort} " : "";
$query_orderby	.= "LIMIT $offset,$perpage";

$orders_result = wad_select_query( $query_from, $query_select, $query_where, $query_orderby);
$orders = mysqli_fetch_all($orders_result, MYSQLI_ASSOC);

foreach( $orders as &$order)
{
	$order_id = $order['order_id'];
	$order['article_info'] = wad_get_order_info_html($order);
	
	$order['due_in'] = wad_get_due_in( $order['writer_submit_time_end'] );

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
	
	$editors = wad_get_users("name, spp_id","role='editor'");
	
	ob_start();
	?>
	<form method="post" class="form-assign-editor form-assign-editor-readyToEdit-order">
		<div class="form-group mb-0">
			<div class="input-group">
				<select name="employee_id" class="form-control dropdown-editors" data-live-search="true" required="required">
					<option value="">Select Editor</option>
					<?php foreach($editors as $editor): ?>
						<option value="<?php echo $editor['spp_id']; ?>"><?php echo $editor['name']; ?></option>
					<?php endforeach; ?>
				</select>
				<div class="input-group-append">
					<button class="btn btn-primary btn-assign-editor btn-assign-editor-readyToEdit-order" type="submit">Assign</button>
				</div>
				<input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
				<input type="hidden" name="action" value="admin_assign_editor_readyToEdit_order" />
			</div>
		</div>
	</form>
	<?php

	$order['assigned_editors'] = ob_get_clean();
	$order['assigned_writers'] = empty($assigned_writers_array) ? '-' : implode(", ", $assigned_writers_array);
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