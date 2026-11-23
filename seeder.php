<?php
class Kelas {
private $pdo;
public function __construct($pdo) {
$this->pdo = $pdo;
}
public function semua() {
return $this->pdo->query("SELECT * FROM kelas ORDER BY id_kelas")->fetchAll();
}
public function tambah($namakelas,$jurusan) {
$stmt = $this->pdo->prepare(
"INSERT INTO kelas (nama_kelas, jurusan) VALUES (?, ?)"
);
return $stmt->execute([$namakelas, $jurusan]);
}
public function ubah($id, $namakelas, $jurusan) {
$stmt = $this->pdo->prepare(
"UPDATE kelas SET nama_kelas = ?, jurusan = ? WHERE id_kelas = ?"
);
return $stmt->execute([$namakelas, $jurusan, $id]);
}
public function punyaSiswa($id): bool
{
$stmt = $this->pdo->prepare('SELECT 1 FROM siswa WHERE id_kelas = :id LIMIT 1');
$stmt->execute([':id' => $id]);
return (bool) $stmt->fetchColumn();
}
public function hapus($id) {
$stmt = $this->pdo->prepare("DELETE FROM kelas WHERE id_kelas = ?");
return $stmt->execute([$id]);
}
}

class Siswa {
private $pdo;
public function __construct($pdo) {
$this->pdo = $pdo;
}
public function semua() {
return $this->pdo->query("SELECT * FROM siswa s join kelas k on s.id_kelas = k.id_kelas ORDER BY s.id_kelas")->fetchAll();
}
public function tambah($nisn,$nama,$alamat,$id_kelas) {
$stmt = $this->pdo->prepare(
"INSERT INTO siswa (nisn,nama,alamat,id_kelas) VALUES (?,?,?,?)"
);
return $stmt->execute([$nisn,$nama,$alamat,$id_kelas]);
}
public function ubah($targetnisn,$nisn,$nama,$alamat,$id_kelas) {
$stmt = $this->pdo->prepare(
"UPDATE siswa SET nisn = ?, nama = ?, alamat = ?, id_kelas = ? WHERE nisn = ?"
);
return $stmt->execute([$nisn,$nama,$alamat,$id_kelas,$targetnisn]);
}
public function hapus($nisn) {
$stmt = $this->pdo->prepare("DELETE FROM siswa WHERE nisn = ?");
return $stmt->execute([$nisn]);
}
public function cari($target) {
$searchTerm = "%" . $target . "%";
$stmt = $this->pdo->prepare("SELECT * FROM siswa s join kelas k on s.id_kelas = k.id_kelas WHERE nama LIKE ? ORDER BY s.id_kelas");
$stmt->execute([$searchTerm]);
return $stmt->fetchAll(); 
}
}

class Presensi {
private $pdo;
public function __construct($pdo) {
$this->pdo = $pdo;
}
public function semua() {
return $this->pdo->query("SELECT * FROM presensi p join siswa s on p.nisn = s.nisn join kelas k on s.id_kelas = k.id_kelas")->fetchAll();
}
public function hapus($id) {
$stmt = $this->pdo->prepare("DELETE FROM presensi WHERE id = ?");
return $stmt->execute([$id]);
}
public function daftar($nisn) {
$stmt = $this->pdo->prepare(
"INSERT INTO presensi (nisn) VALUES (?)"
);
return $stmt->execute([$nisn]);
}
public function caritanggal($target, $tanggal)
{
$sql = "SELECT p.*, s.nama, k.nama_kelas FROM presensi p JOIN siswa s ON p.nisn = s.nisn JOIN kelas k ON s.id_kelas = k.id_kelas WHERE 1=1";
$params = [];
if (!empty($target)) {
$sql .= " AND s.nama LIKE ?";
$params[] = '%' . $target . '%';
}
if (!empty($tanggal)) {
$sql .= " AND DATE(p.tanggal_waktu) = ?";
$params[] = $tanggal;
}
$sql .= " ORDER BY p.tanggal_waktu DESC";
$stmt = $this->pdo->prepare($sql);
$stmt->execute($params);
return $stmt->fetchAll();
}
}