<?php
header('Content-Type: application/json'); // Pastikan respons berupa JSON
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connection.php'; // File koneksi ke database

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['nama'])) {
    $nama = $data['nama'];

    try {
        // Memulai transaksi
        $conn->autocommit(false);

        // Insert pelanggan
        $stmtPelanggan = $conn->prepare("INSERT INTO Pelanggan (Nama) VALUES (?)");
        $stmtPelanggan->bind_param("s", $nama); // "s" berarti string
        $stmtPelanggan->execute();
        $idPelanggan = $stmtPelanggan->insert_id; // Mendapatkan ID pelanggan yang baru saja dimasukkan
        $stmtPelanggan->close();

        // Insert keranjang untuk pelanggan tersebut
        $stmtKeranjang = $conn->prepare("INSERT INTO Keranjang (totalHarga, idPelanggan) VALUES (0, ?)");
        $stmtKeranjang->bind_param("i", $idPelanggan); // "i" berarti integer
        $stmtKeranjang->execute();
        $stmtKeranjang->close();

        // Commit transaksi jika semua berhasil
        $conn->commit();

        echo json_encode(['success' => true, 'userId' => $idPelanggan]);
    } catch (Exception $e) {
        // Rollback transaksi jika terjadi error
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    } finally {
        $conn->autocommit(true); // Kembali ke mode autocommit
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
}
?>
