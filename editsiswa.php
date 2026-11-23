<?php
require_once "database.php";
require_once "auth.php";
require_once "seeder.php";
if (empty(isset($_GET['id']))) {
header("Location: siswa.php");
exit;
}
$db = new Database();
$pdo = $db->GetConnection();
$stmt = $pdo->query("SELECT id_kelas, nama_kelas FROM kelas ORDER BY nama_kelas ASC");
$daftarKelas = $stmt->fetchAll();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
if (mb_strlen($_POST['nisn'], 'UTF-8') == 10) {
$produk = new Siswa($db->getConnection());
$produk->ubah($_GET['id'],$_POST['nisn'], $_POST['nama'], $_POST['alamat'], $_POST['idkelas']);
header("Location: siswa.php");
exit;
} else {
$error = "NISN wajib 10 digit";
}
}
?>
<h2>Edit Siswa</h2>
<?php if (!empty($error)): ?>
<p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
<?php endif; ?>
<form method="post">
NISN : <input type="text" name="nisn" required><br>
Nama : <input type="text" name="nama" required><br>
Alamat : <input type="text" name="alamat"><br>
<select name="idkelas" id="idkelas" required>
<option value="">Pilih Kelas</option>
<?php foreach ($daftarKelas as $kelas): ?>
<option value="<?= htmlspecialchars((string) $kelas['id_kelas'], ENT_QUOTES, 'UTF-8') ?>">
<?= htmlspecialchars($kelas['nama_kelas'], ENT_QUOTES, 'UTF-8') ?>
</option>
<?php endforeach; ?>
</select><br>
<button type="submit">Update</button>
</form>
<a href="siswa.php">Kembali</a>
<link rel="stylesheet" href="style.css"> 
