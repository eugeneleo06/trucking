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
    header('Location: ../upsert_vendor.php');
    exit;
}

require '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $nama = htmlspecialchars($_POST["nama"]);
        $mobil = json_encode($_POST['mobil']);

        if (isset($_POST['secure_id']) && $_POST['secure_id'] != "") {
            $secure_id = htmlspecialchars($_POST['secure_id']);

            $sql = "SELECT * FROM vendor WHERE nama=:nama AND secure_id != :secure_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':nama', $nama, PDO::PARAM_STR);
            $stmt->bindParam(':secure_id', $secure_id, PDO::PARAM_STR);
            $stmt->execute();
            $exist = $stmt->fetchAll();
            if ($exist) {
                $_SESSION['error'] = "Nama vendor telah terdaftar";
                header('Location: ../upsert_vendor.php?q='.$secure_id);
                exit;
            }
            // exit;

            $sql = "UPDATE vendor SET nama=:nama, mobil_id=:mobil_id WHERE secure_id=:secure_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':nama', $nama, PDO::PARAM_STR);
            $stmt->bindParam(':mobil_id', $mobil, PDO::PARAM_STR);
            $stmt->bindParam(':secure_id', $secure_id, PDO::PARAM_STR);
            $stmt->execute();
        } else {

            $sql = "SELECT * FROM vendor WHERE nama=:nama";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':nama', $nama, PDO::PARAM_STR);
            $stmt->execute();
            $exist = $stmt->fetchAll();
            if ($exist) {
                $_SESSION['error'] = "Nama vendor telah terdaftar";
                header('Location: ../upsert_vendor.php');
                exit;
            }

            $sql = "INSERT INTO vendor (secure_id, nama, mobil_id) VALUES (:secure_id, :nama, :mobil_id)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':secure_id', Uuid::uuid1()->toString(), PDO::PARAM_STR);
            $stmt->bindParam(':nama', $nama, PDO::PARAM_STR);
            $stmt->bindParam(':mobil_id', $mobil, PDO::PARAM_STR);
            $stmt->execute();
        }

        unset($_SESSION['error']);
        header('Location: ../vendor.php');
        exit;
    } catch (PDOException $e) { 
        echo $e->getMessage();
        exit;
    }

}