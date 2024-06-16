<?php
session_start();
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST"){

//Mendapatkan nilai dari form atribut name di input
$nama = $_POST ['nama'];
$alamat = $_POST ['alamat'];
$no_ktp = $_POST ['no_ktp'];
$no_hp = $_POST ['no_hp'];

//kondisi 1

//cek apakah pasien sudah terdaftar berdasarkan no ktp
$query_check_pasien = "SELECT id, nama, no_rm FROM pasien WHERE no_ktp = '$no_ktp'";
$result_check_pasien = mysqli_query($conn, $query_check_pasien);

if (mysqli_num_rows($result_check_pasien) > 0) {
    $row = mysqli_fetch_assoc($result_check_pasien);

    if ($row['nama'] != $nama) {
        // ketika nama tidak sesuai dengan no_ktp
        echo "<script>alert('Nama pasien tidak sesuai dengan nomor KTP yang terdaftar.');</script>";
        echo "<meta http-equiv='refresh' content='0; url=../Projek_BK/register.php'>";
        die();
    
    }
    
    $_SESSION['signup'] = true;
    $_SESSION['id'] = $row['id'];
    $_SESSION['username'] = $nama;
    $_SESSION['no_rm'] = $row['no_rm'];
    $_SESSION['akses'] = 'pasien';

    echo "<meta http-equiv='refresh' content='0; url=../Projek_BK/pasienhome.php'>";
    die();
    
}

// Situasi 2
// Query untuk mendapatkan nomor pasien terakhir - YYYYMM-XXX -- 202312-004
$queryGetRm = "SELECT MAX(SUBSTRING(no_rm, 8)) as last_queue_number FROM pasien";
$resultRm = mysqli_query($conn, $queryGetRm);

// Periksa hasil query
if (!$resultRm) {
    die("Query gagal: " . mysqli_error($conn));
}

// Ambil nomor antrian terakhir dari hasil query
$rowRm = mysqli_fetch_assoc($resultRm);
$lastQueueNumber = $rowRm['last_queue_number'];

// Jika tabel kosong, atur nomor antrian menjadi 0
$lastQueueNumber = $lastQueueNumber ? $lastQueueNumber : 0;

// Mendapatkan tahun saat ini (misalnya, 202312)
$tahun_bulan = date("Ym");

// Membuat nomor antrian baru dengan menambahkan 1 pada nomor antrian terakhir
$newQueueNumber = $lastQueueNumber + 1;

// Menyusun nomor rekam medis dengan format YYYYMM-XXX
$no_rm = $tahun_bulan . "-" . str_pad ($newQueueNumber, 3, '0', STR_PAD_LEFT);

//insert
$query = "INSERT INTO pasien (nama, alamat, no_ktp, no_hp, no_rm) VALUES ('$nama', '$alamat', '$no_ktp', '$no_hp','$no_rm')";

//eksekusi query
if (mysqli_query($conn, $query)){
    //set session variables
    $_SESSION['signup']= true; //langsung ke dashboard
    $_SESSION['id']= mysqli_insert_id($conn);
    $_SESSION['username']= $nama;
    $_SESSION['no_rm']= $no_rm;
    $_SESSION['akses']= 'pasien';

    //redirect ke dashboard
    echo "<meta http-equiv='refresh' content='0; url=../Projek_BK/pasienhome.php'>";
    die();
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($conn); 
}


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/style1.css">
</head>
<body>
<div id="app">
    <h1>Register New Account</h1>
    <?php
    if (isset($_SESSION['error'])) : 
    ?>
   
  <p> <?php echo $_SESSION['error'];
   unset($_SESSION['error']); 
   ?></p>
   <?php endif; ?>
    
    <form action="" method="post">
        <input type="text" name="nama" class="form-control" required placeholder="Full name" /> <br><br>
        <input type="text" name="alamat" class="form-control" required placeholder="Alamat" /> <br><br>
        <input type="number" name="no_ktp" class="form-control" required placeholder="No Ktp" /> <br><br>
        <input type="number" name="no_hp" class="form-control" required placeholder="No Hp" /> <br><br>
        <input type="submit" name="submit" value="Register"/>
    </form>
   <br> <a class="btn" href="../Projek_BK/login_pasien.php" role="button">Sudah Punya Akun? Login Disini.</a>
</body>
</html>