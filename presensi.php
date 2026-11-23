<?php
require_once "database.php";
require_once "auth.php";
require_once "seeder.php";
include "layout/header.php";
include "layout/sidebar.php";
$db = new Database(); 
$presensi = new Presensi($db->getConnection());
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['date']) || !empty($_POST['nama'])) {
$inputnama = "";
$inputdate = "";
if (!empty($_POST['nama'])) {
$inputnama = $_POST['nama'];
}
if (!empty($_POST['date'])) {
$inputdate = $_POST['date'];
}
$data = $presensi->caritanggal($inputnama,$inputdate);
} else {
$data = $presensi->semua(); 
}
?>
<main>
<h2>Rekap Presensi</h2>
<a href="simulasirfid.php">+ Tambah</a>
<form method="POST">
<input type="text" name="nama" placeholder="Cari nama siswa..." value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>">
<input type="date" name="date">
<button type="submit">Cari</button>
</form>
<table border="1" cellpadding="6">
<tr>
<th>Nama</th><th>Kelas</th><th>Tanggal</th>
</tr>
<?php if (!empty($data)): ?>
<?php foreach ($data as $p): ?>
<tr>
<td><?=htmlspecialchars( $p['nama']) ?></td>
<td><?= htmlspecialchars($p['nama_kelas']) ?></td>
<td><?= htmlspecialchars($p['tanggal_waktu']) ?></td>
<td>
<a href="delete.php?id=<?= $p['id'] ?>&targettable=presensi" onclick="return confirm('hapus log ini?')">Hapus</a>
</td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr>
<td colspan="5" align="center">Data tidak ditemukan.</td>
</tr>
<?php endif; ?>
</table>
<link rel="stylesheet" href="style.css"> 
</main>