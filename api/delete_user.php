<?php
ob_start();

session_start();

if (!isset($_SESSION["username"])) {
    header('Location: ../login.php');
    exit;
}

if ($_SESSION['role'] == "MEMBER" || $_SESSION['role'] == "ADMIN") {
    header('Location: ../upsert_mobil.php');
    exit;
}

require '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {
        $secure_id = htmlspecialchars($_GET['q']);

        $sql = "SELECT * FROM user WHERE secure_id = :secure_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':secure_id', $secure_id, PDO::PARAM_STR);
        $stmt->execute(); // Execute the prepared statement
        $user = $stmt->fetch();
        if (!$user) {
            $_SESSION['error'] = "Data tidak ditemukan";
            header('Location: ../user.php');
            exit;
        }

        $sql = "DELETE FROM user WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $user['id'], PDO::PARAM_INT);
        $stmt->execute();

        unset($_SESSION['error']);
        header('Location: ../user.php');
        exit;
    } catch (PDOException $e) { 
        echo $e->getMessage();
        exit;
    }

}