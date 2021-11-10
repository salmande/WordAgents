<?php

function wad_editors_weekly_stats($stats='editors-weekly'){
	
	global $globals;
	
	$previous_week = strtotime("-1 week +1 day");
	$start_week = strtotime("last monday midnight",$previous_week);
	$end_week = strtotime("next monday",$start_week)-1;

	$date_start = wad_date($start_week,'m/d/Y');
	$date_end = wad_date($end_week,'m/d/Y');
	$date_start_timestamp = $start_week;
	$date_end_timestamp = $end_week;
	$date_filter = true;
	
	$query_from = 'users';
	$query_select = '*';
	$query_where = "role='editor'";
	$query_order = "ORDER BY id ASC";
	
	// $offset = 0;
	// $per_page = 2;
	// $query_order .= " LIMIT $offset,$per_page";
	
	$stats_editors_result = wad_select_query( $query_from,$query_select,$query_where,$query_order);
	// echo $stats_editors_result = wad_select_query( $query_from,$query_select,$query_where,$query_order,true);
	// exit;
	$stats_editors_records = mysqli_fetch_all($stats_editors_result, MYSQLI_ASSOC);

	$columns = array(
		'completed_words',
		'completed_orders_count', 'completed_orders',
		'ontime_completed_orders_count', 'ontime_completed_orders',
		'completed_orders_with_seo_addons_count',
		'completed_orders_with_seo_addons',
		'overdue_orders_count', 'overdue_orders',
		'final_review_count', 'final_review',
		'editor_revision_count','editor_revision',
		'editor_revision_previous_month_count','editor_revision_previous_month',
		'client_revision_count','client_revision',
		'client_revision_previous_month_count','client_revision_previous_month'
	);

	$is_completed_words_column = in_array('completed_words',$columns) ? true : false;
	
	$is_completed_orders_count_column = in_array('completed_orders_count',$columns) ? true : false;
	$is_completed_orders_column = in_array('completed_orders',$columns) ? true : false;
	
	$is_ontime_completed_orders_count_column = in_array('ontime_completed_orders_count',$columns) ? true : false;
	$is_ontime_completed_orders_column = in_array('ontime_completed_orders',$columns) ? true : false;
	
	$is_completed_orders_with_seo_addons_count_column = in_array('completed_orders_with_seo_addons_count',$columns) ? true : false;
	$is_completed_orders_with_seo_addons_column = in_array('completed_orders_with_seo_addons',$columns) ? true : false;
	
	$is_overdue_orders_count_column = in_array('overdue_orders_count',$columns) ? true : false;
	$is_overdue_orders_column = in_array('overdue_orders',$columns) ? true : false;
	
	$is_final_review_count_column = in_array('final_review_count',$columns) ? true : false;
	$is_final_review_column = in_array('final_review',$columns) ? true : false;

	$is_editor_revision_count_column = in_array('editor_revision_count',$columns) ? true : false;
	$is_editor_revision_column = in_array('editor_revision',$columns) ? true : false;
	
	$is_client_revision_count_column = in_array('client_revision_count',$columns) ? true : false;
	$is_client_revision_column = in_array('client_revision',$columns) ? true : false;

	if( !isset($date_filter) )
	{
		$is_editor_revision_previous_month_count_column = in_array('editor_revision_previous_month_count',$columns) ? true : false;
		$is_editor_revision_previous_month_column = in_array('editor_revision_previous_month',$columns) ? true : false;
		
		$is_client_revision_previous_month_count_column = in_array('client_revision_previous_month_count',$columns) ? true : false;
		$is_client_revision_previous_month_column = in_array('client_revision_previous_month',$columns) ? true : false;
	}
		
	ob_start(); ?>
	
	<table class="table table-stats table-<?php echo $stats; ?>">
	
		<?php if( isset($date_filter)): ?>
			<tr class="hide"><td><strong>Start Date : </strong><?php echo $date_start; ?></td></tr>
			<tr class="hide"><td><strong>End Date : </strong><?php echo $date_end; ?></td></tr>
		<?php endif; ?>
		
			<tr>
				<th scope="col" class="column-name"><strong>Name</strong></th>
				<th scope="col" class="column-email hide"><strong>Email</strong></th>
				<th scope="col" class="column-archive-account hide"><strong>Archived Account</strong></th>
				
				<?php if( $is_completed_words_column ): ?><th scope="col"><strong>Total Number of <br/>Words Completed</strong></th> <?php endif; ?>
				
				<?php if( $is_completed_orders_count_column ): ?><th scope="col"><strong>Total Number of <br/>Completed Orders</strong></th> <?php endif; ?>
				<?php if( $is_completed_orders_column ): ?><th scope="col" class="column-orders"><strong>Completed Orders</strong></th> <?php endif; ?>
				
				<?php if( $is_ontime_completed_orders_count_column ): ?><th scope="col"><strong>Total Number of <br/>Ontime Completed<br /> Orders</strong></th> <?php endif; ?>
				<?php if( $is_ontime_completed_orders_column ): ?><th scope="col" class="column-orders"><strong>Ontime Completed<br /> Orders</strong></th> <?php endif; ?>

				<?php if( $is_completed_orders_with_seo_addons_count_column ): ?><th scope="col"><strong>Total Number of <br/>Completed Orders<br /> with SEO Addons</strong></th> <?php endif; ?>
				<?php if( $is_completed_orders_with_seo_addons_column ): ?><th scope="col" class="column-orders"><strong>Completed Orders<br />with SEO Addons</strong></th> <?php endif; ?>
				
				<?php if( $is_overdue_orders_count_column ): ?><th scope="col"><strong>Total Number of <br/>Overdue Orders</strong></th> <?php endif; ?>
				<?php if( $is_overdue_orders_column ): ?><th scope="col" class="column-orders"><strong>Overdue Orders</strong></th> <?php endif; ?>
				
				<?php if( $is_final_review_count_column ): ?><th scope="col"><strong>Total Number of <br/>Orders sent to<br /> Final Review</strong></th> <?php endif; ?>
				<?php if( $is_final_review_column ): ?><th scope="col" class="column-orders"><strong>Orders sent to<br /> Final Review</strong></th> <?php endif; ?>

				<?php if( $is_editor_revision_count_column ): ?><th scope="col"><strong>Total Number of <br/>Orders sent to<br /> Editor Revision</strong></th> <?php endif; ?>
				<?php if( $is_editor_revision_column ): ?><th scope="col" class="column-orders"><strong>Orders sent to<br /> Editor Revision</strong></th> <?php endif; ?>
				
				<?php if( !isset($date_filter)): ?>
				<?php if( $is_editor_revision_previous_month_count_column ): ?><th scope="col"><strong>Total Number of <br/>Orders sent to<br /> Editor Revision Over the Previous Month</strong></th> <?php endif; ?>
				<?php if( $is_editor_revision_previous_month_column ): ?><th scope="col" class="column-orders"><strong>Orders sent to<br /> Editor Revision Over the Previous Month</strong></th> <?php endif; ?>
				<?php endif; ?>
				
				<?php if( $is_client_revision_count_column ): ?><th scope="col"><strong>Total Number of <br/>Orders sent to<br /> Client Revision</strong></th> <?php endif; ?>
				<?php if( $is_client_revision_column ): ?><th scope="col" class="column-orders"><strong>Orders sent to<br /> Client Revision</strong></th> <?php endif; ?>
				
				<?php if( !isset($date_filter)): ?>
				<?php if( $is_client_revision_previous_month_count_column ): ?><th scope="col"><strong>Total Number of <br/>Orders sent to<br /> Client Revision Over the Previous Month</strong></th> <?php endif; ?>
				<?php if( $is_client_revision_previous_month_column ): ?><th scope="col" class="column-orders"><strong>Orders sent to<br /> Client Revision Over the Previous Month</strong></th> <?php endif; ?>
				<?php endif; ?>
				
			</tr>
			
			<?php
			
			$editors_completed_words_total = 0;
			
			$editors_completed_orders_count_total = 0;
			$editors_completed_orders_total_array = array();
			
			$editors_ontime_completed_orders_count_total = 0;
			$editors_ontime_completed_orders_total_array = array();
			
			$editors_completed_orders_with_seo_addons_count_total = 0;
			$editors_completed_orders_with_seo_addons_total_array = array();
			
			$editors_overdue_orders_count_total = 0;
			$editors_overdue_orders_total_array = array();
			
			$editors_final_review_count_total = 0;
			$editors_final_review_total_array = array();
			
			$editors_editor_revision_count_total = 0;
			$editors_editor_revision_total_array = array();
			
			$editors_client_revision_count_total = 0;
			$editors_client_revision_total_array = array();
			
			if( !isset($date_filter) )
			{
				$editors_client_revision_previous_month_count_total = 0;
				$editors_client_revision_previous_month_total_array = array();

				$editors_editor_revision_previous_month_count_total = 0;
				$editors_editor_revision_previous_month_total_array = array();

				$first_day_of_last_month_timestamp = strtotime('first day of last month');
				$last_month_begin_timestamp = strtotime('today',$first_day_of_last_month_timestamp);
				$last_day_of_last_last_timestamp = strtotime('last day of last month');
				$last_month_end_timestamp = strtotime('tomorrow',$last_day_of_last_last_timestamp)-1;

			}
			
			$editors_completed_orders_status = array(3);
			$editors_ontime_completed_orders_status = array(3,9);
			$editors_overdue_completed_orders_status = array(3,9);
			$editors_completed_words_status = array(3);
			
			$i=0;
			
			
			foreach($stats_editors_records as $editor):
				
				$editor_name = $editor['name'];
				$editor_spp_id = $editor['spp_id'];
				$editor_email = $editor['email'];
				
				if( !empty($columns) )
				{
					$assigned_orders_array = wad_explode_assigned_orders($editor['assigned_orders']);

					if( $is_completed_words_column
						|| $is_completed_orders_count_column
						|| $is_completed_orders_column
						|| $is_ontime_completed_orders_count_column
						|| $is_ontime_completed_orders_column
						|| $is_completed_orders_with_seo_addons_count_column
						|| $is_completed_orders_with_seo_addons_column
						|| $is_overdue_orders_count_column
						|| $is_overdue_orders_column
						|| $is_final_review_count_column
						|| $is_final_review_column
						|| $is_editor_revision_count_column
						|| $is_editor_revision_column
						|| $is_client_revision_count_column
						|| $is_client_revision_column
					){
						
						$editor_orders_count = 0;
					
						$editor_completed_words = 0;
						
						$editor_completed_orders_count = 0;
						$editor_completed_orders_array = array();
						
						$editor_ontime_completed_orders_count = 0;
						$editor_ontime_completed_orders_array = array();
						
						$editor_revision_count = 0;
						$editor_revision_array = array();
						
						$client_revision_count = 0;
						$client_revision_array = array();
						
						$editor_completed_orders_with_seo_addons_count= 0;
						$editor_completed_orders_with_seo_addons_array = array();
						
						$editor_overdue_orders_count= 0;
						$editor_overdue_orders_array = array();
						
						$editor_final_review_count= 0;
						$editor_final_review_array = array();
					
						$current_time = time();

						foreach($assigned_orders_array as $order_id)
						{
							$order = wad_get_order($order_id);
							if(empty($order))
								continue;

							$status = $order['status'];
							
							$editor_claim_time = $order['editor_claim_time'];
							$editor_claim_due_time = $order['editor_claim_time_end'];
							$editor_submit_time = $order['editor_submit_time'];
							
							$is_tool = $order['is_tool'];
							
							$is_editor_submit_time_within_time_range = false;
							if(isset($date_filter) ){
								if( $editor_submit_time >= $date_start_timestamp && $editor_submit_time <= $date_end_timestamp ){
									$is_editor_submit_time_within_time_range = true;
								}
							}
							
							//Words Completed
							if( $is_completed_words_column ){
								if( in_array($status,$editors_completed_words_status) )
								{
									if(isset($date_filter) ){
										if( $is_editor_submit_time_within_time_range ){
											$editor_completed_words += $order['order_words'];
										}
									}else{
										$editor_completed_words += $order['order_words'];
									}
								}
							}
							
							//Completed Orders Count
							if( $is_completed_orders_count_column )
							{
								if( in_array($status,$editors_completed_orders_status) )
								{
									if(isset($date_filter) ){
										if( $is_editor_submit_time_within_time_range ){
											$editor_completed_orders_count++;
										}
									}else{
										$editor_completed_orders_count++;
									}
								}
							}
							
							//Completed Orders
							if( $is_completed_orders_column )
							{
								if( in_array($status,$editors_completed_orders_status) )
								{
									if(isset($date_filter) ){
										if( $is_editor_submit_time_within_time_range ){
											$editor_completed_orders_array[] = $order_id;
										}
									}else{
										$editor_completed_orders_array[] = $order_id;
									}
								}
							}
							
							//Ontime Completed Orders Count
							if( $is_ontime_completed_orders_count_column )
							{
								if( in_array($status,$editors_ontime_completed_orders_status) )
								{
									if( $editor_submit_time && $editor_claim_due_time )
									{
										if( $editor_submit_time < $editor_claim_due_time )
										{
											if(isset($date_filter) ){
												if( $is_editor_submit_time_within_time_range ){
													$editor_ontime_completed_orders_count++;
												}
											}else{
												$editor_ontime_completed_orders_count++;
											}
										}
									}
								}
							}
							
							//Ontime Completed Orders
							if( $is_ontime_completed_orders_column)
							{
								if( in_array($status,$editors_ontime_completed_orders_status) )
								{
									if( $editor_submit_time && $editor_claim_due_time )
									{
										if( $editor_submit_time < $editor_claim_due_time )
										{
											if(isset($date_filter) ){
												if( $is_editor_submit_time_within_time_range ){
													$editor_ontime_completed_orders_array[] = $order_id;
												}
											}else{
												$editor_ontime_completed_orders_array[] = $order_id;
											}
										}
									}
								}
							}
							
							//Completed Orders with SEO Addons Count
							if( $is_completed_orders_with_seo_addons_count_column )
							{
								if( in_array($status,$editors_completed_orders_status) )
								{
									if( $is_tool )
									{
										if(isset($date_filter) ){
											if( $is_editor_submit_time_within_time_range ){
												$editor_completed_orders_with_seo_addons_count++;
											}
										}else{
											$editor_completed_orders_with_seo_addons_count++;
										}
									}
								}
							}
							
							//Completed Orders with SEO Addons
							if( $is_completed_orders_with_seo_addons_column )
							{
								if( in_array($status,$editors_completed_orders_status) )
								{
									if( $is_tool )
									{
										if(isset($date_filter) ){
											if( $is_editor_submit_time_within_time_range ){
												$editor_completed_orders_with_seo_addons_array[] = $order_id;
											}
										}else{
											$editor_completed_orders_with_seo_addons_array[] = $order_id;
										}
									}
								}
							}
							
							//Overdue Orders Count
							if( $is_overdue_orders_count_column )
							{
								if( $editor_submit_time && $editor_claim_due_time )
								{
									if( in_array($status,$editors_overdue_completed_orders_status) )
									{
										if( $editor_submit_time > $editor_claim_due_time )
										{
											if(isset($date_filter) ){
												if( $is_editor_submit_time_within_time_range ){
													$editor_overdue_orders_count++;
												}
											}else{
												$editor_overdue_orders_count++;
											}
										}
									}
								}
							}
							
							//Overdue Orders
							if( $is_overdue_orders_column )
							{
								if( $editor_submit_time && $editor_claim_due_time )
								{
									if( in_array($status,$editors_overdue_completed_orders_status) )
									{
										if( $editor_submit_time > $editor_claim_due_time )
										{
											if(isset($date_filter) ){
												if( $is_editor_submit_time_within_time_range ){
													$editor_overdue_orders_array[] = $order_id;
												}
											}else{
												$editor_overdue_orders_array[] = $order_id;
											}
										}
									}
								}
							}
							
							//Final Review Count
							if( $is_final_review_count_column)
							{
								$where="order_id='{$order_id}' AND from_type='System'";
								if( isset($date_filter))
								$where .= " AND (time >= {$date_start_timestamp} AND time <= {$date_end_timestamp})";
								
								if( $total = wad_get_total_count("order_final_review",$where) ){
									$editor_final_review_count = $editor_final_review_count + $total;
								}
							}
							
							//Final Review
							if( $is_final_review_column)
							{
								$where="order_id='{$order_id}' AND from_type='System'";
								if( isset($date_filter))
								$where .= " AND (time >= {$date_start_timestamp} AND time <= {$date_end_timestamp})";
							
								if( $total = wad_get_total_count("order_final_review",$where) ){
									$editor_final_review_array[] = $order_id;
								}
							}
							
							
							//Editor Revisoin Count
							if( $is_editor_revision_count_column)
							{
								$where="order_id='{$order_id}' AND from_type='System'";
								if( isset($date_filter))
								$where .= " AND (time >= {$date_start_timestamp} AND time <= {$date_end_timestamp})";
							
								if( $total = wad_get_total_count("order_editor_revision",$where) ){
									$editor_revision_count = $editor_revision_count + $total;
								}
							}
							
							//Editor Revisoin
							if( $is_editor_revision_column)
							{
								$where="order_id='{$order_id}' AND from_type='System'";
								if( isset($date_filter))
								$where .= " AND (time >= {$date_start_timestamp} AND time <= {$date_end_timestamp})";
							
								if( $total = wad_get_total_count("order_editor_revision",$where) ){
									$editor_revision_array[] = $order_id;
								}
							}
							
							//Client Revision Count
							if( $is_client_revision_count_column)
							{
								$where="order_id='{$order_id}'";
								if( isset($date_filter))
								$where .= " AND (time >= {$date_start_timestamp} AND time <= {$date_end_timestamp})";
							
								if( $total = wad_get_total_count("order_client_revision",$where) ){
									$client_revision_count = $client_revision_count + $total;
								}
							}
							
							//Client Revision
							if( $is_client_revision_column)
							{
								$where="order_id='{$order_id}'";
								if( isset($date_filter))
								$where .= " AND (time >= {$date_start_timestamp} AND time <= {$date_end_timestamp})";
							
								if( $total = wad_get_total_count("order_client_revision",$where) ){
									$client_revision_array[] = $order_id;
								}
							}
								
						} //foreach
						
					} // columns
					
					if( !isset($date_filter) )
					{
						if( $is_editor_revision_previous_month_count_column
							|| $is_editor_revision_previous_month_column
							|| $is_client_revision_previous_month_count_column
							|| $is_client_revision_previous_month_column
						){
							
							$editor_revision_previous_month_count = 0;
							$editor_revision_previous_month_array = array();
							
							$client_revision_previous_month_count = 0;
							$client_revision_previous_month_array = array();
							
							//Editor Revisoin Previous Month Count
							if( $is_editor_revision_previous_month_count_column)
							{
								$where="order_id='{$order_id}' AND from_type='System'";
								$where .= " AND (time >= {$last_month_begin_timestamp} AND time <= {$last_month_end_timestamp})";
							
								if( $total = wad_get_total_count("order_editor_revision",$where) ){
									$editor_revision_previous_month_count = $editor_revision_count + $total;
								}
							}
							
							//Editor Revisoin Previous Month
							if( $is_editor_revision_previous_month_column)
							{
								$where="order_id='{$order_id}' AND from_type='System'";
								$where .= " AND (time >= {$last_month_begin_timestamp} AND time <= {$last_month_end_timestamp})";
							
								if( $total = wad_get_total_count("order_editor_revision",$where) ){
									$editor_revision_previous_month_array[] = $order_id;
								}
							}
							
							//Client Revision Previous Month Count
							if( $is_client_revision_previous_month_count_column)
							{
								$where="order_id='{$order_id}'";
								$where .= " AND (time >= {$last_month_begin_timestamp} AND time <= {$last_month_end_timestamp})";
							
								if( $total = wad_get_total_count("order_client_revision",$where) ){
									$client_revision_previous_month_count = $client_revision_count + $total;
								}
							}
							
							//Client Revision Previous Month
							if( $is_client_revision_previous_month_column)
							{
								$where="order_id='{$order_id}'";
								$where .= " AND (time >= {$last_month_begin_timestamp} AND time <= {$last_month_end_timestamp})";
							
								if( $total = wad_get_total_count("order_client_revision",$where) ){
									$client_revision_previous_month_array[] = $order_id;
								}
							}
							
							if( $is_editor_revision_previous_month_count_column )
							$editors_editor_revision_previous_month_count_total += $editor_revision_previous_month_count;
							
							if( $is_editor_revision_previous_month_column )
							$editors_editor_revision_previous_month_total_array = array_merge($editors_editor_revision_previous_month_total_array,$editor_revision_previous_month_array);

							if( $is_client_revision_previous_month_count_column )
							$editors_client_revision_previous_month_count_total += $client_revision_previous_month_count;
							
							if( $is_client_revision_previous_month_column )
							$editors_client_revision_previous_month_total_array = array_merge($editors_client_revision_previous_month_total_array,$client_revision_previous_month_array);
							
							
						} // previuos month columns
					} // ! set date filter
					
					if( $is_client_revision_count_column )
					$editors_client_revision_count_total += $client_revision_count;
					
					if( $is_client_revision_column )
					$editors_client_revision_total_array = array_merge($editors_client_revision_total_array,$client_revision_array);
					
					if( $is_editor_revision_count_column )
					$editors_editor_revision_count_total += $editor_revision_count;
					
					if( $is_editor_revision_column )
					$editors_editor_revision_total_array = array_merge($editors_editor_revision_total_array,$editor_revision_array);
					
					if( $is_completed_words_column )
					$editors_completed_words_total += $editor_completed_words;		
				
					if( $is_completed_orders_count_column )
					$editors_completed_orders_count_total += $editor_completed_orders_count;					
					
					if( $is_completed_orders_column )
					$editors_completed_orders_total_array = array_merge($editors_completed_orders_total_array,$editor_completed_orders_array);
					
					if( $is_ontime_completed_orders_count_column )
					$editors_ontime_completed_orders_count_total += $editor_ontime_completed_orders_count;					
					
					if( $is_ontime_completed_orders_column )
					$editors_ontime_completed_orders_total_array = array_merge($editors_ontime_completed_orders_total_array,$editor_ontime_completed_orders_array);				

					if( $is_completed_orders_with_seo_addons_count_column )
					$editors_completed_orders_with_seo_addons_count_total += $editor_completed_orders_with_seo_addons_count;
					
					if( $is_completed_orders_with_seo_addons_column )
					$editors_completed_orders_with_seo_addons_total_array = array_merge($editors_completed_orders_with_seo_addons_total_array,$editor_completed_orders_with_seo_addons_array);
				
					if( $is_overdue_orders_count_column )
					$editors_overdue_orders_count_total += $editor_overdue_orders_count;					
					
					if( $is_overdue_orders_column )
					$editors_overdue_orders_total_array= array_merge($editors_overdue_orders_total_array,$editor_overdue_orders_array);

					if( $is_final_review_count_column )
					$editors_final_review_count_total += $editor_final_review_count;					
					
					if( $is_final_review_column )
					$editors_final_review_total_array = array_merge($editors_final_review_total_array,$editor_final_review_array);				

				} // !empty($columns)
			?>
			
			<tr>
				<td>
					<div class="name-column">
						<?php echo $editor_name; ?>
					</div>
				</td>
				
				<td class="hide"><?php echo $editor_email; ?></td>
				<td class="hide"><?php echo ( $editor['is_archive'] ) ? 'Yes' : 'No'; ?></td>
				
				<?php if( $is_completed_words_column ): ?>
				<td><?php echo number_format($editor_completed_words, 0, '.', ','); ?></td>
				<?php endif; ?>

				<?php if( $is_completed_orders_count_column ): ?>
				<td><?php echo $editor_completed_orders_count; ?></td>
				<?php endif; ?>

				<?php if( $is_completed_orders_column ): ?>
				<td><div class="overflow-auto h-55px"><?php echo implode(', ',$editor_completed_orders_array); ?></div></td>
				<?php endif; ?>

				<?php if( $is_ontime_completed_orders_count_column ): ?>
				<td><?php echo $editor_ontime_completed_orders_count; ?></td>
				<?php endif; ?>

				<?php if( $is_ontime_completed_orders_column ): ?>
				<td><div class="overflow-auto h-55px"><?php echo implode(', ',$editor_ontime_completed_orders_array); ?></div></td>
				<?php endif; ?>
				
				<?php if( $is_completed_orders_with_seo_addons_count_column ): ?>
				<td><?php echo $editor_completed_orders_with_seo_addons_count; ?></td>
				<?php endif; ?>
				
				<?php if( $is_completed_orders_with_seo_addons_column ): ?>
				<td><div class="overflow-auto h-55px"><?php echo implode(', ',$editor_completed_orders_with_seo_addons_array); ?></div></td>
				<?php endif; ?>
				
				<?php if( $is_overdue_orders_count_column ): ?>
				<td><?php echo $editor_overdue_orders_count; ?></td>
				<?php endif; ?>
				
				<?php if( $is_overdue_orders_column ): ?>
				<td><div class="overflow-auto h-55px"><?php echo implode(', ',$editor_overdue_orders_array); ?></div></td>
				<?php endif; ?>
				
				<?php if( $is_final_review_count_column ): ?>
				<td><?php echo $editor_final_review_count; ?></td>
				<?php endif; ?>
				
				<?php if( $is_final_review_column ): ?>
				<td><div class="overflow-auto h-55px"><?php echo implode(', ',$editor_final_review_array); ?></div></td>
				<?php endif; ?>
				
				<?php if( $is_editor_revision_count_column ): ?>
				<td><?php echo $editor_revision_count; ?></td>
				<?php endif; ?>

				<?php if( $is_editor_revision_column ): ?>
				<td><div class="overflow-auto h-55px"><?php echo implode(', ',$editor_revision_array); ?></div></td>
				<?php endif; ?>
				
				<?php if( !isset($date_filter)): ?>
					<?php if( $is_editor_revision_previous_month_count_column ): ?>
					<td><?php echo $editor_revision_previous_month_count; ?></td>
					<?php endif; ?>
					<?php if( $is_editor_revision_previous_month_column ): ?>
					<td><div class="overflow-auto h-55px"><?php echo implode(', ',$editor_revision_previous_month_array); ?></div></td>
					<?php endif; ?>
				<?php endif; ?>

				<?php if( $is_client_revision_count_column ): ?>
				<td><?php echo $client_revision_count; ?></td>
				<?php endif; ?>

				<?php if( $is_client_revision_column ): ?>
				<td><div class="overflow-auto h-55px"><?php echo implode(', ',$client_revision_array); ?></div></td>
				<?php endif; ?>
				
				<?php if( !isset($date_filter)): ?>
					<?php if( $is_client_revision_previous_month_count_column ): ?>
					<td><?php echo $client_revision_previous_month_count; ?></td>
					<?php endif; ?>
					<?php if( $is_client_revision_previous_month_column ): ?>
					<td><div class="overflow-auto h-55px"><?php echo implode(', ',$client_revision_previous_month_array); ?></div></td>
					<?php endif; ?>
				<?php endif; ?>
				
			</tr>
			
			<?php $i++; endforeach; ?>
			
			<?php if( !empty($columns) ): ?>
			<tr class="row-total bg-primary-o-25">
				<td><strong>Total:</strong></td>
				<td class="hide"></td>
				<td class="hide"></td>
				
				<?php if( $is_completed_words_column ): ?>
				<td><strong><?php echo number_format($editors_completed_words_total, 0, '.', ','); ?></strong></td>	
				<?php endif; ?>
				
				<?php if( $is_completed_orders_count_column ): ?>
				<td><strong><?php echo $editors_completed_orders_count_total; ?></strong></td>	
				<?php endif; ?>
				
				<?php if( $is_completed_orders_column ): ?>
				<td><div class="overflow-auto h-55px"><strong><?php echo implode(', ',$editors_completed_orders_total_array); ?></strong></div></td>	
				<?php endif; ?>
				
				<?php if( $is_ontime_completed_orders_count_column ): ?>
				<td><strong><?php echo $editors_ontime_completed_orders_count_total; ?></strong></td>	
				<?php endif; ?>
				
				<?php if( $is_ontime_completed_orders_column ): ?>
				<td><div class="overflow-auto h-55px"><strong><?php echo implode(', ',$editors_ontime_completed_orders_total_array); ?></strong></div></td>	
				<?php endif; ?>

				<?php if( $is_completed_orders_with_seo_addons_count_column ): ?>
				<td><strong><?php echo $editors_completed_orders_with_seo_addons_count_total; ?></strong></td>	
				<?php endif; ?>
								
				<?php if( $is_completed_orders_with_seo_addons_column ): ?>
				<td><div class="overflow-auto h-55px"><strong><?php echo implode(', ',$editors_completed_orders_with_seo_addons_total_array); ?></strong></div></td>	
				<?php endif; ?>

				<?php if( $is_overdue_orders_count_column ): ?>
				<td><strong><?php echo $editors_overdue_orders_count_total; ?></strong></td>	
				<?php endif; ?>
								
				<?php if( $is_overdue_orders_column ): ?>
				<td><div class="overflow-auto h-55px"><strong><?php echo implode(', ',$editors_overdue_orders_total_array); ?></strong></div></td>	
				<?php endif; ?>

				<?php if( $is_final_review_count_column ): ?>
				<td><strong><?php echo $editors_final_review_count_total; ?></strong></td>	
				<?php endif; ?>
								
				<?php if( $is_final_review_column ): ?>
				<td><div class="overflow-auto h-55px"><strong><?php echo implode(', ',$editors_final_review_total_array); ?></strong></div></td>	
				<?php endif; ?>

				<?php if( $is_editor_revision_count_column ): ?>
				<td><strong><?php echo $editors_editor_revision_count_total; ?></strong></td>
				<?php endif; ?>
				
				<?php if( $is_editor_revision_column ): ?>
				<td><div class="overflow-auto h-55px"><strong><?php echo implode(', ',$editors_editor_revision_total_array); ?></strong></div></td>	
				<?php endif; ?>
				
				<?php if( !isset($date_filter)): ?>
					<?php if( $is_editor_revision_previous_month_count_column ): ?>
					<td><strong><?php echo $editors_editor_revision_previous_month_count_total; ?></strong></td>
					<?php endif; ?>
					
					<?php if( $is_editor_revision_previous_month_column ): ?>
					<td><div class="overflow-auto h-55px"><strong><?php echo implode(', ',$editors_editor_revision_previous_month_total_array); ?></strong></div></td>	
					<?php endif; ?>
				<?php endif; ?>
				
				<?php if( $is_client_revision_count_column ): ?>
				<td><strong><?php echo $editors_client_revision_count_total; ?></strong></td>
				<?php endif; ?>
				
				<?php if( $is_client_revision_column ): ?>
				<td><div class="overflow-auto h-55px"><strong><?php echo implode(', ',$editors_client_revision_total_array); ?></strong></div></td>	
				<?php endif; ?>
				
				<?php if( !isset($date_filter)): ?>
					<?php if( $is_client_revision_previous_month_count_column ): ?>
					<td><strong><?php echo $editors_client_revision_previous_month_count_total; ?></strong></td>
					<?php endif; ?>
					
					<?php if( $is_client_revision_previous_month_column ): ?>
					<td><div class="overflow-auto h-55px"><strong><?php echo implode(', ',$editors_client_revision_previous_month_total_array); ?></strong></div></td>	
					<?php endif; ?>
				<?php endif; ?>
				
			</tr>
			
			<?php endif; ?>
			
	</table>
	
	<?php
	
	$html = ob_get_clean();
	
	// echo $html;

	$filename = wad_date($start_week,'d M');
	$filename .= ' - ';
	$filename .= wad_date($end_week,'d M Y');
	
	$reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
	$spreadsheet = $reader->loadFromString($html);
	$spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(23);
	$editors_stats = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
	$editors_stats_filename = $filename.'.xls';
	$editors_stats_file = BASE_DIR.'/stats-generated/Weekly OG Reports/Editors/'.$filename.'.xls';
	$editors_stats->save($editors_stats_file); 
	
	$report_link = BASE_URL . '/stats-generated/Weekly OG Reports/Editors/'.$editors_stats_filename;	
	
	return $report_link;

}