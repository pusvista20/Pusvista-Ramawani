<?php
require_once 'config/database.php';require_once 'includes/auth.php';
$id=(int)($_GET['id']??0);$st=$pdo->prepare('SELECT * FROM dokumen WHERE id=?');$st->execute([$id]);$d=$st->fetch();if(!$d){http_response_code(404);exit('Dokumen tidak ditemukan.');}
$types=['Surat Masuk','Surat Keluar','Laporan','Undangan','Lainnya'];$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 $nomor=trim($_POST['nomor_dokumen']??'');$tanggal=$_POST['tanggal']??'';$jenis=$_POST['jenis_dokumen']??'';$nama=trim($_POST['nama_dokumen']??'');$ket=trim($_POST['keterangan']??'');
 if(!$nomor||!$tanggal||!$nama||!in_array($jenis,$types,true))$error='Lengkapi data wajib.';
 else {
  $file=$d['file_dokumen'];$newFile=!empty($_FILES['file_dokumen'])&&$_FILES['file_dokumen']['error']===UPLOAD_ERR_OK;
  if($newFile){$f=$_FILES['file_dokumen'];$mime=(new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);if($mime!=='application/pdf'||$f['size']>10*1024*1024)$error='File pengganti harus PDF dan maksimal 10 MB.';else{$file=bin2hex(random_bytes(16)).'.pdf';if(!move_uploaded_file($f['tmp_name'],__DIR__.'/uploads/'.$file))$error='Gagal mengunggah file.';}}
  if(!$error){$u=$pdo->prepare('UPDATE dokumen SET nomor_dokumen=?,tanggal=?,jenis_dokumen=?,nama_dokumen=?,keterangan=?,file_dokumen=? WHERE id=?');$u->execute([$nomor,$tanggal,$jenis,$nama,$ket,$file,$id]);if($file!==$d['file_dokumen']&&is_file(__DIR__.'/uploads/'.$d['file_dokumen']))@unlink(__DIR__.'/uploads/'.$d['file_dokumen']);header('Location: lihat_dokumen.php?id='.$id);exit;}
 }
}
$pageTitle='Edit Dokumen';require 'includes/header.php';
?>
<div class="page-heading"><div><h1>Edit Dokumen</h1><div class="subheading">Perbarui metadata atau ganti file PDF.</div></div><a href="dokumen.php" class="btn btn-outline-secondary">Kembali</a></div>
<div class="panel"><?php if($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?><form method="post" enctype="multipart/form-data"><div class="row g-3">
<div class="col-md-6"><label class="form-label">Nomor Dokumen *</label><input class="form-control" name="nomor_dokumen" required value="<?= htmlspecialchars($_POST['nomor_dokumen']??$d['nomor_dokumen']) ?>"></div>
<div class="col-md-6"><label class="form-label">Nama/Judul *</label><input class="form-control" name="nama_dokumen" required value="<?= htmlspecialchars($_POST['nama_dokumen']??$d['nama_dokumen']) ?>"></div>
<div class="col-md-6"><label class="form-label">Tanggal *</label><input type="date" class="form-control" name="tanggal" required value="<?= htmlspecialchars($_POST['tanggal']??$d['tanggal']) ?>"></div>
<div class="col-md-6"><label class="form-label">Jenis *</label><select class="form-select" name="jenis_dokumen"><?php foreach($types as $t): ?><option value="<?= $t ?>" <?= (($d['jenis_dokumen']===$t)?'selected':'') ?>><?= $t ?></option><?php endforeach; ?></select></div>
<div class="col-12"><label class="form-label">Keterangan</label><textarea class="form-control" name="keterangan" rows="3"><?= htmlspecialchars($_POST['keterangan']??$d['keterangan']) ?></textarea></div>
<div class="col-12"><label class="form-label">Ganti file PDF (opsional)</label><input type="file" class="form-control" name="file_dokumen" accept="application/pdf,.pdf"><div class="form-text">Biarkan kosong jika tidak ingin mengganti file.</div></div>
</div><div class="text-end mt-4"><button class="btn btn-primary">Simpan Perubahan</button></div></form></div>
<?php require 'includes/footer.php'; ?>
