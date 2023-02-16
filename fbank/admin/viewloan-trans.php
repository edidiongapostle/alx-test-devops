<?php
include_once("./layout/header.php");
//require_once("./include/adminloginFunction.php");
//include_once("../include/config.php");

$id = $_GET['id'];
//$id1 = $_SESSION['loan_id'];
//$sql = "SELECT * FROM users WHERE id =:id";
//$data = $conn->prepare($sql);
//$data->execute([
//    'id'=>$id1
//]);
//
//$result = $data->fetch(PDO::FETCH_ASSOC);


$sql="SELECT * FROM loan LEFT JOIN users ON loan.acct_id = users.id WHERE loan_reference_id ='$id'";
$stmt = $conn->prepare($sql);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$email = $row['acct_email'];
$currency = currency($row);
$id1 = $row['acct_no'];


$fullName = $row['firstname']." ".$row['lastname'];

if($row['loan_status'] === '0'){
    $tran_status = '<span class="text-success">Processing</span>';
}else if($row['loan_status'] === '1'){
    $tran_status = '<span class="text-success">Approved</span>';
}else if($row['loan_status']=== '3'){
    $tran_status = '<span class="text-danger">Cancel</span>';
}else if($row['loan_status']=== '2') {
    $tran_status = '<span class="text-danger">Hold</span>';
}

if(isset($_POST['loan_submit'])){
    $loan_message = $_POST['loan_message'];
    $loan_status = $_POST['loan_status'];

    if($loan_status === '1'){
        $status_value = 1;
        $sql = "UPDATE loan SET loan_status=:loan_status,loan_message=:loan_message WHERE loan_reference_id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'loan_status' =>$status_value,
            'loan_message'=>$loan_message,
            'id'=>$id
        ]);

        if(true){
            $amount = $row['amount'];
            $available_loan = $row['loan_balance'] + $amount;
            $sql = "UPDATE users SET loan_balance=:loan_balance WHERE acct_no=:id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
               'loan_balance'=>$available_loan,
                'id'=>$id1
            ]);
        }if(true){
            $amount_balance = $row['acct_balance'];
            $messageText = $loan_message;
            $APP_NAME = $pageTitle;
            $tran_status = "Approved";
            $message = $sendMail->loanMsg($currency,$amount,$amount_balance, $available_loan, $APP_NAME,$tran_status,$messageText);
            $subject = "[LOAN APPROVED] - $APP_NAME";
            $email_message->send_mail($email, $message, $subject);

            $subject = "[LOAN APPROVED] - $APP_NAME";
            $email_message->send_mail(WEB_EMAIL, $message, $subject);

        }

        if(true){
            toast_alert('success','Your Loan Approve Successfully','Approve');
        }
    }

}

if(isset($_POST['decline'])){
    $status_value = 3;
    $trans_id = $row['trans_id'];
    $sql = "UPDATE domestic_transfer SET dom_status=:dom_status WHERE dom_id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'dom_status' =>$status_value,
        'id'=>$id
    ]);

    $amount_balance = $row['acct_balance'];
    $messageText = $loan_message;
    $APP_NAME = $pageTitle;
    $tran_status = "Declined";
    $message = $sendMail->loanMsg($currency,$amount,$amount_balance, $available_loan, $APP_NAME,$tran_status,$messageText);
    $subject = "[LOAN DECLINED] - $APP_NAME";
    $email_message->send_mail($email, $message, $subject);

    $subject = "[LOAN DECLINED] - $APP_NAME";
    $email_message->send_mail(WEB_EMAIL, $message, $subject);



    if(true){
        toast_alert('success','Transaction Decline Successfully','Decline');

    }else{
        toast_alert('error','Sorry Something Went Wrong');
    }
}

if(isset($_POST['hold'])){
    $status_value = 2;
    $trans_id = $row['trans_id'];
    $sql = "UPDATE domestic_transfer SET dom_status=:dom_status WHERE dom_id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'dom_status' =>$status_value,
        'id'=>$id
    ]);

    $amount_balance = $row['acct_balance'];
    $messageText = $loan_message;
    $APP_NAME = $pageTitle;
    $tran_status = "Hold";
    $message = $sendMail->loanMsg($currency,$amount,$amount_balance, $available_loan, $APP_NAME,$tran_status,$messageText);
    $subject = "[LOAN ON HOLD] - $APP_NAME";
    $email_message->send_mail($email, $message, $subject);

    $subject = "[LOAN ON HOLD] - $APP_NAME";
    $email_message->send_mail(WEB_EMAIL, $message, $subject);

    if(true){
        toast_alert('success','Transaction Hold Successfully','Hold');
        // header("location:./dashboard.php");

    }else{
        toast_alert('error','Sorry Something Went Wrong');
    }
}





?>
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="account-settings-container layout-top-spacing">

            <div class="account-content">
                <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="general-info" class="section general-info"  method="POST">

                                <div class="info">
                                    <h6 class="">View Loan Request</h6>
                                    <div class="row">
                                        <div class="col-md-8 offset-md-2 table-responsive">
                                            <table class="table table-bordered mb-4">
                                                <tbody>
                                                <tr>
                                                    <th>Name</th>
                                                    <th class="text-uppercase"><?= ucwords($fullName) ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Amount Requested</th>
                                                    <th><?=$currency.$row['amount'] ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Loan Remark</th>
                                                    <th><?= $row['loan_remarks'] ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Created At</th>
                                                    <th><?= $row['created_at'] ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Account No</th>
                                                    <th><?= $row['acct_no'] ?></th>
                                                </tr>

                                                <tr>
                                                    <th>Account Balance</th>
                                                    <th><?= $currency.$row['acct_balance']?></th>
                                                </tr>
                                                <tr>
                                                    <th>Loan Balance</th>
                                                    <th><?= $currency.$row['loan_balance']?></th>
                                                </tr>
<!--                                                <tr>-->
<!--                                                    <th>Loan Message</th>-->
<!--                                                    <th>--><?//= $row['loan_message'] ?><!--</th>-->
<!--                                                </tr>-->


                                                <tr>
                                                    <th>Status</th>
                                                    <th><?= $tran_status ?></th>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8 offset-md-2">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for="" class="text-center text-info">Copy This Text for Message inbox </label>
                                                        <textarea class="form-control mb-4 text-danger" rows="2" id="textarea-copy" placeholder="Loan Description" style="resize: none" value="" readonly>Dear <?=$fullName?>  This is to inform you that your loan of <?=$currency.$row['amount']?> have been Approved Successfully Thanks</textarea>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="input-group ">
                                                            <textarea class="form-control mb-4" rows="3" id="textarea-copy" placeholder="Loan Message" name="loan_message" style="resize: none" required></textarea>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="input-group">

                                                                    <select class="form-control  basic" name="loan_status" id="" required>
                                                                        <option value="">Select Type</option>
                                                                        <option value="1">Accept</option>
                                                                        <option value="2">Hold</option>
                                                                        <option value="3">Decline</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                            <button class="btn btn-primary col-12" name="loan_submit">Submit</button>
                                                        </div>
<!--                                                            --><?php
//                                                            echo "<pre>";
//                                                            var_dump($_POST)
//                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        include_once("./layout/footer.php");
        ?>
