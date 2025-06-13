<?php

session_start();

// Memastikan user login terlebih dahulu
if (empty($_SESSION['user'])) {
  header("Location: ../auth/login.php");
  exit;
}

// Menghubungkan ke database
require '../function.php';

// $result = read('SELECT * FROM ')

// Mendapatkan data pengguna berdasarkan session
$query = mysqli_query($con, "SELECT email FROM users WHERE email = '{$_SESSION['user']['email']}'");

// Mengecek apakah query berhasil dan ada hasil
if ($query && mysqli_num_rows($query) > 0) {
  if ($row = mysqli_fetch_assoc($query)) {
    $username = $row['email']; // Menyimpan username ke dalam variabel
  }
} else {
  // Jika tidak ada data, arahkan ke halaman login
  header("Location: ../auth/login.php");
  exit;
}


$tanggalFilter = isset($_GET['tanggal']) ? $_GET['tanggal'] : null;

$queryHistori = "SELECT 
    orders.id AS order_id,
    orders.user_id AS user_id,
    orders.image AS order_image,
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


$cart_items = read($queryHistori);

$grouped_orders = [];

foreach ($cart_items as $item) {
  $order_id = $item['order_id'];

  if (!isset($grouped_orders[$order_id])) {
    $grouped_orders[$order_id] = [
      'order_status' => $item['order_status'],
      'order_total' => $item['order_total'],
      'user_name' => $item['user_name'],
      'order_image' => $item['order_image'],
      'order_date' => $item['order_date'],
      'menus' => [],
    ];
  }

  $grouped_orders[$order_id]['menus'][] = [
    'name' => $item['menu_name'],
    'quantity' => $item['cart_quantity'],
    'price' => $item['menu_price'],
  ];

  $orders_by_date = [];

  foreach ($grouped_orders as $id => $order) {
    $date = date("Y-m-d", strtotime($order['order_date']));
    if (!isset($orders_by_date[$date])) {
      $orders_by_date[$date] = [];
    }
    $orders_by_date[$date][$id] = $order;
  }

}


// var_dump($cart_items)


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>History Admin</title>
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script>
    const update = (event) => {
      const selectedValue = event.value
      const id = event.dataset.id
      // console.log(id, selectedValue)
      // const formData = new FormData()
      // formData.append('status', selectedValue)
      // formData.append('id', id)

      const url = 'updateStatus.php';
      fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          status: selectedValue,
          id: id
        })
      }).then(response => response.text()).then(data => {
        try {
          console.log(JSON.parse(data));
        } catch (e) {
          console.error('Error parsing JSON:', data);
        }
      })
    }
  </script>
</head>

<body style="background-color: #27262b; color: #fff;">
  <?php include '../Component/admin/header.php' ?>


  <div class="container mt-3">
    <div class="row">
      <?php include '../Component/sidebar.php' ?>
      <div class="col-md-9">
        <form method="GET" class="mb-4">
          <div class="row g-2 align-items-center">
            <div class="col-auto">
              <label for="tanggal" class="col-form-label">Filter Tanggal:</label>
            </div>
            <div class="col-auto">
              <input type="date" id="tanggal" name="tanggal" class="form-control"
                value="<?= htmlspecialchars($_GET['tanggal'] ?? '') ?>">
            </div>
            <div class="col-auto">
              <button type="submit" class="btn btn-primary">Tampilkan</button>
              <?php if (isset($_GET['tanggal'])): ?>
                <a href="?" class="btn btn-secondary">Reset</a>
              <?php endif; ?>
            </div>
          </div>
        </form>

        <table class="table table-dark table-striped" style="width: 100%;">
          <thead>
            <tr>
              <th scope="col">Username</th>
              <th scope="col">Detail Pesanan</th>
              <th scope="col">Total</th>
              <th scope="col">Tanggal</th>
              <th scope="col">Detail</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($grouped_orders as $order_id => $order): ?>
              <tr>
                <td><?= $order['user_name'] ?></td>
                <td>
                  <?php foreach ($order['menus'] as $menu): ?>
                    <div>
                      <?= $menu['name'] ?> x <?= $menu['quantity'] ?> (Rp <?= number_format($menu['price'], 0, ',', '.') ?>)
                    </div>
                  <?php endforeach; ?>
                </td>
                <td>Rp. <?= number_format($order['order_total'], 0, ',', '.') ?></td>
                <td><?= (new DateTime($order['order_date']))->format('d F Y') ?></td>
                <td>
                  <button type="button" class="btn btn-info" data-bs-toggle="modal"
                    data-bs-target="#modal<?= $order_id ?>">
                    Selengkapnya
                  </button>

                  <div class="modal fade" id="modal<?= $order_id ?>" tabindex="-1"
                    aria-labelledby="modalLabel<?= $order_id ?>" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" style="color: #000;" id="modalLabel<?= $order_id ?>">
                            Detail Pesanan #<?= $order_id ?>
                          </h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <p style="color: #000;">Username: <?= $order['user_name'] ?></p>
                          <p style="color: #000;">Total: Rp. <?= number_format($order['order_total'], 0, ',', '.') ?></p>
                          <p style="color: #000;">Status: <?= $order['order_status'] ?></p>
                          <p style="color: #000;">Rincian Menu:</p>
                          <ul>
                            <?php foreach ($order['menus'] as $menu): ?>
                              <li style="color: #000;">
                                <?= $menu['name'] ?> x <?= $menu['quantity'] ?> (Rp
                                <?= number_format($menu['price'], 0, ',', '.') ?>)
                              </li>
                            <?php endforeach; ?>
                          </ul>
                          <p style="color: #000;">Bukti Pembayaran</p>
                          <img src="/img/<?= $order['order_image'] ?>" alt="Bukti Pembayaran"
                            style="width: 100%; max-width: 300px;">
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
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
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

</body>

</html>