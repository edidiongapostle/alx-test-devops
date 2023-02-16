<?php
require_once("./include/adminloginFunction.php");
require_once("./include/adminregFunction.php");
require_once("./include/session.php");

if(@$_SESSION['admin']){
    header('Location:./dashboard.php');
}

if(@!$_SESSION['admin']){
    header('Location:./login.php');
}