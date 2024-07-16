<?php
ob_start();

session_start();

if (!isset($_SESSION["username"])) {
    header('Location: ../login.php');
    exit;
}

if ($_SESSION['role'] == "MEMBER") {
    header('Location: ../upsert_mobil.php');
    exit;
}

require '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {
        $secure_id = htmlspecialchars($_GET['q']);

        $sql = "SELECT * FROM mobil WHERE secure_id = :secure_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':secure_id', $secure_id, PDO::PARAM_STR);
        $stmt->execute(); // Execute the prepared statement
        $mobil = $stmt->fetch();
        if (!$mobil) {
            $_SESSION['error'] = "Data tidak ditemukan";
            header('Location: ../mobil.php');
            exit;
        }

        $sql = "SELECT * FROM list_harga WHERE mobil_id = :mobil_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':mobil_id', $mobil['id'], PDO::PARAM_INT);
        $list_harga = $stmt->fetchAll();

        if ($list_harga) {
            $_SESSION['error'] = "Silahkan hapus list harga yang berkaitan terlebih dahulu";
            header('Location: ../mobil.php');
            exit;
        }

        $sql = "DELETE FROM mobil WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $mobil['id'], PDO::PARAM_INT);
        $stmt->execute();

        unset($_SESSION['error']);
        header('Location: ../mobil.php');
        exit;
    } catch (PDOException $e) { 
        echo $e->getMessage();
        exit;
    }

}