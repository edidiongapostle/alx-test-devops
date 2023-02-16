<?php
session_start();
include_once("../include/userFunction.php");

unset($_SESSION['acct_no'], $_SESSION['wire_transfer'],$_SESSION['dom-transfer'],$_SESSION['login']);
setcookie('firstVisit');
notify_alert('Logout','danger','2000','Close');

header("Location:../login.php");
exit();
