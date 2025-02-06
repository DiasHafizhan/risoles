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


$queryHistori = "SELECT 
    orders.id AS order_id,
    orders.user_id AS user_id,
    orders.image AS order_image,
    orders.total AS order_total,
    orders.status AS order_status,
    users.nama AS user_name
FROM 
    orders
JOIN 
    users
ON 
    orders.user_id = users.id
";

$cart_items = read($queryHistori);

// var_dump($cart_items)




?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>History Admin</title>
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script>
    const update = (event) => {
      const selectedValue = event.value
      const id = event.dataset.id
      // console.log(id, selectedValue)
      // const formData = new FormData()
      // formData.append('status', selectedValue)
      // formData.append('id', id)

      const url = 'updateStatus.php';
      fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          status: selectedValue,
          id: id
        })
      }).then(response => response.text()).then(data => {
        try {
          console.log(JSON.parse(data));
        } catch (e) {
          console.error('Error parsing JSON:', data);
        }
      })
    }
  </script>
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
              <th scope="col">Username</th>
              <th scope="col">Total</th>
              <th scope="col">Bukti</th>
              <th scope="col">Status</th>
              <th scope="col">Detail</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($cart_items as $items): ?>
              <tr style="height: fit-content;">
                <td style=" align-items: center; gap: 5px;">
                  <p><?= $items['user_name'] ?></p>
                </td>
                <td style="align-items: center;">
                  Rp. <?= number_format($items['order_total'], 0, ',', '.') ?>
                </td>
                <td style="align-items: center;"><img src="/img/<?= $items['order_image'] ?>" style="width: 100px;"
                    alt=""></td>
                <td style="align-items: center;">
                  <select class="form-select" id="dropdown" name="type" data-id="<?php echo $items['order_id'] ?>"
                    onchange="update(this)">
                    <option value="pending" <?php echo ($items['order_status'] === 'pending') ? 'selected="selected"' : ''; ?>>Pending
                    </option>
                    <option value="success" <?php echo ($items['order_status'] === 'success') ? 'selected="selected"' : ''; ?>>Success
                    </option>
                  </select>
                </td>
                <td>
                  <!-- Button trigger modal -->
                  <button type="button" class="btn btn-info w-full" data-bs-toggle="modal"
                    data-bs-target="#modal<?= $items['order_id'] ?>">
                    Selengkapnya
                  </button>

                  <!-- Modal -->
                  <div class="modal fade" id="modal<?= $items['order_id'] ?>" tabindex="-1"
                    aria-labelledby="modalLabel<?= $items['order_id'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" style="color: #000;" id="modalLabel<?= $items['order_id'] ?>">Detail Pesanan
                            #<?= $items['order_id'] ?></h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <p style="color: #000;">Username: <?= $items['user_name'] ?></p>
                          <p style="color: #000;">Total: Rp. <?= number_format($items['order_total'], 0, ',', '.') ?></p>
                          <p style="color: #000;">Status:<?= $items['order_status'] ?></p>
                          <p style="color: #000;">Bukti Pembayaran</p>
                          <img src="/img/<?= $items['order_image'] ?>" alt="Bukti Pembayaran"
                            style="width: 100%; max-width: 300px;">
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

</body>

</html>