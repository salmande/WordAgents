<?php
/*
 *- Called via API WordAgents.
 *- file: /api/webhook.wordagents.spp.php
 *- method: delete_invoice_from_dashboard
*/

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../constants.php";
require_once "../db_connection.php";
require_once "../functions.php";

$post = $_POST;

$data 	= $post['data'];
$invoice_id 	= $data['id'];

// file_put_contents('invoice-deleted-'.$invoice_id.'.txt', $invoice_id);

$orders = wad_query_with_fetch("SELECT order_id FROM orders WHERE order_id LIKE '%{$invoice_id}%'");
if( !empty($orders) && is_array($orders) ){
	foreach($orders as $order){
		$order_id = $order['order_id'];
		wad_spp_delete_order($order_id);
	}
}
