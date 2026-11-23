<?php
require_once "database.php";
require_once "auth.php";
require_once "seeder.php";
include "layout/header.php";
include "layout/sidebar.php";
$db = new Database(); 
$siswa = new Siswa($db->getConnection());
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['nama'])) {
$data = $siswa->cari($_POST['nama']);
} else {
$data = $siswa->semua(); 
}
?>
<main>
<h2>Siswa</h2>
<a href="addsiswa.php">+ Tambah Siswa</a>

<form method="POST">
<input type="text" name="nama" placeholder="Cari nama siswa..." value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>">
<button type="submit">Cari</button>
</form>

<table border="1" cellpadding="6">
<tr>
<th>NISN</th><th>Nama</th><th>Alamat</th><th>Kelas</th>
</tr>
<?php if (!empty($data)): ?>
<?php foreach ($data as $s): ?>
<tr>
<td><?= $s['nisn'] ?></td>
<td><?= htmlspecialchars($s['nama']) ?></td>
<td><?= htmlspecialchars($s['alamat']) ?></td>
<td><?= htmlspecialchars($s['nama_kelas']) ?></td>
<td>
<a href="editsiswa.php?id=<?= $s['nisn'] ?>">Edit</a> |
<a href="delete.php?id=<?= $s['nisn'] ?>&targettable=siswa" onclick="return confirm('hapus siswa ini?')">Hapus</a>
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