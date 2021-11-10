<?php

$baseDIR = '/home/customer/www/team.wordagents.com/public_html';

require $baseDIR.'/PhpSpreadsheet/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require $baseDIR . '/constants.php';
require $baseDIR . '/db_connection.php';
require $baseDIR . '/functions.php';

if( wad_get_option('send_emails') == 'yes' ){
	
	require $baseDIR . '/PHPMailer/src/Exception.php';
	require $baseDIR . '/PHPMailer/src/PHPMailer.php';
	require $baseDIR . '/PHPMailer/src/SMTP.php';
	
	wad_send_new_submitted_orders_email();
}
?>