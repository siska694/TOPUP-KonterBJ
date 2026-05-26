<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit();
}

include '../config.php';

$id =
$_GET['id'];

$data =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT *
FROM services
WHERE id='$id'"
));

if(isset($_POST['submit'])){

    $service =
    $_POST['service_name'];

    $price =
    $_POST['price'];

    mysqli_query(
    $conn,
    "UPDATE services
    SET
    service_name='$service',
    price='$price'
    WHERE id='$id'"
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
Edit Service
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
Edit Service
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
value="<?= $data['service_name']; ?>"
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
value="<?= $data['price']; ?>"
required>

</div>

<button
type="submit"
name="submit"
class="btn btn-warning">

Update

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