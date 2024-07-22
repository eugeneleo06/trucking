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
    header('Location: ../upsert_list_harga.php');
    exit;
}

require '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $muat = htmlspecialchars($_POST["muat"]);
        $bongkar = htmlspecialchars($_POST["bongkar"]);
        $vendor = htmlspecialchars($_POST["vendor"]);
        $mobil = htmlspecialchars($_POST['mobil']);
        $raw_harga = $_POST['harga'];
        
        // Remove all non-numeric characters
        $clean_harga = preg_replace('/\D/', '', $raw_harga);
        
        // Convert to integer (optional, depending on your needs)
        $harga = intval($clean_harga);
        

        if (isset($_POST['secure_id']) && $_POST['secure_id'] != "") {
            $secure_id = htmlspecialchars($_POST['secure_id']);
            $sql = "UPDATE list_harga SET muat_id = :muat_id, bongkar_id = :bongkar_id, vendor_id = :vendor_id, mobil_id = :mobil_id, harga = :harga WHERE secure_id=:secure_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':muat_id', $muat, PDO::PARAM_INT);
            $stmt->bindParam(':bongkar_id', $bongkar, PDO::PARAM_INT);
            $stmt->bindParam(':vendor_id', $vendor, PDO::PARAM_INT);
            $stmt->bindParam(':mobil_id', $mobil, PDO::PARAM_STR);
            $stmt->bindParam(':harga', $harga, PDO::PARAM_INT);
            $stmt->bindParam(':secure_id', $secure_id, PDO::PARAM_STR);
            $stmt->execute();
        } else {
            $sql = "INSERT INTO list_harga (secure_id, muat_id, bongkar_id, vendor_id, mobil_id, harga) VALUES (:secure_id, :muat_id, :bongkar_id, :vendor_id, :mobil_id, :harga)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':muat_id', $muat, PDO::PARAM_INT);
            $stmt->bindParam(':bongkar_id', $bongkar, PDO::PARAM_INT);
            $stmt->bindParam(':vendor_id
            ', $vendor, PDO::PARAM_INT);
            $stmt->bindParam(':mobil_id', $mobil, PDO::PARAM_STR);
            $stmt->bindParam(':harga', $harga, PDO::PARAM_INT);
            $stmt->bindParam(':secure_id', Uuid::uuid1()->toString(), PDO::PARAM_STR);
            $stmt->execute();
        }

        unset($_SESSION['error']);
        header('Location: ../list_harga.php');
        exit;
    } catch (PDOException $e) { 
        echo $e->getMessage();
        exit;
    }

}