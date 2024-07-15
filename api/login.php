<?php
ob_start();

session_start();
require '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try{
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $usn = htmlspecialchars($_POST['username']);
            $pass = md5(md5(htmlspecialchars($_POST['password'])));
        
            $sql = "SELECT * FROM user WHERE username= :username AND password= :password LIMIT 1";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':username', $usn, PDO::PARAM_STR);
            $stmt->bindParam(':password', $pass, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if($user){
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                unset($_SESSION['error']);
                header('Location: ../index.php');
                exit;
            } else {
                $_SESSION['error'] = "Wrong username or password";
                header('Location: ../login.php');
                exit;
            }
        }
    } catch(Exception $e){
        echo "Connection failed: " . $e->getMessage();
    }
}


?>