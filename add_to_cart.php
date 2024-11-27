<?php
session_start();
require 'function.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $menu_id = $_POST['menu_id'];
  $menu_name = $_POST['menu_name'];
  $menu_price = $_POST['menu_price'];
  $quantity = $_POST['kuantiti'];
  $user_id = $_SESSION['user_id'];

  // Total harga
  $total_price = $menu_price * $quantity;

  // Tambahkan ke database
  $query = "INSERT INTO cart (id_user, id_menu, kuantitas, total) VALUES ($user_id, $menu_id, $quantity, $total_price)";
  mysqli_query($con, $query);
  $result = mysqli_affected_rows($con);

  if ($result) {
    header("Location: menu.php");
    exit;
  } else {
    echo "Gagal menambahkan ke keranjang.";
  }
}
