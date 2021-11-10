<?php

function wad_available_orders_table($action=null){
	
	global $globals, $current_user;
	$current_user_spp_id = $current_user['spp_id'];
	
	$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
	$per_page = wad_get_per_page();
	$ajax = isset($_REQUEST['ajax']) ? $_REQUEST['ajax'] : false;
	
	$status = 2;
	$sort = 'due_in_end';
	if( is_editor() ){
		$status = 17; // Ready to Edit
		$sort = 'writer_submit_time_end';
	}
	
	$total = $globals['new_orders_count_with_date_due'];
	
	$query_from = "orders";
	$query_select = "*";
	$query_where = "status='{$status}'";
	
	if( $total && $total > $globals['no_of_testing_orders'] )
	{
		$date_due_timestamp_for_new_orders = time()+(60*60*24*$globals['no_of_days_for_new_orders']);
		// $beginOfDay = strtotime("01 Apr 2021", time());
		$endOfDay   = strtotime("tomorrow", $date_due_timestamp_for_new_orders) - 1;		
		
		$query_where .= " AND date_due <= {$endOfDay}";					
		// $query_where .= " AND date_due BETWEEN {$beginOfDay} and {$endOfDay}";
	}
	
	if( isset($globals['test_orders_only']) && $globals['test_orders_only'] )
	$query_where .= " AND order_title = 'TWH TEST - PLEASE IGNORE'";
	
	$query_where .= " AND orders.order_id NOT IN (SELECT user_rejected_order.order_id FROM user_rejected_order WHERE user_rejected_order.spp_id = '{$current_user_spp_id}')";
	
	$generalSearch = isset($_POST['seach_in_orders']) ? trim($_POST['seach_in_orders']) : '';
	if( $generalSearch )
	{	
		if( $query_where )
			$query_where .= ' AND ';
			
		$query_where .= "(order_title LIKE '%{$generalSearch}%' || order_id LIKE '%{$generalSearch}%')";
	}
	
	$query_order = "ORDER BY {$sort} ASC";

	if($per_page!='All'){
		$offset = $page == 1 ? 0 : $per_page*($page-1);
		$query_order .= " LIMIT $offset,$per_page";
	}

	$result = wad_select_query( $query_from,$query_select,$query_where,$query_order);
	$total = wad_get_total_count($query_from,$query_where);
	
	if( $total ){
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
				<th scope="col" class="column-pay_rate">Pay Rate</th>
				<th scope="col">Due In</th>
				<?php if( is_editor() || wad_test() ): ?><th scope="col">Document Link</th><?php endif; ?>
				<th scope="col">Action</th>
			</tr>
		</thead>
		<tbody>
		<?php if(isset($orders) && !empty($orders) ): ?>
			<?php
			
				$employee_id = $current_user['spp_id'];
				$enable_claim = $current_user['enable_claim'];
				$weekly_quota = isset($current_user['weekly_quota']) ? $current_user['weekly_quota'] : '';
				$enable_weekly_quota = isset($current_user['enable_weekly_quota']) ? $current_user['enable_weekly_quota'] : '';
				$onetime_quota = isset($current_user['onetime_quota']) ? $current_user['onetime_quota'] : 0;
				$enable_onetime_quota = isset($current_user['enable_onetime_quota']) ? $current_user['enable_onetime_quota'] : '';
				$working_orders_words_legnth = isset($current_user['working_orders_words_legnth']) ? $current_user['working_orders_words_legnth'] : 0;
				$weekly_orders_words_legnth = isset($current_user['weekly_orders_words_legnth']) ? $current_user['weekly_orders_words_legnth'] : 0;
				$working_order_late_avail = isset($current_user['working_order_late_avail']) ? $current_user['working_order_late_avail'] : 0;
				
				$editor_claim_one_order = $current_user['claim_one_order'];
				$editors_editing_orders_count = isset($current_user['editors_editing_orders_count']) ? $current_user['editors_editing_orders_count'] : 0;

				$editor_revision_count_limit = $current_user['editor_revision_count_limit'];
				$editors_editor_revisions_orders_count = isset($current_user['editors_editor_revisions_orders_count']) ? $current_user['editors_editor_revisions_orders_count'] : 1;
				
				$employee_role_min = strtolower(str_replace(' ', '',$current_user['role']));
				$action = $employee_role_min."_claim_order";
			
				foreach($orders as $order):
				
					$order_id = $order['order_id'];
					$order_words_length = ( $order['order_words'] ) ? $order['order_words'] : 0;
					$order_title = $order['order_title'];
					$order_status = $order['status'];
					$order_doc_link = $order['doc_link'];
					
					$due_in_timestamp = wad_get_due_in_timestamp($order);
					$order_due_in = wad_get_due_in( $due_in_timestamp );
					
					$order_pay_rate = wad_get_pay_rate($order);
					$order_earning = wad_get_order_earning($order);
					
					$order_date_due = date('F d, Y', $order['date_due']);
					
					$action = $employee_role_min."_claim_order";
					$claim_button_data = "data-order_id={$order_id} data-employee_id={$employee_id} data-action={$action}";
					$claim_button_href = '?action='.$action.'&order_id='.$order_id.'&employee_id='.$employee_id;
					
					$writer_claim_weekly_limit = ($weekly_quota < ($weekly_orders_words_legnth + $order_words_length )) && $enable_weekly_quota;
					$writer_claim_onetime_limit = ($onetime_quota < ($working_orders_words_legnth + $order_words_length )) && $enable_onetime_quota;
					?>
					<tr>
						<td><?php echo wad_order_number_html($order_id); ?></td>
						<td><?php echo $order_words_length; ?></td>
						<td><?php echo wad_get_order_info_html( $order );?></td>
						<td class="column-pay_rate">$<?php echo $order_earning; ?></td>
						<td><?php echo $order_due_in; ?></td>
						<?php if( is_editor() || wad_test() ): ?>
						<td>
							<?php if( $doc_link = $order['doc_link'] ): ?>
							<a href="<?php echo $doc_link; ?>" target="_blank">Open Doc</a>
							<?php endif; ?>
						</td>
						<?php endif; ?>
						<td>
							<?php if( $enable_claim): ?>
								<?php if( is_writer() ): ?>
									<?php if( $working_order_late_avail): ?>
										<?php //Late Order in Working; ?>
										<button type="button" class="btn btn-sm mb-2 btn-light" data-toggle="tooltip" title="<?php echo $globals['writers_late_order_in_working_limit_exceed_text']; ?>">Claim</button>
									<?php elseif( $writer_claim_weekly_limit ): ?>
										<?php //Weekly Limit Limit Exceed; ?>
										<button type="button" class="btn btn-sm mb-2 btn-light" data-toggle="tooltip" title="<?php echo $globals['writers_weekly_limit_exceed_text']; ?>">Claim</button>
									<?php elseif( $writer_claim_onetime_limit ): ?>
										<?php //One Time Limit Exceed; ?>
										<button type="button" class="btn btn-sm mb-2 btn-light" data-toggle="tooltip" title="<?php echo $globals['writers_onetime_limit_exceed_text']; ?>">Claim</button>
									<?php else: ?>
										<a href="<?php echo $claim_button_href; ?>" class="btn btn-primary btn-sm btn-writer-claim-order" <?php echo $claim_button_data; ?>>Claim</a>
									<?php endif; ?>
								<?php else: ?>
								
									<?php if( is_editor() ): ?>
										<?php if( $editors_editor_revisions_orders_count >= $editor_revision_count_limit ): ?>
											<?php //Editor Revisions Limit Exceed; ?>
											<button type="button" class="btn btn-sm mb-2 btn-light" data-toggle="tooltip" title="<?php echo $globals['editor_request_revision_limit_exceed_text']; ?>">Claim</button>
										<?php elseif( $editor_claim_one_order && $editors_editing_orders_count > 0 ): ?>
											<?php //Order in Editing ; ?>
											<button type="button" class="btn btn-sm mb-2 btn-light" data-toggle="tooltip" title="<?php echo $globals['editor_claim_one_order_limit_exceed_text']; ?>">Claim</button>
										<?php else: ?>
											<a href="<?php echo $claim_button_href ?>" class="btn btn-primary btn-sm btn-editor-claim-order" <?php echo $claim_button_data; ?>>Claim</a>
										<?php endif; ?>
									
									<?php endif; ?>
									
								<?php endif; ?>
							<?php else:?>
								Not allowed to claim
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
	
	<?php echo isset($pagination) ? $pagination : '';  ?>
	
	<?php return ob_get_clean();
}