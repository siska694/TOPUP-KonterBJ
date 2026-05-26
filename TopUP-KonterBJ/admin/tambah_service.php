<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit();
}

include '../config.php';

if(isset($_POST['submit'])){

    $service =
    $_POST['service_name'];

    $price =
    $_POST['price'];

    mysqli_query(
    $conn,
    "INSERT INTO services
    (
    service_name,
    price
    )
    VALUES
    (
    '$service',
    '$price'
    )"
    );

    header(
    "Location: services.php"
    );

    exit();
}
?>

<!DOCTYPE html>
<html>

<head>

<title>
Tambah Service
</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link rel="stylesheet"
href="http://localhost/DIGBIS/assets/style.css">

</head>

<body class="dashboard-page">

<div class="container py-5">

<div class="card p-5 rounded-5 shadow-lg">

<h2 class="fw-bold mb-4">
Tambah Service
</h2>

<form method="POST">

<div class="mb-4">

<label class="mb-2">
Nama Service
</label>

<input
type="text"
name="service_name"
class="form-control"
required>

</div>

<div class="mb-4">

<label class="mb-2">
Harga
</label>

<input
type="number"
name="price"
class="form-control"
required>

</div>

<button
type="submit"
name="submit"
class="btn btn-primary">

Simpan

</button>

<a
href="services.php"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

</body>
</html>