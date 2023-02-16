<?php
$pageName = "Pin";
require_once("layouts/header.php");
include("./userPinfunction.php");
?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-md-8 offset-md-2 mt-5">
                <div class="card component-card">
                    <div class="card-body">
                        <?php
                        if($_SESSION['wire-transfer']){
                        ?>
                        <div class="user-profile">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="text-center">Verify Transaction Pin</h3>

                                </div>
                            </div>
                            <form action="" method="post" id="transfer_form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="text-center text-info">HELLO, <?= ucwords($fullName)?> KINDLY VALIDATE THE 6 DIGIT OTP SENT TO YOUR <?= $row['acct_phone']?> OR <?= $row['acct_email']?>

                                        </p>
                                        

                                    </div>
                                </div>
                                <div class="row mb-4 mt-4">
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <div class="input-group ">
                                                <input type="text" name="type" value="wire_transfer" hidden>
                                                <input type="number" class="form-control" name="pin" placeholder="pin" aria-label="notification" aria-describedby="basic-addon1" required>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-md-12">
                                                <input type="number" value="<?= $temp_trans['amount'] ?>" name="amount" hidden id="">
                                                <input type="text" value="<?= $temp_trans['bank_name'] ?>" name="bank_name" hidden id="">
                                                <input type="text" value="<?= $temp_trans['acct_name_id']?>" name="acct_name" hidden id="">
                                                <input type="number" value="<?= $temp_trans['acct_number'] ?>" name="acct_number" hidden id="">
                                                <input type="text" value="<?= $temp_trans['acct_type'] ?>" name="acct_type" hidden id="">
                                                <input type="text" value="<?= $temp_trans['acct_country'] ?>" name="acct_country" hidden id="">
                                                <input type="text" value="<?= $temp_trans['acct_swift']?>" name="acct_swift" hidden id="">
                                                <input type="number" value="<?= $temp_trans['acct_routing'] ?>" name="acct_routing" hidden id="">
                                                <input type="text" value="<?= $temp_trans['acct_remarks'] ?>" name="acct_remarks" hidden id="">
                                                <input type="number" value="<?= $temp_trans['acct_id'] ?>" name="account_id" hidden>
                                                <input type="number" value="<?= $row['acct_no'] ?>" name="acct_no" id="acct_no" hidden>


                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group ">
                                            <button class="btn btn-primary col-12" type="submit" >Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <?php
                        }elseif($_SESSION['dom-transfer']){
                        ?>
                        <div class="user-profile">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="text-center">Verify Transaction Pin</h3>

                                </div>
                            </div>
                            <form action="" method="post" id="transfer_form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="text-center text-info">HELLO, <?= ucwords($fullName)?> KINDLY VALIDATE THE 6 DIGIT OTP SENT TO YOUR <?= $row['acct_phone']?> OR <?= $row['acct_email']?>


                                        </p>
                                     
                                    </div>
                                </div>
                                <div class="row mb-4 mt-4">
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <div class="input-group ">
                                                <input type="text" name="type" value="dom_tranfer" hidden>

                                                <input type="number" class="form-control" name="pin" placeholder="pin" aria-label="notification" aria-describedby="basic-addon1" required>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-md-12">
                                                <input type="number" value="<?= $temp_trans['amount'] ?>" name="amount" hidden id="amount">
                                                <input type="text" value="<?= $temp_trans['bank_name'] ?>" name="bank_name" hidden id="bank_name">
                                                <input type="text" value="<?= $temp_trans['acct_name_id']?>" name="acct_name" hidden id="acct_name">
                                                <input type="number" value="<?= $temp_trans['acct_number'] ?>" name="acct_number" hidden id="acct_number">
                                                <input type="text" value="<?= $temp_trans['acct_type'] ?>" name="acct_type" hidden id="acct_type">
                                                <input type="text" value="<?= $temp_trans['trans_type'] ?>" name="trans_type" hidden id="trans_type">
                                                <input type="text" value="<?= $temp_trans['acct_remarks'] ?>" name="acct_remarks" hidden id="acct_remarks">
                                                <input type="number" value="<?= $temp_trans['acct_id'] ?>" name="account_id" id="account_id" hidden>

                                                <input type="number" value="<?= $row['acct_no'] ?>" name="acct_no" id="acct_no" hidden>


                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group ">
                                            <button class="btn btn-primary col-12">Submit</button>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>


                        <?php
                        }
                        ?>
                    </div>

                </div>
            </div>


                                <div class="modal fade" id="thankyouModal" tabindex="-1" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class='row'>

                                                    <div class='col-md-12'>
                                                        <!--begin::Card-->
                                                        <div class='card card-custom'>
                                                            <div class='card-header border-0 ribbon ribbon-right'>
													<span class='card-icon'>
														<i class='flaticon2-chat-1 text-red'></i>
													</span>
                                                                    <h3 class='card-label text-dark'>Transaction is Processing</h3>
                                                                </div>

                                                            </div>
                                                            <div class='separator separator-solid separator-dark opacity-20'></div>

                                                            <div class='swal2-header text-center'>
                                                                <div class='card-body text-dark'>
                                                                    <html><body oncontextmenu='return false' onselectstart='return false' ondragstart='return false' topmargin=0 rightmargin=0 leftmargin=0>

                                                                    <br></br>
                                                                    <p align='center'><img src='https://e-platforms.xyz/images/spinner.gif' width='200' height='200'></p>

                                                                    <div id='splashcontainer' class='ui centered header upper'></div>
                                                                    <div name='splashcontainerns' id='splashcontainerns'></div>
                                                                 </div>
                                                            </div>

                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>




<?php
include_once("layouts/footer.php");

?>
