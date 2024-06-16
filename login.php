<?php
session_start();
include("config.php");
// Inisialisasi pesan error
$err = "";
$username = "";
$password ="";


if (isset($_POST['submit'])) {
    // Pastikan koneksi PDO sudah diinisialisasi sebelumnya
    // Contoh:
    // $pdo = new PDO('mysql:host=localhost;dbname=nama_database', 'username', 'password');
    
    $username = stripslashes($_POST['nama']);
    $password = $_POST['alamat'];
    
    if ($username == 'admin') {
        if ($password == 'admin') {
            $_SESSION['login'] = true;
            $_SESSION['id'] = null;
            $_SESSION['username'] = 'admin';
            $_SESSION['akses'] = 'admin';
            echo "<meta http-equiv='refresh' content='0;url=../Projek_BK/adminhome.php'>";
            die();
        }
    } else {
        $cek_username = $pdo->prepare("SELECT * FROM dokter WHERE nama = '$username'; ");
        try {
           
            $cek_username->execute();
            if ($cek_username->rowCount() == 1) {
                $baris = $cek_username->fetch(PDO::FETCH_ASSOC);
                
                if ($password == $baris['alamat']) {
                    $_SESSION['login'] = true;
                    $_SESSION['id'] = $baris['id'];
                    $_SESSION['username'] = $baris['nama'];
                    $_SESSION['akses'] = 'dokter';
                    echo "<meta http-equiv='refresh' content='0;url=../Projek_BK/dokterhome.php'>";
                    die();
                
                }
    }
} catch (PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    echo "<meta http-equiv='refresh' content='0;'>";
    die();
}
    }
   $_SESSION['error']= 'Username dan Password Tidak cocok';
   echo "<meta http-equiv='refresh' content='0;'>";
   die(); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style1.css">
</head>
<body>
<div id="app">
    <h1>Log In</h1>
    <?php
    if (isset($_SESSION['error'])) : 
    ?>
   
  <p> <?php echo $_SESSION['error'];
   unset($_SESSION['error']); 
   ?></p>
   <?php endif; ?>
    
    <form action="" method="post">
        <input type="text" value="drhani" name="nama" class="input" placeholder="Username | Case Sensitive" /> <br><br>
        <input type="password" value="semarang" name="alamat" class="input" placeholder="Password  | Case Sensitive" /> <br><br>
        <input type="submit" name="submit" value="Login"/>
    </form>
</div>
</body>
</html>