<!DOCTYPE html>
<html>
<body>

<?php
$conn = new mysqli("localhost", "root", "", "test", "3306");

if(! $conn ) {
   die('Could not connect: ' . mysql_error());
}

echo "Connected successfully\n";

$sql = 'CREATE Database test_db';
$retval = $conn->query("CREATE DATABASE something");

if(! $retval ) {
   die('Could not create database: ' . mysql_error());
}

echo "Database test_db created successfully\n";
mysql_close($conn);
?>
</body>

</html>
