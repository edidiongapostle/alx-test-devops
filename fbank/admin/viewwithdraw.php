<?php
include_once("./layout/header.php");

$id = $_GET['id'];
//$id1 = $_SESSION['wire_id'];
//$sql = "SELECT * FROM users WHERE id =:id";
//$data = $conn->prepare($sql);
//$data->execute(['id'=>$id1]);
//
//$result = $data->fetch(PDO::FETCH_ASSOC);

$sql="SELECT * FROM withdrawal LEFT JOIN users ON withdrawal.user_id = users.id WHERE withdrawal.reference_id ='$id'";
$stmt = $conn->prepare($sql);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$currency = currency($row);

$email = $row['acct_email'];
$id1 = $row['id'];



$fullName = $row['firstname']." ".$row['lastname'];


if($row['status'] === '0'){
    $tran_status = '<span class="text-success">Processing</span>';
}else if($row['status'] === '1'){
    $tran_status = '<span class="text-success">Approved</span>';
}else if($row['status']=== '3'){
    $tran_status = '<span class="text-danger">Cancel</span>';
}else if($row['status']=== '2') {
    $tran_status = '<span class="text-danger">Hold</span>';
}

if(isset($_POST['trans_delete'])){
    $trans_delete = $_POST['trans_delete'];

    // $sql = "DELETE FROM transactions WHERE id =$id";
    $sql = "DELETE FROM withdrawal WHERE reference_id='$id'";
    // $sql = "DELETE FROM transactions.user_id = users.id WHERE transactions.trans_id='$id'";

    // FROM transactions LEFT JOIN users ON transactions.user_id = users.id WHERE transactions.refrence_id='$id'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        '$trans_delete'=>$trans_delete
    ]);


    if(true){
        toast_alert('success','Transaction Deleted Successfully');
    }else{
        toast_alert('error', 'Sorry Something Went Wrong');
    }

    header('Location:./withdraw-trans.php');

}

if(isset($_POST['accept'])){
    $status_value = 1;
    $sql = "UPDATE withdrawal SET status=:status WHERE reference_id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'status' =>$status_value,
        'id'=>$id
    ]);

                        //EMAIL SENDING
                        $email = $acct_email;
                        $APP_NAME = $pageTitle;
                        $APP_URL = APP_URL;
                        $BANK_PHONE = $BANK_PHONE;
                        $message = $sendMail->WithdrawMsg($currency,$amount,$amount_balance,$fullName,$APP_NAME);
    
                        $subject = "Withdrawal Status - $APP_NAME";
                        $email_message->send_mail($email, $message, $subject);
                        // Admin Email
                        $subject = "Withdrawal Status - $APP_NAME";
                        $email_message->send_mail(WEB_EMAIL, $message, $subject);

    if(true){
        toast_alert('success','Transaction Approve Successfully','Approved');

    }else{
        toast_alert('error','Sorry Something Went Wrong');
    }
}

if(isset($_POST['decline'])){
    $status_value = 3;
    $sql = "UPDATE withdrawal SET status=:status WHERE reference_id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'status' =>$status_value,
        'id'=>$id
    ]);
    $amount = $row['amount'];
    $amount_balance = $row['acct_balance'] + $row['amount'];

    $sql = "UPDATE users SET acct_balance=:acct_balance WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'acct_balance'=>$amount_balance,
        'id'=>$id1
    ]);

   
                    //EMAIL SENDING
                    $email = $acct_email;
                    $APP_NAME = $pageTitle;
                    $APP_URL = APP_URL;
                    $BANK_PHONE = $BANK_PHONE;
                    $message = $sendMail->WithdrawMsg($currency,$amount,$amount_balance,$fullName,$APP_NAME);

                    $subject = "Withdrawal Status - $APP_NAME";
                    $email_message->send_mail($email, $message, $subject);
                    // Admin Email
                    $subject = "Withdrawal Status - $APP_NAME";
                    $email_message->send_mail(WEB_EMAIL, $message, $subject);

    if(true){
        toast_alert('success','Transaction Decline Successfully','Decline');

    }else{
        toast_alert('error','Sorry Something Went Wrong');
    }
}

if(isset($_POST['hold'])){
    $status_value = 2;
    $sql = "UPDATE withdrawal SET status=:status WHERE reference_id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'status' =>$status_value,
        'id'=>$id
    ]);

    

                 
    if(true){
        toast_alert('success','Transaction Hold Successfully','Hold');

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
                <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll"
                    data-offset="-100">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="general-info" class="section general-info" method="POST">

                                <div class="info">
                                    <h6 class="">View Withdrawal Transaction</h6>
                                    <div class="row">
                                        <div class="col-md-8 offset-md-2 table-responsive">
                                            <table class="table table-bordered mb-4">
                                                <tbody>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th><?= ucwords($fullName) ?></th>
                                                    </tr>

                                                    <tr>
                                                        <th>Email</th>
                                                        <th><?= $row['acct_email'] ?></th>
                                                    </tr>

                                                    <tr>
                                                        <th>Reference ID</th>
                                                        <th><?= $row['reference_id'] ?></th>
                                                    </tr>

                                                    <tr>
                                                        <th>Amount</th>
                                                        <th><?=$currency.$row['amount'] ?></th>
                                                    </tr>

                                                    <?php
                                                    if(empty($row['bankname'])){
                                                        ?>

                                                    <?php
                                                    }else{

                                                    ?>
                                                    <tr>
                                                        <th>Bank Name</th>
                                                        <th><?= $row['bankname'] ?></th>
                                                    </tr>

                                                    <?php 
                                                    }
                                                    ?>


                                                    <?php
                                                    if(empty($row['wallet_address'])){
                                                        ?>

                                                    <?php
                                                    }else{

                                                    ?>
                                                    <tr>
                                                        <th>Wallet Address</th>
                                                        <th><?= $row['wallet_address'] ?></th>
                                                    </tr>
                                                    <?php
                                                    }
                                                    ?>


                                                    <?php
                                                    if(empty($row['routineno'])){
                                                        ?>

                                                    <?php
                                                    }else{

                                                    ?>
                                                    <tr>
                                                        <th>Routine No</th>
                                                        <th><?= $row['routineno'] ?></th>
                                                    </tr>
                                                    <?php 
                                                    }
                                                    ?>


                                                    <?php
                                                    if(empty($row['acctname'])){
                                                        ?>

                                                    <?php
                                                    }else{

                                                    ?>
                                                    <tr>
                                                        <th>Account Name</th>
                                                        <th><?= $row['acctname'] ?></th>
                                                    </tr>

                                                    <?php 
                                                    }
                                                    ?>




                                                    <tr>
                                                        <th>Status</th>
                                                        <th><?= $tran_status ?></th>
                                                    </tr>

                                                    <tr>
                                                        <th>Created At</th>
                                                        <th><?= $row['createdAt'] ?></th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8 offset-md-2">
                                            <div class="row">
                                                <div class="col-md-2">

                                                    <button class="btn btn-primary col-md-12 mb-2"
                                                        name="accept">Accept</button>
                                                </div>
                                                <div class="col-md-2">
                                                    <button class="btn btn-danger col-md-12 mb-2"
                                                        name="hold">Hold</button>
                                                </div>
                                                <div class="col-md-2">
                                                    <button class="btn btn-warning col-md-12 mb-2"
                                                        name="decline">Decline</button>
                                                </div>



                                                <div class="col-md-2">
                                                    <form class="section about" method="POST">

                                                        <button class="btn btn-success"
                                                            name="trans_delete">Delete</button>

                                                    </form>
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