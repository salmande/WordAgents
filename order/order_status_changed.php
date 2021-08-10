<?php
/*
*- Called via API WordAgents.
*- file: /api/webhook.wordagents.spp.php
*- method: order_status_changed_to_dashboard
*/

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../constants.php";
require_once "../db_connection.php";
require_once "../functions.php";


$post = $_POST;
$created = $post['created'];
$data 	= $post['data'];

$order_id 	= $data['id'];
$order_title = $data['service'];
$status 	= wad_get_status_id($data['status']);

$date_due	= isset($data['date_due']) ? $data['date_due'] : '';
$client 	= $data['client'];
$order_form_data 	= $data['form_data'];

$employees 	= isset($data['employees']) ? $data['employees'] : array();
$note = isset($data['note']) ? $data['note'] : '';

$client_id 		= $client['id'];
$client_name 	= $client['name_f'];
$client_name 	.= ( $client['name_l'] ) ? ' '.$client['name_l'] : '';
$client_company 	= isset($client['company']) ? $client['company'] : '';

$order_articles_num	 	= (int) $order_form_data['How many articles do you need?'];

$tags_add = array();

if( $client_company )
$tags_add[] = $client_company;

$tag_bulk_order = "Bulk Order";
if( $order_articles_num > 1 )
$tags_add[] = $tag_bulk_order;

$order = wad_get_order($order_id);
$spp_date_due = $order['spp_date_due'];

