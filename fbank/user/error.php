<?php
$pageName = "404";
include("../include/vendor/autoload.php");
include_once("layouts/header.php");


//$email = $row['acct_email'];
//
//if(isset($_POST['deposit'])) {
//    $amount = $_POST['amount'];
//    $crypto_name = $_POST['crypto_name'];
//    $wallet_address = $_POST['wallet_address'];
//    $acct_id = userDetails('id');
//
//    if (isset($_FILES['image'])) {
//        $file = $_FILES['image'];
//        $name = $file['name'];
//
//        $path = pathinfo($name, PATHINFO_EXTENSION);
//
//        $allowed = array('jpg', 'png', 'jpeg');
//
//
//        $folder = "../assets/deposit/";
//        $n = time() . $name;
//
//        $destination = $folder . $n;
//    }
//    if (move_uploaded_file($file['tmp_name'], $destination)) {
//        if($acct_stat === 'hold'){
//            toast_alert('error','Account on Hold Contact Support for more info');
//        }elseif($amount < 0){
//            toast_alert('error','Invalid amount entered');
//        }elseif($amount < $trans_limit_min){
//            toast_alert('error','Amount Less than Deposit Limit');
//        }elseif($amount > $trans_limit_max){
//            toast_alert('error','Amount greater than than Deposit Limit');
//        }else {
//            $reference_id = uniqid();
//            $deposited = "INSERT INTO deposit (amount,user_id,wallet_address,crypto_id,image,refrence_id)VALUES(:amount,:user_id,:wallet_address,:crypto_id,:image,:refrence_id)";
//            $stmt = $conn->prepare($deposited);
//
//            $stmt->execute([
//                'amount' => $amount,
//                'user_id' => $acct_id,
//                'wallet_address' => $wallet_address,
//                'crypto_id' => $crypto_name,
//                'image' => $n,
//                'refrence_id'=>$reference_id
//
//            ]);
//            if(true) {
//                $sql = "SELECT d.*, c.crypto_name FROM deposit d INNER JOIN crypto_currency c ON d.crypto_id = c.id WHERE d.user_id =:acct_id ORDER BY d.d_id DESC LIMIT 1";
//                $stmt = $conn->prepare($sql);
//                $stmt->execute([
//                    'acct_id'=>$acct_id
//                ]);
//
//                $result = $stmt->fetch(PDO::FETCH_ASSOC);
//                $trans_id = $result['refrence_id'];
//                $crypto_name = $result['crypto_name'];
//
//
//                $APP_NAME = $pageTitle;
//                $message = $sendMail->depositMsg($currency, $amount, $crypto_name, $fullName,$trans_id, $APP_NAME);
//                $subject = "[DEPOSIT] - $APP_NAME";
//                $email_message->send_mail($email, $message, $subject);
//
//                if (true) {
//                    toast_alert("success", "Your Deposit is been on Process", "Thanks!");
//
//                } else {
//                    toast_alert("error", "Sorry Something Went Wrong !");
//                }
//            }
//        }
//
//
//    }
//}

?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">
            <div class="col-md-8 offset-md-2">
                <div class="card component-card">
                    <div class="card-body">
                        <div class="user-profile">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div  class="alert custom-alert-1 mb-4 bg-danger border-danger" role="alert">

                                            <div class="media">
                                                <div class="alert-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>
                                                </div>
                                                <div class="media-body">
                                                    <div class="alert-text">
                                                        <strong>Warning! </strong><span> Account on <span class="text-uppercase "><b>hold</b></span> contact support.</span>
                                                    </div>
                                                    <div class="alert-btn">
                                                        <a class="btn btn-default btn-dismiss" href="mailto:<?=$url_email?>">Contact Us</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>


<?php
include_once('layouts/footer.php')
?>
