<?php 
ob_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit;
}

require 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try{
        $sql = 'SELECT * FROM vendor';
        $stmt = $db->query($sql);
        
        $vendor = $stmt->fetchAll();

        $i = 0;
        foreach($vendor as $v) {
            # GET MOBIL
            $mobilIds = json_decode($v['mobil_id']);
            $mobilNames = array();
            foreach ($mobilIds as $mobilId) {
                $sql = "SELECT nama FROM mobil WHERE id = ".$mobilId;
                $stmt = $db->query($sql);
                $mobil = $stmt->fetchColumn();
                if ($mobil) {
                    $mobilNames[] = $mobil;
                }
            }
            $mobilNamesCombined = implode(" - ", $mobilNames);
            $vendor[$i]['mobil'] = $mobilNamesCombined;

            $i++;
        }
    } catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }
}
?>