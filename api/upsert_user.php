<?php 
require '../vendor/autoload.php';

use Ramsey\Uuid\Uuid;

ob_start();
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit;
}

if ($_SESSION['role'] == "MEMBER" || $_SESSION['role'] == "ADMIN") {
    header('Location: ../upsert_mobil.php');
    exit;
}

require '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $usn = htmlspecialchars($_POST["username"]);
        $pwd = md5(md5(htmlspecialchars($_POST['password'])));
        $role = htmlspecialchars($_POST['role']);

        if (isset($_POST['secure_id']) && $_POST['secure_id'] != "") {
            $secure_id = htmlspecialchars($_POST['secure_id']);

            $sql = "SELECT * FROM user WHERE username = :username AND secure_id != :secure_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':username', $usn, PDO::PARAM_STR);
            $stmt->bindParam(':secure_id', $secure_id, PDO::PARAM_STR);
            $stmt->execute();
            $exist = $stmt->fetchAll();
            if ($exist) {
                $_SESSION['error'] = "Username telah terdaftar";
                header('Location: ../upsert_user.php?q='.$secure_id);
                exit;
            }

            $sql = "UPDATE user SET username=:username, password = :password, role = :role WHERE secure_id=:secure_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':username', $usn, PDO::PARAM_STR);
            $stmt->bindParam(':password', $pwd, PDO::PARAM_STR);
            $stmt->bindParam(':role', $role, PDO::PARAM_STR);
            $stmt->bindParam(':secure_id', $secure_id, PDO::PARAM_STR);
            $stmt->execute();
        } else {

            $sql = "SELECT * FROM user WHERE username=:username";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':username', $usn, PDO::PARAM_STR);
            $stmt->execute();
            $exist = $stmt->fetchAll();
            if ($exist) {
                $_SESSION['error'] = "Username telah terdaftar";
                header('Location: ../upsert_user.php');
                exit;
            }

            $sql = "INSERT INTO user (secure_id, username, password, role) VALUES (:secure_id, :username, :password, :role)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':secure_id', Uuid::uuid1()->toString(), PDO::PARAM_STR);
            $stmt->bindParam(':username', $usn, PDO::PARAM_STR);
            $stmt->bindParam(':password', $pwd, PDO::PARAM_STR);
            $stmt->bindParam(':role', $role, PDO::PARAM_STR);
            $stmt->execute();
        }

        unset($_SESSION['error']);
        header('Location: ../user.php');
        exit;
    } catch (PDOException $e) { 
        echo $e->getMessage();
        exit;
    }

}