<?php
session_start();
include("config.php");

$tgl_periksa = '';
$catatan = '';
$biaya_periksa = '';
$nama_pasien = '';
$nama_dokter = ''; // Added variable to store the doctor's name

if (isset($_GET['id'])) {
    try {
        $stmt = $pdo->prepare("SELECT periksa.*, pasien.nama AS nama_pasien, dokter.nama AS nama_dokter 
                               FROM periksa 
                               JOIN daftar_poli ON periksa.id_daftar_poli = daftar_poli.id 
                               JOIN pasien ON daftar_poli.id_pasien = pasien.id 
                               JOIN jadwal_periksa ON daftar_poli.id_jadwal = jadwal_periksa.id
                               JOIN dokter ON jadwal_periksa.id_dokter = dokter.id
                               WHERE periksa.id = :id");
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tgl_periksa = $row['tgl_periksa'];
            $catatan = $row['catatan'];
            $biaya_periksa = $row['biaya_periksa'];
            $nama_pasien = $row['nama_pasien'];
            $nama_dokter = $row['nama_dokter']; // Store the doctor's name
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
    try {
        $stmt = $pdo->prepare("DELETE FROM periksa WHERE id = :id");
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->execute();

        header('Location: riwayat_periksa.php');
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
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

    <!-- Font Google -->
    <link href="https://fonts.googleapis.com/css2?family=Teachers:ital,wght@0,400..800;1,400..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Teachers:ital,wght@0,400..800;1,400..800&display=swap" rel="stylesheet">
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

        <!-- Main content -->
        <div class="main">
            <div class="container-fluid py-2" style="background-color:#FFF5E4;">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h3>Daftar Detail Periksa</h3>
                        </div>

                        <!-- Data Periksa -->
                        <div class="card">
                            <div class="card-header">
                                Data Pasien
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Tanggal Periksa</th>
                                            <th scope="col">Nama Pasien</th>
                                            <th scope="col">Nama Dokter</th> <!-- New column for doctor's name -->
                                            <th scope="col">Catatan</th>
                                            <th scope="col">Total Biaya</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $result = $pdo->query("SELECT periksa.*, pasien.nama AS nama_pasien, dokter.nama AS nama_dokter 
                                                               FROM periksa 
                                                               JOIN daftar_poli ON periksa.id_daftar_poli = daftar_poli.id 
                                                               JOIN pasien ON daftar_poli.id_pasien = pasien.id 
                                                               JOIN jadwal_periksa ON daftar_poli.id_jadwal = jadwal_periksa.id
                                                               JOIN dokter ON jadwal_periksa.id_dokter = dokter.id");
                                        $no = 1;
                                        while ($data = $result->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $no++ ?></td>
                                                <td><?php echo $data['tgl_periksa'] ?></td>
                                                <td><?php echo $data['nama_pasien'] ?></td>
                                                <td><?php echo $data['nama_dokter'] ?></td> <!-- Display doctor's name -->
                                                <td><?php echo $data['catatan'] ?></td>
                                                <td><?php echo $data['biaya_periksa'] ?></td>
                                                <td>
                                                    <a class="btn rounded-pill px-3" href="riwayat_periksa.php?id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoA6Vn8xlg4zELxR1CkM1u7r40I12F3IOP1SKpVkkpF0h4g" crossorigin="anonymous"></script>
</body>
</html>
