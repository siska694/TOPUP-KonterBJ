<?php
include 'config.php';

$categories =
mysqli_query(
$conn,
"SELECT DISTINCT category
FROM services
ORDER BY category ASC"
);

$services =
mysqli_query(
$conn,
"SELECT *
FROM services
ORDER BY category,
provider,
price ASC"
);

/*
=========================
LAST TRANSACTION
=========================
*/

$last_transaction =
mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT
transactions.*,
services.service_name
FROM transactions
LEFT JOIN services
ON services.id =
transactions.service_id
ORDER BY transactions.id DESC
LIMIT 1"
));

function getLogo($provider){

    $provider =
    strtolower(trim($provider));

    if(str_contains(
    $provider,
    'telkomsel'
    )){
        return
'assets/images/telkomsel.png';
    }

    if(str_contains(
    $provider,
    'xl'
    )){
        return
'assets/images/xl.png';
    }

    if(str_contains(
    $provider,
    'tri'
    )){
        return
'assets/images/tri.png';
    }

    if(
        str_contains(
        $provider,
        'indosat'
        )
        ||
        str_contains(
        $provider,
        'im3'
        )
    ){
        return
'assets/images/indosat.png';
    }

    if(str_contains(
    $provider,
    'mobile'
    )){
        return
'assets/images/ml.png';
    }

    if(str_contains(
    $provider,
    'free'
    )){
        return
'assets/images/freefire.png';
    }

    if(str_contains(
    $provider,
    'pubg'
    )){
        return
'assets/images/pubg.png';
    }

    if(str_contains(
    $provider,
    'roblox'
    )){
        return
'assets/images/roblox.png';
    }

    if(str_contains(
    $provider,
    'ovo'
    )){
        return
'https://upload.wikimedia.org/wikipedia/commons/e/eb/Logo_ovo_purple.svg';
    }

    if(str_contains(
    $provider,
    'dana'
    )){
        return
'https://upload.wikimedia.org/wikipedia/commons/7/72/Logo_dana_blue.svg';
    }

    if(str_contains(
    $provider,
    'pln'
    )){
        return
'https://upload.wikimedia.org/wikipedia/commons/9/97/Logo_PLN.png';
    }

    return
'https://cdn-icons-png.flaticon.com/512/847/847969.png';
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
TopUP-KonterBJ
</title>

<link href=
"https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<style>

body{
    background:#071b34;
    color:white;
}

.container-custom{
    max-width:1300px;
    margin:auto;
}

.hero{
    background:
    linear-gradient(
    135deg,
    #2563eb,
    #1d4ed8
    );

    padding:40px;
    border-radius:35px;
    margin-bottom:40px;
}

.hero h1{
    font-weight:700;
}

.category-btn{
    border-radius:30px;
    padding:10px 22px;
}

.provider-card,
.nominal-card{
    background:#0d2446;
    border-radius:28px;
    padding:30px;
    text-align:center;
    cursor:pointer;
    transition:.25s;
    border:2px solid transparent;
    height:100%;
}

.provider-card:hover,
.nominal-card:hover{
    transform:translateY(-5px);
    border-color:#2563eb;
}

.provider-logo{
    width:90px;
    height:70px;
    object-fit:contain;
    margin-bottom:20px;
}

.provider-name{
    font-size:22px;
    font-weight:700;
}

.nominal-card h5{
    font-weight:700;
}

.nominal-card h4{
    font-size:28px;
    font-weight:700;
}

.modal-content{
    background:#0d2446;
    border-radius:35px;
    color:white;
}

.form-control,
.form-select{
    border:none;
    border-radius:18px;
    height:58px;
}

.btn-primary{
    border-radius:18px;
    height:58px;
}

.hide{
    display:none;
}

.info-card{
    background:#0d2446;
    border-radius:30px;
    padding:28px;
    height:100%;
}

.badge-success{
    background:#10b981;
}

.badge-pending{
    background:#f59e0b;
}

.mini-title{
    color:#94a3b8;
    font-size:14px;
}

.step-box{
    background:#0d2446;
    border-radius:25px;
    padding:20px;
    text-align:center;
    height:100%;
}

.step-number{
    width:50px;
    height:50px;
    background:#2563eb;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
    margin:auto;
    margin-bottom:15px;
}

.feature-card{
    background:#0d2446;
    border-radius:25px;
    padding:25px;
    text-align:center;
}

</style>

</head>

<body>

<div class="container-custom py-5">

<!-- HERO -->

<div class="hero">

<h1>
TopUP-KonterBJ
</h1>

<p class="mb-0">

Pulsa, Game,
PLN dan E-Wallet
lebih cepat.

</p>

</div>

<div class="row g-4 mb-5">

<!-- LAST TRANSACTION -->

<div class="col-lg-6">

<div class="info-card">

<h4 class="fw-bold mb-4">
🔔 Transaksi Terakhir
</h4>

<?php if($last_transaction): ?>

<div class="mini-title">
Produk
</div>

<h5>

<?= $last_transaction['service_name']; ?>

</h5>

<div class="mini-title mt-3">
Nomor Tujuan
</div>

<h5>

<?= $last_transaction['phone_number']; ?>

</h5>

<div class="mini-title mt-3">
Status
</div>

<span class="badge
<?= $last_transaction['status']
== 'success'
?
'badge-success'
:
'badge-pending'; ?>">

<?= strtoupper(
$last_transaction['status']
); ?>

</span>

<?php

$product =
strtolower(
$last_transaction[
'service_name'
]);

if(
str_contains(
$product,
'pln'
)
):
?>

<div
class="alert
alert-warning
mt-4
mb-0">

Token PLN akan
diproses setelah
admin validasi.

</div>

<?php endif; ?>

<?php else: ?>

<p class="text-light mb-0">

Belum ada transaksi.

</p>

<?php endif; ?>

</div>

</div>

<!-- TRUST -->

<div class="col-lg-6">

<div class="info-card">

<h4 class="fw-bold mb-4">
⚡ Kenapa DIGBIS?
</h4>

<div class="row text-center">

<div class="col-6 mb-4">

<h5>
⚡ Cepat
</h5>

<small>
Diproses admin
lebih cepat
</small>

</div>

<div class="col-6 mb-4">

<h5>
🔒 Aman
</h5>

<small>
Pembayaran jelas
dan transparan
</small>

</div>

<div class="col-6">

<h5>
💰 Murah
</h5>

<small>
Fee admin tetap
Rp2.000
</small>

</div>

<div class="col-6">

<h5>
🎮 Lengkap
</h5>

<small>
Game, Pulsa,
PLN, E-wallet
</small>

</div>

</div>

</div>

</div>

</div>

<!-- PROMO -->

<div class="row g-4 mb-5">

<div class="col-lg-4">

<div class="feature-card">

<h4>
🔥 Promo
</h4>

<p class="mb-0">

Admin fee hanya
Rp2.000 semua
transaksi

</p>

</div>

</div>

<div class="col-lg-4">

<div class="feature-card">

<h4>
⚡ Fast Process
</h4>

<p class="mb-0">

Pesanan cepat
divalidasi admin

</p>

</div>

</div>

<div class="col-lg-4">

<div class="feature-card">

<h4>
🔔 Live Status
</h4>

<p class="mb-0">

Pantau status
pesanan kamu

</p>

</div>

</div>

</div>

<!-- HOW TO -->

<h3 class="fw-bold mb-4">

Cara Order

</h3>

<div class="row g-4 mb-5">

<div class="col-lg-3">

<div class="step-box">

<div class="step-number">

1

</div>

Pilih Produk

</div>

</div>

<div class="col-lg-3">

<div class="step-box">

<div class="step-number">

2

</div>

Isi Data

</div>

</div>

<div class="col-lg-3">

<div class="step-box">

<div class="step-number">

3

</div>

Transfer &
Upload Bukti

</div>

</div>

<div class="col-lg-3">

<div class="step-box">

<div class="step-number">

4

</div>

Tunggu Approval

</div>

</div>

</div>

<!-- CATEGORY -->

<div class="mb-5">

<?php while(
$cat =
mysqli_fetch_assoc(
$categories
)):
?>

<button
class="btn
btn-outline-light
me-2 mb-2
category-btn"

onclick="selectCategory(
'<?= $cat['category']; ?>'
)">

