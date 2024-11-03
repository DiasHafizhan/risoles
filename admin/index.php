<?php

session_start();

// Memastikan user login terlebih dahulu
if (empty($_SESSION['pengguna'])) {
  header("Location: ../auth/login.php");
  exit;
}

// Menghubungkan ke database
require '../function.php';

// Mendapatkan data pengguna berdasarkan session
$query = mysqli_query($con, "SELECT email FROM users WHERE email = '$_SESSION[pengguna]'");

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

<body>
  <?php include '../Component/admin/header.php' ?>


  <div class="container mt-3">
    <div class="row">
      <?php include '../Component/sidebar.php' ?>
      <div class="col-md-9">
        <div class="card">
          <h5 class="card-header">dashboard</h5>
          <div class="card-body">
            <h5 class="card-title">Special title treatment</h5>
            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
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