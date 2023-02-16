<?php
include_once("./layout/header.php");
//require_once("./include/adminloginFunction.php");
//include_once("../include/config.php");

$id = $_GET['id'];

$sql="SELECT * FROM transactions LEFT JOIN users ON transactions.user_id = users.id WHERE transactions.trans_id='$id'";
$stmt = $conn->prepare($sql);
$stmt->execute();




$row = $stmt->fetch(PDO::FETCH_ASSOC);
$id1 = $row['id'];
$currency = currency($row);
$email = $row['acct_email'];

$fullName = $row['firstname']." ".$row['lastname'];
if($row['trans_type'] === '1'){
    $trans_type = '<span class="text-success">Credit</span>';
}else if($row['trans_type']=== '2'){
    $trans_type = '<span class="text-danger">Debit</span>';
}

if ($row['trans_type']==='1'){
    $transfer_type = "CREDIT";
}else if($row['trans_type']==='2'){
    $transfer_type = "DEBIT";
}

if($row['trans_status'] === '0'){
    $tran_status = '<span class="text-success">Processing</span>';
}else if($row['trans_status'] === '1'){
    $tran_status = '<span class="text-success">Approved</span>';
}else if($row['trans_status']=== '3'){
    $tran_status = '<span class="text-danger">Cancel</span>';
}else if($row['trans_status']=== '2') {
    $tran_status = '<span class="text-danger">Hold</span>';
}

//trans_type = 1 "CREDIT"
//trans_type = 2 "DEBIT"

if(($row['trans_type'] === '1') && isset($_POST['accept'])) {
$status_value = 1;
$trans_id = $row['refrence_id'];
$sql = "UPDATE transactions SET trans_status=:trans_status WHERE refrence_id=:id";
$stmt = $conn->prepare($sql);
$stmt->execute([
    'trans_status' => $status_value,
    'id' => $trans_id
]);

if (true) {
    $amount_balance = $row['amount'] + $row['acct_balance'];
    $sql = "UPDATE users SET acct_balance=:acct_balance WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'acct_balance' =>$amount_balance,
        'id' =>$id1
    ]);
    if(true){
        $APP_NAME = $pageTitle;
        $tran_status = "Successful";
        $reference_id = $row['refrence_id'];
        $amount = $row['amount'];
        $message = $sendMail->creditMsg($currency, $amount,$amount_balance,$transfer_type, $fullName, $APP_NAME,$tran_status,$reference_id);
        $subject = "[DEPOSIT APPROVED] - $APP_NAME";
        $email_message->send_mail($email, $message, $subject);
    }
    if (true) {
        toast_alert('success', 'Transaction Approve Successfully', 'Approved');

    } else {
        toast_alert('error', 'Sorry Something Went Wrong');
    }
}
}else if(($row['trans_type']=== '2') && isset($_POST['accept'])){
    $status_value = 1;
    $trans_id = $row['refrence_id'];
    $sql = "UPDATE transactions SET trans_status=:trans_status WHERE refrence_id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'trans_status' =>$status_value,
        'id'=>$trans_id
    ]);
    if (true){
        $amount_balance =$row['acct_balance'] - $row['amount'];
        $sql = "UPDATE users SET acct_balance=:acct_balance WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'acct_balance' =>$amount_balance,
            'id' =>$id1
        ]);
    }
    if(true){
        $APP_NAME = $pageTitle;
        $tran_status = "Successful";
        $reference_id = $row['refrence_id'];
        $amount = $row['amount'];
        $message = $sendMail->creditMsg($currency, $amount,$amount_balance,$transfer_type, $fullName, $APP_NAME,$tran_status,$reference_id);
        $subject = "[DEBIT APPROVED] - $APP_NAME";
        $email_message->send_mail($email, $message, $subject);
    }

    if(true){
        toast_alert('success','Transaction Approve Successfully','Approved');

    }else{
        toast_alert('error','Sorry Something Went Wrong');
    }
}


