<?php
require_once "database.php";
require_once "auth.php";
require_once "seeder.php";
if (empty(isset($_GET['id']))) {
header("Location: kelas.php");
exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 $db = new Database();
 $kelas = new Kelas($db->getConnection());
 $kelas->ubah($_GET['id'],$_POST['namakelas'], $_POST['jurusan']);
 header("Location: kelas.php");
 exit;
}
?>
<h2>Edit Kelas</h2>
<form method="post">
 Nama kelas : <input type="text" name="namakelas" required><br>
 Jurusan : <input type="text" name="jurusan" required><br>
 <button type="submit">Update</button>
</form>
<a href="kelas.php">Kembali</a>
<link rel="stylesheet" href="style.css"> 
