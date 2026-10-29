<?php
require_once 'config/database.php';require_once 'includes/auth.php';
if($_SERVER['REQUEST_METHOD']!=='POST'){header('Location: dokumen.php');exit;}
$id=(int)($_POST['id']??0);$st=$pdo->prepare('SELECT file_dokumen FROM dokumen WHERE id=?');$st->execute([$id]);$d=$st->fetch();
if($d){$del=$pdo->prepare('DELETE FROM dokumen WHERE id=?');$del->execute([$id]);$path=__DIR__.'/uploads/'.$d['file_dokumen'];if(is_file($path))@unlink($path);}
header('Location: dokumen.php');exit;
