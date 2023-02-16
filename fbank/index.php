<?php
require_once("include/loginFunction.php");

if(@$_SESSION['acct_no']){
    header("Location:./user/dashboard.php");
}

if(@!$_SESSION['acct_no']){
    header("Location:./home.php");
}

// session_start();  
      if(isset($_SESSION["name"]))  
      {  
           if((time() - $_SESSION['last_login_timestamp']) > 60) // 900 = 15 * 60  
           {  
                header("location:logout.php");  
           }  
           else  
           {  
                $_SESSION['last_login_timestamp'] = time();  
                echo "<h1 align='center'>".$_SESSION["name"]."</h1>";  
                echo '<h1 align="center">'.$_SESSION['last_login_timestamp'].'</h1>';  
                echo "<p align='center'><a href='logout.php'>Logout</a></p>";  
           }  
      }  
      else  
      {  
           header('location:./home.php');  
      }  