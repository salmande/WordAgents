<?php

require '../../../../constants.php';

require BASE_DIR . '/db_connection.php';
require BASE_DIR . '/functions.php';

$query_select 	= "name, email, role, assigned_orders, spp_id, is_archive";
$query_from 	= "users";
$query_where	= "role='Editor' AND (spp_id IS NOT NULL AND spp_id != 0)";
// $query_where	.= "AND spp_id=3253";

$generalSearch = isset($_POST['query']['generalSearch']) ? trim($_POST['query']['generalSearch']) : '';
if( $generalSearch ){
	if( $query_where )
		$query_where .= ' AND ';
	
	$query_where .= "(name LIKE '%{$generalSearch}%' || email LIKE '%{$generalSearch}%')";
}

$orders_per_page = wad_get_option('orders_per_page');
$page = isset($_POST['pagination']['page']) ? $_POST['pagination']['page'] : 1;
$pages = isset($_POST['pagination']['pages']) ? $_POST['pagination']['pages'] : 1;
$perpage = isset($_POST['pagination']['perpage']) ? $_POST['pagination']['perpage'] : $orders_per_page;
$total = wad_get_total_count($query_from,$query_where);

$offset = ($page-1)*$perpage;

$field = isset($_POST['sort']['field']) ? $_POST['sort']['field'] : '';
$sort = isset($_POST['sort']['sort']) ? $_POST['sort']['sort'] : '';

$query_orderby 	= ( $field && $sort ) ? "ORDER BY {$field} {$sort} " : "";
$query_orderby	.= "LIMIT $offset,$perpage";

$all_users_result = wad_select_query( $query_from, $query_select, $query_where, $query_orderby);
$all_users = mysqli_fetch_all($all_users_result, MYSQLI_ASSOC);

$all_orders = wad_get_orders("order_id, order_words, is_tool, status");


$i=0;
foreach($all_users as &$user){
	
	$spp_id = $user['spp_id'];
	
	if( ! $spp_id ){
		continue;
	}
	
	$user_name = $user['name'];
	$user_spp_id = $user['spp_id'];
	$user_email = $user['email'];
	$user_role = $user['role'];
	
	ob_start();
	?>
		<div>
			<div class="text-dark-75 font-weight-bolder font-size-lg mb-0"><a class="text-dark-75 text-hover-primary" href="<?php echo BASE_URL; ?>/users/edit/<?php echo $user_spp_id; ?>"><?php echo $user_name; ?></a></div>
			<a href="<?php echo BASE_URL; ?>/users/edit/<?php echo $user_spp_id; ?>" class="text-muted font-weight-bold text-hover-primary"><?php echo $user_email; ?></a>
			<br>
			<?php if( $user['is_archive'] ): ?>
				<span class="text-danger">Archived Account</span>
			<?php else: ?>
				<?php if( is_admin() ): ?>
				<a href="<?php echo BASE_URL; ?>?action=sign_in_as_user_using_admin&user=<?php echo $user_spp_id; ?>">Sign in as user</a>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	<?php
	
	$user['name_column'] = ob_get_clean();
	
	$assigned_orders_array = wad_explode_assigned_orders($user['assigned_orders']);
	
	$earning_total = $earning_pending = $orders_pending_total = $orders_complete_total = 0;
	$earning_total_status = array(3,12); //Complete OR Editing
	$earning_pending_status = array(12); //Editing
	$orders_complete_status = array(3); //Complete
	
	foreach($all_orders as $order)
	{
		$order_id = $order['order_id'];
		$status = $order['status'];

		if( in_array($order_id, $assigned_orders_array) )
		{
			//Total Earnings
			if( in_array($status, $earning_total_status) )
			{
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
			if( in_array($status, $orders_complete_status) )
			{
				$orders_complete_total += 1;
			}
		}
	}
	
	$user['sign_in_as_user'] = true;


	$user['pending_earnings'] = '$'.number_format($earning_pending, 2, '.', ',');
	$user['total_earnings'] = '$'.number_format($earning_total, 2, '.', ',');
	$user['order_pending'] = $orders_pending_total;
	$user['order_completed'] = $orders_complete_total;
	$user['total_orders_rejected'] = wad_get_rejected_orders_by_id($spp_id, true);
	$user['total_orders_missed'] = wad_get_missed_orders_by_id($spp_id, true);
	
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