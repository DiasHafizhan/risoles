<?php

require 'function.php';

$profile = read('SELECT * FROM users')[0];

if (isset($_POST['submit'])) {
  if (change($_POST) > 0) {
    echo "
      <script>
        alert('data berhasil di ubah');
      </script>
    ";
  } else {
    echo "
      <script>
        alert('data gagal di ubah');
      </script>
    ";
  }
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body style="background-color: #27262b; color: #fff;">
  <?php include 'Component/header.php' ?>


  <div class="container" style="margin-top: 20px;">
    <div class="row">
      <div class="col-6">
        <img src="./img/login.jpg" alt="" class="rounded-lg" style="height: 600px; width: fit-content; margin: auto;">
      </div>
      <div class="col-6 flex justify-center items-center">
        <div class="">
          <h1 style="margin-bottom: 30px;">Edit Profile</h1>
          <form action="" method="POST">
            <input type="hidden" value="<?= $profile['id'] ?>">
            <div class="netflix-input-container">
              <input type="nama" id="nama" name="nama" value="<?= $profile['nama'] ?>" class="netflix-input"
                placeholder=" " required>
              <label for="nama" class="netflix-label">Nama</label>
            </div>

            <div class="netflix-input-container">
              <input type="telp" id="telp" name="telp" value="<?= $profile['telp'] ?>" class="netflix-input"
                placeholder=" " required>
              <label for="telp" class="netflix-label">No Telp</label>
            </div>

            <div class="netflix-input-container">
              <input type="email" id="email" name="email" value="<?= $profile['email'] ?>" class="netflix-input"
                placeholder=" " required>
              <label for="email" class="netflix-label">Email</label>
            </div>

            <button class="btn-auth rounded-lg" type="submit" name="submit">Edit</button>
          </form>
        </div>
      </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"></script>
</body>

</html>