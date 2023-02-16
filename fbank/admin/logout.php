<?php
session_start();
unset($_SESSION['admin'], $_SESSION['wire_transfer'],$_SESSION['dom-transfer'],$_SESSION['login']);
setcookie('firstVisit');
header("Location:./login.php");