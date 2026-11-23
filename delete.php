<?php
require_once "database.php";
require_once "auth.php";
require_once "seeder.php";
if (isset($_GET['id']) && isset($_GET['targettable'])) {
$db = new Database();   
if ($_GET['targettable'] == "kelas") {
$table = new Kelas($db->getConnection());
if ($table->punyaSiswa($_GET['id'])) {
header('Location: kelas.php?error=invalid');
} else {
$table->hapus($_GET['id']);
header('Location: kelas.php');
}
} else { if ($_GET['targettable'] == "siswa") {
$table = new Siswa($db->getConnection());
$table->hapus($_GET['id']);
header('Location: siswa.php');
}
else { if ($_GET['targettable'] == "presensi") {
$table = new Presensi($db->getConnection());
$table->hapus($_GET['id']);
header('Location: presensi.php');
}
}
}
} else {
header('Location: dashboard.php');
}
exit;