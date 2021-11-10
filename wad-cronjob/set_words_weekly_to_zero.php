<?php

$baseDIR = '/home/customer/www/team.wordagents.com/public_html';
require $baseDIR . '/constants.php';
require $baseDIR . '/db_connection.php';
require $baseDIR . '/functions.php';

wad_update_query("users","words_weekly='0'", "role='Writer' || role='Editor'");