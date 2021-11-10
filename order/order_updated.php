<?php
/*
*- Called via API WordAgents.
*- file: /api/webhook.wordagents.spp.php
*- method: update_order_to_dashboard
*/

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../constants.php";
require_once "../db_connection.php";
require_once "../functions.php";

$post = $_POST;

$data 	= $post['data'];

$order_id 	= $data['id'];
$order = wad_get_order($order_id);
if( empty($order) )
die();

$order_title = $data['service'];
$order_words = 0;
if( isset($data['options']) )
$order_words 	= (int) (preg_replace("/[^0-9.]/", "", $data['options']['How many words?']));
$note = isset($data['note']) ? $data['note'] : '';

$order_words_old = $order['order_words'];
$order_title_old = $order['order_title'];

$set = array();
$trigger_update_note = false;
if( $order_title != $order_title_old ){
	$set['order_title'] = $order_title;
	$trigger_update_note = true;
}
if( $order_words != $order_words_old ){
	$set['order_words'] = $order_words;
	$trigger_update_note = true;
}
if( !empty($set) )
wad_update_order($order_id, $set);

$employees 	= isset($data['employees']) ? $data['employees'] : array();
$employees_total = count($employees);
$assigned_writers_editors_ids = $assigned_writers_ids = $assigned_writers = $assigned_editors = $assigned_editors_ids = array();

if( $employees_total )
{
	foreach($employees as $employee)
	{
		$employee_id = (int) $employee['id'];
			
		if( $employee['role_id'] == 4 ){
			$assigned_writers[] = $employee;
			$assigned_writers_ids[] = $employee_id;
			$assigned_writers_editors_ids[] = $employee_id;
		}
		if( $employee['role_id'] == 7 ){
			$assigned_editors[] = $employee;
			$assigned_editors_ids[] = $employee_id;
			$assigned_writers_editors_ids[] = $employee_id;
		}
	}
}

if( !empty($assigned_writers) )
{
	if( $trigger_update_note ){
		$doc_link = $order['doc_link'];
		$date_due_timestamp = wad_get_new_orders_due_timestamp($order_words);
		$data_get_note_for_working_order = array(
			'order_id' => $order_id,
			'writer_name' => $assigned_writers[0]['name_f'],
			'writer_spp_id' => $assigned_writers_ids[0],
			'date_due_timestamp' => $date_due_timestamp,
		);
						
		$note = wad_get_note_for_working_order( $data_get_note_for_working_order );
		
		$data_spp_update_woring_order = array(
			'order_id' => $order_id,
			'note' => $note,
			'note_log_action' => 'added note'
		);

		wad_spp_update_working_order( $data_spp_update_woring_order );	
	}
}


if( is_order_claimed_this_week($order['assigned']) ){
	
	if( !empty($assigned_writers_editors_ids) )
	{
		foreach($assigned_writers_editors_ids as $spp_id)
		{
			$user = wad_get_user_by_id($spp_id);
			if( !empty($user) ){
				$words_weekly = (int) $user['words_weekly'];
				$words_weekly_updated = $words_weekly - $order_words_old + $order_words;
				$set = array('words_weekly' => $words_weekly_updated);
				wad_update_user($spp_id, $set);
			}
		}
	}
}