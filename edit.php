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

$pasiens = query("SELECT
                          pasien.id AS id_pasien,
                          periksa.biaya_periksa AS biaya_periksa,
                          pasien.nama AS nama_pasien,
                          periksa.catatan AS catatan,
                          periksa.tgl_periksa AS tgl_periksa,
                          daftar_poli.id AS id_daftar_poli,
                          daftar_poli.no_antrian AS no_antrian,
                          daftar_poli.keluhan AS keluhan,
                          daftar_poli.status_periksa AS status_periksa
                        FROM pasien
                        INNER JOIN daftar_poli ON pasien.id = daftar_poli.id_pasien
                        INNER JOIN periksa ON daftar_poli.id = periksa.id_daftar_poli
                        WHERE periksa.id = '$id'")[0];

$obat = query("SELECT * FROM obat");

$selected_obat = [];
$detail_periksa = query("SELECT * FROM detail_periksa WHERE id_periksa='" . $id . "'");
foreach ($detail_periksa as $dp) {
  $selected_obat[] = $dp['id_obat'];
}
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
     
        <!--main content-->
        <div class="main">
            <div class="container-fluid py-2" style="background-color:#FFF5E4;">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h3>Daftar Periksa </h3>
                        </div>

                        <div class="mx-auto">
                            <!--untuk memasukkan data-->
                            <div class="card">
                                <div class="card-header">
          
                                </div>


<div class="card">
  <div class="card-header">
    <h3 class="card-title">Edit Periksa</h3>
  </div>
  <div class="card-body">
    <form action="" method="POST">
      <!-- Kolom input untuk menambahkan data -->
      <div class="form-group">
        <label for="nama_pasien">Nama Pasien</label>
        <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" value="<?= $pasiens["nama_pasien"] ?>" disabled>
      </div>

      <div class="form-group">
        <label for="tgl_periksa">Tanggal Periksa</label>
        <input type="datetime-local" class="form-control" id="tgl_periksa" name="tgl_periksa" value="<?= $pasiens["tgl_periksa"] ?>">
      </div>

      <div class="form-group">
        <label for="catatan">Catatan</label>
        <input type="text" class="form-control" id="catatan" name="catatan" value="<?= $pasiens["catatan"] ?>">
      </div>

      <div class="form-group">
        <label for="nama_pasien">Obat</label>
        <select multiple="" class="form-control" name="obat[]" id="id_obat" multiple>
          <?php foreach ($obat as $obats) : ?>
            <?= var_dump($selected_obat); ?>
            <?php if (in_array($obats['id'], $selected_obat)) : ?>
              <option value="<?= $obats['id']; ?>|<?= $obats['harga'] ?>" selected><?= $obats['nama_obat']; ?> - <?= $obats['kemasan']; ?> - Rp.<?= $obats['harga']; ?></option>
            <?php else : ?>
              <option value="<?= $obats['id']; ?>|<?= $obats['harga'] ?>"> <?= $obats['nama_obat']; ?> - <?= $obats['kemasan']; ?> - Rp.<?= $obats['harga']; ?></option>
            <?php endif; ?>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
          <label for="total_harga">Total Harga</label>
          <input type="text" class="form-control" id="harga" name="harga" readonly value="<?= $pasiens["biaya_periksa"] ?>">
      </div>

      <!-- Tombol untuk mengirim form -->
      <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary" id="simpan_periksa" name="simpan_periksa">
          <i class="fa fa-save"></i> Simpan</button>
      </div>
    </form>

    <?php
    if (isset($_POST['simpan_periksa'])) {
      $biaya_periksa = 150000;
      $total_biaya_obat = 0;
      $obat = isset($_POST['obat']) ? $_POST['obat'] : [];
      $tgl_periksa = $_POST['tgl_periksa'];
      $catatan = $_POST['catatan'];
      $id_obat = [];
      for ($i = 0; $i < count($obat); $i++) {
        $data_obat = explode("|", $obat[$i]);
        // var_dump($data_obat);
        $id_obat[] = $data_obat[0];
        $total_biaya_obat += $data_obat[1];
      }
      $total_biaya = $biaya_periksa + $total_biaya_obat;
      // var_dump($total_biaya);
      // die();

      $id_daftar_poli = $pasiens['id_daftar_poli'];
      $query = "UPDATE periksa SET
                    tgl_periksa = '$tgl_periksa',
                    catatan = '$catatan',
                    biaya_periksa = '$total_biaya'
                  WHERE id_daftar_poli = $id_daftar_poli";
      $query2 = "DELETE FROM detail_periksa WHERE id_periksa = $id";
      $query3 = "INSERT INTO detail_periksa (id_obat, id_periksa) VALUES ";

      if (count($id_obat) > 0) {
        for ($i = 0; $i < count($id_obat); $i++) {
            $query3 .= "($id_obat[$i], $id),";
        }
        $query3 = substr($query3, 0, -1);

        $result3 = mysqli_query($conn, $query3);
    } else {
        $result3 = true; // tidak ada obat untuk dimasukkan, jadi anggap berhasil
    }

    $result = mysqli_query($conn, $query);
    $result2 = mysqli_query($conn, $query2);

      if ($result && $result2 && $result3) {
        echo "
          <script>
            alert('Data berhasil diubah');
            document.location.href = '../ ';
          </script>
        ";
      } else {
        echo "
          <script>
            alert('Data gagal diubah');
            alert('$query');
            document.location.href = '../edit.php/$id';
          </script>
        ";
      }
    }
    ?>

  </div>
</div>
<script>
    $(document).ready(function() {
        $('#id_obat').select2();
        $('#id_obat').on('change.select2', function (e) {
            var selectedValuesArray = $(this).val();
            
            // Calculate the sum
            var sum = 150000;
            if (selectedValuesArray) {
                for (var i = 0; i < selectedValuesArray.length; i++) {
                    // Split the value and get the second part after "|"
                    var parts = selectedValuesArray[i].split("|");
                    console.log(parts);
                    if (parts.length === 2) {
                    sum += parseFloat(parts[1]);
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

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>