$test_clients_array = array(4182,19, 2571, 3517);
// if( in_array($client_id, $test_clients_array) )
// {
	// file_put_contents('order.status.changed---'.$status.'.txt', json_encode($post));

	$order_tags 	= isset($data['tags']) ? $data['tags'] : array();
	$has_order_tags = count($order_tags);

	$order_words 	= (int) (preg_replace("/[^0-9.]/", "", $data['options']['How many words?']));

	$current_timestamp = time();

	$set = '';

	$has_tag_Editor_Revision = '';
	$has_tag_Ready_to_Edit = '';
	if( $has_order_tags )
	{
		if( in_array('Editor Revision', $order_tags) ){
			$has_tag_Editor_Revision = true;
		}		
		if( in_array('Ready to Edit', $order_tags) ){
			$has_tag_Ready_to_Edit = true;
		}		
	}

	//NEW - Setup atts to Update Orders Counter
	$assigned_writers_ids_old = wad_get_assigned_writers_ids($order_id);
	$assigned_editors_ids_old = wad_get_assigned_editors_ids($order_id);
	$status_old = (int) $order['status'];
	$doc_link = $order['doc_link'];

	$status_to = $status;
	$status_from = $status_old;

	$Submitted_To_Working = 			$status_to == 5 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 2;
	$Submitted_To_ReadyToEdit = 		$status_to == 5 && !$has_tag_Editor_Revision && $has_tag_Ready_to_Edit && $status_from == 2;
	$Submitted_To_Editing = 			$status_to == 12 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 2;
	$Submitted_To_EditorRevision = 	$status_to == 5 && $has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 2;
	$Submitted_To_Complete = 		$status_to == 3 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 2;
	$Submitted_To_Revision = 		$status_to == 9 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 2;

	$Working_To_Submitted = 			$status_to == 2 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 5;
	$Working_To_Editing = 			$status_to == 12 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 5;
	$Working_To_Complete = 			$status_to == 3 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 5;
	$Working_To_Revision = 			$status_to == 9 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 5;

	$ReadyToEdit_To_Submitted = 		$status_to == 2 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 17;
	$ReadyToEdit_To_Editing = 		$status_to == 12 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 17;
	$ReadyToEdit_To_Complete = 		$status_to == 3 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 17;
	$ReadyToEdit_To_Revision = 		$status_to == 9 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 17;

	$Editing_To_Submitted = 			$status_to == 2 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 12;
	$Editing_To_Working = 			$status_to == 5 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 12;
	$Editing_To_ReadyToEdit = 		$status_to == 5 && !$has_tag_Editor_Revision && $has_tag_Ready_to_Edit && $status_from == 12;
	$Editing_To_EditorRevision = 	$status_to == 5 && $has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 12;
	$Editing_To_Complete = 			$status_to == 3 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 12;
	$Editing_To_Revision = 			$status_to == 9 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 12;

	$EditorRevision_To_Submitted = 	$status_to == 2 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 6;
	$EditorRevision_To_Editing = 	$status_to == 12 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 6;
	$EditorRevision_To_Complete = 	$status_to == 3 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 6;
	$EditorRevision_To_Revision = 	$status_to == 9 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 6;

	$Complete_To_Submitted = 		$status_to == 2 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 3;
	$Complete_To_Working = 			$status_to == 5 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 3;
	$Complete_To_ReadyToEdit = 		$status_to == 5 && !$has_tag_Editor_Revision && $has_tag_Ready_to_Edit && $status_from == 3;
	$Complete_To_Editing = 			$status_to == 12 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 3;
	$Complete_To_EditorRevision = 	$status_to == 5 && $has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 3;
	$Complete_To_Revision = 			$status_to == 9 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 3;

	$Revision_To_Submitted = 		$status_to == 2 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 9;
	$Revision_To_Working = 			$status_to == 5 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 9;
	$Revision_To_ReadyToEdit = 		$status_to == 5 && !$has_tag_Editor_Revision && $has_tag_Ready_to_Edit && $status_from == 9;
	$Revision_To_Editing = 			$status_to == 12 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 9;
	$Revision_To_EditorRevision = 	$status_to == 5 && $has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 9;
	$Revision_To_Complete = 			$status_to == 3 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 9;		

	$InstructionReview_To_Submitted = 		$status_to == 2 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 14;
	$InstructionReview_To_Working = 			$status_to == 5 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 14;
	$InstructionReview_To_ReadyToEdit = 		$status_to == 5 && !$has_tag_Editor_Revision && $has_tag_Ready_to_Edit && $status_from == 14;
	$InstructionReview_To_Editing = 			$status_to == 12 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 14;
	$InstructionReview_To_EditorRevision = 	$status_to == 5 && $has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 14;
	$InstructionReview_To_Complete = 		$status_to == 3 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 14;
	$InstructionReview_To_Revision = 		$status_to == 9 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit && $status_from == 14;


	// Add log "Changed Order Status" into OG when...
	// - Status is neither Working nor Editing nor Complete nor Submitted
	if(
		( $status != 5 && $status != 12 && $status != 3 && $status != 2 )
		|| $Submitted_To_Working
		|| $Submitted_To_ReadyToEdit
		|| $Submitted_To_Editing
		|| $Submitted_To_EditorRevision
		|| $Submitted_To_Complete
		|| $Submitted_To_Revision
		|| $Working_To_Submitted
		|| $Working_To_Editing
		|| $Working_To_Complete
		|| $Working_To_Revision
		|| $ReadyToEdit_To_Editing
		|| $ReadyToEdit_To_Complete
		|| $ReadyToEdit_To_Revision
		|| $Editing_To_Submitted
		|| $Editing_To_Working
		|| $Editing_To_ReadyToEdit
		|| $Editing_To_EditorRevision
		|| $Editing_To_Complete
		|| $Editing_To_Revision
		|| $EditorRevision_To_Submitted
		|| $EditorRevision_To_Editing
		|| $EditorRevision_To_Complete
		|| $EditorRevision_To_Revision
		|| $Complete_To_Submitted
		|| $Complete_To_Working
		|| $Complete_To_ReadyToEdit
		|| $Complete_To_Editing
		|| $Complete_To_EditorRevision
		|| $Complete_To_Revision
		|| $Revision_To_Submitted
		|| $Revision_To_Working
		|| $Revision_To_ReadyToEdit
		|| $Revision_To_Editing
		|| $Revision_To_EditorRevision
		|| $Revision_To_Complete
		|| $InstructionReview_To_Submitted
		|| $InstructionReview_To_Working
		|| $InstructionReview_To_ReadyToEdit
		|| $InstructionReview_To_Editing
		|| $InstructionReview_To_EditorRevision
		|| $InstructionReview_To_Complete
		|| $InstructionReview_To_Revision
	){
		if( wad_get_option('save_log') == 'yes')
		{
			wad_insert_query( "logs",
				array( "from_type", "action", "source", "source_id", "time", "data"),
				array( "System", "changed order status", "order", $order_id, $current_timestamp, $status)
			);
		}
	}

	$atts = array(
		'order_id' => $order_id,
		'order_words' => (int)$order_words,
		'status' => $status,
		'status_old' => $status_old,
		'assigned_writers_ids_old' => $assigned_writers_ids_old,
		'assigned_editors_ids_old' => $assigned_editors_ids_old,
	);

	//Add employees to the order in case directly assigned from SPP - START

	$employees_total = count($employees);
	$assigned_employees_ids = $assigned_writers_ids = $assigned_writers = $assigned_editors = $assigned_editors_ids = $assigned_editors_ids_auto = $unassigned_editors_ids_auto = array();
	if( $employees_total )
	{
		foreach($employees as $employee)
		{
			$assigned_employees_ids[] = $employee_id = (int) $employee['id'];
				
			if( $employee['role_id'] == 4 ){
				$assigned_writers[] = $employee;
				$assigned_writers_ids[] = $employee_id;
			}
			if( $employee['role_id'] == 7 ){
				$assigned_editors[] = $employee;
				$assigned_editors_ids[] = $employee_id;
			}
			// Add assigned user
			if( ! wad_assign_employee_to_order($order_id, $employee_id, 'has_assigned') ){
				if( wad_get_option('save_log') == 'yes')
				{
					wad_insert_query( "logs",
						array( "from_type", "action", "source", "source_id", "time", "to_type", "to_id" ),
						array( "System", "assigned", "order", $order_id, $current_timestamp, "user", $employee_id )
					);
				} 
			}
		}
	}
		
	//END - Add employees to the order in case directly assigned from SPP

	// Delete employeee if not assigned anymore SPP side - START

	$assigned_users_ids = wad_get_assigned_users_ids($order_id);
	$employees_ids_to_unassign = array();

	if( $employees_total )
	{
		foreach($assigned_users_ids as $assigned_user_id)
		{
			// Check assigned user not exists into SPP order
			if( ! in_array($assigned_user_id, $assigned_employees_ids) ){
				$employees_ids_to_unassign[] = $assigned_user_id;
			}
		}
	}
	else
	{
		$employees_ids_to_unassign = $assigned_users_ids;
	}

	if( !empty($employees_ids_to_unassign) )
	wad_unassign_bulk_users_from_order($order_id, $employees_ids_to_unassign);

	// END - Delete employeee if not assigned anymore SPP side

	// set status to ReadyToEdit (ID:17) into OG if order status is Working and has ReadyToEdit tag.
	if( $status == 5 && $has_tag_Ready_to_Edit ){
		$set .= "status='17'";
	// set status to EditorRevision (ID:6) into OG if order status is Working and has EditorRevision tag.
	}else if( $status == 5 && $has_tag_Editor_Revision ) {
		$set .= "status='6'";
	}
	else{
		$set .= "status='{$status}'";
	}

	$date_due_timestamp = wad_get_new_orders_due_timestamp($order_words);

	if( $status == 2 ) //Submitted
	{ 
		$set .= ", started='{$current_timestamp}', due_in='{$current_timestamp}', due_in_end='{$date_due_timestamp}'";
		
		wad_spp_update_order($order_id, array('note' => ''));
		
		if( wad_get_option('save_log') == 'yes' )
		{
			wad_insert_query( "logs",
				array( "from_type", "action", "source", "source_id", "time"),
				array( "system", "deleted note", "order", $order_id, $current_timestamp)
			);
		}
	}
	elseif( $status == 5) //Working
	{
		if( !empty($assigned_writers) )
		{				
			if( ! $has_tag_Editor_Revision ){
				$set .= ", assigned='{$current_timestamp}', assigned_end='{$date_due_timestamp}', date_due='{$date_due_timestamp}'";	
			}

			//Get orders note
			if(
				$Submitted_To_Working
				|| $Submitted_To_ReadyToEdit
				|| $Submitted_To_EditorRevision
				|| $Editing_To_Working
				|| $Complete_To_Working
				|| $Revision_To_Working
				|| $InstructionReview_To_Working
				|| $InstructionReview_To_ReadyToEdit
				|| $InstructionReview_To_EditorRevision
			){
				$data_get_note_for_working_order = array(
					'order_id' => $order_id,
					'writer_name' => $assigned_writers[0]['name_f'],
					'writer_spp_id' => $assigned_writers_ids[0],
					'date_due_timestamp' => $date_due_timestamp,
				);
								
				$note = wad_get_note_for_working_order( $data_get_note_for_working_order );
				$note .= '<br><a href="'.$doc_link.'" target="_blank">'.$doc_link.'</a>';
			}
			
			$data_spp_update_woring_order = array(
				'order_id' => $order_id,
				'note' => $note,
				'note_log_action' => 'added note'
			);
			
			// Add log for "Changed due date"
			if( 
				$Submitted_To_Working
				|| $InstructionReview_To_Working
			){
				$data_spp_update_woring_order['date_due_timestamp'] = $date_due_timestamp;
			}
			
			//Update note etc
			if(
				$Submitted_To_Working
				|| $Submitted_To_ReadyToEdit
				|| $Submitted_To_EditorRevision
				|| $Editing_To_Working
				|| $Complete_To_Working
				|| $Revision_To_Working
				|| $InstructionReview_To_Working
				|| $InstructionReview_To_ReadyToEdit
				|| $InstructionReview_To_EditorRevision
			){				
				// file_put_contents('note---'.$status.'---'.'.txt', $note);
				wad_spp_update_working_order( $data_spp_update_woring_order );	
			}
			
		}
	}
	elseif( $status == 12) // Editing
	{			
		//Update order note when status changed to Editing from Working
		if( $Working_To_Editing )
		{
			$note .= '<br><a href="'.$doc_link.'" target="_blank">'.$doc_link.'</a>';
			wad_spp_update_working_order( array( 'order_id' => $order_id, 'note' => $note, 'note_log_action' => 'updated note' ) );
		}
		
		//Add order note when status changed to Editing from Submitted
		if( !empty($assigned_writers) &&
			( $Submitted_To_Editing
			|| $InstructionReview_To_Editing
			) 
		){
			$data_get_note_for_working_order = array(
				'order_id' => $order_id,
				'writer_name' => $assigned_writers[0]['name_f'],
				'writer_spp_id' => $assigned_writers_ids[0],
				'date_due_timestamp' => $date_due_timestamp,
			);
			$note = wad_get_note_for_working_order( $data_get_note_for_working_order );
			$note .= '<br><a href="'.$doc_link.'" target="_blank">'.$doc_link.'</a>';
			wad_spp_update_working_order( array( 'order_id' => $order_id, 'note' => $note, 'note_log_action' => 'added note' ) );
		}
	}
	else if($status == 3 ) //Complete
	{			
		//Add order note when status changed to Complete from Submitted
		if( $Submitted_To_Complete || $InstructionReview_To_Complete )
		{
			$data_get_note_for_working_order = array(
				'order_id' => $order_id,
				'writer_name' => $assigned_writers[0]['name_f'],
				'writer_spp_id' => $assigned_writers_ids[0],
				'date_due_timestamp' => $date_due_timestamp,
			);
			$note = wad_get_note_for_working_order( $data_get_note_for_working_order );
			$note .= '<br><a href="'.$doc_link.'" target="_blank">'.$doc_link.'</a>';
			wad_spp_update_working_order( array( 'order_id' => $order_id, 'note' => $note, 'note_log_action' => 'added note' ) );
		}
		
		//Update order note when status changed to Complete from Working
		if( $Working_To_Complete ){
			$note .= '<br><a href="'.$doc_link.'" target="_blank">'.$doc_link.'</a>';
			wad_spp_update_working_order( array( 'order_id' => $order_id, 'note' => $note, 'note_log_action' => 'updated note' ) );
		}
		
	}else if($status == 9 ) //Revision
	{			
		//Add order note when status changed to Revision from Submitted
		if( $Submitted_To_Revision || $InstructionReview_To_Revision )
		{
			$data_get_note_for_working_order = array(
				'order_id' => $order_id,
				'writer_name' => $assigned_writers[0]['name_f'],
				'writer_spp_id' => $assigned_writers_ids[0],
				'date_due_timestamp' => $date_due_timestamp,
			);
			$note = wad_get_note_for_working_order( $data_get_note_for_working_order );
			$note .= '<br><a href="'.$doc_link.'" target="_blank">'.$doc_link.'</a>';
			wad_spp_update_working_order( array( 'order_id' => $order_id, 'note' => $note, 'note_log_action' => 'added note' ) );
		}
		
		//Update order note when status changed to Revision from Working
		if( $Working_To_Revision ){
			$note .= '<br><a href="'.$doc_link.'" target="_blank">'.$doc_link.'</a>';
			wad_spp_update_working_order( array( 'order_id' => $order_id, 'note' => $note, 'note_log_action' => 'updated note' ) );
		}
		
	}

	$where = "order_id='{$order_id}'";

	wad_update_query("orders",$set, $where);
	$set = '';

	// Add log for adding tag "Ready to Edit"
	if( $Submitted_To_ReadyToEdit
		|| $Editing_To_ReadyToEdit
		|| $Complete_To_ReadyToEdit
		|| $Revision_To_ReadyToEdit
		|| $InstructionReview_To_ReadyToEdit
	){
		if( wad_get_option('save_log') == 'yes')
			{
			wad_insert_query( "logs",
				array( "from_type", "action", "source", "source_id", "time", "data"),
				array( "system", "Added tag", "order", $order_id, $current_timestamp, "Ready to Edit")
			);
		}
	}

	// Add log for deleting tag "Ready to Edit"
	if( $ReadyToEdit_To_Revision
		|| $ReadyToEdit_To_Complete
		|| $ReadyToEdit_To_Editing
		|| $ReadyToEdit_To_Submitted
	){
		if( wad_get_option('save_log') == 'yes')
			{
			wad_insert_query( "logs",
				array( "from_type", "action", "source", "source_id", "time", "data"),
				array( "system", "Removed tag", "order", $order_id, $current_timestamp, "Ready to Edit")
			);
		}
	}
			
	// Add log for adding tag "Editor Revision"
	if( $Editing_To_EditorRevision
		|| $Submitted_To_EditorRevision
		|| $Complete_To_EditorRevision
		|| $Revision_To_EditorRevision
		|| $InstructionReview_To_EditorRevision
	){
		if( wad_get_option('save_log') == 'yes')
		{
			wad_insert_query( "logs",
				array( "from_type", "action", "source", "source_id", "time", "data"),
				array( "system", "Added tag", "order", $order_id, $current_timestamp, "Editor Revision")
			);
		}
	}

	// Add log for deleting tag "Editor Revision"
	if( $EditorRevision_To_Submitted
		|| $EditorRevision_To_Editing
		|| $EditorRevision_To_Complete
		|| $EditorRevision_To_Revision
	){
		if( wad_get_option('save_log') == 'yes')
			{
			wad_insert_query( "logs",
				array( "from_type", "action", "source", "source_id", "time", "data"),
				array( "system", "Removed tag", "order", $order_id, $current_timestamp, "Editor Revision")
			);
		}
	}

	if( $status == 2 ) 
	{
		// Add clientCompany and bulkOrder tag if not added
		$post = array();
		
		$tag_client_company_added = $tag_bulk_order_added = false;
		
		$i=0;
		if( !in_array($client_company, $order_tags) ){
			$post["tags[$i]"] = $client_company;
			$tag_client_company_added = true;
			$i++;
		}
		if( !in_array($tag_bulk_order, $order_tags) ){
			$post["tags[$i]"] = $tag_bulk_order;
			$tag_bulk_order_added = true;
			$i++;
		}
		
		wad_spp_update_order($order_id, $post);
		
		wad_add_update_tags_to_order($order_id, $tags_add, $order['tags']);

		if( wad_get_option('save_log') == 'yes')
		{
			if( $tag_client_company_added )
			{
				wad_insert_query( "logs",
					array( "from_type", "action", "source", "source_id", "time", "data"),
					array( "system", "Added tag", "order", $order_id, $current_timestamp, $client_company)
				);
			}
			
			if( $tag_bulk_order_added )
			{
				wad_insert_query( "logs",
					array( "from_type", "action", "source", "source_id", "time", "data"),
					array( "system", "Added tag", "order", $order_id, $current_timestamp, $tag_bulk_order)
				);
			}
		}
	}

	// Removing tags: Editor Revision, Customer Service, Editor Review, Ready to Edit
	// And un-assigning employees if assigned: Erynn and Vinci
	// When status changed to Editing and any status from Revision.
	if(
		$status == 12 || 
		$Revision_To_Submitted || 
		$Revision_To_Working || 
		$Revision_To_ReadyToEdit || 
		$Revision_To_Editing || 
		$Revision_To_EditorRevision || 
		$Revision_To_Complete
	){
		$post = $tags = $tags_delete = array();
		
		$has_assigned_employees = count($assigned_employees_ids);
		$has_Unassigned_Erynn = '';
		$Erynn_ID = 68;
		$has_Unassigned_Vinci = '';
		$Vinci_ID = 3253;
		
		$has_Customer_Service_tag_removed = '';
		$has_Editor_Review_tag_removed = '';
		$has_Ready_to_Edit_tag_removed = '';
		$has_Editor_Revision_tag_removed = '';
		$has_tag_modified = false;
		$i=0;
		if( $has_order_tags )
		{
			foreach($order_tags as $tag){
				// Do not add Editor Revision, Customer Service, Editor Review and Ready to Edit tags again
				if( $tag == 'Editor Revision' && !$Revision_To_EditorRevision  ){
					$has_Editor_Revision_tag_removed = 1;
					$has_tag_modified = true;
					$tags_delete[] = "Editor Revision";
					continue;
				}	
				if( $tag == 'Customer Service'  ){
					$has_Customer_Service_tag_removed = 1;
					$has_tag_modified = true;
					$tags_delete[] = "Customer Service";
					continue;
				}	
				if( $tag == 'Editor Review' ){
					$has_Editor_Review_tag_removed = 1;
					$has_tag_modified = true;
					$tags_delete[] = "Editor Review";
					continue;
				}
				if( $tag == 'Ready to Edit' && !$Revision_To_ReadyToEdit ){
					$has_Ready_to_Edit_tag_removed = 1;
					$has_tag_modified = true;
					$tags_delete[] = "Ready to Edit";
					continue;
				}
				$tags["tags[".$i."]"] = $tag;
				$i++;
			}
		}
		
		// remove all tags if no any tag to add
		if( empty($tags) ){
			$has_tag_modified = true;
			$tags_delete[] = 'Delete all';
			$tags["tags[]"] = '';
		}

		if( $has_assigned_employees ){
			$i=0;
			foreach($assigned_employees_ids as $employee_id){
				// Do not assign to  Erynn and Vinci
				if( $employee_id == $Erynn_ID ){
					$has_Unassigned_Erynn = 1;
					continue;
				}
				if( $employee_id == $Vinci_ID ){
					$has_Unassigned_Vinci = 1;
					$unassigned_editors_ids_auto[] = $Vinci_ID;
					continue;
				}
				$post["employees[$i]"] = $employee_id;
				$i++;
			}
		}
		if( $has_tag_modified ){
			$post = array_merge($post, $tags);
		}
		
		wad_spp_update_order($order_id,$post);
		
		wad_delete_order_tags($order_id, $tags_delete, $order['tags']);
		
		
		if( $has_Unassigned_Erynn ){
			wad_delete_query("order_assigned_user", "spp_id='{$Erynn_ID}' AND order_id='{$order_id}'");
		}
		if( $has_Unassigned_Vinci ){
			wad_delete_query("order_assigned_user", "spp_id='{$Vinci_ID}' AND order_id='{$order_id}'");
		}
		
		if( wad_get_option('save_log') == 'yes')
		{
			if( $has_Editor_Revision_tag_removed ){
				wad_insert_query( "logs",
					array( "from_type", "action", "source", "source_id", "time", "data"),
					array( "system", "Removed tag", "order", $order_id, $current_timestamp, "Editor Revision")
				);
			}
			if( $has_Customer_Service_tag_removed ){
				wad_insert_query( "logs",
					array( "from_type", "action", "source", "source_id", "time", "data"),
					array( "system", "Removed tag", "order", $order_id, $current_timestamp, "Customer Service")
				);
			}
			if( $has_Editor_Review_tag_removed ){
				wad_insert_query( "logs",
					array( "from_type", "action", "source", "source_id", "time", "data"),
					array( "system", "Removed tag", "order", $order_id, $current_timestamp, "Editor Review")
				);
			}
			if( $has_Ready_to_Edit_tag_removed ){
				wad_insert_query( "logs",
					array( "from_type", "action", "source", "source_id", "time", "data"),
					array( "system", "Removed tag", "order", $order_id, $current_timestamp, "Ready to Edit")
				);
			}
			
			if( $has_Unassigned_Erynn )
			{
				wad_insert_query( "logs",
					array( "from_type", "from_id", "action", "source", "source_id", "time", "to_type", "to_id" ),
					array( "system", $Erynn_ID, "unassigned", "order", $order_id, $current_timestamp, "user", $Erynn_ID )
				);
			}
			if( $has_Unassigned_Vinci )
			{
				wad_insert_query( "logs",
					array( "from_type", "from_id", "action", "source", "source_id", "time", "to_type", "to_id" ),
					array( "system", $Vinci_ID, "unassigned", "order", $order_id, $current_timestamp, "user", $Vinci_ID )
				);
			}
		}
		
		
		
	}

	// remove all tags
	if( $status == 3 ) // Completed
	{
		$post = array();
		
		//remove tags.
		$post["tags[]"] = '';
		
		wad_spp_update_order($order_id, $post, true);
		
		wad_delete_order_tags($order_id, array('Delete all'));
		
		if( $has_order_tags )
		{
			foreach($order_tags as $order_tag)
			{
				if( wad_get_option('save_log') == 'yes')
				{
					wad_insert_query( "logs",
						array( "from_type", "action", "source", "source_id", "time", "data"),
						array( "system", "Removed tag", "order", $order_id, $current_timestamp, $order_tag)
					);
				}
			}
		}
	}


	//Add tag Customer Service, Editor Review as well as assign to Erynn and Vinci
	if( $status == 9 ) //Revision
	{
		$tags = $post = array();
		
		$i=0;
		if( sizeof($order_tags) )
		{
			foreach($order_tags as $tag){
				$tags["tags[".$i."]"] = $tag;
				$i++;
			}
		}
		$tags["tags[".$i."]"] = "Customer Service";
		$tags["tags[".($i+1)."]"] = "Editor Review";
		
		$Erynn_ID = 68;
		$Vinci_ID = 3253; //Vinci(Editor)
		$employees_id = array($Erynn_ID,$Vinci_ID);
		// $employees_id = array('2783'); // claudia@wordagents.com
		
		$employees_ids = array_merge($assigned_employees_ids, $employees_id);
		
		$assigned_editors_ids_auto[] = $Vinci_ID; 

		$i=0;
		foreach($employees_ids as $employee_id)
		{
			$post["employees[$i]"] = $employee_id;
			
			// Add employee
			if( ! wad_assign_employee_to_order($order_id, $employee_id, 'has_assigned') ){
				if( wad_get_option('save_log') == 'yes')
				{
					wad_insert_query( "logs",
						array( "from_type", "from_id", "action", "source", "source_id", "time", "to_type", "to_id" ),
						array( "System", $employee_id, "assigned", "order", $order_id, $current_timestamp, "user", $employee_id )
					);
				} 
			}
			
			$i++;
		}
		
		$post = array_merge($post, $tags);

		wad_spp_update_order($order_id, $post);
		
		if( wad_get_option('save_log') == 'yes')
		{
			wad_insert_query( "logs",
				array( "from_type", "action", "source", "source_id", "time", "data"),
				array( "system", "Added tag", "order", $order_id, $current_timestamp, "Customer Service")
			);
			
			wad_insert_query( "logs",
				array( "from_type", "action", "source", "source_id", "time", "data"),
				array( "system", "Added tag", "order", $order_id, $current_timestamp, "Editor Review")
			);
		}
		
		$assigned_employees_ids = $employees_ids;
		
		$post = array(
 			'order_id' => $order_id,
			'order_title' => $order_title
		);
		// zap link: https://zapier.com/app/editor/122721251
		$curl_url = "https://hooks.zapier.com/hooks/catch/8157470/bo31mwu/";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$curl_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		$r = curl_exec($ch);
		
		
		wad_insert_query( "order_client_revision",
			array( "from_type", "order_id", "time"),
			array( "System", $order_id, time())
		);

		

	}

	//NEW - Setup atts to Update Orders Counter

	// getting removed unassigned editor from assigned editors
	if( !empty($unassigned_editors_ids_auto) ){
		foreach($unassigned_editors_ids_auto as $editor_id){
			if (($key = array_search($editor_id, $assigned_editors_ids, true)) !== false) {
				unset($assigned_editors_ids[$key]);
			}
		}
	}

	$atts['has_tag_Ready_to_Edit'] = $has_tag_Ready_to_Edit;
	$atts['has_tag_Editor_Revision'] = $has_tag_Editor_Revision;
	$atts['assigned_employees_ids'] = $assigned_employees_ids;
	$atts['assigned_writers_ids'] = $assigned_writers_ids;
	$atts['assigned_editors_ids'] = $assigned_editors_ids;
	$atts['assigned_editors_ids_auto'] = $assigned_editors_ids_auto;
	$atts['unassigned_editors_ids_auto'] = $unassigned_editors_ids_auto;

	// file_put_contents('atts-before---'.$status.'---'.'.txt', json_encode($atts));
	wad_set_users_order_total_count($atts);	
	
	// NEW END
	
	// Set assigned orders for user
	wad_delete_assigned_order_from_users($order_id);
	foreach($assigned_employees_ids as $employee_id){
		if( is_writer($employee_id) || is_editor($employee_id) ){
			wad_save_assigned_orders_to_user($employee_id, $order_id);
		}
	}
	
	// Update due date to due date of SPP
	if( $status == 2
		|| $Editing_To_ReadyToEdit
		|| $Complete_To_ReadyToEdit
		|| $Revision_To_ReadyToEdit
		|| $InstructionReview_To_ReadyToEdit
	){
		wad_update_query("orders","date_due='{$spp_date_due}'", "order_id='{$order_id}'");
	}
	
// }