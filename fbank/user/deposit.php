<?php

$pageName = "Crypto Funding";
include("../include/vendor/autoload.php");
include_once("layouts/header.php");
//require_once("../include/config.php");
//require_once("../include/userFunction.php");
//require_once('../include/userClass.php');


$email = $row['acct_email'];

if(isset($_POST['deposit'])) {
    $amount = $_POST['amount'];
    $crypto_name = $_POST['crypto_name'];
    $wallet_address = $_POST['wallet_address'];
    $acct_id = userDetails('id');

    if (empty($amount) || empty($crypto_name) || empty($wallet_address)) {
        notify_alert('Fill Required Form', 'danger', '3000', 'Close');
    } else if(empty($_FILES['image'])){
        notify_alert('Upload Payment Screenshot', 'danger', '3000', 'Close');
    }else{

    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];
        $name = $file['name'];

        $path = pathinfo($name, PATHINFO_EXTENSION);

        $allowed = array('jpg', 'png', 'jpeg');


        $folder = "../assets/deposit/";
        $n = time() . $name;

        $destination = $folder . $n;
    }
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        if ($acct_stat === 'hold') {
            toast_alert('error', 'Account on Hold Contact Support for more info');
        } elseif ($amount < 0) {
            toast_alert('error', 'Invalid amount entered');
        } elseif ($amount < $trans_limit_min) {
            toast_alert('error', 'Amount Less than Deposit Limit');
        } elseif ($amount > $trans_limit_max) {
            toast_alert('error', 'Amount greater than than Deposit Limit');
        } else {
            $reference_id = uniqid();
            $deposited = "INSERT INTO deposit (amount,user_id,wallet_address,crypto_id,image,refrence_id)VALUES(:amount,:user_id,:wallet_address,:crypto_id,:image,:refrence_id)";
            $stmt = $conn->prepare($deposited);

            $stmt->execute([
                'amount' => $amount,
                'user_id' => $acct_id,
                'wallet_address' => $wallet_address,
                'crypto_id' => $crypto_name,
                'image' => $n,
                'refrence_id' => $reference_id

            ]);
            if (true) {
                $sql = "SELECT d.*, c.crypto_name FROM deposit d INNER JOIN crypto_currency c ON d.crypto_id = c.id WHERE d.user_id =:acct_id ORDER BY d.d_id DESC LIMIT 1";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    'acct_id' => $acct_id
                ]);

                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $trans_id = $result['refrence_id'];
                $crypto_name = $result['crypto_name'];


                $APP_NAME = $pageTitle;
                $message = $sendMail->depositMsg($currency, $amount, $crypto_name, $fullName, $trans_id, $APP_NAME);
                $subject = "[DEPOSIT] - $APP_NAME";
                $email_message->send_mail($email, $message, $subject);

                $subject = "Pending Deposit Notification - $APP_NAME";
                $email_message->send_mail(WEB_EMAIL, $message, $subject);
                


                if (true) {
                    toast_alert("success", "Your Deposit is been on Process", "Thanks!");

                } else {
                    toast_alert("error", "Sorry Something Went Wrong !");
                }
            }
        }
    }


    }
}

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
                                    <?php
                                    if($acct_stat === 'active'){
                                    ?>
                                    <form method="POST"  enctype="multipart/form-data">
                                        <div class="form-group mb-4 mt-4">
                                            <label for="">Amount</label>
                                            <div class="input-group ">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><svg
                                                                xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather"><line x1="12" y1="1"
                                                                                                          x2="12"
                                                                                                          y2="23"></line><path
                                                                    d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg></span>
                                                </div>

                                                <input type="number" class="form-control" name="amount" placeholder="Amount"
                                                       aria-label="notification" aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">

                                                <div class="form-group mb-4 mt-4">
                                                    <label for="">Crypto Type</label>
                                                    <div class="input-group">
                                                       <select name="crypto_name" class='selectpicker' onchange="crypto_type(this.value)" data-width='100%'>
                                                           <option>Select</option>
                                                           <?php
                                                            $sql = $conn->query("SELECT * FROM crypto_currency ORDER BY crypto_name");
                                                            while($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                                                $data[] = array(
                                                                        'id'=>$rs['id'],
                                                                        'wallet_address'=>$rs['wallet_address']
                                                                );
                                                                ?>
                                                                <option value="<?= $rs['id'] ?>"><?= ucwords($rs['crypto_name']) ?></option>
                                                                <?php
                                                            }
                                                           ?>
                                                       </select>




                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-4 mt-4">
                                                    <label for="">Wallet Address</label>
                                                    <div class="input-group ">
                                                        <input type="text" class="form-control" name="wallet_address" id="wallet_address" placeholder="Wallet Address"
                                                               aria-label="notification" aria-describedby="basic-addon1"
                                                               readonly>
                                                        <a class="btn btn-primary sm-2" href="javascript:;" data-clipboard-action="copy" data-clipboard-target="#wallet_address"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-copy"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg> Copy</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="widget-content widget-content-area">
                                                    <div class="custom-file-container" data-upload-id="myFirstImage">
                                                        <label>Upload (Single File) <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                                                        <label class="custom-file-container__custom-file" >
                                                            <input type="file" class="custom-file-container__custom-file__custom-file-input" name="image" accept="image/*">
                                                            <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                                            <span class="custom-file-container__custom-file__custom-file-control"></span>
                                                        </label>
                                                        <div class="custom-file-container__image-preview"></div>
                                                    </div>
                                            </div>
                                        </div>
                                </div>
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <button class="btn btn-primary mb-2 mr-2" name="deposit" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> Deposit</button>
                                            </div>
                                        </div>
                                </form>
                            </div>
                                <?php
                                }else{
                                ?>
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
                            <?php
                            }
                            ?>

                            </div>
                </div>
            </div>

        </div>
    </div>


    <?php
    include_once('layouts/footer.php')
    ?>
