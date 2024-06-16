<?php
session_start();
include("config.php");

if (isset($_SESSION['login'])){
    $_SESSION['login'] = true;
} else {
    echo "<meta http-equiv='refresh' content='0;url=..'>";
    die();
}

$id_pasien = $_SESSION['id'];
$no_rm = $_SESSION['no_rm'];
$nama = $_SESSION['username'];
$akses = $_SESSION['akses'];

$url = $_SERVER['REQUEST_URI'];
$url = explode("/", $url);
$id_poli = $url[count($url) - 1];

if ($akses != 'pasien') {
    echo "<meta http-equiv='refresh' content='0;url=..'>";
    die();
}
?>

<?php ob_start(); ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Poli</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style2.css">

    <!--font google-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Teachers:ital,wght@0,400..800;1,400..800&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Teachers:ital,wght@0,400..800;1,400..800&display=swap" rel="stylesheet">
</head>
<body>
        
        <!--main content-->

    <div class="card">
    <div class="card-header" style="background-color:#FFF5E4";>
        <h3 class="card-title">Detail Poli</h3>
    </div>
    <div class="card-body">
        <?php
        $poli = $pdo->prepare("SELECT d.nama_poli as poli_nama,
                                      c.nama as dokter_nama,
                                      b.hari as jadwal_hari,
                                      b.jam_mulai as jadwal_mulai,
                                      b.jam_selesai as jadwal_selesai,
                                      a.no_antrian as antrian,
                                      a.id as poli_id
                               FROM daftar_poli as a
                               INNER JOIN jadwal_periksa as b
                               ON a.id_jadwal = b.id
                               INNER JOIN dokter as c
                               ON b.id_dokter = c.id
                               INNER JOIN poli as d
                               ON c.id_poli = d.id
                               WHERE a.id = $id_poli");
        $poli->execute();
        $no = 0;
        if ($poli->rowCount() == 0) {
            echo "Tidak ada data";
        } else {
            while ($p = $poli->fetch()) {
        ?>
            <center>
                <h5>Nama Poli </h5>
                <?= $p['poli_nama'] ?>
                <hr>  
                
                <h5>Nama Dokter </h5>
                <?= $p['dokter_nama'] ?>
                <hr>    

                <h5>Hari </h5>
                <?= $p['jadwal_hari'] ?>
                <hr>    

                <h5>Mulai</h5>
                <?= $p['jadwal_mulai'] ?>
                <hr>    

                <h5>Selesai </h5>
                <?= $p['jadwal_selesai'] ?>
                <hr>    

                <h5>Nomor Antrian </h5>
                <button class="btn btn-success"><?= $p['antrian'] ?></button>
                <hr> 
                
                <a class="btn" href="http://localhost/Projek_BK/index_poli.php" role="button" style= "background-color: #FF9494";>Kembali</a>
            </center>
            <?php
            }
        }
        ?>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>
</html>

