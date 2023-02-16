<?php
include_once("./layout/header.php");
//require_once("./include/adminloginFunction.php");
//include_once("../include/config.php");
//require_once("./include/adminClass.php");

$id = $_GET['id'];
$sql = "SELECT * FROM deposit d LEFT JOIN users u ON d.user_id = u.id  WHERE refrence_id =:id";
$data = $conn->prepare($sql);
$data->execute([
        'id'=>$id
    ]);

$result = $data->fetch(PDO::FETCH_ASSOC);
$id1 = $result['id'];
$currency = currency($result);



$sql = "SELECT d.*, c.crypto_name FROM deposit d INNER JOIN crypto_currency c ON d.crypto_id = c.id WHERE refrence_id='$id'";
$stmt = $conn->prepare($sql);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$email = $result['acct_email'];

$fullName = $result['firstname']." ".$result['lastname'];
if($row['trans_type'] === '1'){
    $trans_type = '<span class="text-success">Credit</span>';
}else if($row['trans_type']=== '2'){
    $trans_type = '<span class="text-danger">Debit</span>';
}

if($row['crypto_status'] === '0'){
    $tran_status = '<span class="text-success">Processing</span>';
}else if($row['crypto_status'] === '1'){
    $tran_status = '<span class="text-success">Approved</span>';
}else if($row['crypto_status']=== '3'){
    $tran_status = '<span class="text-danger">Declined</span>';
}else if($row['crypto_status']=== '2') {
    $tran_status = '<span class="text-danger">On Hold</span>';
}

if(isset($_POST['trans_delete'])){
    $trans_delete = $_POST['trans_delete'];

   // $sql = "DELETE FROM transactions WHERE id =$id";
   $sql = "DELETE FROM deposit WHERE deposit.refrence_id='$id'";
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
    
    header('Location:./crypto-transaction.php');
    
}

if(isset($_POST['accept'])){
    $status_value = 1;
    $amount_balance = $row['amount'] + $result['acct_balance'];

    $trans_id = $row['trans_id'];
    $sql = "UPDATE deposit SET crypto_status=:crypto_status WHERE refrence_id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'crypto_status' =>$status_value,
        'id'=>$id
    ]);

    if(true) {
        $sql = "UPDATE users SET acct_balance=:acct_balance WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'acct_balance' => $amount_balance,
            'id' => $id1
        ]);

        if (true) { 
            $amount = $row['amount'];
            $crypto_name = $row['crypto_name'];
            $APP_NAME = $pageTitle;
            $tran_status = "Approved";
            $reference_id = $row['refrence_id'];
            $message = $sendMail->depositMsg($currency, $amount,$amount_balance, $crypto_name, $fullName, $APP_NAME,$tran_status,$reference_id);
            $subject = "[DEPOSIT APPROVED] - $APP_NAME";
            $email_message->send_mail($email, $message, $subject);
            $subject = "[DEPOSIT APPROVED] - $APP_NAME";
            $email_message->send_mail(WEB_EMAIL, $message, $subject);

            if (true) {
                toast_alert('success', 'Transaction Approve Successfully', 'Approved');

            } else {
                toast_alert('error', 'Sorry Something Went Wrong');
            }
        }
    }
}

if(isset($_POST['decline'])){
    // echo  "<h1>Hello</h1>";
    $status_value = 3;
    $trans_id = $row['trans_id'];
    $sql = "UPDATE deposit SET crypto_status=:crypto_status WHERE refrence_id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'crypto_status' =>$status_value,
        'id'=>$id
    ]);
    if(true) {
        $amount = $row['amount'];
        $crypto_name = $row['crypto_name'];
        $amount_balance = $result['acct_balance'];
        $reference_id = $row['refrence_id'];
        $tran_status = "Declined";
        $APP_NAME = $pageTitle;

        $message = $sendMail->depositMsg($currency, $amount, $amount_balance, $crypto_name, $fullName, $APP_NAME, $tran_status,$reference_id);
        $subject = "[DEPOSIT DECLINED] - $APP_NAME";
        $email_message->send_mail($email, $message, $subject);
        $subject = "[DEPOSIT DECLINED] - $APP_NAME";
        $email_message->send_mail(WEB_EMAIL, $message, $subject);

        if (true) {
            toast_alert('success', 'Transaction Decline Successfully', 'Decline');

        } else {
            toast_alert('error', 'Sorry Something Went Wrong');
        }
    }
}

