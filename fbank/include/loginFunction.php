<?php
ob_start();
session_start();
require_once("config.php");
require_once("userClass.php");
require_once 'userFunction.php';

$message = new message();


$conn = dbConnect();




