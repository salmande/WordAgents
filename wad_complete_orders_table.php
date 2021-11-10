<?php

function wad_complete_orders_table($action=null){
	
	global $globals, $current_user;
	
	$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
	$per_page = wad_get_per_page();
	$ajax = isset($_REQUEST['ajax']) ? $_REQUEST['ajax'] : false;
	

	$total = $globals['complete_orders_count'];
	
	if( $total )
	{
		$assigned_orders_array = wad_explode_assigned_orders($current_user['assigned_orders']);
		$total = count($assigned_orders_array);
	
		$order_ids_IN = wad_set_get_order_id_IN($assigned_orders_array);
		
		$status = "(status='3')"; //Complete
		
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
	}
	
	if( !isset($result) )
		return;
	
	$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
	ob_start(); ?>
	
	<table class="table table-<?php echo $action; ?>">
		<thead>
			<tr>
				<th scope="col">Order#</th>
				<th scope="col">Words Length</th>
				<th scope="col">Article Info</th>
				<th scope="col">Document Link</th>
				<?php if( ! is_editor() ): ?>
				<th scope="col" class="column-pay_rate">Pay Rate</th>
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
					<td> <?php echo wad_get_order_info_html( $order ); ?></td>
					<td>
					<?php if( $doc_link = $order['doc_link'] ): ?>
						<a href="<?php echo $doc_link; ?>" target="_blank">Open Doc</a>
						<?php endif; ?>
					</td>
					<?php if( ! is_editor() ): ?>
					<td class="column-pay_rate">$<?php echo $order_pay_rate; ?></td>
					<td>$<?php echo $order_earning; ?></td>
					<?php endif; ?>
					<td><?php echo wad_get_status_label_in_editing_or_completed($order_status); ?></td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
		</tbody>
	</table>
	
	<?php if(isset($orders) && !empty($orders) ): ?>
		<?php foreach($orders as $order): $order_id = $order['order_id']?>
			<div class="modal fade" id="modal-request_revision-<?php echo $order_id; ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<form method="post">
						<div class="modal-header">
							<h5 class="modal-title">Request for edits Order# <?php echo $order_id; ?></h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Cancel">
								<i aria-hidden="true" class="ki ki-close"></i>
							</button>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<textarea name="content" class="form-control" rows="3"></textarea>
							</div>
							<input type="hidden" name="order" value="<?php echo $order_id; ?>" />
							<input type="hidden" name="action" value="editor_request_revision_editing_order" />
							<input type="hidden" name="employee" value="<?php echo wad_get_current_user('spp_id');?>" />
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary font-weight-bold btn-submit-editor-request_revision_editing_order">Submit</button>
						</div>
						
						</form>
					</div>
				</div>
			</div>
		<?php endforeach; ?>

		<?php foreach($orders as $order): $order_id = $order['order_id']; $order_title = $order['order_title'] ?>
			<div class="modal fade" id="modal-submit-<?php echo $order_id; ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<form method="post">
						<div class="modal-header">
							<h5 class="modal-title"></h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Cancel">
								<i aria-hidden="true" class="ki ki-close"></i>
							</button>
						</div>
						<div class="modal-body">
							Please confirm that you have completed the article.
							<input type="hidden" name="order" value="<?php echo $order_id; ?>" />
							<input type="hidden" name="title" value="<?php echo $order_title; ?>" />
							<input type="hidden" name="action" value="editor_submit_editing_order" />
							<input type="hidden" name="employee" value="<?php echo wad_get_current_user('spp_id');?>" />
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger font-weight-bold" data-dismiss="modal">STILL WRITING</button>
							<a href="<?php echo BASE_URL; ?>?action=editor_submit_editing_order&order=<?php echo $order_id; ?>&employee=<?php echo wad_get_current_user('spp_id');?>" class="btn btn-success btn-success2 font-weight-bold mb-1 editor-confirm-submit_editing_order">CONFIRM</a>
						</div>
						
						</form>
					</div>
				</div>
			</div>
		<?php endforeach; ?>

	<?php endif; ?>
	
	<?php echo isset($pagination) ? $pagination : '';  ?>
	
	<?php return ob_get_clean();
}