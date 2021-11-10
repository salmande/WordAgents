<?php
define('DB_SERVER','localhost');
define('DB_USER','unn1eg6cyutzh');
define('DB_PASS' ,'9Rc-G=M2tG');
define('DB_NAME', 'dbmgq02ndwz2wv');
$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>