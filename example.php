<?php
// Mulai sesi dan panggil fungsi
session_start();
require 'function.php';

// Ambil user ID dari sesi
$user_id = $_SESSION['user']['id'];

// Jumlah data per halaman
$data_per_page = 5;

// Ambil halaman saat ini (default ke 1 jika tidak ada parameter "page" di URL)
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

// Hitung offset
$offset = ($page - 1) * $data_per_page;

// Query dengan limit dan offset
$query = "SELECT 
    orders.id AS order_id,
    orders.user_id AS user_id,
    orders.image AS order_image,
    orders.total AS order_total,
    orders.status AS order_status,
    cart.id AS cart_id,
    cart.id_menu AS cart_menu_id,
    cart.kuantitas AS cart_quantity,
    cart.total AS cart_total,
    cart.orderDate AS cart_order_date,
    menu.name AS menu_name,
    menu.price AS menu_price,
    menu.image AS menu_image
FROM 
    orders
JOIN 
    cart 
ON 
    orders.id = cart.id_order
JOIN 
    menu 
ON 
    cart.id_menu = menu.id
WHERE 
    orders.user_id = $user_id
LIMIT $offset, $data_per_page";

$cart_items = read($query);

// Hitung total data
$total_query = "SELECT COUNT(*) AS total FROM orders WHERE user_id = $user_id";
$total_result = read($total_query);
$total_data = $total_result[0]['total'];

// Hitung total halaman
$total_pages = ceil($total_data / $data_per_page);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Pesanan</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body style="background-color: #27262b; color: white;">
  <div class="container mt-5">
    <h2>Riwayat Pesanan</h2>
    <table class="table table-dark table-striped">
      <thead>
        <tr>
          <th>Produk</th>
          <th>Total</th>
          <th>Tanggal Order</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($cart_items)): ?>
          <?php foreach ($cart_items as $item): ?>
            <tr>
              <td>
                <img src="/img/<?= $item['menu_image'] ?>" alt="" style="width: 100px;">
                <p><?= $item['menu_name'] ?></p>
              </td>
              <td><?= $item['menu_price'] * $item['cart_quantity'] ?></td>
              <td><?= (new DateTime($item['cart_order_date']))->format('d F Y') ?></td>
              <td><span class="btn btn-warning"><?= $item['order_status'] ?></span></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="4">Tidak ada data</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>

    <!-- Pagination -->
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center">
        <!-- Tombol Previous -->
        <?php if ($page > 1): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?= $page - 1; ?>">Previous</a>
          </li>
        <?php else: ?>
          <li class="page-item disabled">
            <a class="page-link" href="#">Previous</a>
          </li>
        <?php endif; ?>

        <!-- Nomor Halaman -->
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
          <li class="page-item <?= $i == $page ? 'active' : ''; ?>">
            <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
          </li>
        <?php endfor; ?>

        <!-- Tombol Next -->
        <?php if ($page < $total_pages): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?= $page + 1; ?>">Next</a>
          </li>
        <?php else: ?>
          <li class="page-item disabled">
            <a class="page-link" href="#">Next</a>
          </li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>