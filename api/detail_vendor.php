<?php 
ob_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit;
}

if ($_SESSION['role'] == "MEMBER") {
    header('Location: ../upsert_vendor.php');
    exit;
}

require 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try{
        if(isset($_GET['q'])) {
            $secure_id = htmlspecialchars($_GET['q']);
            $sql = 'SELECT * FROM vendor WHERE secure_id = :secure_id';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':secure_id', $secure_id, PDO::PARAM_STR);
            $stmt->execute();
            $vendor = $stmt->fetch(PDO::FETCH_ASSOC);

            $mobilIds = json_decode($vendor['mobil_id']);
        }

        $sql = "SELECT * FROM mobil";
        $stmt = $db->query($sql);
        $mobil = $stmt->fetchAll(); 

    } catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }
}
?>