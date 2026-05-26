<?php
include 'config.php';

if(
$_SERVER['REQUEST_METHOD']
== 'POST'
){

$customer =
$_POST['customer_name'];

$phone =
$_POST['phone_number'];

$serviceId =
$_POST['service_id'];

$service =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT *
FROM services
WHERE id='$serviceId'"
));

$amount =
$service['price'];

mysqli_query(
$conn,
"INSERT INTO
transactions
(
customer_name,
phone_number,
service_id,
amount,
status
)
VALUES
(
'$customer',
'$phone',
'$serviceId',
'$amount',
'pending'
)"
);

}
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width,
initial-scale=1.0">

<title>
Transaksi Berhasil
</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link rel="stylesheet"
href="http://localhost/DIGBIS/assets/style.css">

</head>

<body class="landing-page">

<div class="container py-5">

<div
class="row
justify-content-center">

<div
class="col-md-6">

<div
class="topup-card
text-center
shadow-lg">

<div
class="mb-4">

<div
style="
width:100px;
height:100px;
background:#22c55e;
border-radius:50%;
display:flex;
justify-content:center;
align-items:center;
margin:auto;
font-size:40px;
color:white;">

✓

</div>

</div>

<h1
class="fw-bold
mb-3">

Transaksi Berhasil

</h1>

<p
class="text-muted
mb-4">

Pesanan berhasil dibuat.

Silakan tunggu
approval admin.

</p>

<a
href="index.php"
class="btn
btn-primary
px-5
py-3">

Kembali

</a>

</div>

</div>

</div>

</div>

</body>
</html>