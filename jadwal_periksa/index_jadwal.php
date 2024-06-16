<?php
include_once("../config.php");
session_start();

if (isset($_SESSION['login'])) {
  $_SESSION['login'] = true;
} else {
  echo "<meta http-equiv='refresh' content='0; url=..'>";
  die();
}

$nama = $_SESSION['username'];
$akses = $_SESSION['akses'];
$id = $_SESSION['id'];

if ($akses != 'dokter') {
  echo "<meta http-equiv='refresh' content='0; url=..'>";
  die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dokter</title>
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
 <div class="main">

<div class="container-fluid py-2" style="background-color:#FFF5E4";>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>Dashboard Dokter</h3>
            </div>

<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col">
        <a href="create_jadwal.php" class="btn btn-success btn-sm float-right"><i class="fa fa-plus"></i> Tambah Jadwal Periksa</a>
      </div>
    </div>
  </div>
  <div class="card-body">
    <table id="tabel-jadwal-periksa" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Dokter</th>
          <th>Hari</th>
          <th>Jam Mulai</th>
          <th>Jam Selesai</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        $data = $pdo->prepare("SELECT 
                                d.nama as nama_dokter, 
                                p.id as id,
                                p.hari as hari,
                                p.jam_mulai as jam_mulai,
                                p.jam_selesai as jam_selesai,
                                p.status as status
                                FROM jadwal_periksa p INNER JOIN dokter d ON p.id_dokter = d.id
                                WHERE d.id = '$id'");
        $data->execute();
        if ($data->rowCount() == 0) {
          echo "<tr><td colspan='7' align='center'>Tidak ada data</td></tr>";
        } else {
          while($d = $data->fetch()) {
        ?>
        <tr>
          <td><?= $no++; ?></td>
          <td><?= $d['nama_dokter'] ?></td>
          <td><?= $d['hari'] ?></td>
          <td><?= $d['jam_mulai'] ?></td>
          <td><?= $d['jam_selesai'] ?></td>
          <td id="data-status"><?= $d['status'] ?></>
          <td>
            <a href="edit_jadwal.php/<?= $d['id']?>" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> Edit</a>
            <a href="delete_jadwal.php/<?= $d['id']?>" class="btn btn-danger btn-sm delete-button"><i class="fa fa-trash"></i>Delete</a>
          </td>
        </tr>
        <?php
          }
        }
        ?>
      </tbody>
    </table>
    <a class="btn btn-primary" href="http://localhost/Projek_BK/dokterhome.php" role="button">Kembali</a>
  </div>
</div>



<script>
  $(document).ready(function() {
    $('.delete-button').on('click', function(e) {
      return confirm('Apakah anda yakin ingin menghapus data ini?');
    });
  });
</script>
