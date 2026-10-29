<?php
require_once 'config/database.php';require_once 'includes/auth.php';
$id=(int)($_GET['id']??0);$st=$pdo->prepare('SELECT file_dokumen FROM dokumen WHERE id=?');$st->execute([$id]);$d=$st->fetch();
if(!$d){http_response_code(404);exit('Tidak ditemukan');}
$path=__DIR__.'/uploads/'.$d['file_dokumen'];
if(!is_file($path)){http_response_code(404);exit('File tidak ditemukan');}
header('Content-Type: application/pdf');header('Content-Disposition: inline; filename="dokumen.pdf"');header('X-Content-Type-Options: nosniff');readfile($path);
