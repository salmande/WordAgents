<?php

function wad_all_orders_table($action=null){
	
	global $current_user;
	
	$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
	$per_page = wad_get_per_page();
	$ajax = isset($_REQUEST['ajax']) ? $_REQUEST['ajax'] : false;
	
	$assigned_orders_array = wad_explode_assigned_orders($current_user['assigned_orders']);
	$total = count($assigned_orders_array);
	
	if( $total )
	{
		$order_ids_IN = wad_set_get_order_id_IN($assigned_orders_array);
		
		$query_from = 'orders';
		$query_select = '*';
		$query_where = "order_id IN ({$order_ids_IN})";
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
	}
	
	if( !isset($result) )
		return;
	
	$orders_all = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
	ob_start(); ?>
	
	<table class="table table-<?php echo $action; ?>">
		<thead>
			<tr>
				<th scope="col">Order#</th>
				<th scope="col">Words Length</th>
				<th scope="col">Article Info</th>
				<th scope="col" class="column-pay_rate">Pay Rate</th>
				<th scope="col">Document Link</th>
				<th scope="col">Status</th>
			</tr>
		</thead>
		<tbody>
		<?php if(isset($orders_all) && !empty($orders_all) ): ?>
			<?php foreach($orders_all as $order): ?>
				<?php
				$order_id = $order['order_id'];
				$order_words = ( $order['order_words'] ) ? $order['order_words'] : 0;
				$order_title = $order['order_title'];
				$order_status = $order['status'];
				$order_doc_link = $order['doc_link'];
				
				$due_in_timestamp = wad_get_due_in_timestamp($order);
				$order_due_in = wad_get_due_in( $due_in_timestamp );
				
				$order_pay_rate = wad_get_pay_rate($order);
				$order_earning = wad_get_order_earning($order);
				
				$order_date_due = date('F d, Y', $order['date_due']);
				
				?>
				<tr>
					<td><?php echo wad_order_number_html($order_id); ?></td>
					<td><?php echo $order_words; ?></td>
					<td>
						<?php
						echo wad_get_order_info_html( $order );
						?>
					</td>
					<td class="column-pay_rate">$<?php echo $order_earning; ?></td>
					<td>
						<?php if( $order_doc_link ): ?>
						<a href="<?php echo $order_doc_link; ?>" target="_blank">Open Doc</a>
						<?php endif; ?>
					</td>
					<td><?php echo wad_get_status_label_in_editing_or_completed($order_status); ?></td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
		</tbody>
	</table>
	
	<?php echo isset($pagination) ? $pagination : '';  ?>
	
	<?php return ob_get_clean();
}