<?php
define('DB_SERVER','localhost');
define('DB_USER','wordagen.db.a67f');
define('DB_PASS' ,'lT)9dJ]3rI!2');
define('DB_NAME', 'team');
$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>