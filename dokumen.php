<?php
require_once 'config/database.php'; require_once 'includes/auth.php';
$pageTitle='Data Dokumen';
$q=trim($_GET['q']??'');
$sql='SELECT * FROM dokumen'; $params=[];
if($q!==''){ $sql.=' WHERE nomor_dokumen LIKE ? OR nama_dokumen LIKE ? OR jenis_dokumen LIKE ?'; $like='%'.$q.'%'; $params=[$like,$like,$like];}
$sql.=' ORDER BY tanggal DESC, id DESC';
$stmt=$pdo->prepare($sql);$stmt->execute($params);$rows=$stmt->fetchAll();
require 'includes/header.php';
?>
<div class="page-heading"><div><h1>Data Dokumen</h1><div class="subheading">Daftar berkas digital yang telah dimasukkan ke sistem.</div></div><a class="btn btn-primary" href="tambah_dokumen.php">＋ Tambah Dokumen</a></div>
<div class="panel"><form class="d-flex gap-2 mb-3" method="get"><input class="form-control search-box" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Cari nomor, nama, atau jenis dokumen..."><button class="btn btn-primary">Cari</button><a class="btn btn-outline-secondary" href="dokumen.php">Reset</a></form>
<div class="table-responsive"><table class="table"><thead><tr><th>No.</th><th>Nomor Dokumen</th><th>Tanggal</th><th>Jenis</th><th>Nama Dokumen</th><th>Keterangan</th><th>Aksi</th></tr></thead><tbody>
<?php if(!$rows): ?><tr><td colspan="7" class="empty-state">Data dokumen tidak ditemukan.</td></tr><?php else: foreach($rows as $i=>$d): ?>
<tr><td><?= $i+1 ?></td><td><?= htmlspecialchars($d['nomor_dokumen']) ?></td><td><?= htmlspecialchars($d['tanggal']) ?></td><td><span class="badge-soft"><?= htmlspecialchars($d['jenis_dokumen']) ?></span></td><td><?= htmlspecialchars($d['nama_dokumen']) ?></td><td><?= htmlspecialchars($d['keterangan']??'') ?></td><td class="text-nowrap"><a class="btn btn-sm btn-outline-primary" href="lihat_dokumen.php?id=<?= $d['id'] ?>">Lihat</a> <a class="btn btn-sm btn-outline-secondary" href="edit_dokumen.php?id=<?= $d['id'] ?>">Edit</a> <form class="d-inline" method="post" action="hapus_dokumen.php" onsubmit="return confirm('Hapus dokumen ini?')" ><input type="hidden" name="id" value="<?= $d['id'] ?>"><button class="btn btn-sm btn-outline-danger">Hapus</button></form></td></tr>
<?php endforeach; endif; ?></tbody></table></div><div class="small text-secondary">Jumlah data: <?= count($rows) ?></div></div>
<?php require 'includes/footer.php'; ?>
