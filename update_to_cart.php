<?php
session_start();
require 'function.php';

if (!isset($_SESSION['user'])) {
  header("Location: ./auth/login.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $cart_id = (int) $_POST['cart_id'];
  $action = $_POST['action']; // increment / decrement

  // Ambil data cart & menu terkait
  $stmt = $con->prepare("SELECT c.kuantitas, m.id AS menu_id, m.price, m.stock 
                           FROM cart c JOIN menu m ON c.id_menu = m.id 
                           WHERE c.id = ?");
  $stmt->bind_param("i", $cart_id);
  $stmt->execute();
  $stmt->bind_result($current_qty, $menu_id, $price, $stock);
  $stmt->fetch();
  $stmt->close();

  if ($action == 'increment') {
    if ($stock <= 0) {
      echo "Stok tidak cukup";
      exit;
    }

    $new_qty = $current_qty + 1;

    // Kurangi stok
    $con->query("UPDATE menu SET stock = stock - 1 WHERE id = $menu_id");
  } elseif ($action == 'decrement') {
    if ($current_qty <= 1) {
      echo "Kuantitas tidak boleh kurang dari 1";
      exit;
    }

    $new_qty = $current_qty - 1;

    // Tambah stok kembali
    $con->query("UPDATE menu SET stock = stock + 1 WHERE id = $menu_id");
  } else {
    exit;
  }

  $new_total = $new_qty * $price;

  // Update cart
  $stmt = $con->prepare("UPDATE cart SET kuantitas = ?, total = ? WHERE id = ?");
  $stmt->bind_param("iii", $new_qty, $new_total, $cart_id);
  $stmt->execute();
  $stmt->close();

  echo "success";
}
?>