<?php
$Localhost = 'localhost';
$root = 'root';
$password = 'hafizhan14';
$db = 'risoles';


$con = mysqli_connect($Localhost, $root, $password, $db);


function read($query)
{
  global $con;

  $result = mysqli_query($con, $query);
  $rows = [];

  while ($row = mysqli_fetch_array($result)) {
    $rows[] = $row;
  }
  return $rows;
}

function register($data)
{
  global $con;

  $nama = strtolower(stripcslashes($data['nama']));
  $email = mysqli_real_escape_string($con, $data['email']);
  $telp = strtolower(stripcslashes($data['telp']));
  $password = mysqli_real_escape_string($con, $data['password']);
  $password2 = mysqli_real_escape_string($con, $data['password2']);

  // Cek apakah email sudah terdaftar
  $result = mysqli_query($con, "SELECT * FROM users WHERE email = '$email'");
  if (mysqli_fetch_assoc($result)) {
    echo "<script>alert('Email sudah terdaftar');</script>";
    return false;
  }

  // Cek konfirmasi password
  if ($password !== $password2) {
    echo "<script>alert('Konfirmasi password tidak cocok');</script>";
    return false;
  }

  // Hash password
  $password = password_hash($password, PASSWORD_DEFAULT);

  // Query insert tanpa kolom confirmPassword
  $query = "INSERT INTO users (nama, email, telp, password) VALUES ('$nama', '$email', '$telp', '$password')";
  mysqli_query($con, $query);

  return mysqli_affected_rows($con);
}


function tambah($data)
{
  global $con;

  $nameProduct = htmlspecialchars($data['product']);
  $description = htmlspecialchars($data['description']);
  $price = htmlspecialchars($data['price']);
  $stock = htmlspecialchars($data['stock']);
  $type = htmlspecialchars($data['type']);
  $image = upload();

  if (!$image) {
    return false;
  }

  $query = "INSERT INTO menu (name, description, price, stock, image, type) VALUES ('$nameProduct', '$description', $price, $stock,'$image','$type')";


  mysqli_query($con, $query);

  return mysqli_affected_rows($con);
}

function hapus($id)
{
  global $con;

  $id = intval($id);

  // Hapus dulu dari tabel order_items
  mysqli_query($con, "DELETE FROM order_items WHERE menu_id = $id");

  // Baru hapus dari tabel menu
  mysqli_query($con, "DELETE FROM menu WHERE id = $id");

  return mysqli_affected_rows($con);
}



function edit($data)
{
  global $con;

  $id = $data['id'];
  $namaProduct = $data['product'];
  $description = $data['description'];
  $stock = $data['stock'];
  $price = $data['price'];
  $type = $data['type'];
  $image = $data['image'];

  $query = "UPDATE menu SET name = '$namaProduct', description = '$description', price = $price, stock = $stock, type = '$type', image = '$image' WHERE id = $id";

  mysqli_query($con, $query);

  return mysqli_affected_rows($con);

}

function upload()
{
  $namaFile = $_FILES["image"]["name"];
  $ukuranFile = $_FILES["image"]["size"];
  $error = $_FILES["image"]["error"];
  $tmpName = $_FILES["image"]["tmp_name"];

  if ($error === 4) {
    echo "
    <script>
      alert('Anda belum memasukan gambar')
    </script>
    ";
    return false;
  }

  $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
  $fileExtension = pathinfo($namaFile, PATHINFO_EXTENSION);
  if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
    echo "<script>
        alert('Anda Salah memasukan File')
      </script>";
    return false;
  }

  // cek jika ukuranFile gambar terlalu besar
  if ($ukuranFile > 1000000) {
    echo "<script>
          alert('Ukuran File Terlalu Besar')
        </script>";
    return false;
  }
  ;

  move_uploaded_file($tmpName, '../img/' . $namaFile);
  return $namaFile;
}


