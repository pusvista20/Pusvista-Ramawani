<?php
session_start();
if (!empty($_SESSION['user_id'])) { header('Location: index.php'); exit; }
require_once 'config/database.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare('SELECT id,nama,username,password FROM users WHERE username=? LIMIT 1');
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['username'] = $user['username'];
        header('Location: index.php'); exit;
    }
    $error = 'Username atau password tidak sesuai.';
}
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Login Sistem Digitalisasi Dokumen</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link href="assets/style.css" rel="stylesheet"></head>
<body><div class="login-page">
<section class="login-art">

    <img src="DPRD.png" width= "110%" height="110%"
         alt="Gedung DPRD Kota Medan"
         class="gambar-dprd">

    <div class="login-art-content">
       

        <h1>Sistem Digitalisasi Dokumen</h1>

        <p>
            Pengelolaan informasi dan arsip digital
            Komisi IV Sekretariat DPRD Kota Medan.
        </p>
    </div>

</section>
<section class="login-form-wrap"><div class="login-card"><div class="text-primary fw-bold mb-2">PORTAL ADMINISTRATOR</div><h2>Selamat datang</h2><p class="text-secondary mb-4">Masuk untuk mengelola dokumen digital.</p>
<?php if($error): ?><div class="alert alert-danger py-2"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post"><div class="mb-3"><label class="form-label">Username</label><input class="form-control" name="username" required autofocus autocomplete="username" placeholder="Masukkan username"></div><div class="mb-4"><label class="form-label">Password</label><input class="form-control" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan password"></div><button class="btn btn-primary w-100">Login</button></form>

