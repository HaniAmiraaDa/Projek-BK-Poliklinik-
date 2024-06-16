<?php
session_start();
include("config.php");

$tgl_periksa = '';
$catatan = '';
$biaya_periksa = '';

if (isset($_GET['id'])) {
    try {
        $stmt = $pdo->prepare("SELECT periksa.*, daftar_poli.*, pasien.nama AS nama_pasien 
                               FROM periksa 
                               LEFT JOIN daftar_poli ON periksa.id_daftar_poli = daftar_poli.id
                               LEFT JOIN pasien ON periksa.id_pasien = pasien.id
                               WHERE periksa.id = :id");
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tgl_periksa = $row['tgl_periksa'];
            $catatan = $row['catatan'];
            $biaya_periksa = $row['biaya_periksa'];
            // Tambahan informasi dari tabel terkait
            $nama_poli = $row['nama_poli'];
            $nama_pasien = $row['nama_pasien'];
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
    <!-- Head section here -->
</head>

<body>
    <!-- Sidebar and Main content -->
    <!-- Content section here -->
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
                                        <th scope="col">Catatan</th>
                                        <th scope="col">Total Biaya</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $pdo->query("SELECT periksa.*, pasien.nama AS nama_pasien 
                                                          FROM periksa 
                                                          LEFT JOIN pasien ON periksa.id_pasien = pasien.id");
                                    $no = 1;
                                    while ($data = $result->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $no++ ?></td>
                                            <td><?php echo $data['tgl_periksa'] ?></td>
                                            <td><?php echo $data['nama_pasien'] ?></td>
                                            <td><?php echo $data['catatan'] ?></td>
                                            <td><?php echo $data['biaya_periksa'] ?></td>
                                            <td>
                                                <a class="btn rounded-pill px-3" href="riwayat_periksa.php?id=<?php echo $data['id'] ?>">Edit</a>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>
