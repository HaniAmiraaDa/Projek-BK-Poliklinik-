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
$id_dokter = $_SESSION['id'];

if ($akses != 'dokter') {
    echo "<meta http-equiv='refresh' content='0; url=..'>";
    die();
}

$url = $_SERVER['REQUEST_URI'];
$url = explode("/", $url);
$id = $url[count($url) - 1];
$obat = query("SELECT * FROM obat");

$pasiens = query("SELECT
                    p.nama AS nama_pasien,
                    dp.id AS id_daftar_poli
                FROM pasien p
                INNER JOIN daftar_poli dp ON p.id = dp.id_pasien
                WHERE p.id = '$id'")[0];


$biaya_periksa = 150000;
$total_biaya_obat = 0;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pemeriksaan Dokter</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="sources/style3.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
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
                                <div class="card-body">
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label for="nama_pasien">Nama Pasien</label>
                                            <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" value="<?= $pasiens["nama_pasien"] ?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="tgl_periksa">Tanggal Periksa</label>
                                            <input type="datetime-local" class="form-control" id="tgl_periksa" name="tgl_periksa">
                                        </div>
                                        <div class="form-group">
                                            <label for="catatan">Catatan</label>
                                            <input type="text" class="form-control" id="catatan" name="catatan">
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_pasien">Obat</label>
                                            <select class="form-control" name="obat[]" multiple id="id_obat">
                                                <?php foreach ($obat as $obats) : ?>
                                                        <option value="<?= $obats['id']; ?>|<?= $obats['harga'] ?>"><?= $obats['nama_obat']; ?> - <?= $obats['kemasan']; ?> - Rp.<?= $obats['harga']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="total_harga">Total Harga</label>
                                            <input type="text" class="form-control" id="harga" name="harga" readonly>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-success" id="simpan_periksa" name="simpan_periksa">Save</button>
                                        </div>
                                    </form>
                                    <?php
                                    if (isset($_POST['simpan_periksa'])) {
                                        $tgl_periksa = $_POST['tgl_periksa'];
                                        $catatan = $_POST['catatan'];
                                        $obat = $_POST['obat'];
                                        $id_daftar_poli = $pasiens['id_daftar_poli'];
                                        $id_obat = [];
                                        for ($i = 0; $i < count($obat); $i++) {
                                            $data_obat = explode("|", $obat[$i]);
                                            $id_obat[] = $data_obat[0];
                                            $total_biaya_obat += $data_obat[1];
                                        }
                                        $total_biaya = $biaya_periksa + $total_biaya_obat;

                                        $query = "INSERT INTO periksa (id_daftar_poli, tgl_periksa, catatan, biaya_periksa) VALUES
                                                ($id_daftar_poli, '$tgl_periksa', '$catatan', '$total_biaya')";
                                        $result = mysqli_query($conn, $query);

                                        $query2 = "INSERT INTO detail_periksa (id_obat, id_periksa) VALUES ";
                                        $periksa_id = mysqli_insert_id($conn);
                                        for ($i = 0; $i < count($id_obat); $i++) {
                                            $query2 .= "($id_obat[$i], $periksa_id),";
                                        }
                                        $query2 = substr($query2, 0, -1);
                                        $result2 = mysqli_query($conn, $query2);

                                        $query3 = "UPDATE daftar_poli SET status_periksa = '1' WHERE id = $id_daftar_poli";
                                        $result3 = mysqli_query($conn, $query3);

                                        if ($result && $result2 && $result3) {
                                            echo "
                                                <script>
                                                    alert('Data berhasil diubah');
                                                    document.location.href = '../';
                                                </script>
                                            ";
                                        } else {
                                            echo "
                                                <script>
                                                    alert('Data gagal diubah');
                                                    document.location.href = '../edit.php/$id';
                                                </script>
                                            ";
                                        }
                                    }
                                    ?>
                                </div>
                            </div>

                        <script>
                            $(document).ready(function()){
                                $('#id_obat').select2();
                                $('#id_obat').on('change.select2', function (e) {
                                    var selectedValuesArray = $(this).val();
                                    

                                    //calculate the sum
                                    var sum = 150000;
                                    if (selectedValuesArray){
                                        for (var i = 0; i < selectedValuesArray.length; i++){
                                            //split value and get the second part after "|"
                                            var parts = selectedValuesArray[i].split("|");
                                            if (parts.length ===2){
                                                sum += parseFloat (parts[1]);
                                            }
                                        }
                                    }
                                    $('#harga').val(sum);
                                });
                            });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
   
</body>

</html>
