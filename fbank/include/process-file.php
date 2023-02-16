<?php
require_once ('../session.php');
require_once("config.php");
$conn = dbConnect();

if(isset($_POST['pin']) && $_POST['type'] === "dom_tranfer"){

    $acct_no = $_POST['acct_no'];

    $viesConn="SELECT * FROM users WHERE acct_no = :acct_no";
    $stmt = $conn->prepare($viesConn);

    $stmt->execute([
        ':acct_no'=>$acct_no
    ]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $pin = inputValidation($_POST['pin']);
    $oldPin = inputValidation($row['acct_otp']);


    $acct_amount = inputValidation($row['acct_balance']);
    $account_id = inputValidation($_POST['account_id']);
    $amount = inputValidation($_POST['amount']);
    $bank_name = inputValidation($_POST['bank_name']);
    $acct_name = inputValidation($_POST['acct_name']);
    $acct_number = inputValidation($_POST['acct_number']);
    $acct_type = inputValidation($_POST['acct_type']);
    $acct_country = inputValidation($_POST['acct_country']);
    $acct_swift = inputValidation($_POST['acct_swift']);
    $acct_routing = inputValidation($_POST['acct_routing']);
    $acct_remarks = inputValidation($_POST['acct_remarks']);

    $limit_balance = $row['acct_limit'];
    $transferLimit = $row['limit_remain'];

    if($pin !== $oldPin){
        echo json_encode("error_pin");
//        toast_alert('error','Incorrect OTP CODE');
    }else if($acct_amount < 0){
        echo json_encode("balance");
        toast_alert('error','Insufficient Balance');
    }else {

        $tBalance = ($transferLimit - $amount);
        $aBalance = ($acct_amount - $amount);


        $sql = "UPDATE users SET limit_remain=:limit_remain,acct_balance=:acct_balance WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'limit_remain' => $tBalance,
            'acct_balance' => $aBalance,
            'id' => $account_id
        ]);

        if (true) {
            $refrence_id = uniqid();
            $sql = "INSERT INTO domestic_transfer (acct_id,amount,bank_name,acct_name,acct_number,acct_type,acct_remarks,refrence_id) VALUES(:acct_id,:amount,:bank_name,:acct_name,:acct_number,:acct_type,:acct_remarks,:refrence_id)";
            $tranfered = $conn->prepare($sql);
            $tranfered->execute([
                'amount' => $amount,
                'acct_id' => $account_id,
                'bank_name' => $bank_name,
                'acct_name' => $acct_name,
                'acct_number' => $acct_number,
                'acct_type' => $acct_type,
                'acct_remarks' => $acct_remarks,
                'refrence_id'=>$refrence_id
            ]);

            if (true) {
                session_start();
                $_SESSION['dom_transfer'] = $refrence_id;
                echo json_encode("success");

//                echo "<script>$('#thankyouModal').modal('show')</script>";
//                header("Location:./success.php");

            } else {
                toast_alert("error", "Sorry Error Occured Contact Support");
            }

        }
    }
}

if(isset($_POST['pin']) && $_POST['type'] === "wire_transfer"){


    $acct_no = $_POST['acct_no'];

    $viesConn="SELECT * FROM users WHERE acct_no = :acct_no";
    $stmt = $conn->prepare($viesConn);

    $stmt->execute([
        ':acct_no'=>$acct_no
    ]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $pin = inputValidation($_POST['pin']);
    $oldPin = inputValidation($row['acct_otp']);
    $acct_amount = inputValidation($row['acct_balance']);
    $account_id = inputValidation($_POST['account_id']);
    $amount = inputValidation($_POST['amount']);
    $bank_name = inputValidation($_POST['bank_name']);
    $acct_name = inputValidation($_POST['acct_name']);
    $acct_number = inputValidation($_POST['acct_number']);
    $acct_type = inputValidation($_POST['acct_type']);
    $acct_country = inputValidation($_POST['acct_country']);
    $acct_swift = inputValidation($_POST['acct_swift']);
    $acct_routing = inputValidation($_POST['acct_routing']);
    $acct_remarks = inputValidation($_POST['acct_remarks']);

    $limit_balance = $row['acct_limit'];
    $transferLimit = $row['limit_remain'];

    if($pin !== $oldPin){
        echo json_encode("error_pin");
    }else if($acct_amount < 0){
        echo json_encode("balance");
    }else {

        $tBalance = ($transferLimit - $amount);
        $aBalance = ($acct_amount - $amount);


        $sql = "UPDATE users SET limit_remain=:limit_remain,acct_balance=:acct_balance WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'limit_remain' => $tBalance,
            'acct_balance' => $aBalance,
            'id' => $account_id
        ]);

        if (true) {
            $refrence_id = uniqid();
            $sql = "INSERT INTO wire_transfer (amount,acct_id,refrence_id,bank_name,acct_name,acct_number,acct_type,acct_country,acct_swift,acct_routing,acct_remarks) VALUES(:amount,:acct_id,:refrence_id,:bank_name,:acct_name,:acct_number,:acct_type,:acct_country,:acct_swift,:acct_routing,:acct_remarks)";
            $tranfered = $conn->prepare($sql);
            $tranfered->execute([
                'amount' => $amount,
                'acct_id' => $account_id,
                'refrence_id'=>$refrence_id,
                'bank_name' => $bank_name,
                'acct_name' => $acct_name,
                'acct_number' => $acct_number,
                'acct_type' => $acct_type,
                'acct_country' => $acct_country,
                'acct_swift' => $acct_swift,
                'acct_routing' => $acct_routing,
                'acct_remarks' => $acct_remarks
            ]);

            if (true) {
                session_start();
                $_SESSION['wire_transfer'] = $refrence_id;
                echo json_encode("success");

//                header("Location:./success.php");

            } else {
                toast_alert("error", "Sorry Error Occured Contact Support");
            }

        }
    }
}

