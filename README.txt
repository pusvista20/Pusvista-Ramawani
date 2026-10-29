SISTEM DIGITALISASI DOKUMEN - PHP + MYSQL

CARA INSTALASI (XAMPP):
1. Ekstrak folder digitalisasi_dokumen_php ke C:\xampp\htdocs\
2. Jalankan Apache dan MySQL dari XAMPP Control Panel.
3. Buka http://localhost/phpmyadmin
4. Pilih tab Import, pilih file database.sql dari folder proyek, lalu klik Import/Go.
   Alternatif: buka tab SQL dan jalankan isi database.sql.
5. Periksa config/database.php. Default XAMPP biasanya user root dan password kosong.
6. Pastikan folder uploads tersedia. Jika belum ada, buat folder uploads di dalam proyek.
7. Buka http://localhost/digitalisasi_dokumen_php/login.php
8. Login awal: username admin, password password.

CATATAN:
- Akun awal untuk pengujian lokal. Ganti password sebelum penggunaan nyata.
- Sistem ini prototipe akademik/lokal. Jangan mengunggah dokumen kedinasan rahasia atau data pribadi ke lingkungan uji.
- Batasi akses folder uploads di server produksi dan gunakan HTTPS, backup, otorisasi, serta kebijakan retensi sebelum dipakai di kantor.
- Upload dibatasi ke PDF maksimal 10 MB. Pastikan ekstensi fileinfo PHP aktif.
