<?php
include_once "../config.php";
session_start();

if (isset($_SESSION['login'])) {
    $_SESSION['login'] = true;
} else {
    echo "<meta http-equiv='refresh' content='0; url=..'>";
    die();
}

$nama = $_SESSION['username'];
$akses = $_SESSION['akses'];
$id_dokter = $_SESSION['id'];

if ($akses != 'dokter') {
    echo "<meta http-equiv='refresh' content='0; url=..'>";
    die();
}

$url = $_SERVER['REQUEST_URI'];
$url = explode("/", $url);
$id = $url[count($url) - 1];

$jadwal = query("SELECT * FROM jadwal_periksa WHERE id = $id")[0];

// Input data to db
if (isset($_POST["submit"])) {
    // Cek validasi

    
    // if (empty($_POST["hari"]) || empty($_POST["jam_mulai"]) || empty($_POST["jam_selesai"])) {
              // cek apakah data berhasil di tambahkan atau tidak
        if (updateJadwalPeriksa($_POST, $id) > 0) {
            echo "
            <script>
                alert('Data berhasil ditambahkan');
                document.location.href = '../index_jadwal.php';
            </script>
        ";
        echo "
          <script>
              alert('Data tidak boleh kosong');
              document.location.href = '../jadwal_periksa/edit_jadwal.php';
          </script>
      ";
        die;
    } else {
        // cek apakah data berhasil di tambahkan atau tidak
        if (updateJadwalPeriksa($_POST, $id) > 0) {
            echo "
            <script>
                alert('Data berhasil ditambahkan');
                document.location.href = '../index_jadwal.php';
            </script>
        ";
        } else {
            echo "
            <script>
                alert('Data Gagal ditambahkan');
                document.location.href = '../index_jadwal.php';
            </script>
        ";
        }
    }
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
            <div class="container-fluid py-2" style="background-color:#FFF5E4;">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h3>Periksa Pasien</h3>
                        </div>
                        <div class="mx-auto">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Memeriksa pasien</h3>
                                </div>

<div class="card">
  <div class="card-header">
    <h3 class="card-title">Tambah Jadwal Periksa</h3>
  </div>
  <div class="card-body">
    <form action="" id="tambahJadwal" method="POST">
      <input type="hidden" name="id_dokter" value="<?=$id_dokter?>">
      <div class="form-group">
        <label for="hari">Hari</label>
        <select name="hari" id="hari" class="form-control" disabled>
          <option hidden>-- Pilih Hari --</option>
          <?php
            $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            foreach ($hari as $h): ?>
            <?php if ($h == $jadwal['hari']): ?>
              <option value="<?=$h?>" selected><?=$h?></option>
            <?php else: ?>
              <option value="<?=$h?>"><?=$h?></option>
            <?php endif;?>
        <?php endforeach;?>
        </select>
      </div>
      <div class="form-group">
        <label for="jam_mulai">Jam Mulai</label>
        <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" value="<?= date('H:i', strtotime($jadwal['jam_mulai'])) ?>" disabled>
      </div>
      <div class="form-group">
        <label for="jam_selesai">Jam Selesai</label>
        <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" value="<?=date('H:i', strtotime($jadwal['jam_selesai']))?>" disabled>
      </div>
      <div class="form-group ml-3">
        <label for="jam_selesai">Status</label>
        <br/>
        <!-- <input type="" name="status" id="jam_selesai" class="form-control"> -->
        <input class="form-check-input" type="radio" name="status" id="flexRadioDefault1" value="Y">
        <label class="form-check-label" for="flexRadioDefault1">
           Y
        </label>
        <br/>
        <input class="form-check-input" type="radio" name="status" id="flexRadioDefault2" value="N" checked>
         <label class="form-check-label" for="flexRadioDefault2">
         N
        </label>
      </div>
      <div class="d-flex justify-content-end">
        <button type="submit" name="submit" id="submitButton" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
      </div>
    </form>
  </div>
</div>

<script>
  let jam_mulai = $('#jam_mulai');
  let jam_selesai = $('#jam_selesai');

  $('#tambahJadwal').submit(function (e) {
    if (jam_mulai.value >= jam_selesai.value) {
      e.preventDefault();
      alert('Jam mulai tidak boleh lebih dari jam selesai');
    }
  });

</script>


</div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>
