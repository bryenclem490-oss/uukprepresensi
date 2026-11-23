<?php
require_once "database.php";
require_once "auth.php";
require_once "seeder.php";
include "layout/header.php";
include "layout/sidebar.php";
$db = new Database(); 
$kelas = new Kelas($db->getConnection());
$data = $kelas->semua();

if (isset($_GET['error']) && $_GET['error'] == 'invalid') {
$error = 'Tidak bisa dihapus, kelas masih ada siswa.';
}
?>
<main>
<h2>Kelas</h2>

<?php if (!empty($error)): ?>
<p style="color: red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<a href="addkelas.php">+ Tambah kelas</a>


<table border="1" cellpadding="6">
<tr>
<th>ID</th><th>Nama Kelas</th><th>Jurusan</th>
</tr>
<?php if (!empty($data)): ?>
<?php foreach ($data as $k): ?>
<tr>
<td><?= $k['id_kelas'] ?></td>
<td><?= htmlspecialchars($k['nama_kelas']) ?></td>
<td><?= htmlspecialchars($k['jurusan']) ?></td>
<td>
<a href="editkelas.php?id=<?= $k['id_kelas'] ?>">Edit</a> |
<a href="delete.php?id=<?= $k['id_kelas'] ?>&targettable=kelas" onclick="return confirm('hapus Kelas ini?')">Hapus</a>
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