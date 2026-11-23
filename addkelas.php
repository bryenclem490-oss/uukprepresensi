<?php
require_once "database.php";
require_once "auth.php";
require_once "seeder.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 $db = new Database();
 $siswa = new Kelas($db->getConnection());
 $siswa->tambah($_POST['namakelas'], $_POST['jurusan']);
 header("Location: kelas.php");
 exit;
}
?>
<h2>Tambah Kelas</h2>
<form method="post">
 Nama kelas : <input type="text" name="namakelas" required><br>
 Jurusan : <input type="text" name="jurusan" required><br>
 <button type="submit">Simpan</button>
</form>
<a href="presensi.php">Kembali</a>
<link rel="stylesheet" href="style.css"> 