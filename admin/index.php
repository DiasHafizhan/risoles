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

// Query untuk menghitung baris
$sql = "SELECT COUNT(*) AS total_rows FROM menu";
$result = $con->query($sql);

// Ambil hasil
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
} else {
  echo "Tabel kosong.";
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body style="background-color: #27262b; color: #fff;">
  <?php include '../Component/admin/header.php' ?>


  <div class="container mt-3">
    <div class="row">
      <?php include '../Component/sidebar.php' ?>
      <div class="col-md-9">
        <div class="flex justify-between items-center">
          <div class="rounded-lg"
            style="width: 32%; border: 1px solid #7e89ac; padding: 10px; background-color: #343b4f;">
            <div class="flex items-center" style="gap: 10px; color: #d9e1fa;">
              <p style="font-size: 18px; margin-bottom: 2px;"><i class='bx bx-food-menu'></i></p>
              <p style="font-size: 15px; margin-bottom: 2px; font-weight: 700;">Total Products</p>
            </div>
            <h3><?= $row['total_rows'] ?></h3>
          </div>
          <div class="rounded-lg"
            style="width: 32%; border: 1px solid #7e89ac; padding: 10px; background-color: #343b4f;">
            <div class="flex items-center" style="gap: 10px; color: #d9e1fa;">
              <p style="font-size: 18px; margin-bottom: 2px;"><i class='bx bx-package'></i></p>
              <p style="font-size: 15px; margin-bottom: 2px; font-weight: 700;">Sales This Mounth</p>
            </div>
            <h3>300</h3>
          </div>
          <div class="rounded-lg"
            style="width: 32%; border: 1px solid #7e89ac; padding: 10px; background-color: #343b4f;">
            <div class="flex items-center" style="gap: 10px; color: #d9e1fa;">
              <p style="font-size: 18px; margin-bottom: 2px;"><i class='bx bx-dollar'></i></p>
              <p style="font-size: 15px; margin-bottom: 2px; font-weight: 700;">Revenue This Mounth</p>
            </div>
            <h3>300</h3>
          </div>

        </div>
      </div>
    </div>
  </div>




  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>