if(isset($_POST['hold'])){
    $status_value = 2;
    $trans_id = $row['trans_id'];
    $sql = "UPDATE deposit SET crypto_status=:crypto_status WHERE refrence_id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'crypto_status' =>$status_value,
        'id'=>$id
    ]);

    if(true) {
        $amount = $row['amount'];
        $crypto_name = $row['crypto_name'];
        $amount_balance = $result['acct_balance'];
        $reference_id = $row['refrence_id'];
        $tran_status = "ON HOLD";
        $APP_NAME = $pageTitle;
        $message = $sendMail->depositMsg($currency, $amount, $amount_balance, $crypto_name, $fullName, $APP_NAME, $tran_status,$reference_id);
        $subject = "[DEPOSIT ON HOLD] - $APP_NAME";
        $email_message->send_mail($email, $message, $subject);
        $subject = "[DEPOSIT ON HOLD] - $APP_NAME";
        $email_message->send_mail(WEB_EMAIL, $message, $subject);


        if (true) {
            toast_alert('success', 'Transaction Hold Successfully', 'Hold');
            // header("location:./dashboard.php");

        } else {
            toast_alert('error', 'Sorry Something Went Wrong');
        }
    }
}
$sql = "SELECT d.*, c.crypto_name FROM deposit d INNER JOIN crypto_currency c ON d.crypto_id = c.id WHERE refrence_id='$id'";
$stmt = $conn->prepare($sql);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);

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
                                    <h6 class="">View Crypto Transaction</h6>
                                    <div class="row">
                                        <div class="col-md-8 offset-md-2 table-responsive">
                                            <table class="table table-bordered mb-4">
                                                <tbody>
                                                <tr>
                                                    <th>Name</th>
                                                    <th><?= ucwords($fullName) ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Amount</th>
                                                    <th><?=$currency. $row['amount'] ?></th>
                                                </tr>

                                                <tr>
                                                    <th>Transaction ID</th>
                                                    <th><?= $row['refrence_id'] ?></th>
                                                </tr>

                                                <tr>
                                                    <th>Wallet Address</th>
                                                    <th><?= $row['wallet_address'] ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Crypto Name</th>
                                                    <th><?= $row['crypto_name'] ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Receipt</th>
                                                    <th><?php
                                                        if(empty($row['image'])) {
                                                            echo "<p>No Receipt Submitted</p>"
                                                        ?>
                                                        <?php
                                                        }
                                                        ?>

                                                        <a href="../assets/deposit/<?=$row['image']?>" target="_blank"><img src="../assets/deposit/<?=$row['image']?>" width="20%" alt=""></a>
                                                    </th>

                                                </tr>
                                                <tr>
                                                    <th>Created At</th>
                                                    <th><?= $row['created_at'] ?></th>
                                                </tr>
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
                                                <?php
                                                if($row['crypto_status'] == '0'){
                                                ?>
                                                    <div class="col-md-2">

                                                        <button class="btn btn-primary col-md-12 mb-2" name="accept" >Accept</button>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button class="btn btn-danger col-md-12 mb-2" name="hold" >Hold</button>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button class="btn btn-warning col-md-12 mb-2" name="decline" >Decline</button>
                                                    </div>
                                                <?php
                                                }
                                                ?>

                                            <div class="col-md-2">
                                                   <form class="section about" method="POST">
                        
                                                <button class="btn btn-success" name="trans_delete">Delete</button>
                                           
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
