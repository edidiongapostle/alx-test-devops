<?php
$pageName = "Domestic Transfer";
include_once("layouts/header.php");
require_once("./userPinfunction.php");
//require_once("../include/config.php");
//require_once("../include/loginFunction.php");
//require_once("../include/userFunction.php");
//require_once('../include/userClass.php');






?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-md-8 offset-md-2">
                <div class="card component-card">
                    <div class="card-body">
                        <div class="user-profile">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php
                                        if($acct_stat === 'active'){
                                    ?>
                                      <?php
                                   
                                   if($page['transfer'] === '1'){
                                    ?>
                                    
                                    <?php
                                   
                                   if($row['transfer'] === '1'){
                                    ?>
                                    
                                    
                                    <h3 class="text-center">Domestic Transfer</h3>
                                    <form method="POST"  enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-4 mt-4">
                                                    <label for="">Amount</label>
                                                    <div class="input-group ">
                                                        <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-dollar-sign"><line x1="12" y1="1"x2="12"y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg></span>
                                                        </div>
                                                        <input type="number" class="form-control" name="amount" value="<?= $_POST['amount']?>" placeholder="Amount" aria-label="notification" aria-describedby="basic-addon1" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-4 mt-4">
                                                    <label for="">Beneficiary Account Name</label>
                                                    <div class="input-group ">
                                                        <input type="text" class="form-control" name="acct_name"  placeholder="Beneficiary Account Name" aria-label="notification" aria-describedby="basic-addon1" value="<?= $_POST['acct_name']?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-4 mt-4">
                                                    <label for="">Bank Name</label>
                                                    <div class="input-group ">
                                                        <input type="text" class="form-control" name="bank_name"  placeholder="Bank Name" value="<?= $_POST['bank_name']?>" aria-label="notification" aria-describedby="basic-addon1" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-4 mt-4">
                                                    <label for="">Beneficiary Account No</label>
                                                    <div class="input-group ">
                                                        <input type="number" class="form-control" name="acct_number"  placeholder="Beneficiary Account Name" aria-label="notification" aria-describedby="basic-addon1" value="<?= $_POST['acct_number']?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="row">
                                            <div class="col-md-6">

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-4 mt-4">
                                                    <label for="">Select Account Type</label>
                                                    <div class="input-group">
                                                        <select name="acct_type" class='selectpicker' data-width='100%' required>
                                                            <option value="">Select Account Type</option>
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
                                            <div class="col-md-6">
                                                <div class="form-group mb-4 mt-4">
                                                    <label for="">Naration/Purpose</label>
                                                    <div class="input-group ">
                                                        <textarea class="form-control mb-4" rows="3" id="textarea-copy" placeholder="Fund Description" name="acct_remarks"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>




                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <button class="btn btn-primary mb-2 mr-2" name="domestic-transfer" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> Transfer</button>
                                            </div>
                                        </div>
                                    </form>
                                    <?php
                                        }else{
                                    ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div  class="alert custom-alert-1 mb-4 bg-danger border-danger" role="alert">

                                                <div class="media">
                                                    <div class="alert-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="alert-text">
                                                            <strong>Warning! </strong><span> You can not Make <span class="text-uppercase "><b>Transfer</b></span> contact support.</span>
                                                        </div>
                                                        <div class="alert-btn">
                                                            <a class="btn btn-default btn-dismiss" href="mailto:<?=$page['url_email'] ?>">Contact Us</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        }
                                    ?>
                                    <?php
                                        }else{
                                    ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div  class="alert custom-alert-1 mb-4 bg-danger border-danger" role="alert">

                                                <div class="media">
                                                    <div class="alert-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="alert-text">
                                                            <strong>Warning! </strong><span> You can not Make <span class="text-uppercase "><b>Transfer</b></span> contact support.</span>
                                                        </div>
                                                        <div class="alert-btn">
                                                            <a class="btn btn-default btn-dismiss" href="mailto:<?=$page['url_email'] ?>">Contact Us</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        }
                                    ?>
                                    
                                    <?php
                                        }else{
                                    ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div  class="alert custom-alert-1 mb-4 bg-danger border-danger" role="alert">

                                                <div class="media">
                                                    <div class="alert-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="alert-text">
                                                            <strong>Warning! </strong><span> Account on <span class="text-uppercase "><b>hold</b></span> contact support.</span>
                                                        </div>
                                                        <div class="alert-btn">
                                                            <a class="btn btn-default btn-dismiss" href="mailto:<?=$page['url_email'] ?>">Contact Us</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        }
                                    ?>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <?php
            include_once("layouts/footer.php");
            ?>
