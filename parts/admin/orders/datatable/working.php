<?php
require '../../../../constants.php';

require BASE_DIR . '/db_connection.php';
require BASE_DIR . '/functions.php';

$orders_per_page = wad_get_option('orders_per_page');

$query_from 	= "orders";
$query_select 	= "*";
$query_where	= "status=5";

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

$field = isset($_POST['sort']['field']) ? $_POST['sort']['field'] : 'assigned_end';
$sort = isset($_POST['sort']['sort']) ? $_POST['sort']['sort'] : 'ASC';

$query_orderby 	= ( $field && $sort ) ? "ORDER BY {$field} {$sort} " : "";
$query_orderby	.= "LIMIT $offset,$perpage";

$orders_result = wad_select_query( $query_from, $query_select, $query_where, $query_orderby);
// echo wad_select_query( $query_from, $query_select, $query_where, $query_orderby,true);exit;
$orders = mysqli_fetch_all($orders_result, MYSQLI_ASSOC);

foreach( $orders as &$order)
{
	$order_id = $order['order_id'];
	$order['article_info'] = wad_get_order_info_html($order);
	
	$order['pay_rate'] = '$'.wad_get_order_earning($order);
	
	$order['due_in'] = wad_get_due_in( $order['assigned_end'] );

	if( $order['doc_link'] )
	$order['doc_link'] = sprintf('<a href="%s" target="_blank">Open Doc</a>', $order['doc_link']);
	
	$assigned_writers_editors = wad_get_assigned_writers_and_editors($order_id, array('name','spp_id'));
	$assigned_writers = $assigned_writers_editors['writers'];
	$assigned_editors = $assigned_writers_editors['editors'];

	$assigned_writers_name_array = $assigned_writers_spp_id_array = $assigned_editors_array = array();
	foreach($assigned_writers as $assigned_writer){
		$assigned_writers_name_array[] = sprintf('<a href="%s">%s</a>', BASE_URL.'/users/edit/'.$assigned_writer['spp_id'], $assigned_writer['name']);
		$assigned_writers_spp_id_array[] = $assigned_writer['spp_id'];
	}
	foreach($assigned_editors as $assigned_editor){
		$assigned_editors_array[] = sprintf('<a href="%s">%s</a>', BASE_URL.'/users/edit/'.$assigned_editor['spp_id'], $assigned_editor['name']);
	}
	
	$employee_old_id = isset($assigned_writers_spp_id_array[0]) ? $assigned_writers_spp_id_array[0] : null;

	$is_writer_assigned = isset($assigned_writers_spp_id_array[0]) ? true : false;
	$hide_writers_dropdown = ($is_writer_assigned) ? " d-none" : '';
	
	$writers = wad_get_users("name, spp_id","role='writer'");
	
	ob_start();
	?>
		<form method="post" class="form-assign-writer-working-order<?php echo $hide_writers_dropdown; ?>">
			<div class="form-group mb-0">
				<div class="input-group">
					<select name="employee_id" class="form-control dropdown-writers" data-live-search="true" required="required">
						<option value="">Select Writer</option>
						<?php foreach($writers as $writer): ?>
							<option value="<?php echo $writer['spp_id']; ?>" <?php if(in_array($writer['spp_id'], $assigned_writers_spp_id_array)){ echo 'selected="selected"'; } ?>><?php echo $writer['name']; ?></option>
						<?php endforeach; ?>
					</select>
					<div class="input-group-append">
						<button class="btn btn-primary btn-assign-writer-working-order" type="submit">Assign</button>
					</div>
					<input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
					<input type="hidden" name="employee_old_id" value="<?php echo $employee_old_id; ?>" />
					<input type="hidden" name="action" value="admin_assign_writer_working_order" />
				</div>
			</div>
		</form>
		
		<?php if( $is_writer_assigned ): ?>
			<span class="writers-name"><?php echo implode("<br>", $assigned_writers_name_array);?></span>
			<a href="javascript:void(0)" class="change-writer-trigger"><i class="fas fa-pencil-alt"></i></a>
		<?php else: ?>
			<span class="writers-name"></span>
			<a href="javascript:void(0)" class="change-writer-trigger d-none"><i class="fas fa-pencil-alt"></i></a>
		<?php endif; 
		
	$order['assigned_writers'] = ob_get_clean();
	$order['assigned_editors'] = empty($assigned_editors_array) ? '-' : implode(", ", $assigned_editors_array);
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