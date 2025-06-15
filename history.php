<?php

session_start();
require 'function.php';

$user = $_SESSION['user'];

$user_id = $user['id'];

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
    orders.user_id IS NOT NULL
    AND orders.user_id = $user_id
ORDER BY 
    orders.id DESC";


$cart_items = read($query);

$grouped_orders = [];

foreach ($cart_items as $item) {
  $order_id = $item['order_id'];

  if (!isset($grouped_orders[$order_id])) {
    $grouped_orders[$order_id] = [
      'order_status' => $item['order_status'],
      'cart_order_date' => $item['cart_order_date'],
      'menus' => [],
      'order_total' => 0,
    ];
  }

  $grouped_orders[$order_id]['menus'][] = [
    'name' => $item['menu_name'],
    'quantity' => $item['cart_quantity'],
    'price' => $item['menu_price'],
  ];

  $grouped_orders[$order_id]['order_total'] += $item['menu_price'] * $item['cart_quantity'];
}


// var_dump($cart_items);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Pesanan</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body style="background-color: #27262b; color: white;">
  <?php include 'Component/header.php' ?>

  <div class="container">
    <div class="row flex justify-between" style="margin-top: 20px;">
      <div class="">
        <table class="table table-dark table-striped" style="width: 100%;">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Produk</th>
              <th scope="col">Total</th>
              <th scope="col">Date order</th>
              <th scope="col">Status</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1;
            foreach ($grouped_orders as $order): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td>
                  <?php foreach ($order['menus'] as $menu): ?>
                    <div>
                      <?= $menu['name'] ?> (<?= $menu['quantity'] ?> x Rp.
                      <?= number_format($menu['price'], 0, ',', '.') ?>)
                    </div>
                  <?php endforeach ?>
                </td>

                <td>
                  Rp. <?= number_format($order['order_total'], 0, ',', '.') ?>
                </td>

                <td><?= (new DateTime($order['cart_order_date']))->format('d F Y') ?></td>

                <td>
                  <?php
                  $status = strtolower($order['order_status']);
                  $btn_class = match ($status) {
                    'dimasak' => 'btn-warning',
                    'selesai' => 'btn-success',
                    default => 'btn-danger'
                  };
                  ?>
                  <p class="btn <?= $btn_class ?>"><?= ucfirst($status) ?></p>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>

        </table>

      </div>
    </div>
  </div>

  <?php include 'Component/footer.php' ?>




  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>