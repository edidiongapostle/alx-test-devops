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

<!DOCTYPE php>
<php lang="en">


<meta http-equiv="content-type" content="text/php;charset=UTF-8" />
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Savings Account, Checking Accounts, Loans">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <?php

$title = '';

switch (basename($_SERVER['PHP_SELF'])) {

  case ('about.php') : $title = 'About Us'; break;
  case ('bitcoin.php') : $title = 'Personal or Business Account'; break;
  case ('cards.php') : $title = 'Debit/ Credit Cards'; break;
  case ('contact.php') : $title = 'Contact Us'; break;
  case ('home.php') : $title = 'Home'; break;
  case ('loans.php') : $title = 'Loans'; break;
  case ('help-center.php') : $title = 'Help Center'; break;
  case ('service.php') : $title = 'Service'; break;
  case ('404.php') : $title = '404 Error'; break;

}

echo '<title>'.$title.' - Online Banking, Loans & Mortgages, Credit Card </title>';

?>

    <!-- Favicon -->
    <link rel="icon" href="./img/core-img/favicon.png">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="./style.css">

</head>
<body>
    <!-- Preloader -->
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="lds-ellipsis">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    


    <!-- ##### Header Area Start ##### -->
    <header class="header-area">
        <!-- Top Header Area -->
        <div class="top-header-area">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="col-12 d-flex justify-content-between">
                        <!-- Logo Area -->
                        <div class="logo">
                            <a href="/"><img style="width:200px;height:65px" src="./img/favicon-removebg-preview.png" alt="Logo of <?=$pageTitle ?>"></a>
                        </div>

                        <!-- Top Contact Info -->
                        <div class="top-contact-info d-flex align-items-center">
                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="3110 14th St NW #101, Washington, DC 20010"><img src="./img/core-img/placeholder.png" alt=""> <span>3110 14th St NW #101, Washington, DC 20010</span></a>
                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="<?= $page['url_email'] ?>"><img src="./img/core-img/message.png" alt=""> <span><?= $page['url_email'] ?></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navbar Area -->
        <div class="credit-main-menu" id="sticker">
            <div class="classy-nav-container breakpoint-off">
                <div class="container">
                    <!-- Menu -->
                    <nav class="classy-navbar justify-content-between" id="creditNav">

                        <!-- Navbar Toggler -->
                        <div class="classy-navbar-toggler">
                            <span class="navbarToggler"><span></span><span></span><span></span></span>
                        </div>

                        <!-- Menu -->
                        <div class="classy-menu">

                            <!-- Close Button -->
                            <div class="classycloseIcon">
                                <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                            </div>

                            <!-- Nav Start -->
                            <div class="classynav">
                                <ul>
                                    <li><a href="/">Home</a></li>
                                    
                                    <li><a href="services.php">Services</a></li>
                                    <li><a href="loans.php">Our Loans</a></li>
                                    <li><a href="bitcoin.php">Bitcoin</a></li>
                                    <li><a href="about.php">About Us</a></li>
                                    <li><a href="contact.php">Contact</a></li>
                                    <li><a href="./signup/verify-registration.php">Register</a></li>
                                </ul>
                            </div>
                            <!-- Nav End -->
                        </div>

                        <!-- Contact -->
                        <div class="contact">
                            <a href="./login.php"><img src="./img/core-img/call2.png" alt=""> Log on</a>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>    <!-- ##### Header Area End ##### -->

    