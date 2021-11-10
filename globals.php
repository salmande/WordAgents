<?php

global $current_user, $globals;

$current_user = wad_get_current_user();
if( empty($current_user) )
	return;

$globals['current_url'] = wad_get_current_url(true);

$current_user = wad_get_user_by_id($current_user['spp_id']);
unset($current_user['password']);
unset($current_user['authtoken']);
$globals['current_user'] = $current_user;

$current_user_spp_id = $current_user['spp_id'];

$test_orders_only = ( wad_test() && (wad_get_option("test_orders_only")=='yes') ) ? true : false;
$globals['test_orders_only'] = $test_orders_only;

$globals['new_orders_count'] = $current_user['new_orders_count'];
$globals['all_orders_count'] = $current_user['all_orders_count'];
$globals['working_orders_count'] = $current_user['working_orders_count'];
$globals['editing_orders_count'] = $current_user['editing_orders_count'];
$globals['editor_revision_orders_count'] = $current_user['editor_revision_orders_count'];
$globals['revision_orders_count'] = $current_user['revision_orders_count'];
$globals['complete_orders_count'] = $current_user['complete_orders_count'];
$globals['all_orders_weekly_words_count'] = number_format($current_user['words_weekly'], 0, '.', ',');
$globals['no_of_days_for_new_orders'] = wad_get_option('no_of_days_for_new_orders') ? wad_get_option('no_of_days_for_new_orders') : 0;
$globals['no_of_testing_orders'] = wad_get_option('no_of_testing_orders') ? wad_get_option('no_of_testing_orders') : 0;

$globals['order_complete_client_email_templates'] = array("Standard Order","Optimization add on");

$globals['admin']['all_orders_count'] = wad_get_total_count('orders');
$globals['admin']['new_orders_count'] = wad_get_total_count('orders','status=2');
$globals['admin']['working_orders_count'] = wad_get_total_count('orders','status=5');
$globals['admin']['readyToEdit_orders_count'] = wad_get_total_count('orders','status=17');
$globals['admin']['editing_orders_count'] = wad_get_total_count('orders','status=12');
$globals['admin']['editorRevision_orders_count'] = wad_get_total_count('orders','status=6');
$globals['admin']['complete_orders_count'] = wad_get_total_count('orders','status=3');
$globals['admin']['revision_orders_count'] = wad_get_total_count('orders','status=9');
$globals['admin']['overdue_orders_count'] = wad_get_total_count('orders',"(UNIX_TIMESTAMP() > writer_submit_time_end AND status='17') OR (UNIX_TIMESTAMP() > editor_claim_time_end AND status='12')");

$current_timestamp_minus_24_hours = time() - 24*60*60;
$globals['admin']['stuck_orders_count'] = wad_get_total_count('orders',"UNIX_TIMESTAMP() > due_in_end AND status='2' OR ({$current_timestamp_minus_24_hours} > writer_submit_time_end AND status='17') OR ({$current_timestamp_minus_24_hours} > editor_claim_time_end AND status='12')");

$is_new_orders_page = ($wad_url == 'orders') || ($wad_url == 'ajax' && isset($_REQUEST['action']) && $_REQUEST['action'] == 'orders');
$is_editing_page = ($wad_url == 'wad-orders/editing') || ($wad_url == 'ajax' && isset($_REQUEST['action']) && $_REQUEST['action'] == 'orders-editing');