function change($data)
{
  global $con;

  $id = $data['id']; // Ambil ID dari data
  $nama = $data['nama'];
  $telp = $data['telp'];
  $email = $data['email'];

  // Query untuk memperbarui data
  $query = "UPDATE users SET 
              nama = '$nama', 
              telp = '$telp', 
              email = '$email' 
            WHERE id = '$id'";

  // Jalankan query
  mysqli_query($con, $query);

  // Kembalikan jumlah baris yang terpengaruh
  return mysqli_affected_rows($con);
}


function readSingle($query, $params = [])
{
  global $con; // Pastikan $con adalah koneksi database Anda

  // Siapkan statement
  $stmt = mysqli_prepare($con, $query);

  if ($stmt === false) {
    die('Prepare statement gagal: ' . mysqli_error($con));
  }

  // Bind parameter jika ada
  if (!empty($params)) {
    $types = str_repeat('s', count($params)); // Mengasumsikan semua parameter adalah string
    mysqli_stmt_bind_param($stmt, $types, ...$params);
  }

  // Eksekusi statement
  mysqli_stmt_execute($stmt);

  // Ambil hasil query
  $result = mysqli_stmt_get_result($stmt);

  // Ambil satu baris hasil (asosiatif)
  $data = mysqli_fetch_assoc($result);

  // Tutup statement
  mysqli_stmt_close($stmt);

  return $data; // Kembalikan hasil
}

function order($data)
{
  global $con;

  $user_id = mysqli_real_escape_string($con, $data['userId']);
  $total = mysqli_real_escape_string($con, $data['total']);

  // 1. Cek apakah user sudah memiliki pesanan 'Pending'
  $check_order = mysqli_query($con, "SELECT id FROM orders WHERE user_id = '$user_id' AND status = 'dimasak'");
  if (mysqli_num_rows($check_order) > 0) {
    return false; // Sudah ada pesanan aktif, tidak bisa buat baru
  }

  // 2. Validasi file upload
  if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    return false; // Gagal upload atau tidak ada file
  }

  $image = $_FILES['image']['name'];
  $tmp = $_FILES['image']['tmp_name'];
  $upload_dir = "img/";
  $upload_path = $upload_dir . $image;

  // Validasi ekstensi file
  $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
  $file_ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
  if (!in_array($file_ext, $allowed_ext)) {
    return false; // Ekstensi tidak diperbolehkan
  }

  move_uploaded_file($tmp, $upload_path);

  // 3. Insert ke tabel orders
  $query_order = "INSERT INTO orders (user_id, image, total, status) 
                  VALUES ('$user_id', '$image', '$total', 'dimasak')";
  $result_order = mysqli_query($con, $query_order);

  if (!$result_order) {
    return false;
  }

  $order_id = mysqli_insert_id($con);

  // 4. Ambil data keranjang
  $query_cart = "SELECT * FROM cart WHERE id_user = '$user_id' AND id_order IS NULL";
  $cart_items = mysqli_query($con, $query_cart);

  while ($item = mysqli_fetch_assoc($cart_items)) {
    $menu_id = $item['id_menu'];
    $quantity = $item['kuantitas'];
    $created_at = $item['orderDate'];

    // Simpan item ke order_items
    $insert_item = "INSERT INTO order_items (order_id, menu_id, quantity, created_at)
                    VALUES ('$order_id', '$menu_id', '$quantity', '$created_at')";
    mysqli_query($con, $insert_item);

    // 6. Kurangi stok menu
    $update_stok = "UPDATE menu SET stock = stock - $quantity WHERE id = '$menu_id' AND stock >= $quantity";
    mysqli_query($con, $update_stok);
  }

  // 5. Update cart
  $update_cart = "UPDATE cart SET id_order = '$order_id' WHERE id_user = '$user_id' AND id_order IS NULL";
  mysqli_query($con, $update_cart);

  return true;
}








?>