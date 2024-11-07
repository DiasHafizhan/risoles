<?php

session_start();

require 'function.php';

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

<body>
  <?php include 'Component/header.php' ?>


  <div class="container">
    <div class="row">
      <div class="col-8">
        <div style="background-color: #1A1A1D; color: white; margin-top: 20px;">
          <h1 class="container">Bundle</h1>
        </div>

        <div class="container flex flex-wrap" style="gap: 25px;">
          <?php foreach ($product as $menu): ?>
            <?php if ($menu['type'] == 'Bundle'): ?>
              <div style="width: 48%;">
                <img src="./img/<?= $menu['image'] ?>" alt="" class="w-full">
                <h2 class="text-2xl"><?= $menu['name'] ?></h2>
                <p class="text-lg">Rp. <?= number_format($menu['price'], 0, ',', '.') ?></p>
                <p class="card-text overflow-hidden text-ellipsis whitespace-normal"
                  style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                  <?= $menu['description'] ?>
                </p>
                <button class="btn btn-primary w-full rounded-3xl">Cart</button>
              </div>
            <?php endif ?>
          <?php endforeach ?>
        </div>

        <div style="background-color: #1A1A1D; color: white; margin-top: 20px;">
          <h1 class="container">Makanan</h1>
        </div>

        <div class="container flex flex-wrap" style="gap: 25px;">
          <?php foreach ($product as $menu): ?>
            <?php if ($menu['type'] == 'Makanan'): ?>
              <div style="width: 48%;">
                <img src="./img/<?= $menu['image'] ?>" alt="" class="w-full">
                <h2 class="text-2xl"><?= $menu['name'] ?></h2>
                <p class="text-lg">Rp. <?= number_format($menu['price'], 0, ',', '.') ?></p>
                <p class="card-text overflow-hidden text-ellipsis whitespace-normal"
                  style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                  <?= $menu['description'] ?>
                </p>
                <button class="btn btn-primary w-full rounded-3xl">Cart</button>
              </div>
            <?php endif ?>
          <?php endforeach ?>
        </div>

        <div style="background-color: #1A1A1D; color: white; margin-top: 20px;">
          <h1 class="container">Minuman</h1>
        </div>

        <div class="container flex flex-wrap" style="gap: 25px;">
          <?php foreach ($product as $menu): ?>
            <?php if ($menu['type'] == 'Minuman'): ?>
              <div style="width: 48%;">
                <img src="./img/<?= $menu['image'] ?>" alt="" class="w-full">
                <h2 class="text-2xl"><?= $menu['name'] ?></h2>
                <p class="text-lg">Rp. <?= number_format($menu['price'], 0, ',', '.') ?></p>
                <p class="card-text overflow-hidden text-ellipsis whitespace-normal"
                  style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                  <?= $menu['description'] ?>
                </p>
                <button class="btn btn-primary w-full rounded-3xl cart-btn" data-name="<?= $menu['name'] ?>"
                  data-price="<?= $menu['price'] ?>">
                  Cart
                </button>
              </div>
            <?php endif ?>
          <?php endforeach ?>
        </div>
      </div>

      <!-- Keranjang -->
      <div class="col-4" style="background-color: #A6AEBF; margin-top: 20px; height: 100vh;">
        <h2 class="text-center">Keranjang</h2>
        <div style="border: 1px solid red; margin-bottom: 20px;"></div>

        <!-- Items product -->
        <div id="cart-items" style="border-bottom: 1px solid red;">
          <!-- Items akan ditambahkan secara dinamis di sini -->
        </div>
        <!-- Items product -->

        <!-- Total cart -->
        <div class="flex justify-between items-center rounded-3xl text-center p-2"
          style="border: 1px solid red; margin-top: 20px;">
          <p class="m-0">Total</p>
          <p id="cart-total" class="m-0">Rp. 0</p>
        </div>
        <!-- Total cart -->

        <a href="" class="btn btn-primary w-full rounded-3xl" style="margin-top: 20px;">
          Pesan Sekarang
        </a>
      </div>
      <!-- Keranjang -->


    </div>


  </div>




  <script>
    // Mendapatkan elemen-elemen tombol dan counter
    const decrementBtn = document.getElementById('decrementBtn');
    const incrementBtn = document.getElementById('incrementBtn');
    const counterValue = document.getElementById('counterValue');

    // Fungsi untuk mengurangi nilai
    decrementBtn.addEventListener('click', () => {
      let currentValue = parseInt(counterValue.textContent);
      if (currentValue > 1) { // Pastikan nilai tidak kurang dari 1
        counterValue.textContent = currentValue - 1;
      }
    });

    // Fungsi untuk menambah nilai
    incrementBtn.addEventListener('click', () => {
      let currentValue = parseInt(counterValue.textContent);
      counterValue.textContent = currentValue + 1;
    });



    // Fungsi untuk menambah item ke keranjang
    function addItemToCart(name, price) {
      const cartContainer = document.getElementById('cart-items');

      // Cek apakah item sudah ada di keranjang
      let existingItem = document.querySelector(`.cart-item[data-name="${name}"]`);
      if (existingItem) {
        // Jika item sudah ada, tambahkan jumlahnya
        let qtyElement = existingItem.querySelector('.item-qty');
        qtyElement.textContent = parseInt(qtyElement.textContent) + 1;
      } else {
        // Jika item belum ada, buat elemen baru
        const cartItem = document.createElement('div');
        cartItem.className = 'cart-item';
        cartItem.setAttribute('data-name', name);
        cartItem.innerHTML = `
            <p class="text-lg">${name}</p>
            <div class="flex justify-between items-center">
                <p class="text-lg">Rp. ${price.toLocaleString()}</p>
                <div class="flex items-center">
                    <span class="item-qty">1</span>
                </div>
            </div>
        `;
        cartContainer.appendChild(cartItem);
      }

      // Update total
      updateTotal();
    }

    // Fungsi untuk update total keranjang
    function updateTotal() {
      const cartItems = document.querySelectorAll('.cart-item');
      let total = 0;

      cartItems.forEach(item => {
        const price = parseInt(item.querySelector('.text-lg').textContent.replace('Rp. ', '').replace('.', ''));
        const qty = parseInt(item.querySelector('.item-qty').textContent);
        total += price * qty;
      });

      document.getElementById('cart-total').textContent = `Rp. ${total.toLocaleString()}`;
    }

    // Event listener untuk semua tombol "Cart"
    document.querySelectorAll('.cart-btn').forEach(button => {
      button.addEventListener('click', () => {
        const name = button.getAttribute('data-name');
        const price = parseInt(button.getAttribute('data-price'));
        addItemToCart(name, price);
      });
    });


  </script>
</body>

</html>