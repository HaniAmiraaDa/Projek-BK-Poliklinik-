<?php
session_start();
include("config.php");


if (isset($_SESSION['signup'])){
    $_SESSION ['signup'] = true;
    }else{
        echo "<meta http-equiv='refresh' content='0;url=../Projek_BK/register.php'>";
        die();
    }
    $id_pasien = $_SESSION ['id'];
    $no_rm = $_SESSION ['no_rm'];
    $nama = $_SESSION ['username'];
    $akses = $_SESSION ['akses'];

    if ($akses != 'pasien' ){
        echo "<meta http-equiv='refresh' content='0;url=../pasienhome.php'>";
        die();
    }

    if (isset($_POST['submit'])){
        if ($_POST['id_jadwal'] =="900"){
            echo "
                <script>
                    alert('Jadwal tidak boleh kosong!');
                </script>    
            " ;
            echo "<meta http-equiv='refresh' content='0'>";
        }

        if (daftarPoli($_POST)> 0){
            echo "
                <script>
                    alert('Berhasil Mendaftar Poli!');
                </script>    
            " ;
        }else{
            echo "
                <script>
                    alert('Gagal Mendaftar Poli!');
                </script>    
            " ;
        }
    }
    ?>
   
   <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard poli</title>
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
                    <img src="sources/user.png" alt="" width="27" height="27" class="d-inline-block align-text-top">
                        <span>Ny.Amira</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="http://localhost/Projek_BK/pasienhome.php#" class="sidebar-link">
                    <img src="sources/home.png" alt="" width="24" height="24" class="d-inline-block align-text-top">
                        <span>Home</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="http://localhost/Projek_BK/index_poli.php#" class="sidebar-link">
                    <img src="sources/clinic.png" alt="" width="24" height="24" class="d-inline-block align-text-top">
                        <span>Poli</span>
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

        <div class="container-fluid py-2" style="background-color:#FFF5E4";>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3>Dashboard Pasien</h3>
                    </div>
                </div>
            </div>
        </div>

      <div class="container-fluid py-2">
        <div class="row">
            <div class="col-lg-6">
                <!--Registrasi poli-->
                <div class="card">
                    <h5 class="card-header">Daftar PoliKlinik </h5>
                    <div class="card-body">

                    <form action="" method="POST">
                        <input type="hidden" name="id_pasien" value="<?= $id_pasien  ?>">
                        <div class="mb-3 row">
                            <label for="no_rm" class="form-label">No Rekam Medis</label>
                                <input type="text" class="form-control" name="no_rm" id="no_rm" placeholder="Nomer rekam Medis" value="<?= $no_rm ?>">
                        </div>

                        <div class="mb-3">
                            <label for="inputPoli" class="form-label">Pilih Poli </label>
                            <select id="inputPoli" class="form-control">
                                <option> Open this select menu </option>
                                <?php
                                $data= $pdo->prepare("SELECT* FROM poli");
                                $data->execute();
                                if ($data->rowCount() == 0){
                                    echo "<option>Tidak Ada Poli </option>";
                                }else{
                                    while($d = $data->fetch()){
                                ?>
                                <option value="<?= $d['id'] ?>"><?= $d['nama_poli'] ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>    
                        </div>

                        <div class="mb-3">
                            <label for="inputJadwal" class="form-label">Pilih Jadwal</label>
                            <select id="inputJadwal" class="form-control" name="id_jadwal">
                                <option value="900">-Pilih Menu-</option>
                            </select>
                        </div>


                        <div class="mb-3">
                            <label for="Keluhan" class="form-label">Keluhan</label>
                            <textarea class="form-control" id="keluhan" rows="3" name="keluhan"></textarea>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Daftar</button>
                </form>
        </div>
    </div>
                            </div>
            <!-- End registration poli -->

<div class="col-lg-6">
    <!-- Registration poli history -->
    <div class="card">
        <h5 class="card-header">Riwayat daftar poli</h5>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Poli</th>
                        <th scope="col">Dokter</th>
                        <th scope="col">Hari</th>
                        <th scope="col">Mulai</th>
                        <th scope="col">Selesai</th>
                        <th scope="col">Antiran</th>
                    </tr>
                </thead>
                <tbody>

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
                                                  WHERE a.id_pasien = $id_pasien
                                                  ORDER BY a.id desc");

$poli->execute();
$no = 0;
if ($poli->rowCount() == 0) {
    echo "Tidak ada data";
} else {
    while ($p = $poli->fetch()) {
?>
<tr>
    <th scope="row">
         <?php
          ++$no; 
         if ($no == 1){
            echo "<span class='badge badge-info'>New</span>";
         }else {
            echo $no;
         }
         ?>
         </th>
    <td><?php echo $p['poli_nama']; ?></td>
    <td><?php echo $p['dokter_nama']; ?></td>
    <td><?php echo $p['jadwal_hari']; ?></td>
    <td><?php echo $p['jadwal_mulai']; ?></td>
    <td><?php echo $p['jadwal_selesai']; ?></td>
    <td><?php echo $p['antrian']; ?></td>
    <td>
        <a href="detail_poli.php/<?= $p['poli_id']?>">
            <button class="btn btn-success btn-sm">Detail</button>
        </a>
    </td>        
</tr>
<?php
    }
}
?>

</tbody>
</table>
</div>
</div>
</div>
<!--end-->

</div>
</div>
</div><!--end container-fluid-->
</div><!--end main-->

<script>
document.getElementById('inputPoli').addEventListener('change', function() {
    var poliId = this.value; // Ambil nilai ID poli yang dipilih
    loadJadwal(poliId); // Panggil fungsi untuk memuat jadwal dokter
});

function loadJadwal(poliId) {
    // Buat objek XMLHttpRequest
    var xhr = new XMLHttpRequest();

    // Konfigurasi permintaan Ajax
    xhr.open('GET', 'http://localhost/Projek_BK/get_jadwal.php?poli_id=' + poliId, true);

    // Atur header untuk menentukan bahwa respons yang diharapkan adalah HTML
    xhr.setRequestHeader('Content-Type', 'text/html');

    // Atur fungsi callback ketika permintaan selesai
    xhr.onload = function() {
        if (xhr.status == 200) {
            // Jika permintaan berhasil, perbarui opsi pada select pilih jadwal
            document.getElementById('inputJadwal').innerHTML = xhr.responseText;
        }
    };

    // Kirim permintaan
    xhr.send();
}
</script>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>