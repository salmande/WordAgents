<?php
/*
 *- Called via API WordAgents.
 *- file: /api/webhook.wordagents.spp.php
 *- method: add_order_to_dashboard
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
$client 	= $data['client'];
$date_due 	= isset($data['date_due']) ? strtotime($data['date_due']) : '';
$form_data 	= $data['form_data'];
$employees 	= $data['employees'];

$client_id 		= $client['id'];
$client_name 	= $client['name_f'];
$client_name 	.= ( $client['name_l'] ) ? ' '.$client['name_l'] : '';
$client_company 	= isset($client['company']) ? $client['company'] : '';
$tags_add = array();

if( $client_company )
$tags_add[] = $client_company;

$order_articles_num	 	= $form_data['How many articles do you need?'];
$order_title = isset($form_data['Title or Topic']) ? trim($form_data['Title or Topic']) : '';
if( empty($order_title) ){
	$order_title = isset($form_data['Title']) ? $form_data['Title'] : '';
}

if( $order_articles_num > 1 )
$tags_add[] = "Bulk Order";

$order_words 	= (int) (preg_replace("/[^0-9.]/", "", $data['options']['How many words?']));
// $order_words = (int) (str_replace(array(',','Words'),'',$order_info['options']['How many words?']));

$tool=0;
if(isset($form_data['Which tool would you like us to use to optimize your article?']) ){
	$tool=1;
}

$started = $due_in = $due_in_end = $created;

$due_in_end = $created + (60*60*48);
if( $order_words >= 5000 ){
	$due_in_end = $created + (60*60*72);
}

$test_clients_array = array(4182,19, 2571, 3517);

// if( in_array($client_id, $test_clients_array) )
// {
	if( wad_get_option('create_order') == 'yes' ){
		wad_insert_query("orders",
			array('order_id','order_title','is_tool','created','started','date_due','spp_date_due','due_in', 'due_in_end', 'status', 'order_words'),
			array($order_id, $order_title, $tool, $created, $started, $date_due, $date_due, $due_in, $due_in_end, 2, $order_words)
		);
		
		//NEW - Incrementing new orders total count for all writers
		$args = array(
			'roles' => array('Writer'),
			'add_to_Writer_fields' => array('new_orders_count'),
		);
		wad_set_users_order_total_count($args);
		//NEW END

		if( $order_id )
		wad_store_new_created_order($order_id);

		if( wad_get_option('save_log') == 'yes'){
			
			$log_columns = 	array( "from_type", "from_id", "action", "source", "source_id", "time" );
			$log_values = 	array( "client", $client_id, "created", "order", $order_id, time() );

			wad_insert_query("logs", $log_columns, $log_values);
		}

		// Insert pre-defined employees which are assigned to the purchased service SPP into database
		foreach($employees as $employee){
			$employee_id = $employee['id'];
			$has_inserted = wad_insert_query("order_assigned_user",
				array('order_id','spp_id'),
				array($order_id, $employee_id)
			);
			if( wad_get_option('save_log') == 'yes'){
				if( $has_inserted ){
					wad_insert_query( "logs",
						array( "from_type", "from_id", "action", "source", "source_id", "time", "to_type", "to_id" ),
						array( "system", $employee_id, "assigned", "order", $order_id, time(), "user", $employee_id )
					);
				}
			}
		}

		$post = array();
		if( count($tags_add) )
		{
			$i=0;
			foreach($tags_add as $tag){
				$post["tags[".$i."]"] = $tag;
				$i++;
			}
			wad_add_update_tags_to_order($order_id, $tags_add);
		}

		wad_spp_update_order($order_id, $post);

		if( wad_get_option('save_log') == 'yes')
		{
			foreach($tags_add as $tag){
				wad_insert_query( "logs",
					array( "from_type", "from_id", "action", "source", "source_id", "time", "data"),
					array( "system", "", "Added tag", "order", $order_id, time(), $tag)
				);
			}
		}
	}
// }