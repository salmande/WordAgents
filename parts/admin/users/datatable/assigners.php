<?php

require '../../../../constants.php';

require BASE_DIR . '/db_connection.php';
require BASE_DIR . '/functions.php';

$query_from 	= "users";
$query_select 	= "name, email, role, assigned_orders, spp_id, is_archive";
$query_where	= "role='Assigner' AND (spp_id IS NOT NULL AND spp_id != 0)";

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