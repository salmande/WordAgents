<?php

require 'PhpSpreadsheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// date_default_timezone_set ('Asia/Karachi');
//date_default_timezone_set ('US/Eastern');
date_default_timezone_set('America/New_York');

require "constants.php";
require 'db_connection.php';
require 'functions.php';

global $wad_url;

$wad_url = isset($_GET['url']) ? $_GET['url'] : 'home'; //home

//remove last slash if exists
if(substr($wad_url, -1) == '/') {
    $wad_url = substr($wad_url, 0, -1);
}

//Load all orders page in place of home page
if( $wad_url == 'home' )
{
	if( is_writer() || is_editor() )
	$wad_url = 'orders';
}

//Load all users page in place of admin page
if( is_admin() && $wad_url == 'admin' )
{
	$wad_url = 'admin/users/all';
}

// "/orders" finds orders directory first. if found, run /orders/index.php so replaceing orders with wad-orders directory name in order to run from root index.php to load orders.
if( strpos($wad_url, 'orders') !== false )
{
	$wad_url_array = explode('/',$wad_url);
	$wad_url_array[0] = str_replace('orders','wad-orders',$wad_url_array[0]);
	$wad_url = implode('/',$wad_url_array);
}

// checking cronjob into url if found load wad-cronjob folder
if( strpos($wad_url, 'cronjob') !== false )
{
	$wad_url_array = explode('/',$wad_url);
	$wad_url_array[0] = str_replace('cronjob','wad-cronjob',$wad_url_array[0]);
	$wad_url = implode('/',$wad_url_array);
}

// admin pages ( found 'admin' in URL )
if( strpos($wad_url, 'admin') !== false )
{
	$wad_url_array = explode('/',$wad_url);
	$wad_url_array[0] = str_replace('admin','wad-admin',$wad_url_array[0]);
	$wad_url = implode('/',$wad_url_array);
	
	// Redirect to home if not admin logged-in
	if( ! is_admin() ){
		header("Location: ".BASE_URL);
		die();
	}
}else{
	// not admin pages redirect to admin
	if( is_admin() && $wad_url != 'ajax' ){
		header("Location: ".BASE_URL."/admin");
		die();
	}
}

if( $wad_url == 'wad-orders' ){
	$wad_url = 'orders';
}
if( $wad_url == 'wad-admin' ){
	$wad_url = 'wad-admin/index';
}

if( strpos($wad_url, 'wad-admin/users/edit/') !== false ){
	$wad_url = 'wad-admin/users/edit';
}

// checking into url, webhook or cronjob 
$webhook = strpos($wad_url, 'webhook');
$cronjob = strpos($wad_url, 'wad-cronjob');

// neither webhook nor cronjob
$a = $webhook === false && $cronjob === false;
if($a)
{
	$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";  
	$request_uri = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];  
	
	// checking into url, login or register or forgot or reset pages 
	$login = strpos($wad_url, 'login');
	$register = strpos($wad_url, 'register');
	$forgot =  strpos($wad_url, 'forgot');
	$reset = strpos($wad_url, 'reset-password');
	
	//either login or register or forgot or reset
	$is_login_register_forgot_reset_page = $login !== false || $register !== false || $forgot !== false || $reset !== false;

	if( is_user_logged_in() ){	
		if ( $is_login_register_forgot_reset_page ) { 
			header("Location: ".BASE_URL);
			die();
		}
	}else{
		if ( $is_login_register_forgot_reset_page ) { 
			// do nothing
		}else{
			header("Location: ".BASE_URL."/login?redirect_to=".urlencode($request_uri));
			die();
		}
	}
}

if( wad_get_option('send_emails') == 'yes' )
{	
	require 'PHPMailer/src/Exception.php';
	require 'PHPMailer/src/PHPMailer.php';
	require 'PHPMailer/src/SMTP.php';

	// Email new orders daily
	// wad_send_new_created_orders_email();

	// wad_send_new_submitted_orders_email();
	
	// Email for working orders within last 6 hours.
	wad_send_email_for_working_orders();
	
}

if( wad_get_option('reject_order') == 'yes' )
{
	//Change Order status to Instruction Review after 48 hours if no claim
	//wad_update_submitted_orders(); //removed this functionality for now
	
	//Order is being rejected after 48 hours of claim and added to available list to reclaim
	wad_update_working_orders(); 
}

require 'action.php';

if( is_user_logged_in() )
{
	$globals['wad_url'] = $wad_url;
	require 'globals.php';
	require 'data.php';	
}

$file = $wad_url.'.php';

if( ! file_exists($file) ){
	
	echo "$wad_url <br />Something wrong or 404 Not Found";
	die();
}

require $file;