if(isset($_POST['trans_delete'])){
    $trans_delete = $_POST['trans_delete'];

   // $sql = "DELETE FROM transactions WHERE id =$id";
   $sql = "DELETE FROM transactions WHERE transactions.trans_id='$id'";
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
    
    header('Location:./credit_debit_trans.php');
    
}

if(isset($_POST['decline'])){
    $status_value = 3;
    $trans_id = $row['refrence_id'];
    $sql = "UPDATE transactions SET trans_status=:trans_status WHERE refrence_id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'trans_status' =>$status_value,
        'id'=>$trans_id
    ]);
    if(true){
        $APP_NAME = $pageTitle;
        $amount_balance = $row['acct_balance'];
        $tran_status = "Declined";
        $reference_id = $row['refrence_id'];
        $amount = $row['amount'];
        $message = $sendMail->creditMsg($currency, $amount,$amount_balance,$transfer_type, $fullName, $APP_NAME,$tran_status,$reference_id);
        $subject = "[TRANSACTION DECLINED] - $APP_NAME";
        $email_message->send_mail($email, $message, $subject);
    }

    if(true){
        toast_alert('success','Transaction Decline Successfully','Decline');

    }else{
        toast_alert('error','Sorry Something Went Wrong');
    }
}

if(isset($_POST['hold'])){
    $status_value = 2;
    $trans_id = $row['refrence_id'];
    $sql = "UPDATE transactions SET trans_status=:trans_status WHERE refrence_id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'trans_status' =>$status_value,
        'id'=>$trans_id
    ]);
    if(true){
        $APP_NAME = $pageTitle;
        $amount_balance = $row['acct_balance'];
        $tran_status = "ON HOLD";
        $reference_id = $row['refrence_id'];
        $amount = $row['amount'];
        $message = $sendMail->creditMsg($currency, $amount,$amount_balance,$transfer_type, $fullName, $APP_NAME,$tran_status,$reference_id);
        $subject = "[TRANSACTION ON HOLD] - $APP_NAME";
        $email_message->send_mail($email, $message, $subject);
    }

    if(true){
        toast_alert('success','Transaction Hold Successfully','Hold');
       // header("location:./dashboard.php");

    }else{
        toast_alert('error','Sorry Something Went Wrong');
    }
}




$sql="SELECT * FROM transactions LEFT JOIN users ON transactions.user_id = users.id WHERE transactions.trans_id='$id'";
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
                                    <h6 class="">Credit / Debit Transaction</h6>
                                    <div class="row">
                                        <div class="col-md-8 offset-md-2 table-responsive">
                                            <table class="table table-bordered mb-4">
                                              <tbody>
                                                  <tr>
                                                      <th>Name</th>
                                                      <th><?= ucwords($fullName) ?></th>
                                                  </tr>
                                                  <tr>
                                                      <th>Transaction ID</th>
                                                      <th><?=$row['refrence_id'] ?></th>
                                                  </tr>
                                                  <tr>
                                                      <th>Amount</th>
                                                      <th><?=$currency.$row['amount'] ?></th>
                                                  </tr>
                                                  <tr>
                                                      <th>Transfer Type</th>
                                                      <th><?= $trans_type ?></th>
                                                  </tr>
                                                  <tr>
                                                      <th>Sender Name</th>
                                                      <th><?= $row['sender_name'] ?></th>
                                                  </tr>
                                                  <tr>
                                                      <th>Description</th>
                                                      <th><?= $row['description'] ?></th>
                                                  </tr>
                                                  <tr>
                                                      <th>Created At</th>
                                                      <th><?= $row['created_at'] ?></th>
                                                  </tr>
                                                  <tr>
                                                      <th>Time Created</th>
                                                      <th><?= $row['time_created'] ?></th>
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
                                                if($row['trans_type'] == '0'){
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
