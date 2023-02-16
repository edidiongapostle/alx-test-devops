<?php
require_once("config.php"); 

$conn = dbConnect();



 
if (isset($_POST['register'])){
    $firstname = inputValidation($_POST['firstname']);
    $lastname = inputValidation($_POST['lastname']);
    $acct_limit = inputValidation($_POST['acct_limit']);
    $limit_remain = inputValidation($_POST['limit_remain']);
    $acct_no = "9909".(substr(number_format(time() * rand(), 0, '', ''), 0, 6));
    // $acct_no =inputValidation($_POST['acct_no']);
    $ssn =inputValidation($_POST['ssn']);
    $acct_balance =inputValidation($_POST['acct_balance']);
    $acct_type = inputValidation($_POST['acct_type']);
    $acct_gender =inputValidation($_POST['acct_gender']);
    $marital_status = inputValidation($_POST['marital_status']);
    $acct_currency =inputValidation($_POST['acct_currency']);
    $acct_email = inputValidation($_POST['acct_email']);
    $acct_phone = inputValidation($_POST['acct_phone']);
    $acct_occupation = inputValidation($_POST['acct_occupation']);
    $acct_dob = inputValidation($_POST['acct_dob']);
    $country = inputValidation($_POST['country']);
    $state = inputValidation($_POST['state']);
    $acct_address =inputValidation($_POST['acct_address']);
    $acct_password =inputValidation( $_POST['acct_password']);
    $confirm_password = inputValidation($_POST['confirm_password']);
    $acct_cot = inputValidation($_POST['acct_cot']);
    $acct_imf = inputValidation($_POST['acct_imf']);
    $acct_tax = inputValidation($_POST['acct_tax']);
    $acct_pin = inputValidation($_POST['acct_pin']);
    // Account Manager Field
    $mgr_name = inputValidation($_POST['mgr_name']);
    $mgr_no = inputValidation($_POST['mgr_no']);
    $mgr_email = inputValidation($_POST['mgr_email']);
    $mgr_id = inputValidation($_POST['mgr_id']);
    $mgr_image = inputValidation($_POST['mgr_image']);
    
    


    if($acct_password !== $confirm_password){
        toast_alert('error','Password not matched');

    }else{
        //checking exiting email
        $usersVerified = "SELECT * FROM users WHERE acct_email=:acct_email";
        $stmt = $conn->prepare($usersVerified);
        $stmt->execute([
            'acct_email'=>$acct_email
        ]);

        if($stmt->rowCount() >0){
            toast_alert('error','Email Already Exit');
        }else{
            //INSERT INTO DATABASE
            $registered = "INSERT INTO users (firstname,lastname,acct_limit,limit_remain,acct_email,acct_password,acct_no,ssn,acct_balance,acct_type,acct_gender,marital_status,acct_currency,acct_phone,acct_occupation,country,state,acct_address,acct_dob,acct_cot,acct_imf,acct_pin,acct_tax,mgr_name,mgr_no,mgr_email,mgr_id,mgr_image) VALUES(:firstname,:lastname,:acct_limit,:limit_remain,:acct_email,:acct_password,:acct_no,:ssn,:acct_balance,:acct_type,:acct_gender,:marital_status,:acct_currency,:acct_phone,:acct_occupation,:country,:state,:acct_address,:acct_dob,:acct_cot,:acct_imf,:acct_tax,:acct_pin,:mgr_name,:mgr_no,:mgr_email,:mgr_id,:mgr_image)";
            $reg = $conn->prepare($registered);
            $reg->execute([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'acct_limit' => $acct_limit,
                'limit_remain' => $limit_remain,
                'acct_email' => $acct_email,
                'acct_password' => password_hash((string)$acct_password, PASSWORD_BCRYPT),
                'acct_no'=>$acct_no,
                'ssn'=>$ssn,
                'acct_balance'=>$acct_balance,
                'acct_type'=>$acct_type,
                'acct_gender'=>$acct_gender,
                'marital_status'=>$marital_status,
                'acct_currency'=>$acct_currency,
                'acct_phone'=>$acct_phone,
                'acct_occupation'=>$acct_occupation,
                'country'=>$country,
                'state'=>$state,
                'acct_address'=>$acct_address,
                'acct_dob'=>$acct_dob,
                'acct_cot'=>$acct_cot,
                'acct_imf'=>$acct_imf,
                'acct_tax'=>$acct_tax,
                'acct_pin'=>$acct_pin,
                // Account Manager Field
                'mgr_name' =>$mgr_name,
                'mgr_no' =>$mgr_no,
                'mgr_email' =>$mgr_email,
                'mgr_id' =>$mgr_id,
                'mgr_image' =>$mgr_image,
                
                
            ]);


            if(true){

                if($acct_currency === 'USD'){
                    $currency =  "$";
                }elseif($acct_currency === 'EUR'){
                    $currency = "&euro;";
                }

                $amount_balance = $acct_balance;
                $fullName = $firstname." ".$lastname;
                //EMAIL SENDING
                $email = $acct_email;
                $APP_NAME = $pageTitle;
                $APP_URL = APP_URL;
                $BANK_PHONE = $BANK_PHONE;
                $tran_status = "";
                $message = $sendMail->regMsg($currency,$amount_balance, $fullName,$acct_type,$acct_password, $APP_NAME,$APP_URL,$BANK_PHONE,$acct_no);
                $subject = "Welcome $fullName - $APP_NAME";
                $email_message->send_mail($email, $message, $subject);
            }


            if(true){
                toast_alert('success','Account Created Successfully','Approved');
            }else{
                toast_alert('error','Sorry something went wrong');
            }
        }

    }







}

?>