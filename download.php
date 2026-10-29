<?php
require_once 'config/database.php';require_once 'includes/auth.php';
$id=(int)($_GET['id']??0);$st=$pdo->prepare('SELECT nama_dokumen,file_dokumen FROM dokumen WHERE id=?');$st->execute([$id]);$d=$st->fetch();
if(!$d){http_response_code(404);exit('Dokumen tidak ditemukan.');}
$path=__DIR__.'/uploads/'.$d['file_dokumen'];if(!is_file($path)){http_response_code(404);exit('File tidak ditemukan.');}
$safe=preg_replace('/[^A-Za-z0-9._-]/','_', $d['nama_dokumen']).'.pdf';
header('Content-Type: application/pdf');header('Content-Disposition: attachment; filename="'.$safe.'"');header('Content-Length: '.filesize($path));header('X-Content-Type-Options: nosniff');readfile($path);
