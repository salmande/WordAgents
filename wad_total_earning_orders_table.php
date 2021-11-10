<?php

function wad_total_earning_orders_table($action=null){
	
	global $globals, $current_user;
	
	$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
	$per_page = wad_get_per_page();
	$ajax = isset($_REQUEST['ajax']) ? $_REQUEST['ajax'] : false;
	

	$assigned_orders_array = wad_explode_assigned_orders($current_user['assigned_orders']);
	$total = count($assigned_orders_array);

	$order_ids_IN = wad_set_get_order_id_IN($assigned_orders_array);
	
	$status = "(status='3' OR status='5' OR status='17' OR status='12' OR status='6' OR status='9')"; //Complete || Working || Ready to Edit || Editing || Editor Revision || Revisions
	if( is_editor() ){
		$status = "(status='3' OR status='12' OR status='6' OR status='9')"; //Complete || Editing || Editor Revision || Revisions
	}
	
	$query_from = 'orders';
	$query_select = '*';
	$query_where = "order_id IN ({$order_ids_IN}) AND {$status}";
	$query_order = "ORDER BY started ASC";
	
	$generalSearch = isset($_POST['seach_in_orders']) ? trim($_POST['seach_in_orders']) : '';
	if( $generalSearch )
	{	
		if( $query_where )
			$query_where .= ' AND ';
			
		$query_where .= "(order_title LIKE '%{$generalSearch}%' || order_id LIKE '%{$generalSearch}%')";
	}

	
	if($per_page!='All'){
		$offset = $page == 1 ? 0 : $per_page*($page-1);
		$query_order .= " LIMIT $offset,$per_page";
	}
	
	$result = wad_select_query( $query_from,$query_select,$query_where,$query_order);
	$total = wad_get_total_count($query_from,$query_where);
	
	if( $total)
	$pagination = wad_pagination($page, $total, $per_page);
	
	if( !isset($result) )
		return;
	
	$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
	ob_start(); ?>
	
	<table class="table table-<?php echo $action; ?>">
		<thead>
			<tr>
				<th scope="col">Order#</th>
				<th scope="col">Words Length</th>
				<?php if( ! is_editor() ): ?>
				<th scope="col">Pay Rate</th>
				<th scope="col">Earnings</th>
				<?php endif; ?>
				<th scope="col">Status</th>
			</tr>
		</thead>
		<tbody>
		<?php if(isset($orders) && !empty($orders) ): ?>
			<?php foreach($orders as $order): ?>
				<?php
				$order_id = $order['order_id'];
				$order_words = ( $order['order_words'] ) ? $order['order_words'] : 0;
				$order_title = $order['order_title'];
				$order_status = $order['status'];
				
				$due_in_timestamp = wad_get_due_in_timestamp($order);
				$order_due_in = wad_get_due_in( $due_in_timestamp );
				
				$order_pay_rate = wad_get_pay_rate($order);
				$order_earning = wad_get_order_earning($order);
				
				$order_date_due = date('F d, Y', $order['date_due']);
				
				?>
				<tr>
					<td><?php echo wad_order_number_html($order_id); ?></td>
					<td><?php echo $order_words; ?></td>
					<?php if( ! is_editor() ): ?>
						<td>$<?php echo $order_pay_rate; ?></td>
						<td>$<?php echo $order_earning; ?></td>
					<?php endif; ?>
					<td><?php echo wad_get_status_label_in_editing_or_completed($order_status); ?></td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
		</tbody>
	</table>

	<?php echo isset($pagination) ? $pagination : '';  ?>
	
	<?php return ob_get_clean();
}