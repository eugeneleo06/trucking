<?php 
require '../vendor/autoload.php';

use Ramsey\Uuid\Uuid;

ob_start();
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit;
}

if ($_SESSION['role'] == "MEMBER") {
    header('Location: ../upsert_muat_bongkar.php');
    exit;
}

require '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $nama = htmlspecialchars($_POST["nama"]);

        if (isset($_POST['secure_id']) && $_POST['secure_id'] != "") {
            $secure_id = htmlspecialchars($_POST['secure_id']);

            $sql = "SELECT * FROM muat_bongkar WHERE nama=:nama AND secure_id != :secure_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':nama', $nama, PDO::PARAM_STR);
            $stmt->bindParam(':secure_id', $secure_id, PDO::PARAM_STR);
            $stmt->execute();
            $exist = $stmt->fetchAll();
            if ($exist) {
                $_SESSION['error'] = "Nama telah terdaftar";
                header('Location: ../upsert_muat_bongkar.php?q='.$secure_id);
                exit;
            }

            $sql = "UPDATE muat_bongkar SET nama=:nama WHERE secure_id=:secure_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':nama', $nama, PDO::PARAM_STR);
            $stmt->bindParam(':secure_id', $secure_id, PDO::PARAM_STR);
            $stmt->execute();
        } else {
            $sql = "SELECT * FROM muat_bongkar WHERE nama=:nama";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':nama', $nama, PDO::PARAM_STR);
            $stmt->execute();
            $exist = $stmt->fetchAll();
            if ($exist) {
                $_SESSION['error'] = "Nama telah terdaftar";
                header('Location: ../upsert_muat_bongkar.php');
                exit;
            }

            $sql = "INSERT INTO muat_bongkar (secure_id, nama) VALUES (:secure_id, :nama)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':secure_id', Uuid::uuid1()->toString(), PDO::PARAM_STR);
            $stmt->bindParam(':nama', $nama, PDO::PARAM_STR);
            $stmt->execute();
        }

        unset($_SESSION['error']);
        header('Location: ../muat_bongkar.php');
        exit;
    } catch (PDOException $e) { 
        echo $e->getMessage();
        exit;
    }

}