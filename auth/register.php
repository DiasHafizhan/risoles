<?php

require "../function.php";

if (isset($_POST['submit'])) {
  if (register($_POST) > 0) {
    header('location: login.php');
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - HM Risoles</title>
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <?php include '../Component/header.php'; ?>

  <div class="container text-center mt-5">
    <h1 class="text-2xl mb-5">Selamat Datang di HM Risoles</h1>

    <div class="rounded-lg mx-auto p-4" style="border: 1px solid red; width: 60%;">
      <h2 class="mb-3">Buat Akun</h2>

      <form action="" method="POST">
        <div class="row">
          <div class="col-6">
            <div class="netflix-input-container">
              <input type="text" id="name" name="nama" class="netflix-input" placeholder=" " required>
              <label for="name" class="netflix-label">Name</label>
            </div>

            <div class="netflix-input-container">
              <input type="email" id="email" name="email" class="netflix-input" placeholder=" " required>
              <label for="email" class="netflix-label">Email</label>
            </div>

            <div class="netflix-input-container">
              <input type="telp" id="telp" name="telp" class="netflix-input" placeholder=" " required>
              <label for="telp" class="netflix-label">No Telp</label>
            </div>
          </div>
          <div class="col-6">
            <div class="netflix-input-container">
              <input type="password" id="password" name="password" class="netflix-input" placeholder=" " required>
              <label for="password" class="netflix-label">Kata Sandi</label>
            </div>

            <div class="netflix-input-container">
              <input type="password" id="password2" name="password2" class="netflix-input" placeholder=" " required>
              <label for="password2" class="netflix-label">Konfirmasi kata sandi</label>
            </div>
          </div>
        </div>
        <button class="btn-auth rounded-3xl" type="submit" name="submit">Register</button>
      </form>
    </div>

    <div class="req">
      <p class="mt-3">Sudah punya akun?</p>
      <a href="login.php" class="rounded-3xl">Login</a>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN6jIeHz" crossorigin="anonymous"></script>
</body>

</html>