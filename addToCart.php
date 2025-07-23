<?php
session_start();
include 'dataBase.php';

if(isset($_POST['product_id'])) {
  $id = $_POST['product_id'];
  $query = "SELECT * FROM tbl_products WHERE id = " . intval($id);
  $result = $conn->query($query);

  if($result && $result->num_rows > 0) {
    $product = $result->fetch_assoc();

    if(isset($_SESSION['cart']) && isset($_SESSION['cart'][$id])) {
      $existingQuantity = $_SESSION['cart'][$id]['quantity'];
      $_SESSION['cart'][$id]['quantity'] = $existingQuantity + 1;
    } else {
      if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
      }

      $newItem = array();
      $newItem['id'] = $product['id'];
      $newItem['product_name'] = $product['product_name'];
      $newItem['product_price'] = $product['product_price'];
      $newItem['product_image'] = $product['product_image'];
      $newItem['quantity'] = 1;
      $_SESSION['cart'][$id] = $newItem;
    }
  }
}

header("Location: index.php");
exit;
