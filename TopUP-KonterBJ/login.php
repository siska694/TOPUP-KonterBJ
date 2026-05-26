<?php
session_start();

if(isset($_POST['login'])){

    $username =
    $_POST['username'];

    $password =
    $_POST['password'];

    if(
        $username == "admin"
        &&
        $password == "123"
    ){

        $_SESSION['admin']
        = true;

        header(
            "Location: admin/dashboard.php"
        );
        exit();

    }else{
        $error =
        "Username / Password salah";
    }
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
Login Admin
</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link rel="stylesheet"
href="assets/style.css">

</head>

<body class="login-page">

<div class="login-container">

<div class="card login-card shadow-lg">

<div class="card-body p-5">

<h2 class="fw-bold text-center mb-2">
TOP UP KONTERBJ
</h2>

<p class="text-center text-muted mb-4">
Admin Login
</p>

<?php
if(isset($error)):
?>

<div class="alert alert-danger">

<?= $error; ?>

</div>

<?php endif; ?>

<form method="POST">

<div class="mb-3">

<label>
Username
</label>

<input
type="text"
name="username"
class="form-control"
required>

</div>

<div class="mb-4">

<label>
Password
</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<button
type="submit"
name="login"
class="btn btn-primary w-100">

Login

</button>

</form>

</div>

</div>

</div>

</body>
</html>