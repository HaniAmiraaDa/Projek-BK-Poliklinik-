<?php
session_start();
include ("config.php");

$nama_obat = '';
$kemasan = '';
$harga = '';

if (isset($_GET['id'])) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM obat WHERE id = :id");
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $nama_obat = $row['nama_obat'];
            $kemasan = $row['kemasan'];
            $harga = $row['harga'];
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if (isset($_POST['simpan'])) {
    if (isset($_POST['id'])) {
        $stmt = $pdo->prepare("UPDATE obat SET nama_obat= :nama_obat, kemasan= :kemasan, harga= :harga WHERE id= :id");
        $stmt->bindParam(':nama_obat', $_POST['nama_obat'], PDO::PARAM_STR);
        $stmt->bindParam(':kemasan', $_POST['kemasan'], PDO::PARAM_STR);
        $stmt->bindParam(':harga', $_POST['harga'], PDO::PARAM_INT);
        $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
        $stmt->execute();

        header('Location: obat.php');
        exit();
    } else {
        $stmt = $pdo->prepare("INSERT INTO obat (nama_obat, kemasan, harga) VALUES (:nama_obat, :kemasan, :harga)");
        $stmt->bindParam(':nama_obat', $_POST['nama_obat'], PDO::PARAM_STR);
        $stmt->bindParam(':kemasan', $_POST['kemasan'], PDO::PARAM_STR);
        $stmt->bindParam(':harga', $_POST['harga'], PDO::PARAM_INT);
        $stmt->execute();

        header('Location: obat.php');
        exit();
    }
}

if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
    $stmt = $pdo->prepare("DELETE FROM obat WHERE id = :id");
    $stmt->bindParam(':id', $_GET['id']);
    $stmt->execute();

    header('Location: obat.php');
    exit();
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
            <ul class="sidebar-nav">
                <li class="sidebar-item">
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
                <li class="sidebar-item">
                    <a href="http://localhost/Projek_BK/pasienhome.php" class="sidebar-link">
                        <img src="sources/pasien.png" alt="" width="24" height="24" class="d-inline-block align-text-top">
                        <span>Pasien</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="http://localhost/Projek_BK/poli.php#" class="sidebar-link">
                        <img src="sources/clinic.png" alt="" width="24" height="24" class="d-inline-block align-text-top">
                        <span>Poli</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="http://localhost/Projek_BK/obat.php#" class="sidebar-link">
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
            <div class="container-fluid py-2" style="background-color:#FFF5E4;">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h3>Daftar Obat</h3>
                        </div>

                        <!--crud obat-->
                        <div class="mx-auto">

                            <!--untuk memasukkan data-->
                            <div class="card">
                                <div class="card-header">
                                    Buat / Edit Data
                                </div>
                                <div class="card-body">
                                    <form action="" method="POST" name="myForm" onsubmit="return(validate());">
                                        <?php if (isset($_GET['id'])): ?>
                                            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                                        <?php endif; ?>
                                        <div class="mb-3 row">
                                            <label for="nama_obat" class="col-sm-2 col-form-label">Nama Obat</label>
                                            <div class="col-sm-10 mx-1">
                                                <input type="text" class="form-control" name="nama_obat" id="nama_obat" placeholder="Nama Obat" value="<?php echo $nama_obat ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="kemasan" class="col-sm-2 col-form-label">Kemasan</label>
                                            <div class="col-sm-10 mx-1">
                                                <input type="text" class="form-control" name="kemasan" id="kemasan" placeholder="Nama Kemasan" value="<?php echo $kemasan ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                                            <div class="col-sm-10 mx-1">
                                                <input type="text" class="form-control" name="harga" id="harga" placeholder="Harga" value="<?php echo $harga ?>">
                                            </div>
                                        </div>
                                        <div class="col-12 py-3">
                                            <button type="submit" class="btn rounded-pill" style="width: 3cm; background-color:#FFF5E4;" name="simpan">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!--untuk mengeluarkan data-->
                            <div class="card">
                                <div class="card-header">
                                    Data Obat
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Nama Obat</th>
                                                <th scope="col">Kemasan</th>
                                                <th scope="col">Harga</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $result = $pdo->query("SELECT * FROM obat");
                                            $no = 1;
                                            while ($data = $result->fetch(PDO::FETCH_ASSOC)) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $no++ ?></td>
                                                    <td><?php echo $data['nama_obat'] ?></td>
                                                    <td><?php echo $data['kemasan'] ?></td>
                                                    <td><?php echo $data['harga'] ?></td>
                                                    <td>
                                                        <a class="btn rounded-pill px-3" href="obat.php?id=<?php echo $data['id'] ?>">Edit</a>
                                                        <a class="btn rounded-pill px-3" href="obat.php?id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
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

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>
