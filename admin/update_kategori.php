<?php
include '../function.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $kategori = $_POST['kategori'];

  $allowed = ['admin', 'kitchen', 'kasir'];
  if (!in_array($kategori, $allowed)) {
    http_response_code(400);
    echo "Kategori tidak valid.";
    exit;
  }

  $stmt = $con->prepare("UPDATE users SET kategori = ? WHERE id = ?");
  $stmt->bind_param("si", $kategori, $id);

  if ($stmt->execute()) {
    echo "Kategori berhasil diupdate.";
  } else {
    http_response_code(500);
    echo "Gagal memperbarui kategori.";
  }
}
