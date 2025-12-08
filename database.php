<?php
$host = "localhost";
$dbname = "shifttrack";
$user = "root";
$pass = "";

try {
    $connection = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",$user,$pass);
} catch (PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());
}
?>
