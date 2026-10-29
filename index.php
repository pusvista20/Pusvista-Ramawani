<?php
require_once 'config/database.php';
require_once 'includes/auth.php';
$pageTitle = 'Dashboard';
$total = (int)$pdo->query('SELECT COUNT(*) FROM dokumen')->fetchColumn();
$masuk = (int)$pdo->query("SELECT COUNT(*) FROM dokumen WHERE jenis_dokumen='Surat Masuk'")->fetchColumn();
$keluar = (int)$pdo->query("SELECT COUNT(*) FROM dokumen WHERE jenis_dokumen='Surat Keluar'")->fetchColumn();
$kategori = (int)$pdo->query('SELECT COUNT(DISTINCT jenis_dokumen) FROM dokumen')->fetchColumn();
$recent = $pdo->query('SELECT * FROM dokumen ORDER BY created_at DESC LIMIT 6')->fetchAll();
require 'includes/header.php';
?>
<div class="page-heading"><div><h1>Dashboard</h1><div class="subheading">Ringkasan pengelolaan dokumen digital.</div></div><a class="btn btn-primary" href="tambah_dokumen.php">＋ Tambah Dokumen</a></div>
<div class="row g-3 mb-4">
<?php foreach ([['Total Dokumen',$total,'▤'],['Surat Masuk',$masuk,'✉'],['Surat Keluar',$keluar,'➤'],['Kategori',$kategori,'▰']] as $s): ?>
<div class="col-6 col-xl-3"><div class="stat-card"><span class="stat-icon"><?= $s[2] ?></span><div class="stat-label"><?= $s[0] ?></div><div class="stat-number"><?= $s[1] ?></div><span class="text-secondary small">Data tersimpan</span></div></div>
<?php endforeach; ?></div>
<div class="panel"><div class="d-flex justify-content-between align-items-center mb-3"><div class="panel-title mb-0">Dokumen Terbaru</div><a href="dokumen.php" class="btn btn-outline-primary btn-sm">Lihat semua</a></div>
<div class="table-responsive"><table class="table"><thead><tr><th>No.</th><th>Nomor</th><th>Tanggal</th><th>Jenis</th><th>Nama Dokumen</th><th>Aksi</th></tr></thead><tbody>
<?php if(!$recent): ?><tr><td colspan="6" class="empty-state">Belum ada dokumen. Klik “Tambah Dokumen” untuk memulai.</td></tr><?php else: foreach($recent as $i=>$d): ?>
<tr><td><?= $i+1 ?></td><td><?= htmlspecialchars($d['nomor_dokumen']) ?></td><td><?= htmlspecialchars($d['tanggal']) ?></td><td><span class="badge-soft"><?= htmlspecialchars($d['jenis_dokumen']) ?></span></td><td><?= htmlspecialchars($d['nama_dokumen']) ?></td><td><a class="btn btn-sm btn-outline-primary" href="lihat_dokumen.php?id=<?= $d['id'] ?>">Lihat</a></td></tr>
<?php endforeach; endif; ?></tbody></table></div></div>
<?php require 'includes/footer.php'; ?>
