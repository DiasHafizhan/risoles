<?php

require '../function.php';

$id = $_GET['id'];

$product = read("SELECT * FROM menu WHERE id = $id")[0];

if(isset($_POST['submit'])){
  if(edit($_POST) > 0){
    header('location: listMenu.php');
  }
}



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

  <!-- <?php include '../Component/admin/header.php' ?> -->


  <div class="container">
    <h1 style="color: #AF1740; margin-bottom: 40px; margin-bottom: 40px; margin-top: 20px;">
      Add Menu
    </h1>


    <form method="POST" style="margin-bottom: 70px;">
      <input type="hidden" value="<?= $product['id'] ?>" name="id">
      <div class="mb-3">
        <label for="product" class="form-label">Product Name</label>
        <input type="text" class="form-control" name="product" id="product" value="<?= $product['name'] ?>"
          aria-describedby="emailHelp">
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea id="description" name="description" class="form-control" rows="4"
          placeholder="Enter the description here..."><?= $product['description'] ?></textarea>
      </div>
      <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="text" class="form-control" value="<?= $product['price'] ?>" name="price" id="price">
      </div>
      <div class="mb-3">
        <label for="stock" class="form-label">Stock</label>
        <input type="text" class="form-control" value="<?= $product['stock'] ?>" name="stock" id="stock">
      </div>
      <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" class="form-control" name="image" id="image">
      </div>
      <div class="mb-3">
        <label for="type" class="form-label">Menu Type</label>
        <select class="form-select" id="dropdown" name="type">
          <option value="Bundle">Bundle</option>
          <option value="Makanan">Makanan</option>
          <option value="Minuman">Minuman</option>
        </select>
      </div>
      <button type="submit" name="submit" class="btn btn-primary">Submit</button>
  </div>
  </form>


  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>