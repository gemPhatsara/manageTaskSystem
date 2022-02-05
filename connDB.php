<?php 

$serverName = '127.0.0.1';
$userName = 'root';
$userPassword = '';
$dbName = 'managesystem';
try{
	// $conn = new PDO("sqlsrv:server=$serverName ; Database = $dbName", $userName, $userPassword);
	// $conn = new PDO("mysql:dbname={$dbName};host=($serverName}", $userName, $userPassword);
	// $conn = mysqli_connect("127.0.0.1", "root", "", $dbName);
	$conn=new PDO("mysql:dbname=$dbName;host=$serverName",$userName,$userPassword);
	// $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e){
	die(print_r($e->getMessage()));
}
?>