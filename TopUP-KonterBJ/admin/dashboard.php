<?php
session_start();


if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit();
}

include '../config.php';

$totalTransaction =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT COUNT(*) as total
FROM transactions"
));

$pendingTransaction =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT COUNT(*) as total
FROM transactions
WHERE status='pending'"
));

$successTransaction =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT COUNT(*) as total
FROM transactions
WHERE status='success'"
));

$totalRevenue =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT SUM(amount)
as total
FROM transactions
WHERE status='success'"
));

$transactions =
mysqli_query(
$conn,
"SELECT
transactions.*,
services.service_name

FROM transactions

LEFT JOIN services
ON services.id =
transactions.service_id

ORDER BY
transactions.id DESC"
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
Dashboard Admin
</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<link rel="stylesheet"
href="/TopUp-Konterbj/assets/style.css">

</head>

<body class="dashboard-page">

<div class="wrapper">

<!-- SIDEBAR -->

<div class="sidebar">

<div class="logo">
DIGBIS
</div>

<a href="dashboard.php"
class="menu active">

<i class="fa-solid
fa-chart-line"></i>

Dashboard

</a>

<a href="services.php"
class="menu">

<i class="fa-solid
fa-box"></i>

Services

</a>

<a href="../logout.php"
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
Dashboard Overview
</h2>

<p>
Monitor transaksi topup
</p>

</div>

</div>

<div class="row g-4">

<div class="col-md-3">

<div class="stats-card">

<div class="icon-card">

<i class="fa-solid
fa-wallet"></i>

</div>

<h3>

<?= $totalTransaction['total']; ?>

</h3>

<p>
Total Transaction
</p>

</div>

</div>

<div class="col-md-3">

<div class="stats-card">

<div class="icon-card">

<i class="fa-solid
fa-clock"></i>

</div>

<h3>

<?= $pendingTransaction['total']; ?>

</h3>

<p>
Pending
</p>

</div>

</div>

<div class="col-md-3">

<div class="stats-card">

<div class="icon-card">

<i class="fa-solid
fa-circle-check"></i>

</div>

<h3>

<?= $successTransaction['total']; ?>

</h3>

<p>
Success
</p>

</div>

</div>

<div class="col-md-3">

<div class="stats-card">

<div class="icon-card">

<i class="fa-solid
fa-money-bill"></i>

</div>

<h3>

Rp<?= number_format(
$totalRevenue['total']
?? 0,
0,
',',
'.'
); ?>

</h3>

<p>
Revenue
</p>

</div>

</div>

</div>

<div class="table-box">

<div class="table-title">

<h4>
Recent Transactions
</h4>

<a
href="services.php"
class="btn btn-primary">

Manage Services

</a>

</div>

<div class="table-responsive">

<table class="table
align-middle">

<thead>

<tr>

<th>ID</th>
<th>Customer</th>
<th>Phone</th>
<th>Service</th>
<th>Payment</th>
<th>Proof</th>
<th>Amount</th>
<th>Status</th>
<th>Action</th>

</tr>

</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($transactions)): ?>

<tr>

<td>
<?= $row['id']; ?>
</td>

<td>
<?= htmlspecialchars($row['customer_name']); ?>
</td>

<td>
<?= htmlspecialchars($row['phone_number']); ?>
</td>

<td>
<?= htmlspecialchars($row['service_name'] ?? '-'); ?>
</td>

<td>
<?= htmlspecialchars($row['payment_method'] ?? '-'); ?>
</td>

<td>

<?php if(!empty($row['payment_proof'])): ?>

<button
type="button"
class="btn btn-info btn-sm"
data-bs-toggle="modal"
data-bs-target="#proofModal<?= $row['id']; ?>">

Lihat

</button>

<?php else: ?>

<span class="text-secondary">
Tidak ada
</span>

<?php endif; ?>

</td>

<td>

Rp<?= number_format(
$row['amount'],
0,
',',
'.'
); ?>

</td>

<td>

<?php if($row['status'] == 'pending'): ?>

<span class="badge bg-warning">
Pending
</span>

<?php elseif($row['status'] == 'success'): ?>

<span class="badge bg-success">
Success
</span>

<?php else: ?>

<span class="badge bg-danger">
Rejected
</span>

<?php endif; ?>

</td>

<td>

<?php if($row['status'] == 'pending'): ?>

<a
href="transaksi.php?id=<?= $row['id']; ?>&status=success"
class="btn btn-success btn-sm">

Approve

</a>

<a
href="transaksi.php?id=<?= $row['id']; ?>&status=rejected"
class="btn btn-danger btn-sm">

Reject

</a>

<?php else: ?>

<button
class="btn btn-secondary btn-sm"
disabled>

Done

</button>

<?php endif; ?>

</td>

</tr>

<!-- MODAL PROOF -->

<?php if(!empty($row['payment_proof'])): ?>

<div
class="modal fade"
id="proofModal<?= $row['id']; ?>"
tabindex="-1">

<div
class="modal-dialog modal-dialog-centered modal-lg">

<div
class="modal-content border-0"
style="
background:#0d2446;
color:white;
border-radius:30px;">

<div class="modal-header border-0">

<h4 class="fw-bold mb-0">

Bukti Transfer -
<?= htmlspecialchars($row['customer_name']); ?>

</h4>

<button
type="button"
class="btn-close btn-close-white"
data-bs-dismiss="modal">
</button>

</div>

<div class="modal-body text-center">

<img
src="../assets/bukti/<?= htmlspecialchars($row['payment_proof']); ?>"
alt="Bukti Transfer"
class="img-fluid rounded-4 shadow"

style="
max-width:100%;
max-height:600px;
object-fit:contain;
background:#071b34;
padding:12px;">

</div>

<div
class="modal-footer border-0 justify-content-center">

<?php if($row['status'] == 'pending'): ?>

<a
href="transaksi.php?id=<?= $row['id']; ?>&status=success"
class="btn btn-success px-4">

Approve

</a>

<a
href="transaksi.php?id=<?= $row['id']; ?>&status=rejected"
class="btn btn-danger px-4">

Reject

</a>

<?php else: ?>

<button
class="btn btn-secondary"
disabled>

Sudah Diproses

</button>

<?php endif; ?>

</div>

</div>

</div>

</div>

<?php endif; ?>

<?php endwhile; ?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</tbody>

</html>