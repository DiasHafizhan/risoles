<?php
session_start();
require '../function.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Query menggunakan fungsi readSingle
  $query = "SELECT * FROM users WHERE email = ?";
  $user = readSingle($query, [$email]); // Fungsi readSingle mengambil satu record

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['login'] = true;
    // Simpan data user ke dalam session
    $_SESSION['user'] = [
      'id' => $user['id'],
      'nama' => $user['nama'],
      'email' => $user['email'],
      'telp' => $user['telp'],
      'kategori' => $user['kategori']
    ];


    // Arahkan ke halaman berdasarkan kategori user
    switch ($_SESSION['user']['kategori']) {
      case 'admin':
        header("Location: ../admin");
        break;
      case 'kitchen':
        header("Location: ../staff");
        break;
      case 'kasir':
        header("Location: ../kasir");
        break;
      default:
        header("Location: ../index.php"); // untuk user biasa
        break;
    }
    // Arahkan ke halaman berdasarkan kategori user
    // if ($_SESSION['user']['kategori'] === 'admin') {
    //   header("Location: ../admin");
    // } else {
    //   header("Location: ../index.php");
    // }
    exit();
  } else {
    $error = true; // Login gagal
  }
}
?>

<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
  <script src="../assets/js/color-modes.js"></script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="generator" content="Hugo 0.122.0">
  <title>Signin Template · Bootstrap v5.3</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../style.css">
  <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Custom CSS */
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>
</head>

<body style="background-color: #27262b; color: #fff;">
  <div class="container">
    <div class="row">
      <div class="col-6 flex justify-center items-center">
        <div class="rounded-lg" style="width: 350px;">
          <h1 style="font-size: 40px; font-weight: 600; margin-bottom: 10px;">Welcome back!</h1>
          <p style="color: #8e8d94;margin-bottom: 30px;">Don't have an account?
            <a href="register.php" class="no-underline" style="color: #ffbc01;">Register</a>
          </p>

          <form action="" method="POST">
            <div class="netflix-input-container">
              <input type="email" id="email" name="email" class="netflix-input" placeholder=" " required>
              <label for="email" class="netflix-label">Email</label>
            </div>
            <div class="netflix-input-container">
              <input type="password" id="password" name="password" class="netflix-input" placeholder=" " required>
              <label for="password" class="netflix-label">Kata Sandi</label>
            </div>
            <button class="btn-auth rounded-lg w-full" type="submit" name="submit">Login</button>
          </form>
        </div>
      </div>
      <div class="col-6" style="padding: 20px 30px;">
        <img src="../img/login.jpg" alt="" class="rounded-lg" style="height: 600px; width: fit-content; margin: auto;">
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>