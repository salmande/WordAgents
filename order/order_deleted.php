<?php
/*
 *- Called via API WordAgents.
 *- file: /api/webhook.wordagents.spp.php
 *- method: delete_order_from_dashboard
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

// file_put_contents('order-deleted-'.$order_id.'.txt', $order_id);

wad_delete_order($order_id);