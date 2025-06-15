<?php
session_start();
require 'function.php';

// Asumsikan user login memiliki id tersimpan di session sebagai 'user_id'
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$user_id = $user['id'] ?? null;

// Mengambil data produk dan kuantitas dari keranjang
if ($user_id) {
  $query = "SELECT menu.id AS menu_id, cart.id AS cart_id, cart.id_order, menu.name, menu.description, menu.price, menu.image, menu.type, cart.kuantitas, cart.total, cart.orderDate
            FROM cart
            JOIN menu ON cart.id_menu = menu.id
            WHERE cart.id_user = $user_id AND cart.id_order IS NULL";
  $cart_items = read($query);
} else {
  // Tampilkan error atau lakukan sesuatu jika user_id tidak ada

}

// Mendapatkan semua data produk untuk ditampilkan
$product = read('SELECT * FROM menu');

$isLoggedIn = isset($_SESSION['login']) && $_SESSION['login'] === true;
?>





<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body style="background-color: #27262b; color: whites;">
  <?php include 'Component/header.php' ?>


  <div class="container">
    <div class="row">
      <div class="col-8">
        <div style="background-color: #1A1A1D; color: #ffbc01; margin-top: 20px;">
          <h1 class="container">Bundle</h1>
        </div>

        <div class="container flex flex-wrap" style="gap: 25px;">
          <?php foreach ($product as $menu): ?>
            <?php if ($menu['type'] == 'Bundle'): ?>
              <div style="width: 48%;">
                <img src="./img/<?= $menu['image'] ?>" alt="" class="w-full rounded-lg">
                <h2 class="text-2xl" style="color: #ffbc01;"><?= $menu['name'] ?></h2>
                <p class="text-lg" style="color: white; font-weight: 600;">Rp.
                  <?= number_format($menu['price'], 0, ',', '.') ?>
                </p>
                <p style="color: white;">
                  Stock <span style="color: #ffbc01;"><?= $menu['stock'] ?></span>
                </p>

                <!-- Form untuk menambahkan ke keranjang -->
                <?php if ($menu['stock'] > 0): ?>
                  <form action="add_to_cart.php" method="POST">
                    <input type="hidden" name="menu_id" value="<?= $menu['id'] ?>">
                    <input type="hidden" name="menu_name" value="<?= $menu['name'] ?>">
                    <input type="hidden" name="menu_price" value="<?= $menu['price'] ?>">
                    <input type="hidden" name="kuantiti" value="1">
                    <button type="submit" class="btn btn-primary w-full rounded-3xl">Tambah ke Keranjang</button>
                  </form>
                <?php else: ?>
                  <button onclick="alert('Stok habis!')" class="btn btn-danger w-full rounded-3xl" disabled>
                    Stok Habis
                  </button>
                <?php endif; ?>
              </div>
            <?php endif ?>
          <?php endforeach ?>
        </div>

        <div style="background-color: #1A1A1D; color: #ffbc01; margin-top: 20px;">
          <h1 class="container">Makanan</h1>
        </div>

        <div class="container flex flex-wrap" style="gap: 25px;">
          <?php foreach ($product as $menu): ?>
            <?php if ($menu['type'] == 'Makanan'): ?>
              <div style="width: 48%;">
                <img src="./img/<?= $menu['image'] ?>" style="height: 205px;" alt="" class="w-full rounded-lg">
                <h2 class="text-2xl" style="color: #ffbc01;"><?= $menu['name'] ?></h2>
                <p class="text-lg" style="color: white; font-weight: 600;">Rp.
                  <?= number_format($menu['price'], 0, ',', '.') ?>
                </p>
                <p style="color: white;">
                  Stock <span style="color: #ffbc01;"><?= $menu['stock'] ?></span>
                </p>

                <!-- Form untuk menambahkan ke keranjang -->
                <?php if ($menu['stock'] > 0): ?>
                  <form action="add_to_cart.php" method="POST">
                    <input type="hidden" name="menu_id" value="<?= $menu['id'] ?>">
                    <input type="hidden" name="menu_name" value="<?= $menu['name'] ?>">
                    <input type="hidden" name="menu_price" value="<?= $menu['price'] ?>">
                    <input type="hidden" name="kuantiti" value="1">
                    <button type="submit" class="btn btn-primary w-full rounded-3xl">Tambah ke Keranjang</button>
                  </form>
                <?php else: ?>
                  <button onclick="alert('Stok habis!')" class="btn btn-danger w-full rounded-3xl" disabled>
                    Stok Habis
                  </button>
                <?php endif; ?>
              </div>
            <?php endif ?>
          <?php endforeach ?>
        </div>

        <div style="background-color: #1A1A1D; color: #ffbc01; margin-top: 20px;">
          <h1 class="container">Minuman</h1>
        </div>

        <div class="container flex flex-wrap" style="gap: 25px;">
          <?php foreach ($product as $menu): ?>
            <?php if ($menu['type'] == 'Minuman'): ?>
              <div style="width: 48%;">
                <img src="./img/<?= $menu['image'] ?>" style="height: 350px;" alt="" class="w-full rounded-lg">
                <h2 class="text-2xl" style="color: #ffbc01;"><?= $menu['name'] ?></h2>
                <p class="text-lg" style="color: white; font-weight: 600;">Rp.
                  <?= number_format($menu['price'], 0, ',', '.') ?>
                </p>
                <p style="color: white;">
                  Stock <span style="color: #ffbc01;"><?= $menu['stock'] ?></span>
                </p>

                <!-- Form untuk menambahkan ke keranjang -->
                <?php if ($menu['stock'] > 0): ?>
                  <form action="add_to_cart.php" method="POST">
                    <input type="hidden" name="menu_id" value="<?= $menu['id'] ?>">
                    <input type="hidden" name="menu_name" value="<?= $menu['name'] ?>">
                    <input type="hidden" name="menu_price" value="<?= $menu['price'] ?>">
                    <input type="hidden" name="kuantiti" value="1">
                    <button type="submit" class="btn btn-primary w-full rounded-3xl">Tambah ke Keranjang</button>
                  </form>
                <?php else: ?>
                  <button onclick="alert('Stok habis!')" class="btn btn-danger w-full rounded-3xl" disabled>
                    Stok Habis
                  </button>
                <?php endif; ?>
              </div>
            <?php endif ?>
          <?php endforeach ?>
        </div>
      </div>

      <!-- Keranjang -->
      <div class="col-4 rounded-lg"
        style="background-color: #1A1A1D; margin-top: 20px; height: 100vh; position: sticky; top: 80px;">
        <h2 class="text-center" style="color: #ffffff;">Keranjang</h2>
        <div style="border: 1px solid #8e8d94; margin-bottom: 20px;"></div>
        <div id="data_container" data-array='<?php echo json_encode($cart_items); ?>'></div>
        <!-- Items product -->
        <div id="cart-items">
          <?php if ($isLoggedIn): ?>
            <?php foreach ($cart_items as $item): ?>
              <div class="cart-item" data-name="<?= $item['name'] ?>">
                <div class="flex justify-between items-center">
                  <p class="text-lg" style="color: #ffbc01; font-weight: 600;"><?= $item['name'] ?></p>
                  <form action="delete_cart.php" method="POST">
                    <input type="text" class="hidden" name="cartId" value="<?= $item['cart_id'] ?>">
                    <button id="delete-cart" type="submit" style="color: red; font-size: 30px; font-weight: 600;"
                      data-id="<?= $item['cart_id'] ?>">
                      <i class='bx bx-x'></i>
                    </button>
                  </form>
                  <div class="hidden" id="keranjangid">
                    <?= $item['cart_id'] ?>
                  </div>
                </div>
                <div class="flex justify-between items-center" style="color: #ffffff;">
                  <p class="text-lg">Rp. <?= number_format($item['price'], 0, ',', '.') ?></p>
                  <div class="flex items-center">
                    <button class="rounded-lg flex justify-center items-center"
                      style="color: #000000; background-color: #ffffff; padding: 10px 10px; font-weight: 600;"
                      id="decrementBtn" data-id="<?= $item['cart_id'] ?>">
                      <i class='bx bx-minus'></i>
                    </button>
                    <div class="counter" id="<?php echo 'counterValue' . '-' . $item['cart_id']; ?>">
                      <?= $item['kuantitas'] ?>
                    </div>
                    <button class="rounded-lg flex justify-center items-center"
                      style="color: #000000; background-color: #ffffff; padding: 10px 10px; font-weight: 600;"
                      id="incrementBtn" data-id="<?= $item['cart_id'] ?>">
                      <i class='bx bx-plus'></i>
                    </button>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p style="color: white;" class="flex justify-center">Login untuk melihat keranjang Anda.</p>
          <?php endif ?>

        </div>
        <!-- Items product -->

        <!-- Total cart -->
        <div class="flex justify-between items-center rounded-3xl text-center p-2"
          style="border: 1px solid #8e8d94; margin-top: 20px;">
          <p class="m-0" style="color: #ffffff; font-weight: 600;">Total</p>
          <?php if ($isLoggedIn): ?>
            <?php
            $total = array_sum(array_column($cart_items, 'total'));
            ?>
            <p id="cart-total" class="m-0" style="color: #ffbc01; font-weight: 600;"></p>
          <?php else: ?>
            <p class="m-0" style="color: #ffbc01; font-weight: 600;">Rp. 0</p>
          <?php endif ?>
        </div>
        <!-- Total cart -->
        <?php if ($isLoggedIn): ?>
          <a href="orderNow.php" class="btn btn-primary w-full rounded-3xl" style="margin-top: 20px;">
            Pesan Sekarang
          </a>
        <?php else: ?>
          <a href="./auth/login.php" class="btn btn-primary w-full rounded-3xl" style="margin-top: 20px;">
            Pesan Sekarang
          </a>
        <?php endif ?>
      </div>

      <!-- Keranjang -->

    </div>


  </div>

  <!-- footer start -->
  <?php include "./Component/footer.php" ?>
  <!-- footer end -->




  <script>

    // Mendapatkan elemen-elemen tombol dan counter
    const dataContainer = document.getElementById('data_container');
    let phpArray = JSON.parse(dataContainer.getAttribute('data-array'));
    const incrementBtn = document.querySelectorAll('#incrementBtn');
    const decrementBtns = document.querySelectorAll('#decrementBtn');

    const cartTotal = document.getElementById('cart-total')
    let total = 0;
    let hasExecute = false
    function updateQuantitas(id, quantitas) {
      phpArray.forEach(item => {
        if (item.cart_id === id) {
          item.kuantitas = quantitas;
        }
      });
    }
    document.addEventListener("DOMContentLoaded", function () {
      console.log(incrementBtn)
      if (hasExecute == false) {
        console.log('test')
        phpArray.forEach(item => {
          total += item.kuantitas * item.total;
        });
        cartTotal.textContent = total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
      }
      hasExecute = true

      incrementBtn.forEach((incrementBtn) => {
        let keranjangid = incrementBtn.getAttribute('data-id');
        // Fungsi untuk menambah nilai
        incrementBtn.addEventListener('click', (event) => {
          const counterValue = document.getElementById(`counterValue-${keranjangid}`);
          console.log(keranjangid)
          let currentValue = parseInt(counterValue.textContent);
          counterValue.textContent = currentValue + 1;
          console.log(parseInt(counterValue.textContent))
          updateQuantitas(keranjangid, parseInt(counterValue.textContent))
          let jumlah = 0
          let kuantitas = 0
          phpArray.forEach(item => {
            console.log(item.kuantitas);
            if (item.cart_id === keranjangid) {
              kuantitas = item.kuantitas
            }
            jumlah += item.kuantitas * item.total;
          });
          total = jumlah
          console.log(JSON.stringify({
            cart_id: keranjangid
          }))
          const url = 'http://localhost/ppsi/increment.php';
          fetch(url, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              kuantitas: kuantitas,
              cart_id: keranjangid
            })
          }).then(response => response.json()).then(data => console.log(data))
          console.log(jumlah)
          cartTotal.textContent = total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
        })

      })

      decrementBtns.forEach((decrementBtn) => {
        console.log(decrementBtn)
        let keranjangid = decrementBtn.getAttribute('data-id');
        decrementBtn.addEventListener('click', (event) => {
          // Ambil data-id dari tombol yang diklik
          const counterValue = document.getElementById(`counterValue-${keranjangid}`);

          if (counterValue) {
            let currentValue = parseInt(counterValue.textContent);
            if (currentValue > 1) { // Pastikan nilai tidak kurang dari 1
              counterValue.textContent = currentValue - 1;
            }
            else {
              return
            }
          }

          updateQuantitas(keranjangid, parseInt(counterValue.textContent))
          let kuantitas = 0
          phpArray.forEach(item => {
            if (item.cart_id == keranjangid) {
              kuantitas = item.kuantitas
              total -= item.total;
            }
          });
          console.log(JSON.stringify({
            cart_id: keranjangid
          }))
          const url = 'http://localhost/ppsi/increment.php';
          fetch(url, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              kuantitas: kuantitas,
              cart_id: keranjangid
            })
          }).then(response => response.json()).then(data => console.log(data))
          cartTotal.textContent = total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
        });
      });

    });

    console.log(total);
  </script>
</body>

</html>