CREATE DATABASE IF NOT EXISTS web_cafe;

USE web_cafe;

-- Tabel Pelanggan
CREATE TABLE Pelanggan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Nama VARCHAR(255) NOT NULL
);

-- Tabel Keranjang
CREATE TABLE Keranjang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    totalHarga DECIMAL(10,2) DEFAULT 0.00,
    idPelanggan INT NOT NULL,
    FOREIGN KEY (idPelanggan) REFERENCES Pelanggan(id)
    ON DELETE CASCADE
);

-- Tabel Pesanan
CREATE TABLE Pesanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Produk VARCHAR(255) NOT NULL,
    Jumlah INT NOT NULL,
    Harga DECIMAL(10,2) NOT NULL,
    idKeranjang INT NOT NULL,
    FOREIGN KEY (idKeranjang) REFERENCES Keranjang(id)
    ON DELETE CASCADE
);