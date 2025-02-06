<?php

include 'function.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data mentah dari body request
    $raw_input = file_get_contents("php://input");

    // Decode JSON menjadi array
    $input = json_decode($raw_input, true);

    // Periksa apakah JSON decode berhasil
    if ($input === null && json_last_error() !== JSON_ERROR_NONE) {
        // Kirim error jika JSON tidak valid
        echo json_encode(["error" => "Invalid JSON format"]);
        exit;
    }

    $id = $input['cart_id'];
    $kuantitas = $input['kuantitas'];


    $query = "UPDATE cart SET kuantitas = '$kuantitas' WHERE id = '$id'";

    mysqli_query($con, $query);

    mysqli_affected_rows($con);

    // Berikan response
    echo json_encode([
        "message" => "PHP received your data successfully",
        "data" => $input
    ]);
}
?>