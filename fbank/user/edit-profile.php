<?php
$pageName = "Edit Account";
//session_start();
include_once("layouts/header.php");

//require_once("../include/config.php");
//require_once("../include/userFunction.php");
//require_once('../include/userClass.php');
$acct_id = userDetails('id');



if (!$_SESSION['acct_no']) {
    header("location:../login.php");
    die;
}

if(isset($_POST['upload_picture'])){
    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];
        $name = $file['name'];

        $path = pathinfo($name, PATHINFO_EXTENSION);

        $allowed = array('jpg', 'png', 'jpeg');


        $folder = "../assets/profile/";
        $n = $row['firstname'].$name;

        $destination = $folder . $n;
    }
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        $sql = "UPDATE users SET image=:image WHERE id =:id";
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'image'=>$n,
            'id'=>$user_id
        ]);

        if(true){
            toast_alert("success","Your Image Uploaded Successfully", "Thanks!");
        }else{
            echo "invalid";
        }


    }
}

if(isset($_POST['change_password'])) {
    $old_password = inputValidation($_POST['old_password']);
    $new_password = inputValidation($_POST['new_password']);
    $confirm_password = inputValidation($_POST['confirm_password']);

    if (empty($old_password)) {
        notify_alert('Enter Old Password', 'danger', '2000', 'Close');
    } elseif(empty($new_password) || empty($confirm_password)) {
        notify_alert('Enter New Password & Confirm Password', 'danger', '2000', 'Close');
    }else{

        $new_password2 = password_hash((string)$new_password, PASSWORD_BCRYPT);
        $verification = password_verify($old_password, $row['acct_password']);

        if ($verification === false) {
            toast_alert("error", "Incorrect Old Password");

        } else if ($new_password !== $confirm_password) {
            toast_alert("error", "Confirm Password not matched");

        } else if ($new_password === $old_password) {
            toast_alert('error', 'New Password Matched with Old Password');
        } else {
            $sql2 = "UPDATE users SET acct_password=:acct_password WHERE id =:id";
            $passwordUpdate = $conn->prepare($sql2);
            $passwordUpdate->execute([
                'acct_password' => $new_password2,
                'id' => $user_id
            ]);

            $full_name = $user['firstname']. " ". $user['lastname'];
            // $APP_URL = APP_URL;
            $APP_NAME = WEB_TITLE;
            $APP_URL = WEB_URL;
            $APP_EMAIL = WEB_EMAIL;
            $user_email = $user['acct_email'];

            $message = $sendMail->PassChange($full_name,$APP_EMAIL, $APP_NAME);


            $subject = "Password Chnage Notification". "-". $APP_NAME;
            $email_message->send_mail($user_email, $message, $subject);

            $subject = "Password Chnage Notification". "-". $APP_NAME;
            $email_message->send_mail(WEB_EMAIL, $message, $subject);


            if (true) {
                toast_alert('success', 'Your Password Change Successfully !', 'Approved');
            } else {
                toast_alert('error', 'Sorry Something Went Wrong');
            }
        }
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
                                                                    <input type="text" class="form-control mb-4" id="fullName" placeholder="Full Name" value="<?= $row['acct_no'] ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="profession">Account Type</label>
                                                                    <input type="text" class="form-control mb-4" id="profession" placeholder="" value="<?= $row['acct_type'] ?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="fullName">Email</label>
                                                                    <input type="text" class="form-control mb-4" id="fullName" placeholder="Full Name" value="<?= $row['acct_email'] ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="profession">Date Of Birth</label>
                                                                    <input type="text" class="form-control mb-4" id="profession" placeholder="Date Of Birth" value="<?= $row['acct_dob'] ?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="fullName">Occupation</label>
                                                                    <input type="text" class="form-control mb-4"  placeholder="Ocuppation" value="<?= $row['acct_occupation'] ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="profession">Phone Number</label>
                                                                    <input type="text" class="form-control mb-4" id="profession" placeholder="Date Of Birth" value="<?= $row['acct_phone'] ?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="fullName">Gender</label>
                                                                    <input type="text" class="form-control mb-4 text-capitalize"  placeholder="Ocuppation" value="<?= $row['acct_gender'] ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="profession">Marital Status</label>
                                                                    <input type="text" class="form-control mb-4 text-capitalize" id="profession" placeholder="Date Of Birth" value="<?= $row['marital_status'] ?>" readonly>
                                                                </div>
                                                            </div>



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
                        <form class="section about">
                            <div class="info">
                                <h5 class="">Contact Information</h5>
                                <div class="row">
                                    <div class="col-md-11 mx-auto">
                                        <div class="form-group">
                                            <label>Contact Address</label>
                                            <input type="text" class="form-control mb-4" name="acct_address" placeholder="Designer" value="<?= $row['acct_address'] ?>" readonly>
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
                                    <h5 class="">Change Pin</h5>
                                    <div class="row">
                                        <div class="col-md-11 mx-auto">
                                            <div class="form-group">
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
                                                <button class="btn btn-primary" name="change_pin">Change Pin</button>
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
include_once("layouts/footer.php");
?>
