<?php
include '../function.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Ambil data JSON dari body
  $data = json_decode(file_get_contents("php://input"), true);

  $id = $data['id'] ?? null;
  $status = $data['status'] ?? null;

  // Validasi data
  $allowed_status = ['dimasak', 'pending' , 'selesai'];

  if (!$id || !$status || !in_array($status, $allowed_status)) {
    http_response_code(400);
    echo json_encode([
      "success" => false,
      "message" => "Data tidak valid"
    ]);
    exit;
  }

  // Update status pesanan
  $stmt = $con->prepare("UPDATE orders SET status = ? WHERE id = ?");
  $stmt->bind_param("si", $status, $id);

  if ($stmt->execute()) {
    echo json_encode([
      "success" => true,
      "message" => "Status berhasil diperbarui"
    ]);
  } else {
    http_response_code(500);
    echo json_encode([
      "success" => false,
      "message" => "Gagal memperbarui status"
    ]);
  }
} else {
  http_response_code(405);
  echo json_encode([
    "success" => false,
    "message" => "Metode tidak diizinkan"
  ]);
}
?>
