<?php
$host = 'localhost';
$user = 'root';
$password = 'Root@123!';
$db = 'cart_products';
$conn = new mysqli($host, $user, $password, $db);

if($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
