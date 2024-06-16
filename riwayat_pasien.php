<?php
include_once("config.php");
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
  echo "<meta http-equiv='refresh' content='0; url=../..'>";
  die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Riwayat Pasien</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style3.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100..900&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Sidebar -->
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
            <ul class="sidebar-nav">
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
                <li class="sidebar-item">
                    <a href="http://localhost/Projek_BK/index3.php" class="sidebar-link">
                        <img src="sources/stethoscope.png" alt="" width="24" height="24" class="d-inline-block align-text-top">
                        <span>Memeriksa Pasien</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="http://localhost/Projek_BK/riwayat_pasien.php" class="sidebar-link">
                        <img src="sources/riwayat.png" alt="" width="24" height="24" class="d-inline-block align-text-top">
                        <span>Riwayat Pasien</span>
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
        <!-- Main content -->
        <div class="main">
            <div class="container-fluid py-2" style="background-color:#FFF5E4;">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h3>Riwayat Pasien</h3>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Daftar Riwayat Pasien</h3>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Pasien</th>
                                            <th>Alamat</th>
                                            <th>No. KTP</th>
                                            <th>No. Telepon</th>
                                            <th>No. RM</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $index = 1;
                                        $data = $pdo->query("SELECT * FROM pasien");
                                        if ($data->rowCount() == 0) {
                                            echo "<tr><td colspan='7' align='center'>Tidak ada data</td></tr>";
                                        } else {
                                            while ($d = $data->fetch()) {
                                        ?>
                                                <tr>
                                                    <td><?= $index++; ?></td>
                                                    <td><?= $d['nama']; ?></td>
                                                    <td><?= $d['alamat']; ?></td>
                                                    <td><?= $d['no_ktp']; ?></td>
                                                    <td><?= $d['no_hp']; ?></td>
                                                    <td><?= $d['no_rm']; ?></td>
                                                    <td>
                                                    <a class="btn btn-primary" href="http://localhost/Projek_BK/riwayat_periksa.php" role="button">Detail Periksa</a>
                                                    </td>
                                                </tr>
                                                <!-- Modal Detail Riwayat Periksa start here -->
                                               
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                      </div>

    

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl7/4iyM7qpF5hvsg6h8qBl3U1pS6eB0HEe0oFAW3W" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-ZvF5z9j0GLX9BFPJ4i6V1mGGDlcP+wDNNkU3ZLADviLiCOIhJYkefbGpfQxz5x9E" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-QB8E/4+8AzCCVV8WIEUhuuDf4k9Abm6O0p5Ilp1LV65PR5ZPzrXt+7y5Cz3H0dtE" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>
