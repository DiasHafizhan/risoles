<?php

session_start();

require '../function.php';

if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $result = mysqli_query($con, "SELECT * FROM users WHERE email = '$email'");

  if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row["password"])) {
      $userId = $row['id'];  // tambahkan ini
      $_SESSION['login'] = true;
      $_SESSION['user_id'] = $userId;  // gunakan $userId yang benar
      $_SESSION['user'] = $row['kategori'];
      if ($_SESSION['user'] === 'admin') {
        $_SESSION['pengguna'] = $email;
        header("location: ../admin/");
        exit;
      }
      header("location: ../index.php");
      exit;
    }
  }


  $error = true;
}


?>





<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
  <script src="../assets/js/color-modes.js"></script>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.122.0">
  <title>Signin Template · Bootstrap v5.3</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sign-in/">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="../style.css">

  <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
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

    .b-example-divider {
      width: 100%;
      height: 3rem;
      background-color: rgba(0, 0, 0, .1);
      border: solid rgba(0, 0, 0, .15);
      border-width: 1px 0;
      box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }

    .bi {
      vertical-align: -.125em;
      fill: currentColor;
    }

    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }

    .btn-bd-primary {
      --bd-violet-bg: #712cf9;
      --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

      --bs-btn-font-weight: 600;
      --bs-btn-color: var(--bs-white);
      --bs-btn-bg: var(--bd-violet-bg);
      --bs-btn-border-color: var(--bd-violet-bg);
      --bs-btn-hover-color: var(--bs-white);
      --bs-btn-hover-bg: #6528e0;
      --bs-btn-hover-border-color: #6528e0;
      --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
      --bs-btn-active-color: var(--bs-btn-hover-color);
      --bs-btn-active-bg: #5a23c8;
      --bs-btn-active-border-color: #5a23c8;
    }

    .bd-mode-toggle {
      z-index: 1500;
    }

    .bd-mode-toggle .dropdown-menu .active .bi {
      display: block !important;
    }
  </style>


  <!-- Custom styles for this template -->
  <link href="sign-in.css" rel="stylesheet">
</head>

<body style="background-color: #27262b; color: #fff;">

  <div class="container">
    <div class="row">
      <div class="col-6 flex justify-center items-center">
        <div class="rounded-lg" style="width: 350px;">
          <h1 style="font-size: 40px; font-weight: 600; margin-bottom: 10px;">Welcome back !</h1>
          <p style="color: #8e8d94;margin-bottom: 30px;">Don't have an account? <a href="register.php" class="no-underline"
              style="color: #ffbc01;">Register</a></p>

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









    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"></script>

</body>

</html>