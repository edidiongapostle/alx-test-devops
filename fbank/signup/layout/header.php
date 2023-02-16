<?php
ob_start();
require_once("../include/loginFunction.php");
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
    <title><?=$pageName?> - <?=$pageTitle ?> </title>
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon.ico"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="./formcss.css" rel="stylesheet" type="text/css"/>

    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="../assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/forms/switches.css">


    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="../assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link href="../plugins/animate/animate.css" rel="stylesheet" type="text/css" />
    <link href="../plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="../assets/css/elements/alert.css">
    <script src="../plugins/sweetalerts/promise-polyfill.js"></script>
    <link href="../plugins/sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="../plugins/sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/components/custom-sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="../assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="https://www.dukelearntoprogram.com/course1/common/js/image/SimpleImage.js">
    </script>
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->
    <style>
        #Div2{
            display: none;
        }
        #nextShow{
            display: none;
        }

        #Div4{
            display: none;
        }

        #Button11{
            display: none;
        }

        .container-div{
            height: 100%;
        }

        canvas {
            height: 100px;
            border-style: solid;
            border-width: 1px;
            border-color: black;
        }


    </style>
</head>

<body>