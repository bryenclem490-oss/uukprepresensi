<?php
require_once "database.php";
session_start();

if (!empty($_SESSION['user_id'])) {
header("Location: kelas.php");
exit;
}

if (isset($_GET['error']) && $_GET['error'] == 'unauthorized') {
$error = 'Silakan masuk terlebih dahulu.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
$error = "Username dan password wajib diisi.";
} else {
try {
$db = new Database();
$pdo = $db->getConnection();

$stmt = $pdo->prepare("SELECT id_user, username, password FROM users WHERE username = :username LIMIT 1");
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
session_regenerate_id(true);

$_SESSION['user_id'] = $user['id_user'];
$_SESSION['username'] = $user['username'];

header("Location: kelas.php");
exit;
} else {
$error = "Username atau password salah.";
}
} catch (PDOException $e) {
$error = "Terjadi kesalahan pada database.";
}
}
}
?>

<h2>Login</h2>

<?php if (!empty($error)): ?>
<p style="color: red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST" action="">
<div>
<label for="username">Username</label><br>
<input type="text" id="username" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
</div>
<br>
<div>
<label for="password">Password</label><br>
<input type="password" id="password" name="password" required>
</div>
<br>
<button type="submit">Masuk</button>
</form>
<link rel="stylesheet" href="style.css"> 
<?php
// echo password_hash('12345', PASSWORD_DEFAULT);
