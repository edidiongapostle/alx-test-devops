<?php
$pageName = "Loan";
include_once("layouts/header.php");
$acct_id = userDetails('id');




if(isset($_POST['loan-submit'])){
    $amount = $_POST['amount'];
    $loan_remarks = $_POST['loan_remarks'];
    $reference_id = uniqid();
    
   if(empty($amount)){
       notify_alert('Amount Required','info','3000','Close');
   }elseif($amount <= 0){
        notify_alert('Invalid Amount','info','3000','Close');
    }elseif(empty($loan_remarks)){
        notify_alert('Loan Description Required !','info','3000','Close');
    }else {

        $sql2 = "INSERT INTO loan (loan_reference_id,acct_id,amount,loan_remarks) VALUES (:loan_reference_id,:acct_id,:amount,:loan_remarks)";
        $stmt = $conn->prepare($sql2);
        $stmt->execute([
            'loan_reference_id' => $reference_id,
            'acct_id' => $acct_id,
            'amount' => $amount,
            'loan_remarks' => $loan_remarks
        ]);

                            //EMAIL SENDING
                            $email = $acct_email;
                            $APP_NAME = $pageTitle;
                            $APP_URL = APP_URL;
                            $BANK_PHONE = $BANK_PHONE;
                            $message = $sendMail->LoanMsg($currency,$amount,$loan_remarks,$fullName,$APP_NAME,$APP_URL);
        
                            $subject = "Loan Status - $APP_NAME";
                            $email_message->send_mail($email, $message, $subject);
                            // Admin Email
                            $subject = "Loan Status - $APP_NAME";
                            $email_message->send_mail(WEB_EMAIL, $message, $subject);

        if (true) {
            toast_alert('success', 'Your Loan have been submitted, Kindly wait for Approval', 'Success');
        } else {
            toast_alert('error', 'Sorry An Error occurred, Try Again !');
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
                                    <h3 class="text-center">Loan/Mortages Application</h3>
                                    <form method="POST" >
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-4 mt-4">
                                                    <label for="">Amount</label>
                                                    <div class="input-group ">
                                                        <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-dollar-sign"><line x1="12" y1="1"x2="12"y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg></span>
                                                        </div>
                                                        <input type="number" class="form-control" name="amount" value="<?= $_POST['amount']?>" placeholder="Amount" aria-label="notification" aria-describedby="basic-addon1" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-4 mt-4">
                                                    <label for="">Receiver (Customer Care)</label>
                                                    <div class="input-group ">
                                                        <input type="text" class="form-control" name=""  placeholder="Customer Service" aria-label="notification" aria-describedby="basic-addon1" value="" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-4 mt-4">
                                                    <label for="">Naration/Purpose</label>
                                                    <div class="input-group ">
                                                        <textarea class="form-control mb-4" rows="3" id="textarea-copy" placeholder="Loan Description" name="loan_remarks" ><?=$_POST['loan_remarks']?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <button class="btn btn-primary mb-2 mr-2" name="loan-submit" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> Submit</button>
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
            include_once("layouts/footer.php");
            ?>
