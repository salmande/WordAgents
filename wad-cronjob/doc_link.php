<?php

$baseDIR = '/home/customer/www/team.wordagents.com/public_html';

require $baseDIR . '/constants.php';
require $baseDIR . '/db_connection.php';
require $baseDIR . '/functions.php';

$orders = wad_get_orders('order_id',"doc_link is NULL OR doc_link=''");

if( empty($orders) )
	return;

foreach($orders as $order){
	$order_id = $order['order_id'];
	wad_add_order_doc_link_if_not_avail($order_id);
}