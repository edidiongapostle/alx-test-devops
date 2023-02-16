<?php
include_once("layout/header.php");
require_once("include/userClass.php");
require_once("include/loginFunction.php");


if(@$_SESSION['acct_no']){
    header("Location:./user/dashboard.php");
}

session_start();  
 if(isset($_POST["sub"]))  
 {  
      $_SESSION["name"] = $_POST["name"];  
      $_SESSION['last_login_timestamp'] = time();  
      header("location:index.php");       
 }



if(isset($_POST['login'])){
    $acct_no = inputValidation($_POST['acct_no']);
    $acct_password = inputValidation($_POST['acct_password']);



    $log = "SELECT * FROM users WHERE acct_no =:acct_no";
    $stmt = $conn->prepare($log);
    $stmt->execute([
        'acct_no'=>$acct_no
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);


    if($stmt->rowCount() === 0){
//        toast_alert("error","Invalid login details");
        notify_alert('Invalid login details','danger','2000','Close');

    }else{
        $validPassword = password_verify($acct_password, $user['acct_password']);

        if ($validPassword === false){
            notify_alert('Invalid login details','danger','2000','Close');

//            toast_alert("error","Invalid login details");
        }else{

            if($user['acct_status'] === 'hold'){
                notify_alert('Account on Hold, Kindly contact support to activate your account','danger','3000','close');
            }else {

                $acct_otp = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

                $sql = "UPDATE users SET acct_otp=:acct_otp WHERE acct_no=:acct_no";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    'acct_otp' => $acct_otp,
                    'acct_no' => $acct_no
                ]);
                
                //IP LOGIN DETAILS
            
            $device = $_SERVER['HTTP_USER_AGENT'];
            $ipAddress = $_SERVER['REMOTE_ADDR'];
            $nowDate = date('Y-m-d H:i:s');
            $user_id = $user['id'];
          
            
            $stmt = $conn->prepare("INSERT INTO audit_logs (user_id,device,ipAddress,datenow) VALUES(:user_id,:device,:ipAddress,:datenow)");
            $stmt->execute([
                'user_id'=>$user_id,
                'device'=>$device,
                'ipAddress'=>$ipAddress,
                'datenow'=>$nowDate
                ]);

                if (true) {

                    $sql = "SELECT * FROM users WHERE acct_no=:acct_no";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([
                        'acct_no' => $acct_no
                    ]);
                    $resultCode = $stmt->fetch(PDO::FETCH_ASSOC);
                    $code = $resultCode['acct_otp'];

                    // $APP_NAME = $pageTitle;
                    // $email = $resultCode['acct_email'];
                    // $fullName = $resultCode['firstname'] . " " . $resultCode['lastname'];

                    // $message = $sendMail->otpRequestLogin($fullName, $code, $APP_NAME);
                    // $subject = "[OTP CODE] - $APP_NAME";
                    // $email_message->send_mail($email, $message, $subject);
                    
                    if (true) {
                        
                        $full_name = $user['firstname']. " ". $user['lastname'];
                        // $APP_URL = APP_URL;
                        $APP_NAME = WEB_TITLE;
                        $APP_URL = WEB_URL;
                        $user_email = $user['acct_email'];

                        $message = $sendMail->LoginMsg($full_name, $device, $ipAddress, $nowDate, $APP_NAME, $APP_URL, $BANK_PHONE);

                        // User Email
                        $subject = "Login Notification". "-". $APP_NAME;
                        $email_message->send_mail($user_email, $message, $subject);
                        // Admin Email
                        $subject = "User Login Notification". "-". $APP_NAME;
                        $email_message->send_mail(WEB_EMAIL, $message, $subject);
                    }
                    
                     if (true) {
                        $_SESSION['login'] = $user['acct_no'];
                        header("Location:./pin.php");
                        exit;
                    }
                }
            }

        }
    }


}
?>

<div class="form-container outer">
    <div class="form-form">
        <div class="form-form-wrap">
            <div class="form-container">
                <div class="form-content">

                    <h1 class="">Sign In</h1>
                   
                    <p class="">Log in to your account to continue.</p>
                 <!--   <img src="./assets/settings/<?=$page['image']?>" class="navbar-logo" alt="logo" width="20%"> -->

                    <form class="text-left" method="POST">
                        <div class="form">

                            <div id="username-field" class="field-wrapper input">
                                <label for="username">Account ID</label>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <input id="username" name="acct_no" type="number" class="form-control" placeholder="Account ID">
                            </div>

                            <div id="password-field" class="field-wrapper input mb-2">
                                <div class="d-flex justify-content-between">
                                    <label for="password">PASSWORD</label>
                                    <a href="./signup" class="forgot-pass-link">Create New Account</a>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                <input id="password" name="acct_password" type="password" class="form-control" placeholder="Password">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </div>
                            <div class="d-sm-flex justify-content-between">
                                <div class="field-wrapper">
                                    <button type="submit" class="btn btn-primary" name="login" value="">Log In</button>
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

include_once("layout/footer.php");

?>

