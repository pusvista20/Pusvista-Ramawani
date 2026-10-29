<?php
require_once 'config/database.php'; require_once 'includes/auth.php';
$id=(int)($_GET['id']??0);$st=$pdo->prepare('SELECT * FROM dokumen WHERE id=?');$st->execute([$id]);$d=$st->fetch();
if(!$d){http_response_code(404);exit('Dokumen tidak ditemukan.');}
$pageTitle='Detail Dokumen';require 'includes/header.php';
?>
<div class="page-heading"><div><h1>Detail Dokumen</h1><div class="subheading">Informasi dan pratinjau dokumen.</div></div><a class="btn btn-outline-secondary" href="dokumen.php">Kembali</a></div>
<div class="row g-3"><div class="col-lg-4"><div class="panel"><div class="panel-title">Informasi</div><dl class="row small"><dt class="col-5">Nomor</dt><dd class="col-7"><?= htmlspecialchars($d['nomor_dokumen']) ?></dd><dt class="col-5">Tanggal</dt><dd class="col-7"><?= htmlspecialchars($d['tanggal']) ?></dd><dt class="col-5">Jenis</dt><dd class="col-7"><?= htmlspecialchars($d['jenis_dokumen']) ?></dd><dt class="col-5">Nama</dt><dd class="col-7"><?= htmlspecialchars($d['nama_dokumen']) ?></dd><dt class="col-5">Keterangan</dt><dd class="col-7"><?= nl2br(htmlspecialchars($d['keterangan']??'-')) ?></dd></dl><a class="btn btn-primary w-100" href="download.php?id=<?= $d['id'] ?>">Download PDF</a></div></div>
<div class="col-lg-8"><div class="panel p-2"><iframe title="Pratinjau PDF" src="preview.php?id=<?= $d['id'] ?>" style="width:100%;height:650px;border:0;border-radius:8px"></iframe></div></div></div>
<?php require 'includes/footer.php'; ?>
