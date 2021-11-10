<?php

$current_user_spp_id = wad_get_current_user('spp_id');

$action = ( isset($_REQUEST['action']) && $_REQUEST['action'] ) ? $_REQUEST['action'] : '';

if( $action == 'orders'
	|| $action == 'orders-working'
	|| $action == 'orders-editing'
	|| $action == 'orders-revisions-editor'
	|| $action == 'orders-revisions-client'
	|| $action == 'orders-complete'
	|| $action == 'orders-all'
	|| $action == 'accounting-pending'
	|| $action == 'accounting-all'
){
	$data_var = 'orders';

	$page = $_REQUEST['page'];
	$per_page = $_REQUEST['per_page'];
	$offset = $page == 1 ? 0 : $per_page*($page-1);

	if( $action == 'orders-working')
	{		
		/* $total = $globals['working_orders_count'];
			
		if( $total )
		{
			$assigned_orders_array = wad_explode_assigned_orders($current_user['assigned_orders']);
			$order_ids_IN = wad_set_get_order_id_IN($assigned_orders_array);

			$status = "(status='5')"; //Working
		
			$query_from = 'orders';
			$query_select = '*';
			$query_where = "order_id IN ({$order_ids_IN}) AND {$status}";
			$query_order = "ORDER BY assigned_end ASC LIMIT $offset,$per_page";
			
			$result = wad_select_query( $query_from,$query_select,$query_where,$query_order);
			$pagination = wad_pagination($page, $total, $per_page);
		} */
		
		echo wad_working_orders_table($action);
		
	}
	else if( $action == 'accounting-pending')
	{
		/* $status = "(status='5' OR status='17' OR status='12' OR status='6' OR status='9')"; //Working || Ready to Edit || Editing || Editor Revision || Revisions
		if( is_editor() ){
			$status = "(status='12' OR status='6' OR status='9')"; //Editing || Editor Revision || Revisions
		}

		$assigned_orders_array = wad_explode_assigned_orders($current_user['assigned_orders']);
		$order_ids_IN = wad_set_get_order_id_IN($assigned_orders_array);

		$query_from = 'orders';
		$query_select = '*';
		$query_where = "order_id IN ({$order_ids_IN}) AND {$status}";
		$query_order = "ORDER BY started ASC LIMIT $offset,$per_page";
		
		$total = wad_get_total_count($query_from,$query_where);
		
		if( $total ){
			$result = wad_select_query( $query_from,$query_select,$query_where,$query_order);
			$pagination = wad_pagination($page, $total, $per_page);
		} */
		
		echo wad_pending_earning_orders_table($action);
		
	}
	else if( $action == 'orders-editing')
	{
		/* $total = $globals['editing_orders_count'];
		if( $total )
		{
			$sort = 'started';
			$status = "(status='17' OR status='12')"; //Ready to Edit || Editing
			if( is_editor() ){
				$sort = 'editor_claim_time_end';
				$status = "(status='12')"; // Editing
			}
			
			$assigned_orders_array = wad_explode_assigned_orders($current_user['assigned_orders']);
			$order_ids_IN = wad_set_get_order_id_IN($assigned_orders_array);
		
			$query_from = 'orders';
			$query_select = '*';
			$query_where = "order_id IN ({$order_ids_IN}) AND {$status}";
			$query_order = "ORDER BY {$sort} ASC LIMIT $offset,$per_page";
			
			$result = wad_select_query( $query_from,$query_select,$query_where,$query_order);
			$pagination = wad_pagination($page, $total, $per_page);
		} */
		
		echo wad_editing_orders_table($action);

		
	}
	else if( $action == 'orders-revisions-editor')
	{				
		/* $total = $globals['editor_revision_orders_count'];
		if( $total )
		{
			$status = "(status='6')"; //Editor Revision
			
			$assigned_orders_array = wad_explode_assigned_orders($current_user['assigned_orders']);
			$order_ids_IN = wad_set_get_order_id_IN($assigned_orders_array);

			$query_from = 'orders';
			$query_select = '*';
			$query_where = "order_id IN ({$order_ids_IN}) AND {$status}";
			$query_order = "ORDER BY started ASC LIMIT $offset,$per_page";
			
			$result = wad_select_query( $query_from,$query_select,$query_where,$query_order);
			$pagination = wad_pagination($page, $total, $per_page);
		}		 */
		
		echo wad_editor_revision_orders_table($action);
	}
	else if( $action == 'orders-revisions-client')
	{				
		/* $total = $globals['revision_orders_count'];
		if( $total )
		{
			$status = "(status='9')"; //Client Revisions
			
			$assigned_orders_array = wad_explode_assigned_orders($current_user['assigned_orders']);
			$order_ids_IN = wad_set_get_order_id_IN($assigned_orders_array);

			$query_from = 'orders';
			$query_select = '*';
			$query_where = "order_id IN ({$order_ids_IN}) AND {$status}";
			$query_order = "ORDER BY started ASC LIMIT $offset,$per_page";
			
			$result = wad_select_query( $query_from,$query_select,$query_where,$query_order);
			$pagination = wad_pagination($page, $total, $per_page);
		}		 */
		
		echo wad_client_revision_orders_table($action);
	}
	else if( $action == 'orders-complete')
	{
		/* $total = $globals['complete_orders_count'];
		
		if( $total )
		{
			$assigned_orders_array = wad_explode_assigned_orders($current_user['assigned_orders']);
			$order_ids_IN = wad_set_get_order_id_IN($assigned_orders_array);

			$query_from = 'orders';
			$query_select = '*';
			$query_where = "order_id IN ({$order_ids_IN}) AND status=3";
			$query_order = "ORDER BY started ASC LIMIT $offset,$per_page";
			
			$result = wad_select_query( $query_from,$query_select,$query_where,$query_order);
			$pagination = wad_pagination($page, $total, $per_page);
		} */
		
		echo wad_complete_orders_table($action);
	}
	else if( $action == 'accounting-all')
	{
		/* $status = "(status='3' OR status='5' OR status='17' OR status='12' OR status='6' OR status='9')"; //Complete || Working || Ready to Edit || Editing || Editor Revision || Revisions
		if( is_editor() ){
			$status = "(status='3' OR status='12' OR status='6' OR status='9')"; //Complete || Editing || Editor Revision || Revisions
		}

		$assigned_orders_array = wad_explode_assigned_orders($current_user['assigned_orders']);
		$order_ids_IN = wad_set_get_order_id_IN($assigned_orders_array);

		$query_from = 'orders';
		$query_select = '*';
		$query_where = "order_id IN ({$order_ids_IN}) AND {$status}";
		$query_order = "ORDER BY started ASC LIMIT $offset,$per_page";
		
		$total = wad_get_total_count($query_from,$query_where);
		
		if( $total ){
			$result = wad_select_query( $query_from,$query_select,$query_where,$query_order);
			$pagination = wad_pagination($page, $total, $per_page);
		} */
		
		echo wad_total_earning_orders_table($action);
		
	}
	else if( $action == 'orders-all')
	{
		echo wad_all_orders_table($action);

		/* $assigned_orders_array = wad_explode_assigned_orders($current_user['assigned_orders']);
		$total = count($assigned_orders_array);
		
		$order_ids_IN = wad_set_get_order_id_IN($assigned_orders_array);
		
		$query_from = 'orders';
		$query_select = '*';
		$query_where = "order_id IN ({$order_ids_IN})";
		$query_order = "ORDER BY started ASC LIMIT $offset,$per_page";
		
		$result = wad_select_query( $query_from,$query_select,$query_where,$query_order);
		
		if( $total ){
			$pagination = wad_pagination($page, $total, $per_page, 2, "page=%d&per_page=%d");
		} */
	}
	else
	{
		
		echo wad_available_orders_table($action);
		
		/* $current_user_spp_id = wad_get_current_user('spp_id');
		
		$sort = 'due_in_end';
		$status = 2;
		if( is_editor() ){
			$sort = 'writer_submit_time_end';
			$status = 17; // Ready to Edit
		}
		
		// $total = $globals['new_orders_count'];
		$total = $_SESSION['new_orders_count_with_date_due'];
		$date_due_timestamp_for_new_orders = time()+(60*60*24*$globals['no_of_days_for_new_orders']);
		// $beginOfDay = strtotime("01 Apr 2021", time());
		$endOfDay   = strtotime("tomorrow", $date_due_timestamp_for_new_orders) - 1;
		
		$query_from = "orders";
		$query_select = "*";
		$query_where = "status='{$status}'";
		// if( !wad_test() ){// remove this condition to check orders based on due date
			if( $total && $total > 3 ){
				$query_where .= " AND date_due <= {$endOfDay}";					
				// $query_where .= " AND date_due BETWEEN {$beginOfDay} and {$endOfDay}";				
			}
		// }
		
		if( isset($globals['test_orders_only']) && $globals['test_orders_only'] )
		$query_where .= " AND order_title = 'TWH TEST - PLEASE IGNORE'";
		
		$query_where .= " AND orders.order_id NOT IN (SELECT user_rejected_order.order_id FROM user_rejected_order WHERE user_rejected_order.spp_id = '{$current_user_spp_id}')";
		$query_order = "ORDER BY {$sort} ASC LIMIT $offset,$per_page";

		$result = wad_select_query( $query_from,$query_select,$query_where,$query_order);
		
		if( !$total || $total < 4){
			$total = $globals['new_orders_count'] = $_SESSION['new_orders_count'] = wad_get_total_count($query_from, $query_where);
		}

		if( $total ){
			$pagination = wad_pagination($page, $total, $per_page, 2, "page=%d&per_page=%d&action=orders", "orders");
		} */
	}

	if( isset($result) )
	$orders_all = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
	${"$data_var"} = array();
	
	if( isset($orders_all)  )
	{
		$i=0;
		foreach($orders_all as $order){

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
			
			${$data_var}[$i]['order_id'] = $order_id;		
			${$data_var}[$i]['words_length'] = $order_words;		
			${$data_var}[$i]['title'] = $order_title;
			${$data_var}[$i]['earning'] = '$'.$order_earning;
			${$data_var}[$i]['status'] = $order_status;
			
			if( $action == 'orders-complete' || $action == 'accounting-pending' || $action == 'accounting-all'){
				${$data_var}[$i]['pay_rate'] = '$'.($order_pay_rate);
			}else{
				${$data_var}[$i]['pay_rate'] = '$'.$order_earning;
			}
			${$data_var}[$i]['due_in'] = $order_due_in;
			${$data_var}[$i]['doc_link'] = $order_doc_link;
			${$data_var}[$i]['date_due'] = $order_date_due;
			
			$i++;
		}
			
		ob_start();
		
		switch( $action ){
			
			case "orders-working":
				// require 'parts/orders/table/working.php'; break;
			
			case "accounting-pending":
				// require 'parts/accounting/table/pending.php'; break;
			
			case "orders-editing":
				// require 'parts/orders/table/editing.php'; break;
			
			case "orders-revisions-editor":
				// require 'parts/orders/table/revisions/editor.php'; break;
			
			case "orders-revisions-client":
				// require 'parts/orders/table/revisions/client.php'; break;
			
			case "orders-complete":
				// require 'parts/orders/table/complete.php'; break;
			
			case "accounting-all":
				// require 'parts/accounting/table/all.php'; break;
			
			case "orders-all":
				// require 'parts/orders/table/all.php'; break;
			
			default:
				// require 'parts/orders/table/orders.php';
			
		}
		
		echo ob_get_clean();
		
	} //isset($orders_all)

}

