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
          <div style="width: 48%;">
            <img src="./img/appetizer1.png" alt="" class="w-full">
            <p class="">
            <h2 class="text-2xl">Paket 1</h2>
            <p class="text-lg">Rp. 3.500</p>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis, inventore?</p>
            </p>
            <button class="btn btn-primary w-full rounded-3xl">Cart</button>
          </div>
          <div style="width: 48%;">
            <img src="./img/appetizer1.png" alt="" class="w-full">
            <p class="">
            <h2 class="text-2xl">Paket 1</h2>
            <p class="text-lg">Rp. 3.500</p>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis, inventore?</p>
            </p>
            <button class="btn btn-primary w-full rounded-3xl">Cart</button>
          </div>
        </div>
      </div>

      <!-- Keranjang -->
      <div class="col-4" style="background-color: #A6AEBF; margin-top: 20px; height: 100vh;">
        <h2 class="text-center">Keranjang</h2>
        <div style="border: 1px solid red; margin-bottom: 20px;"></div>

        <!-- Items product -->
        <div class="" style="border-bottom: 1px solid red;">
          <div class="">
            <div class="">
              <p class="text-lg" style="margin-bottom: 0;">Paket 1</p>
            </div>
            <div class="flex justify-between items-center">
              <p class="text-lg" style="margin-bottom: 0;">Rp. 3.500</p>
              <div class="flex items-center">
                <button class="btn" id="decrementBtn">-</button>
                <div class="counter" id="counterValue">1</div>
                <button class="btn" id="incrementBtn">+</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Items product -->

        <!-- Total cart -->
        <div class="flex justify-between items-center rounded-3xl text-center p-2"
          style="border: 1px solid red; margin-top: 20px;">
          <p class="m-0">Total</p>
          <p class="m-0">Rp. 20.000</p>
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
  </script>
</body>

</html>