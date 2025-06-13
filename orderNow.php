<?php
session_start();
require 'function.php';

// Asumsikan user login memiliki id tersimpan di session sebagai 'user_id'
$user = $_SESSION['user'];
$user_id = $user['id'];


// Mengambil data produk dan kuantitas dari keranjang
$query = "SELECT menu.id AS menu_id, cart.id AS cart_id, cart.id_order, menu.name, menu.description, menu.price, menu.image, menu.type, cart.kuantitas, cart.total, cart.orderDate
          FROM cart
          JOIN menu ON cart.id_menu = menu.id
          WHERE cart.id_user = $user_id AND cart.id_order IS NULL";


$cart_items = read($query);



if (!empty($cart_items) && isset($cart_items[0]['orderDate'])) {
  $orderDate = $cart_items[0]['orderDate'];
  $dateOnly = (new DateTime($orderDate))->format('d F Y');
} else {
  $orderDate = null; // Atur default jika tidak ada data
  $dateOnly = '';
}

if (isset($_POST['submit'])) {
  // var_dump($_POST);
  if (order($_POST)) {
    header('location: index.php');
  } else {
    echo "Gagal";
  }
}


$isLoggedIn = isset($_SESSION['login']) && $_SESSION['login'] === true;
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order | Risoles</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body style="background-color: #27262b; color: #fff;">
  <?php include 'Component/header.php' ?>


  <div class="container mt-4">

    <div class="flex justify-between items-center mb-3">
      <h2>User : <?= $user['nama'] ?></h2>
      <a href="" class="no-underline rounded-lg" style="color: #ffbc01; border: 1px #8e8d94 solid; padding: 5px;"><i
          class='bx bxs-shopping-bag'></i> Invoce
      </a>
    </div>
    <p><span style="color: #8e8d94;">Order Date</span> : <?= $dateOnly ?></p>
    <hr>

    <div class="mt-3" style="margin-bottom: 50px;">
      <div id="data_container" data-array='<?php echo json_encode($cart_items); ?>'></div>
      <?php foreach ($cart_items as $item): ?>
        <div class="mb-3 flex justify-between items-center">
          <div class="flex gap-2 items-center">
            <img src="img/<?= $item['image'] ?>" alt="" style="width: 100px;">
            <div class="">
              <p style="margin-bottom: 0;"><?= $item['name'] ?></p>
              <p style="margin-bottom: 0; color: #8e8d94;"><?= $item['type'] ?></p>
            </div>
          </div>
          <div class="">
            <p style="margin-bottom: 0;">
              Rp. <?= number_format($item['price'], 0, ',', '.') ?>
            </p>
            <p style="margin-bottom: 0;color: #8e8d94; text-align: end;">Qty: <?= $item['kuantitas'] ?></p>
          </div>
        </div>
      <?php endforeach ?>
      <hr>
      <p style="font-size: 20px; text-align: end;" id="orderTotal">
        Total : Rp. <?= number_format($item['price'], 0, ',', '.') ?>
      </p>
    </div>

    <h1 class="text-center mb-5">How to Pay</h1>
    <div class="flex text-center rounded-lg"
      style="background-color: #1d1d1d; color: #ffffff; width: 100%; margin-bottom: 50px;">
      <div style="width: 33.3%; padding: 50px 0; border-right: 1px solid #8e8d94;">
        <i style="font-size: 40px; margin-bottom: 10px; font-weight:600;" class='bx bx-qr'></i>
        <p style="margin-bottom: 5px; font-size: 20px; font-weight:600;">Scan QR</p>
        <p style="max-width: 250px; color: #8e8d94;" class="mx-auto">
          Scan the QR code to complete your transaction quickly and securely.
        </p>
      </div>
      <div style="width: 33.3%; padding: 50px 0; border-right: 1px solid #8e8d94;">
        <i style="font-size: 40px; margin-bottom: 10px; font-weight:600;" class='bx bx-image'></i>
        <p style="margin-bottom: 5px; font-size: 20px; font-weight:600;">Screen Shot</p>
        <p style="max-width: 250px; color: #8e8d94;" class="mx-auto">
          Take a screenshot of the payment page for your records or confirmation.
        </p>
      </div>
      <div style="width: 33.3%; padding: 50px 0;">
        <i style="font-size: 40px; margin-bottom: 10px; font-weight:600;" class='bx bx-cart-alt'></i>
        <p style="margin-bottom: 5px; font-size: 20px; font-weight:600;">Pickup</p>
        <p style="max-width: 250px; color: #8e8d94;" class="mx-auto">
          pickup after completing your payment process.
        </p>
      </div>
    </div>


    <h2>Upload Screenshot</h2>
    <form action="" method="POST" enctype="multipart/form-data">
      <div style="border: dashed 1px #8e8d94; padding: 40px 0;" class="flex justify-center items-center">
        <input type="file" name="image">
        <input type="text" name="total" id="totalOrder" class="hidden">
        <input type="text" name="userId" id="userId" class="hidden" value="<?= $user['id'] ?>">
      </div>
      <!-- Button trigger modal -->
      <button type="button" class="w-full btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Qr Code
      </button>
      <button class="w-full btn btn-success" type="submit" name="submit">Order</button>
    </form>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-black">
            <h1 class="text-center text-3xl font-bold" style="margin-bottom: 20px;">QRIS</h1>
            <img src="./img/qris.png" alt="" style="width: 200px; margin: auto;">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger w-full" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>




  <!-- Footer start -->
  <?php include "./Component/footer.php" ?>
  <!-- Footer end -->




  <script>
    const dataContainer = document.getElementById('data_container');
    let phpArray = JSON.parse(dataContainer.getAttribute('data-array'));

    const orderTotal = document.getElementById('orderTotal')
    const totalInput = document.getElementById('totalOrder')
    let hasExecute = false
    let total = 0
    document.addEventListener("DOMContentLoaded", function () {
      if (hasExecute == false) {
        console.log(phpArray)
        phpArray.forEach(item => {
          total += item.kuantitas * item.total;
        });
        orderTotal.textContent = total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
        totalInput.value = total
      }
      hasExecute = true
    })
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

</body>

</html>