<?php
include_once("./layout/header.php");
//require_once("./include/adminloginFunction.php");
//include_once("../include/config.php");

$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE id =:id";
$data = $conn->prepare($sql);
$data->execute(['id'=>$id]);

$row = $data->fetch(PDO::FETCH_ASSOC);

if($row['billing_code']==='0'){
    $billing = "DEACTIVATE";
}elseif($row['billing_code']==='1'){
    $billing = "ACTIVE";
}

if($row['transfer']==='0'){
    $transfer = "DEACTIVATE";
}elseif($row['transfer']==='1'){
    $transfer = "ACTIVE";
}

if(isset($_POST['upload_picture'])){
    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];
        $name = $file['name'];

        $path = pathinfo($name, PATHINFO_EXTENSION);

        $allowed = array('jpg', 'png', 'jpeg');


        $folder = "../assets/profile/";
        $n = $row['acct_no'].$name;

        $destination = $folder . $n;
    }
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        $sql = "UPDATE users SET image=:image WHERE id =:acct_id";
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'image'=>$n,
            'acct_id'=>$id

        ]);

        if(true){
            toast_alert("success","Your Image Uploaded Successfully", "Thanks!");
        }else{
            echo "invalid";
        }
        
        // header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
        header("Location:./users.php");
die;


    }
}

if(isset($_POST['profile_save'])){
    $acct_no = $_POST['acct_no'];
    $acct_type = $_POST['acct_type'];
    $acct_email = $_POST['acct_email'];
    $acct_dob = $_POST['acct_dob'];
    $acct_occupation = $_POST['acct_occupation'];
    $acct_phone = $_POST['acct_phone'];
    $acct_gender = $_POST['acct_gender'];
    $marital_status = $_POST['marital_status'];
    $acct_limit = $_POST['acct_limit'];
    $acct_balance = $_POST['acct_balance'];
     $acct_cot = $_POST['acct_cot'];
      $acct_imf = $_POST['acct_imf'];
       $acct_tax = $_POST['acct_tax'];


//    if($acct_limit === '5000'){
//        $limit = 0;
//    }else{
//        $limit = $acct_limit;
//    }
    $limiBalance = ($acct_limit + $row['limit_remain']);
    $limit = ($row['acct_limit']+$acct_limit);

//    var_dump($limit);
//    exit();


    $sql = "UPDATE users SET acct_no=:acct_no, acct_type=:acct_type,acct_email=:acct_email,acct_dob=:acct_dob,acct_occupation=:acct_occupation,acct_phone=:acct_phone,acct_gender=:acct_gender,marital_status=:marital_status,acct_limit=:acct_limit,acct_cot=:acct_cot,acct_tax=:acct_tax,acct_imf=:acct_imf,acct_balance=:acct_balance,limit_remain=:limit_remain WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'acct_no'=>$acct_no,
        'acct_type'=>$acct_type,
        'acct_email'=>$acct_email,
        'acct_dob'=>$acct_dob,
        'acct_occupation'=>$acct_occupation,
        'acct_phone'=>$acct_phone,
        'acct_gender'=>$acct_gender,
        'acct_tax'=>$acct_tax,
        'acct_cot'=>$acct_cot,
        'acct_imf'=>$acct_imf,
        'marital_status'=>$marital_status,
        'acct_limit'=>$limit,
        'acct_balance'=>$acct_balance,
        'limit_remain'=>$limiBalance,
        'id'=>$id
    ]);

    if(true){
        toast_alert('success','Account updated successfully','Approved');
        
        
        
    }else{
        toast_alert('error','Sorry something went wrong');
        
        
    }
    
    //header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
    header("Location:./users.php");
die;
    

}


if(isset($_POST['status_delete'])){
    $status_delete = $_POST['status_delete'];

    $sql = "DELETE FROM users WHERE id =$id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        '$status_delete'=>$status_delete
    ]);


    if(true){
        toast_alert('success','Account Deleted Successfully');
    }else{
        toast_alert('error', 'Sorry Something Went Wrong');
    }
    
    header("Location:./users.php");
die;
    
}



