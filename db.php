<?php
// $host = "sql201.infinityfree.com";
// $username = "if0_37607015"; // your MySQL username
// $password = "khattab2005"; // your MySQL password
// $dbname = "if0_37607015_test01"; // your database name

$host = "localhost";
$username = "abdo01"; // your MySQL username
$password = "Aa@123"; // your MySQL password
$dbname = "test01"; // your database name



$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
