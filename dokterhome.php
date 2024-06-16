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
                        <h3>Dashboard Dokter</h3>
                    </div>

                    </div>
        <div class="container py-1" style="background-color:#FFF5E4";>
        <div class="row">
            <div class="col-12">
                <h2  class="text-center"></h2>
            </div>
        </div>
    </div>

    <div class="container-fluid" style="background-color:#FFF5E4";>
                <div class="container">
            <div class="row">
                <div class="col-4";>
                <div class="card"
                style="background-color:#FFD1D1";>
  <div class="card-header">
    Riwayat Pasien
  </div>
  <div class="card-body">
    <blockquote class="blockquote mb-0">
      <b><center><h3>463</h3></center></b>
     <br> <center><footer class="blockquote-footer">Pasien</footer></center>
    </blockquote>
  </div>
</div>
</div>
<div class="col-4">
                <div class="card"
                style="background-color:#FFD1D1";>
  <div class="card-header">
    Janji Konsultasi
  </div>
  <div class="card-body">
    <blockquote class="blockquote mb-0">
      <b><center><h3>20</h3></center></b>
     <br> <center><footer class="blockquote-footer">Pasien</footer></center>
    </blockquote>
  </div>
</div>
</div>

                <div class="col-4">
                   <br> <br><center><h5>"Hallo, dr. hani"</h5></center>
                    <center><p>Semangat Kerjanya hari ini!</p></center>
                </div>
                </div>
                </div>
</div>

                <div class="container py-2" style="background-color:#FFF5E4";>
        <div class="row">
            <div class="col-12">
                <h2  class="text-center"></h2>
            </div>
        </div>
    </div>
                </div>
            </div>
            <div class="container-fluid  m-4" style="background-color:#FFE3E1";>
        <div class="container" >
      <div class="row">
          <div class="col-12">
              <h2  class="text-center"></h2>
          </div>
      </div>
    </div>

    <div class="row">
      <div class="col-4">
      <ul class="list-group list-group-flush" >
 <b> <li class="list-group-item"style="background-color:#FFE3E1";>Jadwal Jaga Dokter 2024</li></b>
  <li class="list-group-item"style="background-color:#FFF5E4";>1. Senin  (Malam)</li>
  <li class="list-group-item"style="background-color:#FFE3E1";>2. Selasa (Pagi)</li>
  <li class="list-group-item"style="background-color:#FFF5E4";>3. Rabu   (Pagi)</li>
  <li class="list-group-item"style="background-color:#FFE3E1";>4. Jumat  (Malam)</li>
  <li class="list-group-item"style="background-color:#FFF5E4";>5. Sabtu  (Malam)</li>
</ul>

      </div>
    <div class="col-8">
    <img src="sources/diagram.svg" class="img-fluid" alt="..." width= "500px">
    </div>
</div>
        </div>
                </div>
            </div>
        </div>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>