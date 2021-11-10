<?php

$baseDIR = '/home/customer/www/team.wordagents.com/public_html';

require $baseDIR.'/PhpSpreadsheet/vendor/autoload.php';

require $baseDIR . '/constants.php';
require $baseDIR . '/db_connection.php';
require $baseDIR . '/functions.php';
require $baseDIR . '/globals.php';

$report_link = wad_writers_weekly_stats();

// zap link: https://zapier.com/app/editor/136584871
$post = array(
	'report_link' => $report_link,
	'folder_name' => 'Writers'
);
$curl_url = "https://hooks.zapier.com/hooks/catch/8157470/bh1sk69/";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$curl_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
$r = curl_exec($ch);

?>