if( isset($_SESSION['new_orders_count']) && !$is_new_orders_page ){
	$globals['new_orders_count'] = $_SESSION['new_orders_count'];
}else{
	
	$status = 2;
	if( is_editor($current_user_spp_id) ){
		$status = 17; // Ready to Edit
	}
	
	$date_due_timestamp_for_new_orders = time()+(60*60*24*$globals['no_of_days_for_new_orders']);
	// $beginOfDay = strtotime("01 Apr 2021", time());
	$endOfDay   = strtotime("tomorrow", $date_due_timestamp_for_new_orders) - 1;
	
	$query_from = "orders";
	$query_select = "*";
	$query_where = "status='{$status}'";
	
	$query_where .= " AND date_due <= {$endOfDay}";

	if( isset($globals['test_orders_only']) && $globals['test_orders_only'] )
	$query_where .= " AND order_title = 'TWH TEST - PLEASE IGNORE'";

	$query_where .= " AND orders.order_id NOT IN (SELECT user_rejected_order.order_id FROM user_rejected_order WHERE user_rejected_order.spp_id = '{$current_user_spp_id}')";

	$total = wad_get_total_count($query_from,$query_where);
	
	if( $total <= $globals['no_of_testing_orders'])
	{
		$query_where = "status='{$status}'";
		if( isset($globals['test_orders_only']) && $globals['test_orders_only'] )
		$query_where .= " AND order_title = 'TWH TEST - PLEASE IGNORE'";

		$query_where .= " AND orders.order_id NOT IN (SELECT user_rejected_order.order_id FROM user_rejected_order WHERE user_rejected_order.spp_id = '{$current_user_spp_id}')";

		$globals['new_orders_count'] =  $_SESSION['new_orders_count'] = wad_get_total_count($query_from,$query_where);
	}
	
	if( $total && $total > $globals['no_of_testing_orders']){
		$globals['new_orders_count'] = $_SESSION['new_orders_count'] = $total;
	}
	
	$globals['new_orders_count_with_date_due'] = $total;
	
}


if( is_writer() || is_editor() )
{
	$assigned_orders_array = wad_explode_assigned_orders($current_user['assigned_orders']);
	$order_ids_IN = wad_set_get_order_id_IN($assigned_orders_array);
	
	if( $is_new_orders_page )
	{
		if( is_writer() )
		{
			$globals['current_user']['weekly_orders_words_legnth'] = $weekly_orders_words_legnth = 0;
			$globals['current_user']['working_orders_words_legnth'] = $working_orders_words_legnth = 0;
			$globals['current_user']['working_order_late_avail'] = 0;
			
			$first_day_of_this_week_timestamp = strtotime('this week');
			$this_week_begin_timestamp = strtotime('today',$first_day_of_this_week_timestamp);

			$last_day_of_this_week_timestamp = strtotime('next week');
			$this_week_end_timestamp = strtotime('today',$last_day_of_this_week_timestamp)-1;

			$status = "(status='5' OR status='17' OR status='12' OR status='3')"; //Working, ReadyToEdit, Editing, Complete
		
			$query_from = 'orders';
			$query_select = 'assigned, order_words, status, assigned_end, tags';
			$query_where = "order_id IN ({$order_ids_IN}) AND {$status}";
			
			$orders_result = wad_select_query( $query_from,$query_select,$query_where);
			
			$current_timestamp = time();
			
			if ( mysqli_num_rows( $orders_result ) )
			{
				$orders = mysqli_fetch_all( $orders_result, MYSQLI_ASSOC );

				foreach( $orders as $order){
					
					$order_tags = wad_get_order_tags_array($order);
					
					//Weekly Orders
					if( $order['assigned'] >= $this_week_begin_timestamp && $order['assigned'] <= $this_week_end_timestamp )
					{
						if( !in_array('Waiting for Clarification',$order_tags) ){
							$weekly_orders_words_legnth += $order['order_words'];
						}
					}
					
					//Working Orders
					if( $order['status']==5 ){
						if( !in_array('Waiting for Clarification',$order_tags) ){
							$working_orders_words_legnth += $order['order_words'];
						}
					}
					
					// Working Order Late Available
					if( $order['status']==5 && $current_timestamp > $order['assigned_end'] ){
						$globals['current_user']['working_order_late_avail'] = 1;
					}
					
				}
				$globals['current_user']['weekly_orders_words_legnth'] = $weekly_orders_words_legnth;	
				$globals['current_user']['working_orders_words_legnth'] = $working_orders_words_legnth;	
			}

		}else if( is_editor() )
		{
			$globals['current_user']['editors_editing_orders_count'] = $editors_editing_orders_count = 0;
			$globals['current_user']['editors_editor_revisions_orders_count'] = $editors_editor_revisions_orders_count = 0;

			$status = "(status='12' OR status='6')"; //Editing, Editor Revision
		
			$query_from = 'orders';
			$query_select = 'status, tags';
			$query_where = "order_id IN ({$order_ids_IN}) AND {$status}";
			
			$orders_result = wad_select_query( $query_from,$query_select,$query_where);
			
			$current_timestamp = time();
			
			if ( mysqli_num_rows( $orders_result ) )
			{
				$orders = mysqli_fetch_all( $orders_result, MYSQLI_ASSOC );

				foreach( $orders as $order)
				{
					$order_tags = wad_get_order_tags_array($order);
					
					//Editing Orders
					if( $order['status']==12 ){
						if( !in_array('Waiting for Clarification',$order_tags) ){
							$editors_editing_orders_count++;
						}
					}
					
					//Editor Revisions
					if( $order['status']==6 ){
						if( !in_array('Waiting for Clarification',$order_tags) ){
							$editors_editor_revisions_orders_count++;
						}
					}
				}
				
				$globals['current_user']['editors_editing_orders_count'] = $editors_editing_orders_count;	
				$globals['current_user']['editors_editor_revisions_orders_count'] = $editors_editor_revisions_orders_count;	
			}
		}
	}
	else if( $is_editing_page )
	{
		if( is_editor() )
		{
			$globals['current_user']['editors_editor_revisions_orders_count'] = $editors_editor_revisions_orders_count = 0;

			$status = "(status='6')"; //Editing, Editor Revision
		
			$query_from = 'orders';
			$query_select = 'status, tags';
			$query_where = "order_id IN ({$order_ids_IN}) AND {$status}";
			
			$orders_result = wad_select_query( $query_from,$query_select,$query_where);
			
			$current_timestamp = time();
			
			if ( mysqli_num_rows( $orders_result ) )
			{
				$orders = mysqli_fetch_all( $orders_result, MYSQLI_ASSOC );

				foreach( $orders as $order)
				{
					$order_tags = wad_get_order_tags_array($order);
					
					//Editor Revisions
					if( $order['status']==6 ){
						if( !in_array('Waiting for Clarification',$order_tags) ){
							$editors_editor_revisions_orders_count++;
						}
					}
				}
				
				$globals['current_user']['editors_editor_revisions_orders_count'] = $editors_editor_revisions_orders_count;	
			}
		}
	}
}

