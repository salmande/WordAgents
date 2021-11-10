<?php
/*
*- Called via API WordAgents.
*- file: /api/webhook.wordagents.spp.php
*- method: order_tagged_to_dashboard
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
	// file_put_contents('order.status.changed---'.$status.'.txt', json_encode($post));

	$order_tags 	= isset($data['tags']) ? $data['tags'] : array();
	$tags_old = wad_get_order($order_id,'tags');
	$tags_old_array = explode('||',$tags_old);
	$tags_add_array = array();
	
	if( !empty($order_tags) ){
		foreach($order_tags as $tag){
			if( !in_array($tag,$tags_old_array) ){
				$tags_add_array[] = $tag;
			}
		}
	}
	if( !empty($tags_add_array) )
	wad_add_update_tags_to_order($order_id, $tags_add_array);

	if( in_array("Final Review", $tags_add_array) ){
		wad_insert_query( "order_final_review",
			array( "from_type", "order_id", "time"),
			array( "System", $order_id, time())
		);
	}
	
	if( in_array("Editor Revision", $tags_add_array) ){
		wad_insert_query( "order_editor_revision",
			array( "from_type", "order_id", "time"),
			array( "System", $order_id, time())
		);
	}

	
// }