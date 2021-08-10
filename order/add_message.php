<?php
/*
 *- Called via API WordAgents.
 *- file: /api/webhook.wordagents.spp.php
 *- method: add_message_to_dashboard
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
$form_data 	= $data['form_data'];
$employees 	= $data['employees'];

$client_id 		= $client['id'];
$client_name 	= $client['name_f'];
$client_name 	.= ( $client['name_l'] ) ? ' '.$client['name_l'] : '';