<?php
require_once 'config/database.php'; require_once 'includes/auth.php';
$pageTitle='Tambah Dokumen'; $error='';
$types=['Surat Masuk','Surat Keluar','Laporan','Undangan','Lainnya'];
if($_SERVER['REQUEST_METHOD']==='POST'){
  $nomor=trim($_POST['nomor_dokumen']??'');$tanggal=$_POST['tanggal']??'';$jenis=$_POST['jenis_dokumen']??'Lainnya';$nama=trim($_POST['nama_dokumen']??'');$ket=trim($_POST['keterangan']??'');
  if(!$nomor||!$tanggal||!$nama||!in_array($jenis,$types,true)) $error='Lengkapi semua data wajib.';
  elseif(empty($_FILES['file_dokumen'])||$_FILES['file_dokumen']['error']!==UPLOAD_ERR_OK) $error='Pilih file PDF yang akan diunggah.';
  else {
    $f=$_FILES['file_dokumen'];
    if($f['size']>10*1024*1024) $error='Ukuran file maksimal 10 MB.';
    else {
      $mime=(new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);
      if($mime!=='application/pdf') $error='File harus berformat PDF.';
      else {
        $dir=__DIR__.'/uploads'; if(!is_dir($dir)) mkdir($dir,0750,true);
        $filename=bin2hex(random_bytes(16)).'.pdf';
        if(move_uploaded_file($f['tmp_name'],$dir.'/'.$filename)){
          $st=$pdo->prepare('INSERT INTO dokumen (nomor_dokumen,tanggal,jenis_dokumen,nama_dokumen,keterangan,file_dokumen,uploaded_by) VALUES (?,?,?,?,?,?,?)');
          $st->execute([$nomor,$tanggal,$jenis,$nama,$ket,$filename,$_SESSION['user_id']]);
          header('Location: dokumen.php');exit;
        } else $error='Gagal menyimpan file upload.';
      }
    }
  }
}
require 'includes/header.php';
?>
<div class="page-heading"><div><h1>Tambah Dokumen</h1><div class="subheading">Masukkan informasi dokumen hasil scanning dan unggah PDF.</div></div><a href="dokumen.php" class="btn btn-outline-secondary">Kembali</a></div>
<div class="panel"><div class="panel-title">Informasi Dokumen</div><?php if($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post" enctype="multipart/form-data"><div class="row g-3">
<div class="col-md-6"><label class="form-label">Nomor Dokumen *</label><input class="form-control" name="nomor_dokumen" required value="<?= htmlspecialchars($_POST['nomor_dokumen']??'') ?>" placeholder="Contoh: 001/IV/2026"></div>
<div class="col-md-6"><label class="form-label">Nama/Judul Dokumen *</label><input class="form-control" name="nama_dokumen" required value="<?= htmlspecialchars($_POST['nama_dokumen']??'') ?>" placeholder="Contoh: Undangan Rapat Komisi"></div>
<div class="col-md-6"><label class="form-label">Tanggal Dokumen *</label><input type="date" class="form-control" name="tanggal" required value="<?= htmlspecialchars($_POST['tanggal']??'') ?>"></div>
<div class="col-md-6"><label class="form-label">Jenis Dokumen *</label><select class="form-select" name="jenis_dokumen" required><?php foreach($types as $t): ?><option <?= (($_POST['jenis_dokumen']??'')===$t)?'selected':'' ?> value="<?= $t ?>"><?= $t ?></option><?php endforeach; ?></select></div>
<div class="col-12"><label class="form-label">Keterangan</label><textarea class="form-control" name="keterangan" rows="3" placeholder="Keterangan singkat dokumen"><?= htmlspecialchars($_POST['keterangan']??'') ?></textarea></div>
<div class="col-12"><label class="form-label">File Dokumen (PDF, maksimal 10 MB) *</label><input class="form-control" type="file" name="file_dokumen" accept="application/pdf,.pdf" required></div>
</div><div class="d-flex justify-content-end gap-2 mt-4"><a href="dokumen.php" class="btn btn-outline-secondary">Batal</a><button class="btn btn-primary">Simpan Dokumen</button></div></form></div>
<?php require 'includes/footer.php'; ?>