// writer claim order - START
if( $action == 'writer_claim_order' || $action == 'admin_assign_writer_new_order')
{
	wad_writer_claim_order();
	die();
}
// END - writer claim order

// editor claim order - START
if( $action == 'editor_claim_order' || $action == 'admin_assign_editor_readyToEdit_order')
{
	wad_editor_claim_order();
	die();
}
// END - editor claim order

// Order Details Modal Content - START
if( $action == 'order_details_modal_content_ajax')
{
	if( ! $_REQUEST['order_id'] )
		die();
	
	$current_page_url = $_REQUEST['current_page_url'];
	
	echo order_details_modal_content_ajax($_REQUEST['order_id'], $current_page_url);
	die();
}
// END - Order Details Modal Content

// Order Complete Modal Content - START
if( $action == 'order_complete_modal_content_ajax')
{
	if( ! $_REQUEST['order_id'] )
		die();
	
	$current_page_url = $_REQUEST['current_page_url'];
	
	echo order_complete_modal_content_ajax($_REQUEST['order_id'], $current_page_url);
	die();
}
// END - Order Complete Modal Content


// Admin assign writer to Working Order - START
if( $action == 'admin_assign_writer_working_order' )
{
	$current_user_spp_id = wad_get_current_user('spp_id');
	
	$order_id = isset($_REQUEST['order_id']) ? $_REQUEST['order_id'] : '';
	$assigned_writer_id = isset($_REQUEST['employee_id']) ? $_REQUEST['employee_id'] : '';
	$employee_old_id = isset($_REQUEST['employee_old_id']) ? $_REQUEST['employee_old_id'] : '';
	$ajax = isset($_REQUEST['ajax']) ? $_REQUEST['ajax'] : '';
	$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
	
	$assigned_writer = wad_get_user_by_id($assigned_writer_id);
	$assigned_writer_name = $assigned_writer['name'];

	$order_info = wad_get_spp_order_info($order_id);
	$spp_order_status = isset($order_info['status']) ? $order_info['status'] : '';
	if( $spp_order_status=='error' || empty($order_info) )
		return;
	
	$order_words = (int) (str_replace(array(',','Words'),'',$order_info['options']['How many words?']));
	
	$current_timestamp = time();
	$order = array_merge(wad_get_order($order_id), $order_info);
	
	$date_due_timestamp = wad_get_new_orders_due_timestamp($order_words);
	
	$note = wad_get_note_for_working_order(array(
		'order' => $order,
		'order_id' => $order_id,
		'writer_spp_id' => $assigned_writer_id,
		'writer_name' => $assigned_writer_name,
		'date_due_timestamp' => $date_due_timestamp
	));
	
	$post = array(
		"date_due"		=> date('Y-m-d H:i:s', $date_due_timestamp),
		"note"			=> $note
	);
	
	$employees 	= isset($order_info['employees']) ? $order_info['employees'] : array();
	
	$i=0; $assigned_employees_ids = array();
	if( count($employees) ){
		foreach($employees as $employee){
			if( $employee_old_id == $employee['id'] )
				continue;
			$post["employees[$i]"] = $employee['id'];
			$assigned_employees_ids[] = $employee['id'];
			$i++;
		}
	}
	$post["employees[$i]"] = $assigned_writer_id;
	$assigned_employees_ids[] = $assigned_writer_id;
	
	$response = wad_spp_update_order($order_id,$post,true);
	
	if( wad_get_option('save_log') == 'yes' ){
		
		wad_insert_query( "logs",
			array( "from_type", "from_id", "action", "source", "source_id", "time", "to_type", "to_id" ),
			array( "Admin", $current_user_spp_id, "assigned", "order", $order_id, time(), "user", $assigned_writer_id )
		);

		wad_insert_query( "logs",
			array( "from_type", "from_id", "action", "source", "source_id", "time", "data"),
			array( "Admin", $current_user_spp_id, "changed due date", "order", $order_id, time(), $date_due_timestamp)
		);
		
		wad_insert_query( "logs",
			array( "from_type", "from_id", "action", "source", "source_id", "time","data"),
			array( "Admin", $current_user_spp_id, "updated note", "order", $order_id, time(),$note)
		);
	}
	
	wad_update_query("orders", "assigned='{$current_timestamp}', assigned_end ='{$date_due_timestamp}', date_due ='{$date_due_timestamp}'", "order_id='{$order_id}'");
	
	// Add assigned user
	if( ! wad_assign_employee_to_order($order_id, $assigned_writer_id, 'has_assigned') ){
		if( wad_get_option('save_log') == 'yes')
		{
			wad_insert_query( "logs",
				array( "from_type", "action", "source", "source_id", "time", "to_type", "to_id" ),
				array( "System", "assigned", "order", $order_id, $current_timestamp, "user", $assigned_writer_id )
			);
		} 
	}

	//NEW - Decrementing all writers' orders total count
	//NEW - Incrementing working/all orders total count for the assigned writer 
	$args = array(
		'add' => array('working_orders_count', 'all_orders_count'),
		'add_user_spp_id' => $assigned_writer_id,
		'add_words' => $order_words,
		'add_words_user_spp_id' => $assigned_writer_id,
	);
	
	if($employee_old_id){
		wad_delete_query("order_assigned_user", "spp_id='{$employee_old_id}' AND order_id='{$order_id}'");	
		$args['subtract'] = array('working_orders_count', 'all_orders_count');
		$args['subtract_user_spp_id'] = $employee_old_id;
		$args['subtract_words'] = $order_words;
		$args['subtract_words_user_spp_id'] = $employee_old_id;	
	}
	
	wad_set_users_order_total_count($args);
	//NEW END


	// Set assigned orders for user
	wad_delete_assigned_order_from_users($order_id);
	foreach($assigned_employees_ids as $employee_id){
		wad_save_assigned_orders_to_user($employee_id, $order_id);
	}
	
	$writer_name_html = sprintf('<a href="%s">%s</a>', BASE_URL.'/users/edit/'.$assigned_writer['spp_id'], $assigned_writer['name']);
	
	if( $response->status == 'Working' )
	{
		$result = array(
			'result'=>'writer_assigned',
			'msg'=>'Writer assigned successfully',
			'writer_name' => $writer_name_html,
			'employee_old_id' => $assigned_writer_id
			
		);
		echo json_encode($result);
	}
	 
	die();
	

}
// END -  Admin assign writer to Working Order

if( $action == 'stats-writers' )
{
	echo wad_stats_writers($_REQUEST['stats']);
	die();
}

if( $action == 'stats-editors' )
{
	echo wad_stats_editors($_REQUEST['stats']);
	die();
}

if( $action=='stats_export_displaying'){
	
	$date_time = time();
	
	$html = '<table>';
	$html .= $_REQUEST['html'];
	$html .= '</table>';

	$filename = isset($_REQUEST['filename']) ? $_REQUEST['filename'] : 'stats';
	$filename .= '-displaying-'.$date_time;
	
	$reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
	$spreadsheet = $reader->loadFromString($html);
	$spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(23);
	$stats = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
	$stats_filename = $filename.'.xls';
	$stats_file = BASE_DIR.'/stats-generated/'.$filename.'.xls';
	$stats->save($stats_file); 
	
	echo BASE_URL . '/stats-generated/'.$stats_filename;	
	die();
}