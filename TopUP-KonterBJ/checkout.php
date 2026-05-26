<?php
include 'config.php';

if($_SERVER['REQUEST_METHOD'] != 'POST'){
    header("Location:index.php");
    exit();
}

$service_id =
$_POST['service_id'];

$phone_number =
$_POST['phone_number'];

$customer_name =
$_POST['customer_name'];

$payment_method =
$_POST['payment_method'];

$admin_fee = 2000;

/*
=========================
GET SERVICE
=========================
*/

$service =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT *
FROM services
WHERE id='$service_id'"
));

if(!$service){
    die("Produk tidak ditemukan");
}

$total_payment =
$service['price']
+ $admin_fee;

/*
=========================
SAVE TRANSACTION
=========================
*/

mysqli_query(
$conn,
"INSERT INTO transactions(

customer_name,
phone_number,
service_id,
amount,
payment_method,
status

)

VALUES(

'$customer_name',
'$phone_number',
'$service_id',
'$total_payment',
'$payment_method',
'pending'

)"
);

$transaction_id =
mysqli_insert_id(
$conn);

/*
=========================
PAYMENT ACCOUNT
=========================
*/

$payment_info = '';

if(
$payment_method
== 'DANA'
){
    $payment_info =
    '089612345678 (DANA)';
}

elseif(
$payment_method
== 'OVO'
){
    $payment_info =
    '089612345678 (OVO)';
}

elseif(
$payment_method
== 'QRIS'
){
    $payment_info =
    'Scan QRIS Admin';
}

else{
    $payment_info =
    'BCA 123456789 a.n DIGBIS STORE';
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
Invoice Pembayaran
</title>

<link href=
"https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<style>

body{
    background:#071b34;
    color:white;
}

.invoice-box{
    background:#0d2446;
    border-radius:35px;
    padding:45px;
}

.status{
    background:#f59e0b;
    display:inline-block;
    padding:10px 20px;
    border-radius:50px;
    font-weight:600;
}

.info-title{
    color:#94a3b8;
    font-size:14px;
}

.total-box{
    background:#071b34;
    border-radius:25px;
    padding:30px;
}

.total-price{
    font-size:40px;
    font-weight:700;
}

.btn-primary{
    border-radius:18px;
    height:55px;
}

</style>

</head>

<body>

<div class="container py-5">

<div class="row justify-content-center">

<div class="col-lg-7">

<div class="invoice-box">

<h1 class="fw-bold mb-3">
Pesanan Dibuat
</h1>

<p class="mb-4 text-light">

Pesanan berhasil dibuat.
Silakan lakukan pembayaran
dan tunggu approval admin.

</p>

<div class="status mb-4">

PENDING

</div>

<hr>

<div class="row">

<div class="col-6 mb-4">

<div class="info-title">
ID TRANSAKSI
</div>

<h5>
#<?= $transaction_id; ?>
</h5>

</div>

<div class="col-6 mb-4">

<div class="info-title">
PRODUK
</div>

<h5>
<?= $service['service_name']; ?>
</h5>

</div>

<div class="col-6 mb-4">

<div class="info-title">
NOMOR HP
</div>

<h5>
<?= $phone_number; ?>
</h5>

</div>

<div class="col-6 mb-4">

<div class="info-title">
CUSTOMER
</div>

<h5>
<?= $customer_name; ?>
</h5>

</div>

<div class="col-6 mb-4">

<div class="info-title">
METODE BAYAR
</div>

<h5>
<?= $payment_method; ?>
</h5>

</div>

<div class="col-6 mb-4">

<div class="info-title">
TRANSFER KE
</div>

<h5>
<?= $payment_info; ?>
</h5>

</div>

</div>

<div class="total-box">

<div class="row">

<div class="col-6">

<div class="info-title">
Harga Produk
</div>

<h5>
Rp<?= number_format(
$service['price'],
0,
',',
'.'
); ?>
</h5>

</div>

<div class="col-6 text-end">

<div class="info-title">
Admin Fee
</div>

<h5>
Rp2.000
</h5>

</div>

</div>

<hr>

<div class="info-title mb-2">
TOTAL BAYAR
</div>

<div class="total-price mb-4">

Rp<?= number_format(
$total_payment,
0,
',',
'.'
); ?>

</div>

<form
action="upload_bukti.php"
method="POST"
enctype=
"multipart/form-data">

<input
type="hidden"
name="transaction_id"
value="<?= $transaction_id; ?>">

<label
class="form-label mb-2">

Upload Bukti Transfer

</label>

<input
type="file"
name="payment_proof"
class="form-control
mb-3"
required>

<button
class=
"btn btn-success
w-100 py-3">

Saya Sudah Transfer

</button>

</form>

</div>

</div>

</div>

</div>

</div>

</body>
</html>