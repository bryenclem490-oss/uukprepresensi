<?php
require_once "database.php";
require_once "auth.php";
require_once "seeder.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$db = new Database();
$pdo = $db->GetConnection();
$check = $pdo->prepare("SELECT nisn FROM siswa WHERE nisn = ?");
$check->execute([$_POST['nisn']]);
if ($check->fetch() !== false) {
$presensi = new Presensi($db->getConnection());
$presensi->daftar($_POST['nisn']);
$mess = "Berhasil";
} else {
$mess = "NISN yang Anda masukkan tidak ada";
}
}
?>
<h2>Simulasi Tap Kartu</h2>
<?php if (!empty($mess)): ?>
<p><?php echo htmlspecialchars($mess, ENT_QUOTES, 'UTF-8'); ?></p>
<?php endif; ?>
<form method="post">
NISN : <input type="text" name="nisn" required><br>
<button type="submit">Simpan</button>
</form>
<a href="presensi.php">Kembali</a>
<link rel="stylesheet" href="style.css"> 