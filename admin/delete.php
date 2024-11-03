<?php

require '../function.php';

if (isset($_GET['id'])) {
  $id = $_GET['id'];
} else {
  echo "<script>
            alert('ID tidak ditemukan!')
            document.location.href = 'listMenu.php'
          </script>";
}

if (hapus($id) > 0) {
  header('location: listMenu.php');
} else {
  echo "<script>
            alert('Id belum ter Delete')
            document.location.href = 'listMenu.php'
          </script>";
}





?>