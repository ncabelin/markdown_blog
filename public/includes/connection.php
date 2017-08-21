<?php
$server = 'localhost';
$db_username = 'root';
$db_password = 'root';
$db = 'markdown';

$conn = mysqli_connect($server, $db_username, $db_password, $db);

if (!$conn) {
  die('Connection failed');
}

 ?>
