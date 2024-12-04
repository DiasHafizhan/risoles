<?php
session_start();
require 'function.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['user'])) {
  header("Location: ./auth/login.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Pastikan parameter yang diterima adalah nilai tunggal
$menu_id = $_POST['menu_id']; // Harus integer
$menu_name = $_POST['menu_name']; // Harus string
$menu_price = $_POST['menu_price']; // Harus integer
$quantity = $_POST['kuantiti']; // Harus integer
$user_id = $_SESSION['user']['id']; // Harus integer

// Cek apakah variabel-variabel tersebut bukan array
if (is_array($menu_id) || is_array($menu_name) || is_array($menu_price) || is_array($quantity)) {
    die('Input tidak valid, ada array yang dikirim.');
}

$total_price = $menu_price * $quantity;

// Siapkan query untuk memasukkan data ke keranjang
$stmt = $con->prepare("INSERT INTO cart (id_user, id_menu, kuantitas, total) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiii", $user_id, $menu_id, $quantity, $total_price);

if ($stmt->execute()) {
    header("Location: menu.php?status=success");
    exit;
} else {
    echo "Gagal menambahkan ke keranjang: " . $stmt->error;
}

}
