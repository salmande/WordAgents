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
$redirect_to_home = false;
	
//remove last slash if exists
if(substr($wad_url, -1)=='/') {
    $wad_url = substr($wad_url, 0, -1);
}

$wad_url_pieces = explode('/',$wad_url);

if( $wad_url=='home' )
{
	if( (is_admin() || is_assigner() ))
	{
		$wad_url = 'users';
	}
	else if( is_writer() || is_editor() )
	{
		$wad_url = 'orders';
	}
}
else if( $wad_url_pieces[0]=='orders' )
{
	if( !isset($wad_url_pieces[1]) ){ // /orders
		if( is_admin() || is_assigner() ){
			$wad_url = 'wad-orders/all';
		}
	}else{
		
		if( (is_writer() || is_editor())
			&& ( $wad_url_pieces[1]=='new'
				|| $wad_url_pieces[1]=='overdue'
				|| $wad_url_pieces[1]=='stuck'
				|| $wad_url_pieces[1]=='ready_to_edit'
				|| $wad_url_pieces[1]=='editor_revision'
				|| $wad_url_pieces[1]=='revision'
			)
		){
			$redirect_to_home = true;
		}
		
		$wad_url_pieces[0] = str_replace('orders','wad-orders',$wad_url_pieces[0]);
		$wad_url = implode('/',$wad_url_pieces);
	}
}
else if( $wad_url_pieces[0]=='cronjob' )
{
	$wad_url_pieces[0] = str_replace('cronjob','wad-cronjob',$wad_url_pieces[0]);
	$wad_url = implode('/',$wad_url_pieces);
}
else if( $wad_url_pieces[0]=='stats' )
{
	if( is_admin() )
	{
		if( !isset($wad_url_pieces[1]) ){ // /stats
			$wad_url = 'wad-stats/writers';
		}else{
			$wad_url_pieces[0] = str_replace('stats','wad-stats',$wad_url_pieces[0]);
			$wad_url = implode('/',$wad_url_pieces);
		}
	}else{
		$redirect_to_home = true;
	}
}
else if( $wad_url_pieces[0]=='users' )
{
	if( is_admin() || is_assigner() )
	{
		
		if( isset($wad_url_pieces[1]) ){
			$wad_url_pieces[0] = str_replace('users','wad-users',$wad_url_pieces[0]);
			$wad_url = implode('/',$wad_url_pieces);
		}
		
		if( isset($wad_url_pieces[1]) && $wad_url_pieces[1]=='edit' ){ // /users/edit
			// if( is_admin() ){
				$wad_url = $wad_url_pieces[0].'/'.$wad_url_pieces[1];
			// }else{
				// $redirect_to_home = true;
			// }
		}

		if( isset($wad_url_pieces[1]) && $wad_url_pieces[1]=='add' ){ // /users/add
			// if( is_admin() ){
				$wad_url = $wad_url_pieces[0].'/'.$wad_url_pieces[1];
			// }else{
				// $redirect_to_home = true;
			// }
		}
	}else{
		$redirect_to_home = true;
	}
}
else if( $wad_url_pieces[0]=='settings' )
{
	if( is_writer() || is_editor() ){
		$redirect_to_home = true;
	}
	$wad_url_pieces[0] = str_replace('settings','wad-settings',$wad_url_pieces[0]);
	$wad_url = implode('/',$wad_url_pieces);
	
	if( $wad_url=='wad-settings')
		$wad_url = 'settings';
	
}

if( $redirect_to_home )
header("Location: ".BASE_URL);

// checking into url, webhook or cronjob 
$webhook = strpos($wad_url, 'webhook');
$cronjob = strpos($wad_url, 'wad-cronjob');
$neither_webhook_nor_cronjob_url = $webhook === false && $cronjob === false;

if($neither_webhook_nor_cronjob_url)
{
	$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT']==443) ? "https://" : "http://";  
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
			$redirect_url = BASE_URL."/login";
			if( $request_uri != BASE_URL.'/' ){
				$redirect_url .= "?redirect_to=".urlencode($request_uri);
			}
			header("Location: ".$redirect_url);
			die();
		}
	}
}

if( wad_get_option('send_emails')=='yes' ) 
{	
	require 'PHPMailer/src/Exception.php';
	require 'PHPMailer/src/PHPMailer.php';
	require 'PHPMailer/src/SMTP.php';

	// Email new orders daily
	// wad_send_new_created_orders_email();

	// wad_send_new_submitted_orders_email();
	
	
	// Email for working orders within last 6 hours.
	if( SITE_MOD=='Live' )
	wad_send_email_for_working_orders();
	
}

if( wad_get_option('reject_order')=='yes' )
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
	
	// Logout account if archive
	$is_archive = $globals['current_user']['is_archive'];
	if( $is_archive )
	{
		setCookie('wad_user_logged_in',false, strtotime( '+10 years' ));
		setCookie('wad_user_logged_in_spp_id',false, strtotime( '+10 years' ));
		
		header("Location: ".BASE_URL);
	}
	
}

$file = $wad_url.'.php';

if( ! file_exists($file) ){
	
	echo "$wad_url <br />Something wrong or 404 Not Found";
	die();
}

require $file;