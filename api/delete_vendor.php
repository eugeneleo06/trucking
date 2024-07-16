<?php
ob_start();

session_start();

if (!isset($_SESSION["username"])) {
    header('Location: ../login.php');
    exit;
}

if ($_SESSION['role'] == "MEMBER") {
    header('Location: ../upsert_vendor.php');
    exit;
}

require '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {
        $secure_id = htmlspecialchars($_GET['q']);

        $sql = "SELECT * FROM vendor WHERE secure_id = :secure_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':secure_id', $secure_id, PDO::PARAM_STR);
        $stmt->execute(); // Execute the prepared statement
        $vendor = $stmt->fetch();
        if (!$vendor) {
            $_SESSION['error'] = "Data tidak ditemukan";
            header('Location: ../vendor.php');
            exit;
        }

        $sql = "SELECT * FROM list_harga WHERE vendor_id = :vendor_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':vendor_id', $vendor['id'], PDO::PARAM_INT);
        $list_harga = $stmt->fetchAll();

        if ($list_harga) {
            $_SESSION['error'] = "Silahkan hapus list harga yang berkaitan terlebih dahulu";
            header('Location: ../vendor.php');
            exit;
        }

        $sql = "DELETE FROM vendor WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $vendor['id'], PDO::PARAM_INT);
        $stmt->execute();

        unset($_SESSION['error']);
        header('Location: ../vendor.php');
        exit;
    } catch (PDOException $e) { 
        echo $e->getMessage();
        exit;
    }

}