if(isset($_POST['change_pin'])){
    $current_pin = inputValidation($_POST['current_pin']);
    $new_pin = inputValidation($_POST['new_pin']);
    $confirm_pin = inputValidation($_POST['confirm_pin']);
    $verify_pin = $row['acct_pin'];

    if($current_pin !== $verify_pin){
        toast_alert('error','Invalid Old Pin');
    }else if($new_pin !== $confirm_pin){
        toast_alert('error','Confirm Pin not Matched');
    }else if($new_pin === $verify_pin){
        toast_alert('error','New Pin Matched with Old Pin');
    }else{
        $sql2 = "UPDATE users SET acct_pin=:acct_pin WHERE id =:acct_id";
        $passwordUpdate = $conn->prepare($sql2);
        $passwordUpdate->execute([
            'acct_pin' =>$new_pin,
            'acct_id' => $id
        ]);
        if(true){
            toast_alert('success','Account Pin Change Successfully','Approved');
        }else{
            toast_alert('error', 'Sorry Something Went Wrong');
        }
    }
    
    // header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
    header("Location:./users.php");
die;


}

if(isset($_POST['change_password'])) {
    $old_password = inputValidation($_POST['old_password']);
    $new_password = inputValidation($_POST['new_password']);
    $confirm_password = inputValidation($_POST['confirm_password']);

    $new_password2 = password_hash((string)$new_password, PASSWORD_BCRYPT);
    $verification = password_verify($old_password, $row['acct_password']);

    if ($verification === false) {
        toast_alert("error", "Incorrect Old Password");

    } else if ($new_password !== $confirm_password) {
        toast_alert("error", "Confirm Password not matched");

    } else if($new_password === $old_password){
        toast_alert('error', 'New Password Matched with Old Password');
    }else {
        $sql2 = "UPDATE users SET acct_password=:acct_password WHERE id =:acct_id";
        $passwordUpdate = $conn->prepare($sql2);
        $passwordUpdate->execute([
            'acct_password' =>$new_password2,
            'acct_id' => $id
        ]);
        if (true) {
            toast_alert('success', 'Your Password Change Successfully !', 'Approved');
        } else {
            toast_alert('error', 'Sorry Something Went Wrong');
        }
    }
    
   //  header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
   header("Location:./users.php");
die;

}

if(isset($_POST['status_submit'])){
    $acct_status = $_POST['acct_status'];

    $sql = "UPDATE users SET acct_status=:acct_status WHERE id =:acct_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'acct_status'=>$acct_status,
        'acct_id'=>$id
    ]);

    if(true){
        toast_alert('success','Account Status Sent Successfully to '.ucwords($acct_status),'Approved');
    }else{
        toast_alert('error', 'Sorry Something Went Wrong');
    }
    
    // header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
    header("Location:./users.php");
die;

}

if(isset($_POST['billing_code'])){
    $billing_type = $_POST['billing_type'];

    if($billing_type==='0'){
        $type = "Deactivate";
    }else{
        $type = "Active";
    }

    $sql2 = "UPDATE users SET billing_code=:billing_code WHERE id=:acct_id";
    $stmt = $conn->prepare($sql2);
    $stmt->execute([
        'billing_code'=>$billing_type,
        'acct_id'=>$id
    ]);
    if(true){
        toast_alert('success','Billing Code Successfully '.$type,'success');
    }else{
        toast_alert('error', 'Sorry Something Went Wrong');
    }
    
    // header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
    header("Location:./users.php");
die;
}

