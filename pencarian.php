<?php
require_once 'config/database.php';require_once 'includes/auth.php';$pageTitle='Pencarian Dokumen';
$q=trim($_GET['q']??'');$jenis=$_GET['jenis']??'';$from=$_GET['dari']??'';$to=$_GET['sampai']??'';
$sql='SELECT * FROM dokumen WHERE 1=1';$params=[];
if($q!==''){$sql.=' AND (nomor_dokumen LIKE ? OR nama_dokumen LIKE ? OR keterangan LIKE ?)';$like='%'.$q.'%';array_push($params,$like,$like,$like);}
if($jenis!==''){$sql.=' AND jenis_dokumen=?';$params[]=$jenis;}
if($from!==''){$sql.=' AND tanggal>=?';$params[]=$from;}
if($to!==''){$sql.=' AND tanggal<=?';$params[]=$to;}
$sql.=' ORDER BY tanggal DESC';$st=$pdo->prepare($sql);$st->execute($params);$rows=$st->fetchAll();$types=['Surat Masuk','Surat Keluar','Laporan','Undangan','Lainnya'];
require 'includes/header.php';
?>
<div class="page-heading"><div><h1>Pencarian Dokumen</h1><div class="subheading">Cari berdasarkan kata kunci, jenis, atau rentang tanggal.</div></div></div>
<div class="panel mb-4"><form method="get" class="row g-3 align-items-end"><div class="col-lg-4"><label class="form-label">Kata kunci</label><input class="form-control" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Nomor, nama, keterangan"></div><div class="col-lg-2"><label class="form-label">Jenis</label><select class="form-select" name="jenis"><option value="">Semua jenis</option><?php foreach($types as $t): ?><option value="<?= $t ?>" <?= $jenis===$t?'selected':'' ?>><?= $t ?></option><?php endforeach; ?></select></div><div class="col-lg-2"><label class="form-label">Tanggal dari</label><input type="date" class="form-control" name="dari" value="<?= htmlspecialchars($from) ?>"></div><div class="col-lg-2"><label class="form-label">Tanggal sampai</label><input type="date" class="form-control" name="sampai" value="<?= htmlspecialchars($to) ?>"></div><div class="col-lg-2 d-flex gap-2"><button class="btn btn-primary">Cari</button><a href="pencarian.php" class="btn btn-outline-secondary">Reset</a></div></form></div>
<div class="panel"><div class="panel-title">Hasil pencarian (<?= count($rows) ?>)</div><div class="table-responsive"><table class="table"><thead><tr><th>Nomor</th><th>Tanggal</th><th>Jenis</th><th>Nama Dokumen</th><th>Aksi</th></tr></thead><tbody><?php if(!$rows): ?><tr><td colspan="5" class="empty-state">Tidak ada dokumen yang cocok dengan pencarian.</td></tr><?php else: foreach($rows as $d): ?><tr><td><?= htmlspecialchars($d['nomor_dokumen']) ?></td><td><?= htmlspecialchars($d['tanggal']) ?></td><td><span class="badge-soft"><?= htmlspecialchars($d['jenis_dokumen']) ?></span></td><td><?= htmlspecialchars($d['nama_dokumen']) ?></td><td><a class="btn btn-sm btn-outline-primary" href="lihat_dokumen.php?id=<?= $d['id'] ?>">Lihat</a> <a class="btn btn-sm btn-outline-success" href="download.php?id=<?= $d['id'] ?>">Download</a></td></tr><?php endforeach; endif; ?></tbody></table></div></div>
<?php require 'includes/footer.php'; ?>
