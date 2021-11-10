<?php
/*
*- Called via API WordAgents.
*- file: /api/webhook.wordagents.spp.php
*- method: order_untagged_to_dashboard
*/

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../constants.php";
require BASE_DIR . '/db_connection.php';
require BASE_DIR . '/functions.php';

$post = $_POST;
$data 	= $post['data'];

$order_id 	= $data['id'];

$test_clients_array = array(4182,19, 2571, 3517);
// if( in_array($client_id, $test_clients_array) )
// {
	// file_put_contents('order.untagged---'.'-'.$order_id.'.txt', json_encode($post));

	$removed_tags 	= isset($data['removed_tags']) ? $data['removed_tags'] : array();
	
	$tag_removed = $removed_tags[0]['name'];
	
	wad_delete_order_tags($order_id,array($tag_removed));
	
	if( wad_get_option('save_log') == 'yes' )
	{
		wad_insert_query( "logs",
			array( "from_type", "from_id", "action", "source", "source_id", "time", "data"),
			array( "SPP", "", "Removed tag", "order", $order_id, time(), $tag_removed)
		);
	}

	
// }