<?php
ob_start();
require_once("./include/loginFunction.php");
require_once ('./session.php');
$sql = "SELECT * FROM settings WHERE id ='1'";
$stmt = $conn->prepare($sql);
$stmt->execute();

$page = $stmt->fetch(PDO::FETCH_ASSOC);

$title = $page['url_name'];

$pageTitle = $title;
$BANK_PHONE = $page['url_tel'];

$title = new pageTitle();
$email_message = new message();
$sendMail = new emailMessage();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title><?=$pageTitle ?> - Login </title>
    <link rel="icon" type="image/x-icon" href="./assets/img/favicon.ico"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="./assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="./assets/css/authentication/form-2.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="./assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/forms/switches.css">
    <link href="./assets/css/pages/error/style-400.css" rel="stylesheet" type="text/css" />


    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="./assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link href="./plugins/animate/animate.css" rel="stylesheet" type="text/css" />
    <link href="./plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="./assets/css/elements/alert.css">
    <script src="./plugins/sweetalerts/promise-polyfill.js"></script>
    <link href="./plugins/sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="./plugins/sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />
    <link href="./assets/css/components/custom-sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="./assets/js/libs/jquery-3.1.1.min.js"></script>

    <!-- END THEME GLOBAL STYLES -->
    <title>Pin</title>
    <style>
        
        button{
            margin:3px;
        }
        button{
            display: inline-block;
            border:1px solid #0a3bff;
            color: #0022ff;
            border-radius: 30px;
            -webkit-border-radius: 30px;
            -moz-border-radius: 30px;
            font-family: Verdana;
            width: auto;
            height: auto;
            font-size: 16px;
            padding: 10px 17px;
            background-color: #FCFAF9;
        }
        button:hover, button:active{
            border:1px solid #FFFFFF;
            color: #FFFDFC;
            background-color: #FC0000;
        }

        input[type=text], textarea {
            -webkit-transition: all 0.30s ease-in-out;
            -moz-transition: all 0.30s ease-in-out;
            -ms-transition: all 0.30s ease-in-out;
            -o-transition: all 0.30s ease-in-out;
            outline: none;
            padding: 3px 0px 3px 3px;
            margin: 5px 1px 3px 0px;
            border: 1px solid #DDDDDD;
        }

        input[type=text]:focus, textarea:focus {
            box-shadow: 0 0 5px rgba(250, 0, 0, 1);
            padding: 3px 0px 3px 3px;
            margin: 5px 1px 3px 0px;
            border: 1px solid rgba(250, 0, 0, 1);
        }
    </style>
</head>
