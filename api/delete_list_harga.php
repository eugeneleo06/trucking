<?php
ob_start();

session_start();

if (!isset($_SESSION["username"])) {
    header('Location: ../login.php');
    exit;
}

if ($_SESSION['role'] == "MEMBER") {
    header('Location: ../upsert_list_harga.php');
    exit;
}

require '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {
        $secure_id = htmlspecialchars($_GET['q']);

        $sql = "SELECT * FROM list_harga WHERE secure_id = :secure_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':secure_id', $secure_id, PDO::PARAM_STR);
        $stmt->execute(); // Execute the prepared statement
        $list_harga = $stmt->fetch();
        if (!$list_harga) {
            $_SESSION['error'] = "Data tidak ditemukan";
            header('Location: ../list_harga.php');
            exit;
        }

        $sql = "DELETE FROM list_harga WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $list_harga['id'], PDO::PARAM_INT);
        $stmt->execute();

        unset($_SESSION['error']);
        header('Location: ../list_harga.php');
        exit;
    } catch (PDOException $e) { 
        echo $e->getMessage();
        exit;
    }

}