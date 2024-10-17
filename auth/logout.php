<?php
session_start();
$_SESSION = []; // Menghapus semua data sesi
session_unset(); // Menghapus variabel sesi
session_destroy(); // Menghancurkan sesi

header('Location: login.php'); // Mengalihkan ke halaman login
exit; // Menghentikan eksekusi skrip
?>