<?= $cat['category']; ?>

</button>

<?php endwhile; ?>

</div>

<!-- PROVIDER -->

<div
class="row g-4 mb-5"
id="providerSection">

<?php

$shown = [];

mysqli_data_seek(
$services,
0
);

while(
$row =
mysqli_fetch_assoc(
$services
)):

$key =
$row['category']
.
$row['provider'];

if(
in_array(
$key,
$shown
)
){
continue;
}

$shown[] =
$key;
?>

<div
class="col-lg-3
col-md-4
col-6
provider-item hide"

data-category=
"<?= $row['category']; ?>">

<div
class="provider-card"

onclick=
"selectProvider(
'<?= $row['provider']; ?>'
)">

<img
src="<?= getLogo(
$row['provider']
); ?>"

class=
"provider-logo">

<div
class=
"provider-name">

<?= $row['provider']; ?>

</div>

</div>

</div>

<?php endwhile; ?>

</div>

<!-- NOMINAL -->

<div
class="row g-4"
id="nominalSection">

<?php

mysqli_data_seek(
$services,
0
);

while(
$row =
mysqli_fetch_assoc(
$services
)):
?>

<div
class="col-lg-3
col-md-4
col-6
nominal-item hide"

data-provider=
"<?= $row['provider']; ?>">

