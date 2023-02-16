<?php
session_start();
require_once("../include/config.php");
require_once "adminFunction.php";

$conn = dbConnect();


if(isset($_POST['admin_login'])){
    $admin_email = inputValidation($_POST['admin_email']);
    $admin_password = inputValidation($_POST['admin_password']);

    $sql = "SELECT * FROM admin WHERE admin_email=:admin_email";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
       'admin_email'=>$admin_email
    ]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if($stmt->rowCount() === 0){
        toast_alert('error','incorrect password / email');
    }else{
        $validPassword = password_verify($admin_password, $row['admin_password']);

        if ($validPassword === false){

            toast_alert('error','incorrect password / email');
        }else{
            $_SESSION['admin'] = $admin_email;
            echo '<script>window.location.replace("./dashboard.php");</script>';
            exit;
        }
    }




}

