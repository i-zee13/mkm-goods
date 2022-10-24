<?php 
$servername = "localhost";
$username = "junaid";
$password = "Snakebite76253";
$dbname = "import_export";

if($_SERVER['SERVER_NAME'] == "import-export.debug"){
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "import-export";
}

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