// echo '<pre>';
// print_r($globals);
// exit;



if( wad_test()){
	// echo $date_due_timestamp_for_new_orders;
}

$globals['stats_writers_columns_default'] = array(
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

$globals['stats_editors_columns_default'] = array(
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

$globals['admin']['topbar_text'] = wad_get_option('topbar_text');
$globals['admin']['topbar_visibility'] = wad_get_option('topbar_visibility') ? json_decode(wad_get_option('topbar_visibility'), true) : array();
$globals['admin']['topbar_bg_color'] = wad_get_option('topbar_bg_color');

$globals_admin = $globals['admin'];
$current_user = $globals['current_user'];

$globals['current_user']['first_name'] = wad_get_name_part('first',$current_user['name']);

$current_user = $globals['current_user'];

$they_or_you = 'they';
if( is_writer() || is_editor() )
	$they_or_you = 'you';

$globals["weekly_quota_label"] = "Weekly Word Capacity";
$globals["weekly_quota_desc"] = "How many words $they_or_you can claim in week";
$globals["enable_weekly_quota_label"] = "Allow Weekly Word Capacity?";
$globals["enable_weekly_quota_desc"] = "If you want to apply Weekly Quota, select yes";
$globals["onetime_quota_label"] = "Amount Can Claim at One Time";
$globals["onetime_quota_desc"] = "How many words $they_or_you can claim at a time";
$globals["enable_onetime_quota_label"] = "Enable Amount Can Claim at One Time";
$globals["enable_onetime_quota_desc"] = "If you want to apply One Time Claim Quota, select yes";

$globals['editor_request_revision_limit_exceed_text'] = 'Sorry, you have too many open orders right now. Please close out your open work, then you’ll be able to claim new orders.';
$globals['editor_claim_one_order_limit_exceed_text'] = 'Sorry, you have too many open orders right now. Please close out your open work, then you’ll be able to claim new orders.';
$globals['writers_late_order_in_working_limit_exceed_text'] = 'Sorry, you have too many late orders right now. Please close out your open work, then you’ll be able to claim new orders.';
$globals['writers_weekly_limit_exceed_text'] = 'Sorry, your Weekly Words Limit Exceeded. You’ll be able to claim new orders by next week.';
$globals['writers_onetime_limit_exceed_text'] = 'Sorry, you have too many open orders right now. Please close out your open work, then you’ll be able to claim new orders.';