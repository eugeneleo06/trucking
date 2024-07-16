<?php 
ob_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit;
}

require 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try{
        $sql = 'SELECT * FROM mobil';
        $stmt = $db->query($sql);
        
        $mobil = $stmt->fetchAll();
    } catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }
}
?>