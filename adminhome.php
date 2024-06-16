<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin </title>
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
            <a href="#" class="sidebar-link">
                <img src="sources/admin.png" alt="" width="25" height="25" class="d-inline-block align-text-top">
                        <span>Admin</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="http://localhost/Projek_BK/adminhome.php" class="sidebar-link">
                    <img src="sources/home.png" alt="" width="24" height="24" class="d-inline-block align-text-top">
                        <span>Home</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="http://localhost/Projek_BK/dokterhome.php" class="sidebar-link">
                    <img src="sources/doctor.png" alt="" width="24" height="24" class="d-inline-block align-text-top">
                        <span>Dokter</span>
                    </a>
                </li>
                </li>
                    <li class="sidebar-item">
                    <a href="http://localhost/Projek_BK/pasienhome.php" class="sidebar-link">
                    <img src="sources/pasien.png" alt="" width="24" height="24" class="d-inline-block align-text-top">
                        <span>Pasien</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="http://localhost/Projek_BK/poli.php" class="sidebar-link">
                    <img src="sources/clinic.png" alt="" width="24" height="24" class="d-inline-block align-text-top">
                        <span>Poli</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="http://localhost/Projek_BK/obat.php" class="sidebar-link">
                    <img src="sources/obat.png" alt="" width="24" height="24" class="d-inline-block align-text-top">
                        <span>Obat</span>
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
                        <h3>Dashboard Admin</h3>
                    </div>

                    <div class="container m-3" style="background-color:#FFF5E4";>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h6>Selamat datang, Admin!</h6>
                    </div>


                    <div class="container-fluid py-3" style="background-color:#FFF5E4";>
                <div class="container">
            <div class="row">
                <div class="col-4">
                    <div class="card text mb-3" style="max-width: 18rem" ;>
                        <div class="card-header"style="background-color:#FFD1D1";>Kunjungan Website</div>
                        <div class="card-body">
                            <h1 class="card-title">2.003</h1>
                            <p class="card-text">User</p>
                    </div>
                        </div>
                </div>

                <div class="col-4">
                    <div class="card text mb-3" style="max-width: 18rem";>
                        <div class="card-header" style="background-color:#FFD1D1";>Kunjungan Pasien</div>
                        <div class="card-body">
                            <h1 class="card-title">1880</h1>
                            <p class="card-text">Pasien</p>
                    </div>
                        </div>
                </div> 

                <div class="col-4">
                    <div class="card text mb-3" style="max-width: 18rem" ;>
                        <div class="card-header" style="background-color:#FFD1D1";>Kunjungan Dokter </div>
                        <div class="card-body">
                            <h1 class="card-title">443</h1>
                            <p class="card-text">Dokter</p>
                    </div>
                        </div>
                </div>
                </div> 
            </div>
                </div>
            </div>


            <div class="container-fluid" style="background-color:#FFF5E4";>
                <div class="container">
            <div class="row">
                <div class="col-4">
                   <div class ="card text" style="max-width: 18rem" ;>
                        <div class="card-header"style="background-color:#FF8080";>user Tidak Aktif</div>
                        <div class="card-body">
                            <h1 class="card-title">1003</h1>
                            <p class="card-text">User</p>
                    </div>
                        </div>
                </div>

                <div class="col-4">
                    <div class="card text" style="max-width: 18rem";>
                        <div class="card-header" style="background-color:#9DDE8B";>User Aktif</div>
                        <div class="card-body">
                            <h1 class="card-title">1000</h1>
                            <p class="card-text">User</p>
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