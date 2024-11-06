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

  $query = "DELETE FROM menu WHERE id = $id";
  mysqli_query($con, $query);

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



?>