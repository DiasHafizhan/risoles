<?php
session_start();

if (empty($_SESSION['user'])) {
  header("Location: ../auth/login.php");
  exit;
}

require '../function.php';

$query = mysqli_query($con, "SELECT email FROM users WHERE email = '{$_SESSION['user']['email']}'");

if ($query && mysqli_num_rows($query) > 0) {
  if ($row = mysqli_fetch_assoc($query)) {
    $username = $row['email'];
  }
} else {
  header("Location: ../auth/login.php");
  exit;
}

$queryHistori = "SELECT 
    orders.id AS order_id,
    orders.user_id AS user_id,
    orders.image AS order_image,
    orders.total AS order_total,
    orders.status AS order_status,
    users.nama AS user_name,
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
    users ON orders.user_id = users.id
JOIN 
    cart ON cart.id_order = orders.id
JOIN 
    menu ON menu.id = cart.id_menu
";

$cart_items = read($queryHistori);

$grouped_orders = [];

foreach ($cart_items as $item) {
  $order_id = $item['order_id'];

  if (!isset($grouped_orders[$order_id])) {
    $grouped_orders[$order_id] = [
      'order_status' => $item['order_status'],
      'cart_order_date' => $item['cart_order_date'],
      'order_total' => 0,
      'menus' => [],
      'user_name' => $item['user_name'],
      'order_image' => $item['order_image'],
    ];
  }

  $grouped_orders[$order_id]['menus'][] = [
    'name' => $item['menu_name'],
    'quantity' => $item['cart_quantity'],
    'price' => $item['menu_price'],
  ];

  $grouped_orders[$order_id]['order_total'] += $item['menu_price'] * $item['cart_quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Staff Kitchen</title>
  <link rel="stylesheet" href="../style.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />


</head>

<body style="background-color: #27262b; color: #fff;">
  <?php include '../Component/admin/header.php' ?>

  <div class="container mt-3">
    <h1>Dashboard Staff Kitchen</h1>
    <table class="table table-dark table-striped">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th>Username</th>
          <th>Detail Pesanan</th>
          <th>Total</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; ?>
        <?php foreach ($grouped_orders as $order_id => $order): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($order['user_name']) ?></td>
            <td>
              <?php foreach ($order['menus'] as $menu): ?>
                <div>
                  <?= htmlspecialchars($menu['name']) ?> (<?= $menu['quantity'] ?> x Rp.
                  <?= number_format($menu['price'], 0, ',', '.') ?>)
                </div>
              <?php endforeach ?>
            </td>
            <td>Rp. <?= number_format($order['order_total'], 0, ',', '.') ?></td>
            <td>
              <select class="form-select" data-id="<?= $order_id ?>" onchange="update(this)">
                <option value="dimasak" <?= $order['order_status'] === 'dimasak' ? 'selected' : '' ?>>Dimasak</option>
                <option value="selesai" <?= $order['order_status'] === 'selesai' ? 'selected' : '' ?>>Selesai</option>
              </select>

            </td>
            <td>
              <button class="btn btn-info" data-bs-toggle="modal"
                data-bs-target="#modal<?= $order_id ?>">Selengkapnya</button>

              <div class="modal fade" id="modal<?= $order_id ?>" tabindex="-1"
                aria-labelledby="modalLabel<?= $order_id ?>" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalLabel<?= $order_id ?>">Detail Pesanan #<?= $order_id ?></h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="color: #000;">
                      <!-- <p>Username: <?= htmlspecialchars($order['user_name']) ?></p>
                      <p>Total: Rp. <?= number_format($order['order_total'], 0, ',', '.') ?></p>
                      <p>Status: <?= $order['order_status'] ?></p> -->
                      <p>Bukti Pembayaran:</p>
                      <img src="/img/<?= $order['order_image'] ?>" alt="Bukti Pembayaran"
                        style="width: 100%; max-width: 300px;">
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>

  </div>


  <script>
    const update = (el) => {
      const selectedValue = el.value;
      const id = el.dataset.id;

      console.log("Data terkirim:", { id, selectedValue });

      fetch('../admin/updateStatus.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ status: selectedValue, id: id })
      })
        .then(response => {
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          return response.json();
        })
        .then(data => {
          if (data.success) {
            alert("Status berhasil diubah ke: " + selectedValue);
          } else {
            alert("Gagal mengubah status: " + (data.message || "Error tidak diketahui"));
          }
        })
        .catch(err => {
          console.error("Fetch error:", err);
          alert("Terjadi kesalahan jaringan atau server.");
        });

    };


  </script>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>