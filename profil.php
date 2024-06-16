<?php
include_once("config.php");
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

$dokter = query("SELECT * FROM dokter WHERE id = $id")[0];

if (isset($_POST["submit"])) {
  // cek apakah data berhasil di ubah atau tidak
  if (ubahDokter($_POST) > 0) {
    $_SESSION['username'] = $_POST['nama'];

    echo "
        <script>
            alert('Data berhasil diubah');
            document.location.href = '../Projek_BK/profil.php';
        </script>
    ";
    session_write_close();
    header("Refresh:0"); // Me-refresh halaman setelah perubahan data
    exit;
  } else {
    echo "
        <script>
            alert('Data Gagal diubah');
            document.location.href = '../Projek_BK/profil.php';
        </script>
    ";
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

        <div class="container-fluid py-2" style="background-color:#FFF5E4";>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3>Profil</h3>
                    </div>

      <!-- Main content -->
      <section class="content">
        <div class="card">
          <form id="editForm" action="" method="POST">
            <input type="hidden" name="id" value="<?= $dokter["id"]; ?>">
            <div class="card-body">
              <div class="form-group">
                <label for="nama">Nama Dokter</label>
                <input type="text" id="nama" name="nama" class="form-control" value="<?= $dokter['nama']; ?>">
              </div>
              <div class="form-group">
                <label for="alamat">Alamat Dokter</label>
                <input type="text" id="alamat" name="alamat" class="form-control" value="<?= $dokter['alamat']; ?>">
              </div>
              <div class="form-group">
                <label for="no_hp">Telepon Dokter</label>
                <input type="number" id="no_hp" name="no_hp" class="form-control" value="<?= $dokter['no_hp']; ?>">
              </div>
              <div class="d-flex justify-content-left">
                <button type="submit" name="submit" id="submitButton" class="btn btn-success" disabled>Update</button>
              </div>
            </div>
          </form>
        </div>
      </section>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('editForm');
    const inputs = form.querySelectorAll('input');
    const submitButton = document.getElementById('submitButton');

    const initialValues = {};
    inputs.forEach(input => {
      initialValues[input.id] = input.value;
    });

    const checkChanges = () => {
      let changes = false;
      inputs.forEach(input => {
        if (input.value !== initialValues[input.id]) {
          changes = true;
        }
      });
      return changes;
    };

    const toggleSubmit = () => {
      if (checkChanges()) {
        submitButton.disabled = false;
      } else {
        submitButton.disabled = true;
      }
    };

    inputs.forEach(input => {
      input.addEventListener('input', toggleSubmit);
    });
  });
</script>
</body>

</html>
