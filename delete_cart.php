<?php
session_start();
require 'function.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $cart_id = $_POST['cartId'];
  $user_id = $_SESSION['user_id'];

  // Total harga
  $total_price = $menu_price * $quantity;

  // Tambahkan ke database
  $query = "DELETE FROM cart WHERE id = $cart_id;";
  mysqli_query($con, $query);
  $result = mysqli_affected_rows($con);

  if ($result) {
    header("Location: menu.php");
    exit;
  } else {
    echo "Gagal menambahkan ke keranjang.";
  }
}
