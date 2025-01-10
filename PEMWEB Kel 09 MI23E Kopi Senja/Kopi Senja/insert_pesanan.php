<?php
header('Content-Type: application/json'); // Pastikan respons berupa JSON
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connection.php'; // File koneksi ke database

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['cart']) && isset($data['userId'])) {
    $cart = $data['cart'];
    $userId = $data['userId'];

    try {
        // Memulai transaksi
        $conn->autocommit(false);

        // Ambil idKeranjang pelanggan
        $stmtKeranjang = $conn->prepare("SELECT id FROM Keranjang WHERE idPelanggan = ?");
        $stmtKeranjang->bind_param("i", $userId); // "i" untuk integer
        $stmtKeranjang->execute();
        $resultKeranjang = $stmtKeranjang->get_result();
        $keranjang = $resultKeranjang->fetch_assoc();
        $stmtKeranjang->close();

        if (!$keranjang) {
            throw new Exception('Keranjang tidak ditemukan.');
        }
        $idKeranjang = $keranjang['id'];

        // Insert semua pesanan ke tabel Pesanan
        $totalHarga = 0;
        foreach ($cart as $item) {
            $stmtPesanan = $conn->prepare("INSERT INTO Pesanan (Produk, Jumlah, Harga, idKeranjang) VALUES (?, ?, ?, ?)");
            $stmtPesanan->bind_param("siii", $item['name'], $item['quantity'], $item['price'], $idKeranjang); // "siii" untuk string dan 3 integer
            $stmtPesanan->execute();
            $stmtPesanan->close();

            $totalHarga += $item['price'] * $item['quantity'];
        }

        // Update totalHarga di tabel Keranjang
        $stmtUpdateKeranjang = $conn->prepare("UPDATE Keranjang SET totalHarga = ? WHERE id = ?");
        $stmtUpdateKeranjang->bind_param("ii", $totalHarga, $idKeranjang); // "ii" untuk dua integer
        $stmtUpdateKeranjang->execute();
        $stmtUpdateKeranjang->close();

        // Commit transaksi jika semua berhasil
        $conn->commit();

        echo json_encode(['success' => true]);
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
