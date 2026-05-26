<?php

include 'config.php';

$id =
$_POST['transaction_id'];

$file =
$_FILES['payment_proof'];

$folder =
'assets/bukti/';

if(!file_exists($folder)){
    mkdir($folder,0777,true);
}

$filename =
time().
'_'.
basename(
$file['name']
);

$path =
$folder.
$filename;

move_uploaded_file(
$file['tmp_name'],
$path
);

mysqli_query(
$conn,
"UPDATE transactions
SET

payment_proof='$filename',
payment_status='waiting_validation'

WHERE id='$id'"
);

?>

<!DOCTYPE html>
<html>
<head>

<link href=
"https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<style>

body{
background:#071b34;
color:white;
}

.box{
background:#0d2446;
border-radius:30px;
padding:50px;
}

</style>

</head>

<body>

<div class="container py-5">

<div class="row justify-content-center">

<div class="col-lg-6">

<div class="box text-center">

<h1 class="mb-4">
Bukti Transfer Terkirim
</h1>

<p>

Admin akan memvalidasi
pembayaran Anda.

</p>

<a
href="index.php"
class=
"btn btn-primary">

Kembali

</a>

</div>

</div>

</div>

</div>

</body>
</html>