<?php 
ob_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit;
}

if ($_SESSION['role'] == "MEMBER" || $_SESSION['role'] == "ADMIN") {
    header('Location: ../upsert_user.php');
    exit;
}

require 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try{
        if(isset($_GET['q'])) {
            $secure_id = htmlspecialchars($_GET['q']);
            $sql = 'SELECT * FROM user WHERE secure_id = :secure_id';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':secure_id', $secure_id, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    } catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }
}
?>