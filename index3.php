<?php
include("config.php");
session_start();

if (isset($_SESSION['login'])) {
  $_SESSION['login'] = true;
} else {
  echo "<meta http-equiv='refresh' content='0; url=../../login.php'>";
  die();
}

$nama = $_SESSION['username'];
$akses = $_SESSION['akses'];

if ($akses != 'dokter') {
  echo "<meta http-equiv='refresh' content='0; url=..'>";
  die();
}

$pasien = query("SELECT
                  periksa.id AS id_periksa,
                  pasien.id AS id_pasien,
                  periksa.catatan AS catatan,
                  daftar_poli.no_antrian AS no_antrian, 
                  pasien.nama AS nama_pasien, 
                  daftar_poli.keluhan AS keluhan,
                  daftar_poli.status_periksa AS status_periksa
                FROM pasien 
                INNER JOIN daftar_poli ON pasien.id = daftar_poli.id_pasien
                LEFT JOIN periksa ON daftar_poli.id = periksa.id_daftar_poli");

$periksa = query("SELECT * from periksa");

$obat = query("SELECT * FROM obat");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Obat</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style3.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100..900&display=swap" rel="stylesheet">
</head>

<body>
     <!--sidebar-->
     <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                <img src="sources/logo.svg" alt="" width="35" height="35" class="d-inline-block align-text-top">
                </button>
                <div class="sidebar-logo">
                    <a href="#">POLIKLINIK UDINUS</a>
                </div>
            </div>
            <ul class="sidebar-nav" >
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                    <img src="sources/profildokter.png" alt="" width="24" height="24" class="d-inline-block align-text-top">
                        <span>dr. Hani</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="http://localhost/Projek_BK/dokterhome.php#" class="sidebar-link">
                    <img src="sources/home.png" alt="" width="24" height="24" class="d-inline-block align-text-top">
                        <span>Home</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="http://localhost/Projek_BK/jadwal_periksa/index_jadwal.php" class="sidebar-link">
                    <img src="sources/jadwal.png" alt="" width="24" height="24" class="d-inline-block align-text-top">
                        <span>Jadwal Periksa</span>
                    </a>
                </li>
                </li>
                    <li class="sidebar-item">
                    <a href="http://localhost/Projek_BK/index3.php" class="sidebar-link">
                    <img src="sources/stethoscope.png" alt="" width="24" height="24" class="d-inline-block align-text-top">
                        <span>Memeriksa Pasien</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="http://localhost/Projek_BK/riwayat_pasien.php" class="sidebar-link">
                    <img src="sources/riwayat.png" alt="" width="24" height="24" class="d-inline-block align-text-top">
                        <span>Riwayat pasien</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="http://localhost/Projek_BK/profil.php" class="sidebar-link">
                    <img src="sources/profil.png" alt="" width="24" height="24" class="d-inline-block align-text-top"> 
                        <span>Profil</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="http://localhost/Projek_BK/index.php" class="sidebar-link">
                <img src="sources/logout.png" alt="" width="24" height="24" class="d-inline-block align-text-top">
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <!--main content-->
        <div class="main">
            <div class="container-fluid py-2" style="background-color:#FFF5E4;">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h3>Daftar Pasien</h3>
                        </div>

                        <div class="mx-auto">
                            <!--untuk memasukkan data-->
                            <div class="card">
                                <div class="card-header">
                                </div>

                                <div class="card">
    <div class="card-header">
        <h3 class="card-title">Periksa Pasien</h3>
    </div>


        <div class="card">
          <div class="card-body p-0">
            <table class="table">
              <thead>
                <tr>
                  <th style="width: 8%">No Urut</th>
                  <th style="width: 40%">Nama Pasien</th>
                  <th style="width: 40%">Keluhan</th>
                  <th style="width: 15%">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($pasien as $pasiens) : ?>
                  <tr>
                    <td id="id" class="text-center"><?= $pasiens["no_antrian"] ?></td>
                    <td><?= $pasiens["nama_pasien"] ?></td>
                    <td><?= $pasiens["keluhan"] ?></td>

                    <td>
                    <?php if ($pasiens["status_periksa"] == 0) { ?>
                        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahPeriksa">Periksa</button> -->
                        <a href="create_dokter.php/<?= $pasiens['id_pasien'] ?>" class="btn btn-success"><i class="fas fa-stethoscope"></i> Check-Up </a>
                        <?php } else { ?>
                          <a href="edit.php/<?= $pasiens['id_periksa'] ?>" class="btn btn-info"><i class="fa fa-edit"></i> Ubah </a>
                      <?php } ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalTambahPeriksa" tabindex="-1" role="dialog" aria-labelledby="modalTambahPeriksaLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalTambahPeriksaLabel">Detail Periksa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <!-- Form untuk menambahkan data periksa -->
                <form action="" method="POST">
                  <!-- Kolom input untuk menambahkan data -->
                  <div class="form-group">
                    <label for="nama_pasien">Nama Pasien</label>
                    <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" value="<?= $pasiens["nama_pasien"] ?>" disabled>
                  </div>
                  
                  <div class="form-group">
                    <label for="tgl_periksa">Tanggal Periksa</label>
                    <input type="datetime-local" class="form-control" id="tgl_periksa" name="tgl_periksa" value="<?= $pariksa["tgl_periksa"] ?>">
                  </div>
                  
                  <div class="form-group">
                    <label for="catatan">Catatan</label>
                    <input type="text" class="form-control" id="catatan" name="catatan" value="<?= $pasiens["catatan"] ?>">
                  </div>

                  <div class="form-group">
                    <label for="nama_pasien">Obat</label>
                    <select multiple="" class="form-control">
                      <?php foreach ($obat as $obats) : ?>
                        <option value="<?= $obats['status'=='Y']; ?>"><?= $obats['nama_obat']; ?> - <?= $obats['kemasan']; ?> - Rp.<?= $obats['harga']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                  <!-- Tombol untuk mengirim form -->
                  <button type="submit" class="btn btn-primary" id="simpan_periksa" name="simpan_periksa">Simpan</button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <?php
        if (isset($_POST['simpan_periksa'])) {
          if (isset($_POST['$id'])) {
            try {
              $tgl_periksa = mysqli_real_escape_string($conn, $_POST['tgl_periksa']);
              $catatan = mysqli_real_escape_string($conn, $_POST['catatan']);

              $query = "INSERT INTO pasien VALUES ('', '$tgl_periksa', '$catatan')";
              mysqli_query($conn, $query);
            } catch (\Exception $e) {
              var_dump($e->getMessage());
            }
          }
        }
        ?>
    </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

      </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>
