<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit();
}

include '../config.php';

if(
isset($_GET['id'])
&&
isset($_GET['status'])
){

$id =
intval(
$_GET['id']
);

$status =
$_GET['status'];

$allowedStatus =
[
'success',
'rejected'
];

if(
in_array(
$status,
$allowedStatus
)
){

mysqli_query(
$conn,
"UPDATE transactions
SET status='$status'
WHERE id='$id'"
);

}

}

header(
"Location: dashboard.php"
);

exit();
?>