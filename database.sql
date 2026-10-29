CREATE DATABASE IF NOT EXISTS digitalisasi_dokumen CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE digitalisasi_dokumen;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS dokumen (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nomor_dokumen VARCHAR(100) NOT NULL,
  tanggal DATE NOT NULL,
  jenis_dokumen ENUM('Surat Masuk','Surat Keluar','Laporan','Undangan','Lainnya') NOT NULL DEFAULT 'Lainnya',
  nama_dokumen VARCHAR(200) NOT NULL,
  keterangan TEXT NULL,
  file_dokumen VARCHAR(255) NOT NULL,
  uploaded_by INT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_dokumen_user FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE SET NULL,
  INDEX idx_nomor (nomor_dokumen),
  INDEX idx_nama (nama_dokumen),
  INDEX idx_tanggal (tanggal),
  INDEX idx_jenis (jenis_dokumen)
);

-- Jalankan sekali setelah membuat database. Password awal: password
-- Hash dibuat dengan password_hash('password', PASSWORD_DEFAULT) pada PHP.
INSERT IGNORE INTO users (nama, username, password)
VALUES ('Administrator', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4KoEa3Ro9llC2rH1uK9J0vZ4f7H0G');
