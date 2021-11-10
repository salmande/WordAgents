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