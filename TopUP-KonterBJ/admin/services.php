<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit();
}

include '../config.php';

$services =
mysqli_query(
$conn,
"SELECT *
FROM services
ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width,
initial-scale=1.0">

<title>
Manage Services
</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<link rel="stylesheet"
href="../assets/style.css">
</head>

<body class="dashboard-page">

<div class="wrapper">

<!-- SIDEBAR -->

<div class="sidebar">

<div class="logo">
DIGBIS
</div>

<a
href="dashboard.php"
class="menu">

<i class="fa-solid
fa-chart-line"></i>

Dashboard

</a>

<a
href="services.php"
class="menu active">

<i class="fa-solid
fa-box"></i>

Services

</a>

<a
href="../logout.php"
class="menu logout">

<i class="fa-solid
fa-right-from-bracket"></i>

Logout

</a>

</div>

<!-- CONTENT -->

<div class="content">

<div class="page-header">

<div>

<h2>
Manage Services
</h2>

<p>
Kelola layanan top up
</p>

</div>

<a
href="tambah_service.php"
class="btn btn-primary">

<i class="fa-solid
fa-plus"></i>

Tambah Service

</a>

</div>

<div class="table-box">

<div class="table-responsive">

<table
class="table
align-middle">

<thead>

<tr>

<th>ID</th>
<th>Service</th>
<th>Price</th>
<th>Action</th>

</tr>

</thead>

<tbody>

<?php
while(
$row =
mysqli_fetch_assoc(
$services
)):
?>

<tr>

<td>
<?= $row['id']; ?>
</td>

<td>
<?= $row['service_name']; ?>
</td>

<td>

Rp<?= number_format(
$row['price'],
0,
',',
'.'
); ?>

</td>

<td>

<a
href="edit_service.php?id=<?= $row['id']; ?>"
class="btn btn-warning btn-sm">

Edit

</a>

<a
href="hapus_service.php?id=<?= $row['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Hapus service ini?')">

Delete

</a>

</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

</body>
</html>