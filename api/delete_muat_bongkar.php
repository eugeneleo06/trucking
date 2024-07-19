<?php
ob_start();

session_start();

if (!isset($_SESSION["username"])) {
    header('Location: ../login.php');
    exit;
}

if ($_SESSION['role'] == "MEMBER") {
    header('Location: ../upsert_muat_bongkar.php');
    exit;
}

require '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {
        $secure_id = htmlspecialchars($_GET['q']);

        $sql = "SELECT * FROM muat_bongkar WHERE secure_id = :secure_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':secure_id', $secure_id, PDO::PARAM_STR);
        $stmt->execute(); // Execute the prepared statement
        $mb = $stmt->fetch();
        if (!$mb) {
            $_SESSION['error'] = "Data tidak ditemukan";
            header('Location: ../muat_bongkar.php');
            exit;
        }

        $sql = "SELECT * FROM list_harga l WHERE l.muat_id = :muat_id OR l.bongkar_id = :bongkar_id ";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':muat_id', $mb['id'], PDO::PARAM_INT);
        $stmt->bindParam(':bongkar_id', $mb['id'], PDO::PARAM_INT);
        $stmt->execute(); // Execute the prepared statement
        $list_harga = $stmt->fetchAll();

        if ($list_harga) {
            $_SESSION['error'] = "Silahkan hapus list harga yang berkaitan terlebih dahulu";
            header('Location: ../muat_bongkar.php');
            exit;
        }

        $sql = "DELETE FROM muat_bongkar WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $mb['id'], PDO::PARAM_INT);
        $stmt->execute();

        unset($_SESSION['error']);
        header('Location: ../muat_bongkar.php');
        exit;
    } catch (PDOException $e) { 
        echo $e->getMessage();
        exit;
    }

}