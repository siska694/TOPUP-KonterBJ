<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit();
}

include '../config.php';

$id =
$_GET['id'];

mysqli_query(
$conn,
"DELETE FROM services
WHERE id='$id'"
);

header(
"Location: services.php"
);

exit();
?>