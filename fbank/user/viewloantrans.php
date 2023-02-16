<?php
$pageName = "View Loan Transaction";
include_once("layouts/header.php");

$id = $_GET['id'];

$sql = "SELECT * FROM loan WHERE loan_reference_id=:id";
$stmt = $conn->prepare($sql);
$stmt->execute([
    'id'=>$id
]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$loanStatus = loanModalStatus($result);

if(empty($result['loan_message'])){
    $loanMsg = "N/A";
}else{
    $loanMsg = $result['loan_message'];
}


?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-md-8 offset-md-2 mt-5">
                <div class="card component-card">
                    <div class="card-body">
                        <div class="user-profile">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <h3 class=" text-info">Loan Transaction</h3>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 offset-md-2">
                                    <table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <td>AMOUNT</td>
                                            <td><?=$currency. $result['amount'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>REFERENCE ID</td>
                                            <td><?= $result['loan_reference_id'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Loan Reason</td>
                                            <td><?= $result['loan_remarks'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Message</td>
                                            <td><?= $loanMsg ?></td>
                                        </tr>

                                        <tr>
                                            <td>STATUS</td>
                                            <td><?=$loanStatus ?></td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


<?php

include_once("./layouts/footer.php");

?>