<div
class="nominal-card"

onclick=
"openCheckout(
<?= $row['id']; ?>,
'<?= $row['service_name']; ?>',
<?= $row['price']; ?>
)">

<h5>

<?= $row['service_name']; ?>

</h5>

<h4>

Rp<?= number_format(
$row['price'],
0,
',',
'.'
); ?>

</h4>

</div>

</div>

<?php endwhile; ?>

</div>

</div>

<!-- MODAL -->

<div
class="modal fade"
id="checkoutModal"
tabindex="-1">

<div
class="modal-dialog
modal-dialog-centered
modal-lg">

<div
class="modal-content border-0">

<div class="modal-body p-5">

<form
action="checkout.php"
method="POST">

<input
type="hidden"
name="service_id"
id="service_id">

<div
class=
"d-flex
justify-content-between
align-items-center
mb-4">

<h2
class=
"fw-bold
mb-0">

Checkout

</h2>

<button
type="button"
class=
"btn-close
btn-close-white"

data-bs-dismiss=
"modal">

</button>

</div>

<div class="mb-3">

<label class="form-label">
Produk
</label>

<input
type="text"
id="selected_product"
class="form-control"
readonly>

</div>

<div class="mb-3">

<label
class="form-label"
id="target_label">

Nomor HP

</label>

<input
type="text"
name="phone_number"
id="target_input"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">
Nama Customer
</label>

<input
type="text"
name="customer_name"
class="form-control"
required>

</div>

<div class="mb-4">

<label class="form-label">
Metode Pembayaran
</label>

<select
name="payment_method"
class="form-select"
required>

<option value="">
Pilih Pembayaran
</option>

<option value="OVO">
OVO
</option>

<option value="DANA">
DANA
</option>

<option value="QRIS">
QRIS
</option>

<option value=
"Transfer Bank">

Transfer Bank

</option>

</select>

</div>

<div
class=
"rounded-4
p-4
mb-4"

style=
"background:#071b34;">

<div
class=
"text-secondary">

Total Bayar

</div>

<h1
class=
"fw-bold
mb-1"
id=
"total_price">

Rp0

</h1>

<small
class=
"text-secondary">

Sudah termasuk
admin fee Rp2.000

</small>

</div>

<button
class=
"btn
btn-primary
w-100">

Lanjut Pembayaran

</button>

</form>

</div>

</div>

</div>

</div>

<script src=
"https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

function selectCategory(category){

    document
    .querySelectorAll(
    '.provider-item'
    )
    .forEach(item=>{

        if(
            item.dataset.category
            === category
        ){
            item.style.display =
            'block';
        }else{
            item.style.display =
            'none';
        }

    });

    document
    .querySelectorAll(
    '.nominal-item'
    )
    .forEach(item=>{

        item.style.display =
        'none';
    });

}

function selectProvider(provider){

    document
    .querySelectorAll(
    '.nominal-item'
    )
    .forEach(item=>{

        if(
            item.dataset.provider
            === provider
        ){
            item.style.display =
            'block';
        }else{
            item.style.display =
            'none';
        }

    });

}

function openCheckout(
id,
name,
price
){

    let total =
    Number(price)
    + 2000;

    document
    .getElementById(
    'service_id'
    )
    .value=id;

    document
    .getElementById(
    'selected_product'
    )
    .value=name;

    document
    .getElementById(
    'total_price'
    )
    .innerHTML=
    'Rp'+
    total.toLocaleString(
    'id-ID'
    );

    let label =
    document.getElementById(
    'target_label'
    );

    let input =
    document.getElementById(
    'target_input'
    );

    let lower =
    name.toLowerCase();

    if(
    lower.includes('pln')
    ){

        label.innerHTML =
        'Nomor Meter PLN';

        input.placeholder =
        'Masukkan nomor meter';
    }

    else if(

    lower.includes('mobile')
    ||
    lower.includes('pubg')
    ||
    lower.includes('roblox')
    ||
    lower.includes('free fire')

    ){

        label.innerHTML =
        'User ID Game';

        input.placeholder =
        'Masukkan user id';
    }

    else if(

    lower.includes('ovo')
    ||
    lower.includes('dana')

    ){

        label.innerHTML =
        'Nomor E-Wallet';

        input.placeholder =
        '08xxxxxxxxxx';
    }

    else{

        label.innerHTML =
        'Nomor HP';

        input.placeholder =
        '08xxxxxxxxxx';
    }

    new bootstrap.Modal(
    document.getElementById(
    'checkoutModal'
    )
    ).show();

}

</script>

</body>
</html>
