<?php
// $host = "sql201.infinityfree.com";
// $username = "if0_37607015"; // your MySQL username
// $password = "khattab2005"; // your MySQL password
// $dbname = "if0_37607015_test01"; // your database name

$host = "localhost";
$username = "abdo01"; // your MySQL username
$password = "Aa@123"; // your MySQL password
$db = "test01"; // your database name

try{
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// Check connection
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    echo "Connection failed. Please try again later.";
}
?>
