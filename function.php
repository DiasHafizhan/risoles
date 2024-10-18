<?php
$Localhost = 'localhost';
$root = 'root';
$password = 'hafizhan14';
$db = 'risoles';


$con = mysqli_connect($Localhost, $root, $password, $db);

function register($data)
{
  global $con;

  $username = strtolower(stripcslashes($data['username']));
  $email = mysqli_real_escape_string($con, $data['email']);
  $password = mysqli_real_escape_string($con, $data['password']);

  // Melakukan query untuk mengecek apakah username atau email sudah terdaftar
  $result = mysqli_query($con, "SELECT * FROM users WHERE email = '$email'");

  if (mysqli_fetch_assoc($result)) {
    // Jika username atau email ditemukan, tampilkan alert
    echo "
      <script>
        alert('Username atau Email sudah terdaftar');
      </script>
    ";
  }

  $password = password_hash($password, PASSWORD_DEFAULT);

  $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
  mysqli_query($con, $query);

  return mysqli_affected_rows($con);
}



?>