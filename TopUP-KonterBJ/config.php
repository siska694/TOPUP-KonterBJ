<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "topup"
);

if(!$conn){
    die(
        "Database gagal terkoneksi"
    );
}

?>