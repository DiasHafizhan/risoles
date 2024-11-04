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

$menu = read("SELECT * FROM menu");


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
          <h5 class="card-header">List Menu</h5>
          <div class="card-body">
            <div class="flex justify-end mb-5">
              <a href="addMenu.php" class="px-3 py-2 btn btn-primary">
                Add Menu
              </a>
            </div>
            <div class="w-full">
              <h1>Makanan</h1>
              <div class="flex flex-wrap justify-between"> <!-- Flex wrapper untuk semua card -->
                <?php foreach ($menu as $product): ?>
                  <div class="card mb-3 card-style"> <!-- Set width card dengan Tailwind -->
                    <img src="../img/<?= $product['image'] ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                      <h5 class="card-title"><?= $product['name'] ?></h5>
                      <p class="card-text overflow-hidden text-ellipsis whitespace-normal"
                        style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                        <?= $product['description'] ?>
                      </p>
                      <div class="flex gap-2 mt-2"> <!-- Flex untuk tombol -->
                        <a href="edit.php?id=<?= $product['id'] ?>" class="btn btn-warning w-full"><i
                            class='bx bxs-edit-alt'></i></a>
                        <!-- Button trigger modal -->
                        <a href="delete.php?id=<?= $product['id'] ?>" type="button" class="btn btn-danger w-full"
                          data-bs-toggle="modal" data-bs-target="#modal<?= $product['id'] ?>">
                          <i class='bx bxs-trash'></i>
                        </a>

                        <!-- Modal -->
                        <div class="modal fade" id="modal<?= $product['id'] ?>" tabindex="-1"
                          aria-labelledby="modalLabel<?= $product['id'] ?>" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h1 class="modal-title fs-5" id="modalLabel<?= $product['id'] ?>">Konfirmasi Penghapusan
                                </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                  aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                Apakah Anda yakin ingin menghapus item ini?
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <a href="delete.php?id=<?= $product['id'] ?>" class="btn btn-danger">Delete</a>
                              </div>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                <?php endforeach ?>
              </div>
            </div>

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