<?php 
ob_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit;
}

require 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try{
        # GET VENDOR AND LIST HARGA
        $sql = 'SELECT l.*, v.nama as vendor FROM list_harga l 
        LEFT JOIN vendor v ON l.vendor_id = v.id';
        $stmt = $db->query($sql);
        $list_harga = $stmt->fetchAll();

        foreach($list_harga as $i=>$v) {
            # GET MOBIL
            $sql = "SELECT nama FROM mobil WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $list_harga[$i]['mobil_id'], PDO::PARAM_INT);
            $stmt->execute();
            $mobil = $stmt->fetchColumn();
            $list_harga[$i]['mobil'] = $mobil;


            # GET MUAT
            $sql = "SELECT nama FROM muat_bongkar WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $list_harga[$i]['muat_id'], PDO::PARAM_INT);
            $stmt->execute();
            $muat = $stmt->fetchColumn();
            $list_harga[$i]['muat'] = $muat;

            # GET BONGKAR
            $sql = "SELECT nama FROM muat_bongkar WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $list_harga[$i]['bongkar_id'], PDO::PARAM_INT);
            $stmt->execute();
            $bongkar = $stmt->fetchColumn();
            $list_harga[$i]['bongkar'] = $bongkar;
        }
    } catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
        exit;
    }
}
?>