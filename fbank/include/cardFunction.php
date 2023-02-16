<?php

function getCardStatus($status){
    if($status['card_status']==='1'){
        return '<button class="btn btn-success btn-sm">ACTIVE</button>';
    }elseif($status['card_status']==='2'){
        return '<button class="btn btn-primary btn-sm ">PROCESSING</button>';
    }elseif($status['card_status']==='3'){
        return '<button class="btn btn-danger btn-sm">ON HOLD</button>';
    }elseif($status['card_status']==='4'){
        return '<button class="btn btn-danger btn-sm">PAUSE</button>';
    }
}

function cardTypeName($card_number){
    if (substr($card_number[0],'0','2')==='52'){
        return "MASTER";
    }elseif (substr($card_number[0],'0','2')==='40'){
        return "VISA";
    }elseif (substr($card_number[0],'0','2')==='67'){
        return "MAESTRO";
    }elseif(substr($card_number[0],'0','2')==='30'){
        return "DINERS";
    }elseif(substr($card_number[0],'0','2')==='62'){
        return "UNIONPAY";
    }elseif(substr($card_number[0],'0','2')==='37'){
        return "AMERICAN EXPRESS";
    }elseif(substr($card_number[0],'0','2')==='60'){
        return "DISCOVER";
    }elseif(substr($card_number[0],'0','2')==='35'){
        return "JCB";
    }else{
        return "INVALID";
    }
}


if(isset($_POST['card_generate'])) {
    $card_name = $_POST['card_name'];
    $card_number = $_POST['card_number'];
    $card_expiration = $_POST['card_expiration'];
    $card_security = $_POST['security'];
    $seria_key = uniqid('CARD', false);



    if (empty($card_number)) {
        notify_alert('Invalid Card Number', 'danger', '3000', 'Close');
    } else {

        $sql2 = "INSERT INTO card SET card_name=:card_name,card_number=:card_number,card_expiration=:card_expiration,card_security=:card_security,user_id=:user_id,seria_key=:seria_key";
        $stmt = $conn->prepare($sql2);
        $stmt->execute([
            'card_name' => $card_name,
            'card_number' => $card_number,
            'card_expiration' => $card_expiration,
            'card_security' => $card_security,
            'user_id' => $user_id,
            'seria_key' => $seria_key
        ]);

                //EMAIL SENDING
                $email = $acct_email;
                $APP_NAME = WEB_TITLE;
                $APP_URL = WEB_URL;
                $BANK_PHONE = $BANK_PHONE;
                $message = $sendMail->CardGenMsg($full_name,$card_name,$card_number,$card_expiration,$card_security,$APP_NAME);

                $subject = "Card Status - $APP_NAME";
                $email_message->send_mail($email, $message, $subject);
                // Admin Email
                $subject = "Card Status - $APP_NAME";
                $email_message->send_mail(WEB_EMAIL, $message, $subject);

        if (true) {
            notify_alert('Credit Card Submit Successfully', 'success', '5000', 'Close');
        } else {
            notify_alert('Sorry Something went wrong', 'danger', '2000', 'Close');
        }
    }
}

if(isset($_POST['pause_card'])){
    $status = 4;
    $sql2 = "UPDATE card SET card_status=:card_status WHERE user_id=:user_id";
    $stmt = $conn->prepare($sql2);
    $stmt->execute([
        'card_status'=>$status,
        'user_id'=>$user_id
    ]);

    //EMAIL SENDING
    $email = $acct_email;
    $APP_NAME = WEB_TITLE;
    $APP_URL = WEB_URL;
    $BANK_PHONE = $BANK_PHONE;
    $message = $sendMail->CardMsg($full_name, $card_number,$APP_NAME);

    $subject = "Card Status - $APP_NAME";
    $email_message->send_mail($email, $message, $subject);
    // Admin Email
    $subject = "Card Status - $APP_NAME";
    $email_message->send_mail(WEB_EMAIL, $message, $subject);

    if(true){
        notify_alert('Credit Card Successfully On Pause','success','3000','Close');
    }else{
        notify_alert('Sorry Something Went Wrong','danger','2000','Close');
    }
}

if(isset($_POST['active_card'])){
    $status = 1;

    $sql2 = "UPDATE card SET card_status=:card_status WHERE user_id=:user_id";
    $stmt = $conn->prepare($sql2);
    $stmt->execute([
        'card_status'=>$status,
        'user_id'=>$user_id
    ]);

        //EMAIL SENDING
        $email = $acct_email;
        $APP_NAME = WEB_TITLE;
        $APP_URL = WEB_URL;
        $BANK_PHONE = $BANK_PHONE;
        $message = $sendMail->CardMsg($full_name, $card_number,$APP_NAME);
    
        $subject = "Card Status - $APP_NAME";
        $email_message->send_mail($email, $message, $subject);
        // Admin Email
        $subject = "Card Status - $APP_NAME";
        $email_message->send_mail(WEB_EMAIL, $message, $subject);

    if(true){
        notify_alert('Credit Card Activate Successfully','success','3000','Close');
    }else{
        notify_alert('Sorry Something Went Wrong','danger','2000','Close');
    }
}

if(isset($_POST['card_request'])){
    $card_type = $_POST['card_type'];
    $card_reason = $_POST['card_reason'];
    $reference_id = uniqid('card',false);

    $sql2 = "INSERT INTO card_request (reference_id,user_id,card_type,card_reason) VALUES (:reference_id,:user_id,:card_type,:card_reason)";
    $stmt = $conn->prepare($sql2);
    $stmt->execute([
        'reference_id'=>$reference_id,
        'user_id'=>$user_id,
        'card_type'=>$card_type,
        'card_reason'=>$card_reason
    ]);

        //EMAIL SENDING
        $email = $acct_email;
        $APP_NAME = WEB_TITLE;
        $APP_URL = WEB_URL;
        $BANK_PHONE = $BANK_PHONE;
        $message = $sendMail->CardMsg($full_name, $card_number,$APP_NAME);
    
        $subject = "Card Status - $APP_NAME";
        $email_message->send_mail($email, $message, $subject);
        // Admin Email
        $subject = "Card Status - $APP_NAME";
        $email_message->send_mail(WEB_EMAIL, $message, $subject);

    if(true){
        notify_alert('Thanks Your Credit Have been on Process Successfully','success','4000','Close');
    }else{
        notify_alert('Sorry Something Went Wrong','danger','2000','Close');
    }
}
