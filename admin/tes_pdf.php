<?php
ob_start(); // Hindari output awal


require_once __DIR__ . '/../vendor/autoload.php';
require '../function.php';

$tanggalFilter = isset($_GET['tanggal']) ? $_GET['tanggal'] : null;

$queryHistori = "SELECT 
    orders.id AS order_id,
    orders.user_id AS user_id,
    orders.total AS order_total,
    orders.status AS order_status,
    users.nama AS user_name,
    menu.name AS menu_name,
    order_items.quantity AS cart_quantity,
    order_items.created_at AS order_date,
    menu.price AS menu_price
FROM 
    orders
JOIN 
    users ON orders.user_id = users.id
JOIN 
    order_items ON order_items.order_id = orders.id
JOIN 
    menu ON order_items.menu_id = menu.id";

if ($tanggalFilter) {
  $queryHistori .= " WHERE DATE(order_items.created_at) = '$tanggalFilter'";
}

$queryHistori .= " ORDER BY order_items.created_at DESC";

$cart_items = read($queryHistori);

// Grupkan pesanan
$grouped_orders = [];

foreach ($cart_items as $item) {
  $order_id = $item['order_id'];

  if (!isset($grouped_orders[$order_id])) {
    $grouped_orders[$order_id] = [
      'order_status' => $item['order_status'],
      'order_total' => $item['order_total'],
      'user_name' => $item['user_name'],
      'order_date' => $item['order_date'],
      'menus' => [],
    ];
  }

  $grouped_orders[$order_id]['menus'][] = [
    'name' => $item['menu_name'],
    'quantity' => $item['cart_quantity'],
    'price' => $item['menu_price'],
  ];
}

// ==================== Hitung Total ====================
$total = 0;
foreach ($invoiceData['items'] as $item) {
    $total += $item['qty'] * $item['price'];
}

// ==================== Buat PDF ====================
$pdf = new TCPDF();
$pdf->SetCreator('Your Company');
$pdf->SetAuthor('Admin');
$pdf->SetTitle('Invoice');
$pdf->SetMargins(15, 20, 15);
$pdf->AddPage();

// ==================== HTML ====================
$html = '<h2 style="text-align:center;">Laporan Penjualan</h2>';

if ($tanggalFilter) {
  $html .= '<p>Tanggal: <strong>' . date('d F Y', strtotime($tanggalFilter)) . '</strong></p>';
}

$html .= '
<table border="1" cellpadding="5" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th>No</th>
      <th>Username</th>
      <th>Detail Menu</th>
      <th>Total</th>
      <th>Tanggal</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
';

$no = 1;
foreach ($grouped_orders as $order) {
  $menuDetail = '';
  foreach ($order['menus'] as $menu) {
    $menuDetail .= $menu['name'] . ' x ' . $menu['quantity'] . ' (Rp ' . number_format($menu['price'], 0, ',', '.') . ')<br>';
  }

  $html .= '<tr>
    <td>' . $no++ . '</td>
    <td>' . htmlspecialchars($order['user_name']) . '</td>
    <td>' . $menuDetail . '</td>
    <td>Rp ' . number_format($order['order_total'], 0, ',', '.') . '</td>
    <td>' . date('d-m-Y', strtotime($order['order_date'])) . '</td>
    <td>' . htmlspecialchars($order['order_status']) . '</td>
  </tr>';
}

$html .= '</tbody></table>';

// ==================== Tampilkan PDF ====================
$pdf->writeHTML($html, true, false, true, false, '');

ob_end_clean(); // Bersihkan output sebelumnya
$pdf->Output('invoice.pdf', 'I'); // Tampilkan PDF di browser
