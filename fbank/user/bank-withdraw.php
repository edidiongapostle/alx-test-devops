<?php

$pageName = "Bank Withdrawal";
include("../include/vendor/autoload.php");
include_once("layouts/header.php");
//require_once("../include/config.php");
//require_once("../include/userFunction.php");
//require_once('../include/userClass.php');


$email = $row['acct_email'];


if(isset($_POST['withdraw'])){
    // $user_id = $_POST['user_id'];
    // $sender_name = $_POST['sender_name'];
    // $amount = $_POST['amount'];
    // $description = $_POST['description'];
    // $created_at = $_POST['created_at'];
    // $time_created = $_POST['time_created'];
    $user_id = userDetails('id');
    $amount = $_POST['amount'];
    $bankname = $_POST['bankname'];
    $account_number = $_POST['account_number'];
    $routineno = $_POST['routineno'];
    $acctname = $_POST['acctname'];

    $trans_type = 2;
    $checkUser = $conn->query("SELECT * FROM users WHERE id='$user_id'");
    $result = $checkUser->fetch(PDO::FETCH_ASSOC);

    if($amount > $result['acct_balance']){
        toast_alert('error','Insufficient Balance');
    }else {




        $available_balance = ($result['acct_balance'] - $amount);
//        $amount-=$result['acct_balance'];

        $sql = "UPDATE users SET acct_balance=:available_balance WHERE id=:user_id";
        $addUp = $conn->prepare($sql);
        $addUp->execute([
            'available_balance' => $available_balance,
            'user_id'=>$user_id
        ]);

            $trans_id = uniqid();
            $sql = "INSERT INTO withdrawal (user_id,amount,bankname,account_number,routineno,acctname,reference_id,trans_type) VALUES(:user_id,:amount,:bankname,:account_number,:routineno,:acctname,:reference_id,:trans_type)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'user_id'=>$user_id,
                'amount' => $amount,
                'bankname' => $bankname,
                'account_number' => $account_number,
                'routineno' => $routineno,
                'acctname' => $acctname,
                'reference_id'=>$trans_id,
                'trans_type' => $trans_type,
            ]);

            $full_name = $user['firstname']. " ". $user['lastname'];
                        // $APP_URL = APP_URL;
                        $APP_NAME = WEB_TITLE;
                        $APP_URL = WEB_URL;
             $user_email = $user['acct_email'];

             $message = $sendMail->BankWithdrawMsg($currency, $full_name, $amount, $bankname, $account_number,$routineno,$acctname, $APP_NAME);


             $subject = "Withdrawal Notification". "-". $APP_NAME;
             $email_message->send_mail($user_email, $message, $subject);

             $subject = "Pending Withdrawal Notification". "-". $APP_NAME;
             $email_message->send_mail(WEB_EMAIL, $message, $subject);

             if (true) {
                toast_alert('success', 'Your Withdrawal hass been processed', 'Pending');
            } else {
                toast_alert('error', 'Sorry Something Went Wrong');
            }
            
                // header("Location:./withdrawal-transaction.php");
                // exit;
        
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
                                        <p>Bank Withdrawal Method</p>
                                        
                                        <div class="form-group mb-4 mt-4">
                                        <p>Name on account must match <strong><?= $fullName ?></strong></p>
                                        </div>
                                        <div class="row">
                                        <div class="col-md-6">
                                                <div class="form-group mb-4 mt-4">
                                                    <label for="">Bank Name</label>
                                                    <div class="input-group ">
                                                        <input type="text" class="form-control" name="bankname"  required placeholder="Bank Name"
                                                               aria-label="notification" aria-describedby="basic-addon1">
                                                         </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-4 mt-4">
                                                    <label for="">Account Number</label>
                                                    <div class="input-group ">
                                                        <input type="number" class="form-control" name="account_number"  required placeholder="Account Number"
                                                               aria-label="notification" aria-describedby="basic-addon1">
                                                         </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-md-6">
                                                <div class="form-group mb-4 mt-4">
                                                    <label for="">Routine Number</label>
                                                    <div class="input-group ">
                                                        <input type="text" class="form-control" name="routineno"  required placeholder="Routine Number"
                                                               aria-label="notification" aria-describedby="basic-addon1">
                                                         </div>
                                                </div>
                                            </div>
                                               
                                            <div class="col-md-6">
                                                <div class="form-group mb-4 mt-4">
                                                    <label for="">Amount</label>
                                                    <div class="input-group ">
                                                        <input type="number" class="form-control" name="amount"  required placeholder="Amount"
                                                               aria-label="notification" aria-describedby="basic-addon1">

                                                               <input type="text" class="form-control" name="acctname" value="<?= $fullName ?>" hidden >


                                                         </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <button class="btn btn-primary mb-2 mr-2" name="withdraw" >
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                                    <polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> Withdraw Funds</button>


                                                    <a href="./withdrawal.php" class="btn btn-danger mb-2 mr-2" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                                    <polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> Use Crypto Withdrawal</a>
                                            </div>
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
