<?php
include 'medoo.php';
$db = new medoo([
	'database_type' => 'mysql',
	'database_name' => 'r1i2n3g4pro',
	'server' => '192.168.1.7',
	'username' => 'ring',
	'password' => 'anh1dr1do',
	'charset' => 'utf8',
	'port' => 3306,
	'option' => [ PDO::ATTR_CASE => PDO::CASE_NATURAL]
]);
require 'global.php';
?>