if(isset($_POST['transfer'])){
    $transfer_type = $_POST['transfer_type'];

    if($transfer_type==='0'){
        $type = "Deactivate";
    }else{
        $type = "Active";
    }

    $sql2 = "UPDATE users SET transfer=:transfer WHERE id=:acct_id";
    $stmt = $conn->prepare($sql2);
    $stmt->execute([
        'transfer'=>$transfer_type,
        'acct_id'=>$id
    ]);
    if(true){
        toast_alert('success','Transfer Status Successfully Changed'.$type,'success');
    }else{
        toast_alert('error', 'Sorry Something Went Wrong');
    }
    
    // header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
    header("Location:./users.php");
die;
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
                            <form id="general-info" class="section general-info" enctype="multipart/form-data" method="POST">

                                <div class="info">
                                    <h6 class="">General Information</h6>
                                    <div class="row">
                                        <div class="col-lg-11 mx-auto">
                                            <div class="row">
                                                <div class="col-xl-2 col-lg-12 col-md-4 text-center">
                                                    <div class="upload mt-4 pr-md-4">
                                                        <center>
                                                            <input type="file" id="input-file-max-fs" class="dropify" data-default-file="../assets/profile/<?= $row['image']?>" name="image" data-max-file-size="2M" />
                                                        </center>
                                                        <p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i> Upload Picture</p>
                                                        <div class="form-group text-center" >
                                                            <button class="btn btn-primary " name="upload_picture">Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                                    <div class="form">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="fullName">Account No</label>
<!--                                                                    --><?php
//                                                                    echo "<pre>";
//                                                                    print_r($_POST)
//                                                                    ?>
                                                                    <input type="text" class="form-control mb-4"  placeholder="Full Name" value="<?= $row['acct_no'] ?>" name="acct_no" >
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="profession">Account Type</label>
                                                                    <div class="input-group">
                                                                        <select name="acct_type" class="form-control  basic" required>
                                                                            <option value="<?= $row['acct_type']?>"><?= $row['acct_type']?></option>
                                                                            <option value="Savings">Savings Account</option>
                                                                            <option value="Current">Current Account</option>
                                                                            <option value="Checking">Checking Account</option>
                                                                            <option value="Fixed Deposit">Fixed Deposit</option>
                                                                            <option value="Non Resident">Non Resident Account</option>
                                                                            <option value="Online Banking">Online Banking</option>
                                                                            <option value="Domicilary Account">Domicilary Account</option>
                                                                            <option value="Joint Account">Joint Account</option>                                                        </select>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="fullName">Email</label>
                                                                    <input type="text" class="form-control mb-4" id="fullName" placeholder="Full Name" value="<?= $row['acct_email'] ?>" name="acct_email" >
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="profession">Date Of Birth</label>
                                                                    <input type="date" class="form-control mb-4" id="profession" placeholder="Date Of Birth" value="<?= $row['acct_dob'] ?>" name="acct_dob">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="fullName">Occupation</label>
                                                                    <input type="text" class="form-control mb-4"  placeholder="Ocuppation" value="<?= $row['acct_occupation'] ?>" name="acct_occupation">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="profession">Phone Number</label>
                                                                    <input type="text" class="form-control mb-4"  placeholder="Date Of Birth" value="<?= $row['acct_phone'] ?>" name="acct_phone">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                         <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="fullName">COT code</label>
                                                                    <input type="text" class="form-control mb-4"  placeholder="Ocuppation" value="<?= $row['acct_cot'] ?>" name="acct_cot">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="profession">IMF code</label>
                                                                    <input type="text" class="form-control mb-4" placeholder="Date Of Birth" value="<?= $row['acct_imf'] ?>" name="acct_imf">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        

                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="fullName">Gender</label>
                                                                    <select name="acct_gender" class="form-control  basic"  id="">
                                                                        <option value="<?= $row['acct_gender']?>"><?= $row['acct_gender']?></option>
                                                                        <option value="male">Male</option>
                                                                        <option value="female">Female</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="profession">Marital Status</label>
                                                                    <input type="text" class="form-control mb-4 text-capitalize" id="profession" placeholder="Date Of Birth" value="<?= $row['marital_status'] ?>" name="marital_status" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label for="profession">Account Limit Balance</label><br>

                                                                        <button class="btn btn-danger disabled col-md-12"><?= $row['acct_limit'] ?></button>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <div class="form-group">
                                                                            
                                                                            <label for="profession">Account Limit</label>
                                                                            <input type="text" class="form-control mb-4" name="acct_limit" placeholder="<?= $row['acct_limit'] ?>" value="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="profession">TAX code</label>
                                                                    <input type="text" class="form-control mb-4" value="<?= $row['acct_tax'] ?>" name="acct_tax">
                                                                </div>
                                                            </div>
                                                        </div>

                                                            <div class="col-md-12">
                                                                <button class="btn btn-primary text-center" name="profile_save">Save</button>
                                                            </div>







                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form class="section about" method="post">
                                <div class="info">
                                    <h5 class="">ACTIVE / HOLD & BILLING CODE</h5>
                                    <div class="row">

                                        <div class="col-md-4 mx-auto">

                                            <div class="form-group">
                                                <button class="btn btn-danger mb-4 disabled">CURRENT STATUS: <b><?=ucwords($row['acct_status']) ?></b> </button><br>
                                                <label for="">SELECT TYPE IF HOLD OR ACTIVE</label>
                                                <select name="acct_status" id="" class="form-control  basic">
                                                    <option value="">Select</option>
                                                        <option value="active">ACTIVE</option>
                                                    <option value="hold">HOLD</option>
                                                </select>
                                            </div>
                                            <div class=" text-center mb-3">
                                                <button class="btn btn-primary" name="status_submit">Submit</button>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mx-auto">

                                            <div class="form-group">
                                                <button class="btn btn-danger mb-4 disabled">BILLING CODE STATUS: <b><?=ucwords($billing) ?></b> </button><br>
                                                <label for="">SELECT BILLING CODE</label>
                                                <select name="billing_type" id="" class="form-control  basic">
                                                    <option value="">Select</option>
                                                    <option value="1">ACTIVE</option>
                                                    <option value="0" >DEACTIVATE</option>
                                                </select>
                                            </div>
                                            <div class=" text-center">
                                                <button class="btn btn-primary" name="billing_code">Change Billing Code</button>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4 mx-auto">

                                            <div class="form-group">
                                                <button class="btn btn-danger mb-4 disabled">TRANSFER CODE STATUS: <b><?=ucwords($transfer) ?></b> </button><br>
                                                <label for="">SELECT TRANSFER STATUS</label>
                                                <select name="transfer_type" id="" class="form-control  basic">
                                                    <option value="">Select</option>
                                                    <option value="1">ACTIVE</option>
                                                    <option value="0" >DEACTIVATE</option>
                                                </select>
                                            </div>
                                            <div class=" text-center">
                                                <button class="btn btn-primary" name="transfer">Change Trasfer Status</button>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </form>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6 layout-spacing">
                            <form class="section about" method="post">
                                <div class="info">
                                    <h5 class="">Change Password</h5>
                                    <div class="row">
                                        <div class="col-md-11 mx-auto">
                                            <div class="form-group">
                                                <label>Old Password</label>
                                                <input type="password" class="form-control mb-4" name="old_password" placeholder="Old Password" value="">
                                            </div>
                                            <div class="form-group">
                                                <label>New Password</label>
                                                <input type="password" class="form-control mb-4" name="new_password" placeholder="New Password" value="">
                                            </div>

                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <input type="password" class="form-control mb-4" name="confirm_password" placeholder="Confirm Password">
                                            </div>

                                            <div class="form-group">
                                                <button class="btn btn-primary" name="change_password">Change Password</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 layout-spacing">
                            <form class="section about" method="post" autocomplete="off" autofocus="off">
                                <div class="info">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5 class="">Change Pin</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <a class="btn btn-danger text-center col-md-12 disabled ">Current Pin : <?= $row['acct_pin']?></a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-11 mx-auto">
                                            <div class="form-group">
<!--                                                <p class="text-danger"></p>-->
                                                <label>Current Pin</label>
                                                <input type="password" class="form-control mb-4" name="current_pin" placeholder="Current Pin" value="">
                                            </div>
                                            <div class="form-group">
                                                <label>New Pin</label>
                                                <input type="password" class="form-control mb-4" name="new_pin" placeholder="New Pin" value="">
                                            </div>

                                            <div class="form-group">
                                                <label>Confirm Pin</label>
                                                <input type="password" class="form-control mb-4" name="confirm_pin" placeholder="Confirm Pin">
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-primary" name="change_pin" > Change Pin</button>
                                                
                                                <form class="section about" method="POST">
                        
                                                <button class="btn btn-danger" name="status_delete" >  Delete User</button>
                                           
                                                </form>
                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            
                            
                        </div>
                        
                        


                    </div>
                </div>
            </div>
            
            
            <?php
include_once("./layout/footer.php");
?>
