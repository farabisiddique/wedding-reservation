<?php
include './env.php';
$servername = HOSTNAME;
$dbusername = DB_USER;
$dbpassword = DB_PASS;
$dbname = DB_NAME;

try {
    // Create connection using PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "hh";
}
