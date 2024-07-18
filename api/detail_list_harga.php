<?php 
ob_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit;
}

if ($_SESSION['role'] == "MEMBER") {
    header('Location: ../upsert_list_harga.php');
    exit;
}

require 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try{
        if(isset($_GET['q'])) {
            $secure_id = htmlspecialchars($_GET['q']);
            $sql = 'SELECT * FROM list_harga WHERE secure_id = :secure_id';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':secure_id', $secure_id, PDO::PARAM_STR);
            $stmt->execute();
            $list_harga = $stmt->fetch(PDO::FETCH_ASSOC);

            $mobilIds = json_decode($list_harga['mobil_id']);
        }

        $sql = "SELECT * FROM muat_bongkar";
        $stmt = $db->query($sql);
        $muat_bongkar = $stmt->fetchAll(); 

        $sql = "SELECT * FROM vendor";
        $stmt = $db->query($sql);
        $vendor = $stmt->fetchAll(); 

        $mobil_vendor = [];

        foreach($vendor as $i=>$v) {
            $vendorMobilIds = json_decode($v['mobil_id']);
            $int_ids = array_map('intval', $vendorMobilIds);

            $vendor_mobil = [];

            foreach($int_ids as $w) {
                $sql = "SELECT * FROM mobil WHERE id = :id";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':id', $w, PDO::PARAM_INT);
                $stmt->execute();
                $vendor_mobil_single = $stmt->fetch(); 
                $vendor_mobil[] = $vendor_mobil_single;
            }
            $mobil_vendor[$i] = $vendor_mobil;
        }

        $sql = "SELECT * FROM mobil";
        $stmt = $db->query($sql);
        $mobil = $stmt->fetchAll(); 


    } catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }
}
?>