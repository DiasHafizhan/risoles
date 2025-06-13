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

$users = read("SELECT * FROM users WHERE kategori IN ('admin', 'kitchen', 'kasir')");

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
        <table class="table table-dark table-striped" style="width: 100%;">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Name</th>
              <th scope="col">Role</th>
              <th scope="col">change roles</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; ?>
            <?php foreach ($users as $user): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($user['nama']) ?></td>
                <td><?= htmlspecialchars($user['kategori'] ?? '-') ?></td>
                <td>
                  <div class="d-flex gap-2">
                    <select class="form-select kategori-dropdown" data-user-id="<?= $user['id'] ?>">
                      <option value="admin" <?= $user['kategori'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                      <option value="kitchen" <?= $user['kategori'] === 'kitchen' ? 'selected' : '' ?>>Kitchen</option>
                      <option value="kasir" <?= $user['kategori'] === 'kasir' ? 'selected' : '' ?>>Kasir</option>
                    </select>


                    <!-- Tombol modal -->
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal<?= $user['id'] ?>">
                      <i class='bx bxs-trash'></i>
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="modal<?= $user['id'] ?>" tabindex="-1"
                      aria-labelledby="modalLabel<?= $user['id'] ?>" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content" style="color: #000;">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalLabel<?= $user['id'] ?>">Konfirmasi Penghapusan</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            Apakah Anda yakin ingin menghapus <strong><?= htmlspecialchars($user['nama']) ?></strong>?
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <a href="delete.php?id=<?= $user['id'] ?>" class="btn btn-danger">Hapus</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>


        </table>
      </div>
    </div>
  </div>



  <script>
    document.querySelectorAll('.kategori-dropdown').forEach(select => {
      select.addEventListener('change', function () {
        const userId = this.dataset.userId;
        const newKategori = this.value;

        fetch('update_kategori.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: `id=${userId}&kategori=${newKategori}`
        })
          .then(response => response.text())
          .then(result => {
            alert("Kategori berhasil diperbarui.");
          })
          .catch(error => {
            console.error('Error:', error);
            alert("Terjadi kesalahan saat memperbarui kategori.");
          });
      });
    });
  </script>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>