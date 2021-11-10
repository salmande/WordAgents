<?php

function wad_writers_weekly_stats($stats='writers-weekly'){
	
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
	$query_where = "role='writer'";
	$query_order = "ORDER BY id ASC";

	$stats_writers_total = wad_get_total_count( $query_from,$query_where);
	
	// $offset = 0;
	// $per_page = 2;
	// $query_order .= " LIMIT $offset,$per_page";
	
	$stats_writers_result = wad_select_query( $query_from,$query_select,$query_where,$query_order);
	// echo $stats_writers_result = wad_select_query( $query_from,$query_select,$query_where,$query_order,true);
	// exit;
	$stats_writers_records = mysqli_fetch_all($stats_writers_result, MYSQLI_ASSOC);
	
	
	$columns = array(
		'completed_words',
		'pay',
		'completed_orders_count', 'completed_orders',
		'ontime_completed_orders_count', 'ontime_completed_orders',
		'completed_orders_with_seo_addons_count',
		'completed_orders_with_seo_addons',
		'overdue_orders_count', 'overdue_orders',
		'final_review_count', 'final_review',
		'editor_revision_count','editor_revision',
		'client_revision_count','client_revision',
		'rejected_orders_count','rejected_orders',
		'order_turnaround',
		'late_orders_count','late_orders'
	);

	$is_completed_words_column = in_array('completed_words',$columns) ? true : false;
	$is_pay_column = in_array('pay',$columns) ? true : false;
	
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
	
	$is_rejected_orders_count_column = in_array('rejected_orders_count',$columns) ? true : false;
	$is_rejected_orders_column = in_array('rejected_orders',$columns) ? true : false;
	
	$is_order_turnaround_column = in_array('order_turnaround',$columns) ? true : false;
	
	$is_late_orders_count_column = in_array('late_orders_count',$columns) ? true : false;
	$is_late_orders_column = in_array('late_orders',$columns) ? true : false;
	
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
				<?php if( $is_pay_column ): ?><th scope="col"><strong>Total Pay</strong></th> <?php endif; ?>
				
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
				
				<?php if( $is_client_revision_count_column ): ?><th scope="col"><strong>Total Number of <br/>Orders sent to<br /> Client Revision</strong></th> <?php endif; ?>
				<?php if( $is_client_revision_column ): ?><th scope="col" class="column-orders"><strong>Orders sent to<br /> Client Revision</strong></th> <?php endif; ?>
				
				<?php if( $is_rejected_orders_count_column ): ?><th scope="col"><strong>Total Number of <br/>Orders Rejected</strong></th> <?php endif; ?>
				<?php if( $is_rejected_orders_column ): ?><th scope="col" class="column-orders"><strong>Orders Rejected</strong></th> <?php endif; ?>
				
				<?php //"Number of assignments missed" column here ?>
				<?php //Assignments Missed colum here ?>
				<?php // Total Number of Bad Orders here ?>
				<?php //Bad Assignments here ?>
				
				<?php if( $is_order_turnaround_column ): ?><th scope="col"><strong>Order Turnaround time</strong></th> <?php endif; ?>
				
				<?php if( $is_late_orders_count_column ): ?><th scope="col"><strong>Total Number of Late Orders</strong></th> <?php endif; ?>
				<?php if( $is_late_orders_column ): ?><th scope="col" class="column-orders"><strong>Late Orders</strong></th> <?php endif; ?>
			</tr>
			
			<?php
			
			$writers_turnaround_time_total = 0;
			
			$writers_completed_words_total = 0;
			$writers_pay_total = 0;
			
			$writers_completed_orders_count_total = 0;
			$writers_completed_orders_total_array = array();
			
			$writers_ontime_completed_orders_count_total = 0;
			$writers_ontime_completed_orders_total_array = array();
			
			$writers_completed_orders_with_seo_addons_count_total = 0;
			$writers_completed_orders_with_seo_addons_total_array = array();
			
			$writers_overdue_orders_count_total = 0;
			$writers_overdue_orders_total_array = array();
			
			$writers_final_review_count_total = 0;
			$writers_final_review_total_array = array();
			
			$writers_late_orders_count_total = 0;
			$writers_late_orders_total_array = array();
			
			$writers_editor_revision_count_total = 0;
			$writers_editor_revision_total_array = array();
			
			$writers_client_revision_count_total = 0;
			$writers_client_revision_total_array = array();
			
			$writers_rejected_orders_count_total = 0;
			$writers_rejected_orders_total_array = array();
			
			$writers_completed_orders_status = array(17,12,3);
			$writers_ontime_completed_orders_status = array(17,12,6,3,9);
			$writers_overdue_completed_orders_status = array(17,12,6,3,9);
			$writers_late_completed_orders_status = array(17,12,6,3,9);
			$writers_completed_words_status = array(3);
			$writers_pay_status = array(3);
			
			$i=0;
			
			foreach($stats_writers_records as $writer):
				
				$writer_name = $writer['name'];
				$writer_spp_id = $writer['spp_id'];
				$writer_email = $writer['email'];
				
				if( !empty($columns) )
				{
					if( $is_order_turnaround_column
						|| $is_completed_words_column
						|| $is_pay_column
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
						|| $is_late_orders_count_column
						|| $is_late_orders_column
					){
						$assigned_orders_array = wad_explode_assigned_orders($writer['assigned_orders']);
						
						$writer_turnaround_time = $writer_orders_count = 0;
						
						$late_orders_count = $editor_revision_count = $client_revision_count = 0;
						
						$writer_completed_words = 0;
						$writer_pay = 0;
						
						$writer_completed_orders_count = 0;
						$writer_completed_orders_array = array();
						
						$writer_ontime_completed_orders_count = 0;
						$writer_ontime_completed_orders_array = array();
						
						$late_orders_count = 0;
						$late_orders_array = array();
						
						$editor_revision_count = 0;
						$editor_revision_array = array();
						
						$client_revision_array = array();
						$client_revision_count = 0;
						
						$writer_completed_orders_with_seo_addons_count= 0;
						$writer_completed_orders_with_seo_addons_array = array();
						
						$writer_overdue_orders_count= 0;
						$writer_overdue_orders_array = array();
						
						$writer_final_review_count= 0;
						$writer_final_review_array = array();
					
						$current_time = time();

						foreach($assigned_orders_array as $order_id)
						{
							$order = wad_get_order($order_id);
							if(empty($order))
								continue;

							$status = $order['status'];
							
							$writer_claim_time = $order['assigned'];
							$writer_claim_due_time = $order['assigned_end'];
							$writer_submit_time = $order['writer_submit_time'];
							$writer_submit_due_time = $order['writer_submit_time_end'];
							
							$is_tool = $order['is_tool'];
							
							$is_writer_submit_time_within_time_range = false;
							if(isset($date_filter) ){
								if( $writer_submit_time >= $date_start_timestamp && $writer_submit_time <= $date_end_timestamp ){
									$is_writer_submit_time_within_time_range = true;
								}
							}
							
							//Words Completed
							if( $is_completed_words_column ){
								if( in_array($status,$writers_completed_words_status) )
								{
									if(isset($date_filter) ){
										if( $is_writer_submit_time_within_time_range ){
											$writer_completed_words += $order['order_words'];
										}
									}else{
										$writer_completed_words += $order['order_words'];
									}
								}
							}
							
							//Pay
							if( $is_pay_column ){
								if( in_array($status,$writers_pay_status) )
								{
									if(isset($date_filter) ){
										if( $is_writer_submit_time_within_time_range ){
											$writer_pay += wad_get_order_earning($order, $writer_spp_id);
										}
									}else{
										$writer_pay += wad_get_order_earning($order, $writer_spp_id);
									}
									
								}
							}
							
							//Completed Orders Count
							if( $is_completed_orders_count_column )
							{
								if( in_array($status,$writers_completed_orders_status) )
								{
									if(isset($date_filter) ){
										if( $is_writer_submit_time_within_time_range ){
											$writer_completed_orders_count++;
										}
									}else{
										$writer_completed_orders_count++;
									}
								}
							}
							
							//Completed Orders
							if( $is_completed_orders_column )
							{
								if( in_array($status,$writers_completed_orders_status) )
								{
									if(isset($date_filter) ){
										if( $is_writer_submit_time_within_time_range ){
											$writer_completed_orders_array[] = $order_id;
										}
									}else{
										$writer_completed_orders_array[] = $order_id;
									}
								}
							}
							
							//Ontime Completed Orders Count
							if( $is_ontime_completed_orders_count_column )
							{
								if( in_array($status,$writers_ontime_completed_orders_status) )
								{
									if( $writer_submit_time && $writer_claim_due_time )
									{
										if( $writer_submit_time < $writer_claim_due_time )
										{
											if(isset($date_filter) ){
												if( $is_writer_submit_time_within_time_range ){
													$writer_ontime_completed_orders_count++;
												}
											}else{
												$writer_ontime_completed_orders_count++;
											}
										}
									}
								}
							}
							
							//Ontime Completed Orders
							if( $is_ontime_completed_orders_column)
							{
								if( in_array($status,$writers_ontime_completed_orders_status) )
								{
									if( $writer_submit_time && $writer_claim_due_time )
									{
										if( $writer_submit_time < $writer_claim_due_time )
										{
											if(isset($date_filter) ){
												if( $is_writer_submit_time_within_time_range ){
													$writer_ontime_completed_orders_array[] = $order_id;
												}
											}else{
												$writer_ontime_completed_orders_array[] = $order_id;
											}
										}
									}
								}
							}
							
							//Completed Orders with SEO Addons Count
							if( $is_completed_orders_with_seo_addons_count_column )
							{
								if( in_array($status,$writers_completed_orders_status) )
								{
									if( $is_tool )
									{
										if(isset($date_filter) ){
											if( $is_writer_submit_time_within_time_range ){
												$writer_completed_orders_with_seo_addons_count++;
											}
										}else{
											$writer_completed_orders_with_seo_addons_count++;
										}
									}
								}
							}
							
							//Completed Orders with SEO Addons
							if( $is_completed_orders_with_seo_addons_column )
							{
								if( in_array($status,$writers_completed_orders_status) )
								{
									if( $is_tool )
									{
										if(isset($date_filter) ){
											if( $is_writer_submit_time_within_time_range ){
												$writer_completed_orders_with_seo_addons_array[] = $order_id;
											}
										}else{
											$writer_completed_orders_with_seo_addons_array[] = $order_id;
										}
									}
								}
							}
							
							//Overdue Orders Count
							if( $is_overdue_orders_count_column )
							{
								if( $writer_submit_time && $writer_claim_due_time )
								{
									if( in_array($status,$writers_overdue_completed_orders_status) )
									{
										if( $writer_submit_time > $writer_claim_due_time )
										{
											if(isset($date_filter) ){
												if( $is_writer_submit_time_within_time_range ){
													$writer_overdue_orders_count++;
												}
											}else{
												$writer_overdue_orders_count++;
											}
										}
									}
								}
							}
							
							//Overdue Orders
							if( $is_overdue_orders_column )
							{
								if( $writer_submit_time && $writer_claim_due_time )
								{
									if( in_array($status,$writers_overdue_completed_orders_status) )
									{
										if( $writer_submit_time > $writer_claim_due_time )
										{
											if(isset($date_filter) ){
												if( $is_writer_submit_time_within_time_range ){
													$writer_overdue_orders_array[] = $order_id;
												}
											}else{
												$writer_overdue_orders_array[] = $order_id;
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
									$writer_final_review_count = $writer_final_review_count + $total;
								}
							}
							
							//Final Review
							if( $is_final_review_column)
							{
								$where="order_id='{$order_id}' AND from_type='System'";
								if( isset($date_filter))
								$where .= " AND (time >= {$date_start_timestamp} AND time <= {$date_end_timestamp})";
							
								if( $total = wad_get_total_count("order_final_review",$where) ){
									$writer_final_review_array[] = $order_id;
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
							
							//Late Orders Count
							if( $is_late_orders_count_column )
							{
								if( $writer_submit_time && $writer_claim_due_time )
								{
									if( in_array($status,$writers_late_completed_orders_status) )
									{
										if( $writer_submit_time > $writer_claim_due_time )
										{
											if(isset($date_filter) ){
												if( $is_writer_submit_time_within_time_range ){
													$late_orders_count++;
												}
											}else{
												$late_orders_count++;
											}
										}
									}
								}
							}
							
							//Late Orders
							if( $is_late_orders_column )
							{
								if( $writer_submit_time && $writer_claim_due_time )
								{
									if( in_array($status,$writers_late_completed_orders_status) )
									{
										if( $writer_submit_time > $writer_claim_due_time )
										{
											if(isset($date_filter) ){
												if( $is_writer_submit_time_within_time_range ){
													$late_orders_array[] = $order_id;
												}
											}else{
												$late_orders_array[] = $order_id;
											}
										}
									}
								}
							}
							
							//Writer Turnaround Time
							if( $is_order_turnaround_column )
							{
								if( $writer_submit_time && $writer_claim_time && ($writer_submit_time > $writer_claim_time) )
								{
									if(isset($date_filter) ){
										if( $is_writer_submit_time_within_time_range ){
											$writer_turnaround_time += $writer_submit_time - $writer_claim_time;
											$writer_orders_count++;
										}
									}else{
										$writer_turnaround_time += $writer_submit_time - $writer_claim_time;
										$writer_orders_count++;
									}
								}
							}
							
								
						} //foreach
						
					} // columns
					
					if( $is_rejected_orders_count_column ){
						$where=null;
						if( isset($date_filter))
						$where = "(time >= {$date_start_timestamp} AND time <= {$date_end_timestamp})";
						$rejected_orders_count = wad_get_rejected_orders_by_id($writer_spp_id, true,$where);
						
						$writers_rejected_orders_count_total += $rejected_orders_count;
					}
					if( $is_rejected_orders_column ){
						$where=null;
						if( isset($date_filter))
						$where = "(time >= {$date_start_timestamp} AND time <= {$date_end_timestamp})";
						$rejected_orders = wad_get_rejected_orders_by_id($writer_spp_id, false,$where);
						$rejected_orders_array = array();
						if(!empty($rejected_orders)){
							foreach($rejected_orders as $order){
								$rejected_orders_array[] = $order['order_id'];
							}
						}
						
						$writers_rejected_orders_total_array = array_merge($writers_rejected_orders_total_array,$rejected_orders_array);
					}
					
					if( $is_order_turnaround_column )
					{
						if( $writer_turnaround_time ){
							$writer_turnaround_time = $writer_turnaround_time / $writer_orders_count;
							$writers_turnaround_time_total += $writer_turnaround_time;
						}
					}
					
					if( $is_late_orders_count_column )
					$writers_late_orders_count_total += $late_orders_count;

					if( $is_late_orders_column )
					$writers_late_orders_total_array = array_merge($writers_late_orders_total_array,$late_orders_array);

					if( $is_client_revision_count_column )
					$writers_client_revision_count_total += $client_revision_count;
					
					if( $is_client_revision_column )
					$writers_client_revision_total_array = array_merge($writers_client_revision_total_array,$client_revision_array);
					
					if( $is_editor_revision_count_column )
					$writers_editor_revision_count_total += $editor_revision_count;
					
					if( $is_editor_revision_column )
					$writers_editor_revision_total_array = array_merge($writers_editor_revision_total_array,$editor_revision_array);
					
					if( $is_completed_words_column )
					$writers_completed_words_total += $writer_completed_words;		
				
					if( $is_pay_column )
					$writers_pay_total += $writer_pay;					
					
					if( $is_completed_orders_count_column )
					$writers_completed_orders_count_total += $writer_completed_orders_count;					
					
					if( $is_completed_orders_column )
					$writers_completed_orders_total_array = array_merge($writers_completed_orders_total_array,$writer_completed_orders_array);
					
					if( $is_ontime_completed_orders_count_column )
					$writers_ontime_completed_orders_count_total += $writer_ontime_completed_orders_count;					
					
					if( $is_ontime_completed_orders_column )
					$writers_ontime_completed_orders_total_array = array_merge($writers_ontime_completed_orders_total_array,$writer_ontime_completed_orders_array);				

					if( $is_completed_orders_with_seo_addons_count_column )
					$writers_completed_orders_with_seo_addons_count_total += $writer_completed_orders_with_seo_addons_count;					
					
					if( $is_completed_orders_with_seo_addons_column )
					$writers_completed_orders_with_seo_addons_total_array = array_merge($writers_completed_orders_with_seo_addons_total_array,$writer_completed_orders_with_seo_addons_array);
				
					if( $is_overdue_orders_count_column )
					$writers_overdue_orders_count_total += $writer_overdue_orders_count;					
					
					if( $is_overdue_orders_column )
					$writers_overdue_orders_total_array= array_merge($writers_overdue_orders_total_array,$writer_overdue_orders_array);				

					if( $is_final_review_count_column )
					$writers_final_review_count_total += $writer_final_review_count;					
					
					if( $is_final_review_column )
					$writers_final_review_total_array = array_merge($writers_final_review_total_array,$writer_final_review_array);				

				} // !empty($columns)
			?>
			
			<tr>
				<td>
					<div class="name-column">
							<?php echo $writer_name; ?>
						
					</div>
				</td>
				
				<td class="hide"><?php echo $writer_email; ?></td>
				<td class="hide"><?php echo ( $writer['is_archive'] ) ? 'Yes' : 'No'; ?></td>
				
				<?php if( $is_completed_words_column ): ?>
				<td><?php echo number_format($writer_completed_words, 0, '.', ','); ?></td>
				<?php endif; ?>

				<?php if( $is_pay_column ): ?>
				<td><?php echo '$'.$writer_pay; ?></td>
				<?php endif; ?>

				<?php if( $is_completed_orders_count_column ): ?>
				<td><?php echo $writer_completed_orders_count; ?></td>
				<?php endif; ?>

				<?php if( $is_completed_orders_column ): ?>
				<td><div class="overflow-auto h-55px"><?php echo implode(', ',$writer_completed_orders_array); ?></div></td>
				<?php endif; ?>

				<?php if( $is_ontime_completed_orders_count_column ): ?>
				<td><?php echo $writer_ontime_completed_orders_count; ?></td>
				<?php endif; ?>

				<?php if( $is_ontime_completed_orders_column ): ?>
				<td><div class="overflow-auto h-55px"><?php echo implode(', ',$writer_ontime_completed_orders_array); ?></div></td>
				<?php endif; ?>
				
				<?php if( $is_completed_orders_with_seo_addons_count_column ): ?>
				<td><?php echo $writer_completed_orders_with_seo_addons_count; ?></td>
				<?php endif; ?>
				
				<?php if( $is_completed_orders_with_seo_addons_column ): ?>
				<td><div class="overflow-auto h-55px"><?php echo implode(', ',$writer_completed_orders_with_seo_addons_array); ?></div></td>
				<?php endif; ?>
				
				<?php if( $is_overdue_orders_count_column ): ?>
				<td><?php echo $writer_overdue_orders_count; ?></td>
				<?php endif; ?>
				
				<?php if( $is_overdue_orders_column ): ?>
				<td><div class="overflow-auto h-55px"><?php echo implode(', ',$writer_overdue_orders_array); ?></div></td>
				<?php endif; ?>
				
				<?php if( $is_final_review_count_column ): ?>
				<td><?php echo $writer_final_review_count; ?></td>
				<?php endif; ?>
				
				<?php if( $is_final_review_column ): ?>
				<td><div class="overflow-auto h-55px"><?php echo implode(', ',$writer_final_review_array); ?></div></td>
				<?php endif; ?>
				
				<?php if( $is_editor_revision_count_column ): ?>
				<td><?php echo $editor_revision_count; ?></td>
				<?php endif; ?>

				<?php if( $is_editor_revision_column ): ?>
				<td><div class="overflow-auto h-55px"><?php echo implode(', ',$editor_revision_array); ?></div></td>
				<?php endif; ?>

				<?php if( $is_client_revision_count_column ): ?>
				<td><?php echo $client_revision_count; ?></td>
				<?php endif; ?>

				<?php if( $is_client_revision_column ): ?>
				<td><div class="overflow-auto h-55px"><?php echo implode(', ',$client_revision_array); ?></div></td>
				<?php endif; ?>

				<?php if( $is_rejected_orders_count_column ): ?>
				<td><?php echo $rejected_orders_count; ?></td>
				<?php endif; ?>

				<?php if( $is_rejected_orders_column ): ?>
				<td><div class="overflow-auto h-55px"><?php echo implode(', ',$rejected_orders_array); ?></div></td>
				<?php endif; ?>

				<?php //"Number of assignments missed" column here ?>
				<?php //Assignments Missed colum here ?>
				<?php // Total Number of Bad Orders here ?>
				<?php //Bad Assignments here ?>
				
				<?php if( $is_order_turnaround_column ): ?>
				<td><?php //echo ( $writer_turnaround_time > 0 ) ? number_format($writer_turnaround_time, 3, '.', ',') : 0; echo '%';
				// echo ($writer_turnaround_time) ? seconds2human($writer_turnaround_time,array('second')) : 0;
				echo seconds2hours($writer_turnaround_time);
				?></td>
				<?php endif; ?>
				
				<?php if( $is_late_orders_count_column ): ?>
				<td><?php echo $late_orders_count; ?></td>
				<?php endif; ?>

				<?php if( $is_late_orders_column ): ?>
				<td><div class="overflow-auto h-55px"><?php echo implode(', ',$late_orders_array); ?></div></td>
				<?php endif; ?>

			</tr>
			
			<?php $i++; endforeach; ?>
			
			<?php
			
			if( $writers_turnaround_time_total && $i ){
				// $writers_turnaround_time_total = $writers_turnaround_time_total / $i;
			}
			
			?>
			
			<?php if( !empty($columns) ): ?>
			<tr class="row-total bg-primary-o-25">
				<td><strong>Total:</strong></td>
				<td class="hide"></td>
				<td class="hide"></td>
				
				<?php if( $is_completed_words_column ): ?>
				<td><strong><?php echo number_format($writers_completed_words_total, 0, '.', ','); ?></strong></td>	
				<?php endif; ?>
				
				<?php if( $is_pay_column ): ?>
				<td><strong><?php echo '$'.$writers_pay_total; ?></strong></td>	
				<?php endif; ?>
				
				<?php if( $is_completed_orders_count_column ): ?>
				<td><strong><?php echo $writers_completed_orders_count_total; ?></strong></td>	
				<?php endif; ?>
				
				<?php if( $is_completed_orders_column ): ?>
				<td><div class="overflow-auto h-55px"><strong><?php echo implode(', ',$writers_completed_orders_total_array); ?></strong></div></td>	
				<?php endif; ?>
				
				<?php if( $is_ontime_completed_orders_count_column ): ?>
				<td><strong><?php echo $writers_ontime_completed_orders_count_total; ?></strong></td>	
				<?php endif; ?>
				
				<?php if( $is_ontime_completed_orders_column ): ?>
				<td><div class="overflow-auto h-55px"><strong><?php echo implode(', ',$writers_ontime_completed_orders_total_array); ?></strong></div></td>	
				<?php endif; ?>

				<?php if( $is_completed_orders_with_seo_addons_count_column ): ?>
				<td><strong><?php echo $writers_completed_orders_with_seo_addons_count_total; ?></strong></td>	
				<?php endif; ?>
								
				<?php if( $is_completed_orders_with_seo_addons_column ): ?>
				<td><div class="overflow-auto h-55px"><strong><?php echo implode(', ',$writers_completed_orders_with_seo_addons_total_array); ?></strong></div></td>	
				<?php endif; ?>

				<?php if( $is_overdue_orders_count_column ): ?>
				<td><strong><?php echo $writers_overdue_orders_count_total; ?></strong></td>	
				<?php endif; ?>
								
				<?php if( $is_overdue_orders_column ): ?>
				<td><div class="overflow-auto h-55px"><strong><?php echo implode(', ',$writers_overdue_orders_total_array); ?></strong></div></td>	
				<?php endif; ?>

				<?php if( $is_final_review_count_column ): ?>
				<td><strong><?php echo $writers_final_review_count_total; ?></strong></td>	
				<?php endif; ?>
								
				<?php if( $is_final_review_column ): ?>
				<td><div class="overflow-auto h-55px"><strong><?php echo implode(', ',$writers_final_review_total_array); ?></strong></div></td>	
				<?php endif; ?>

				<?php if( $is_editor_revision_count_column ): ?>
				<td><strong><?php echo $writers_editor_revision_count_total; ?></strong></td>
				<?php endif; ?>
				
				<?php if( $is_editor_revision_column ): ?>
				<td><div class="overflow-auto h-55px"><strong><?php echo implode(', ',$writers_editor_revision_total_array); ?></strong></div></td>	
				<?php endif; ?>
				
				<?php if( $is_client_revision_count_column ): ?>
				<td><strong><?php echo $writers_client_revision_count_total; ?></strong></td>
				<?php endif; ?>
				
				<?php if( $is_client_revision_column ): ?>
				<td><div class="overflow-auto h-55px"><strong><?php echo implode(', ',$writers_client_revision_total_array); ?></strong></div></td>	
				<?php endif; ?>
				
				<?php if( $is_rejected_orders_count_column ): ?>
				<td><strong><?php echo $writers_rejected_orders_count_total; ?></strong></td>	
				<?php endif; ?>
				
				<?php if( $is_rejected_orders_column ): ?>
				<td><div class="overflow-auto h-55px"><strong><?php echo implode(', ',$writers_rejected_orders_total_array); ?></strong></div></td>	
				<?php endif; ?>
				
				<?php //"Number of assignments missed" column here ?>
				<?php //Assignments Missed colum here ?>
				<?php // Total Number of Bad Orders here ?>
				<?php //Bad Assignments here ?>
				
				<?php if( $is_order_turnaround_column ): ?>
				<td><strong>
				<?php //echo ( $writers_turnaround_time_total > 0 ) ? number_format($writers_turnaround_time_total, 3, '.', ',') : 0; echo '%';
				// echo ($writers_turnaround_time_total) ? seconds2human($writers_turnaround_time_total,array('second')) : 0;
				echo seconds2hours($writers_turnaround_time_total);
				?></strong></td>
				<?php endif; ?>
				
				<?php if( $is_late_orders_count_column ): ?>
				<td><strong><?php echo $writers_late_orders_count_total; ?></strong></td>
				<?php endif; ?>
				
				<?php if( $is_late_orders_column ): ?>
				<td><div class="overflow-auto h-55px"><strong><?php echo implode(', ',$writers_late_orders_total_array); ?></strong></div></td>	
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
	$writers_stats = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
	$writers_stats_filename = $filename.'.xls';
	$writers_stats_file = BASE_DIR.'/stats-generated/Weekly OG Reports/Writers/'.$filename.'.xls';
	$writers_stats->save($writers_stats_file); 
	
	$report_link =  BASE_URL . '/stats-generated/Weekly OG Reports/Writers/'.$writers_stats_filename;	
	
	return $report_link;

}