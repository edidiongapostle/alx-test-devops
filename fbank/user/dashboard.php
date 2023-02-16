<?php
$pageName = "Dashboard";
include_once("layouts/header.php");
//include_once("../include/userFunction.php");
if(!$_SESSION['acct_no']) {
    header("location:../login.php");
    die;
}
if(@!$_COOKIE['firstVisit']){
    setcookie("firstVisit", "no", time() + 3600);
    notify_alert('Welcome Back '.$fullName." !",'success','3000','Close');
}

unset($_SESSION['wire_transfer'], $_SESSION['dom_transfer']);

?>

<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">

            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-4 layout-spacing layout-visible">
                <div class="widget widget-three">
                    <div class="widget-heading">
                        <h5 class="">Summary</h5>


                        <div class="task-action">
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="index.html#" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask" style="will-change: transform;">
                                    <a class="dropdown-item" href="javascript:void(0);">View Report</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Edit Report</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Mark as Done</a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="widget-content">

                        <div class="order-summary">

                            <div class="summary-list">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                </div>
                                <div class="w-summary-details">

                                    <div class="w-summary-info">
                                        <h6>Limit</h6>
                                        <p class="summary-count"><?=$currency.$row['acct_limit'] ?></p>
                                    </div>

                                    <div class="w-summary-stats">
                                        <div class="progress">
                                            <div class="progress-bar bg-gradient-secondary" role="progressbar" style="width: 100%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="summary-list">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tag"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7" y2="7"></line></svg>
                                </div>
                                <div class="w-summary-details">

                                    <div class="w-summary-info">
                                        <h6>Loan Balance</h6>
                                        <p class="summary-count"><?= $currency.$row['loan_balance']?></p>
                                    </div>

                                    <div class="w-summary-stats">
                                        <div class="progress">
                                            <div class="progress-bar bg-gradient-success" role="progressbar" style="width: 100%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="summary-list">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                                </div>
                                <div class="w-summary-details">

                                    <div class="w-summary-info">
                                        <h6>Expenses</h6>
                                        <p class="summary-count"><?=$currency."".$limitRemain ?></p>
                                    </div>

                                    <div class="w-summary-stats">
                                        <div class="progress">
                                            <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-4 layout-spacing layout-visible">
                <div class="widget-two">
                    <div class="widget-content">
                        <div class="w-numeric-value">
                            <div class="w-content">
                                <span class="w-value">Daily Stats</span>
                                <span class="w-numeric-title"><a class="text-primary" href="./credit-debit_transaction.php">Go to Transaction for details.</a></span>
                            </div>
                            <div class="w-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                            </div>
                        </div>
                        <div class="w-chart">
                            <div id="daily-sales"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12 layout-spacing">

                <div class="widget widget-account-invoice-three">

                    <div class="widget-heading">
                        <div class="wallet-usr-info">
                            <div class="usr-name">
                                <span><img src="../assets/profile/<?= $row['image']?>" alt="admin-profile" class="img-fluid"> <?php echo $fullName ?></span>
                            </div>
                            <div class="add">
                                <span><a  data-toggle="modal" data-target="#exampleModal"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus text-white"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></a></span>
                            </div>
                        </div>
                        <div class="wallet-balance">
                            <p>Balance</p>
                            <h5 class=""><span class="w-currency"><?php echo $currency?></span><?php echo number_format($acct_balance, 2, '.', ','); ?></h5>
                        </div>
                        <?php
                        if($row['loan_balance'] > 0){

                            ?>
                            <div class="wallet-balance">
                                <p class="">Loan Amount</p>
                                <h5 class="text-danger"><span class="w-currency text-danger"><?php echo $currency?></span><?php echo $row['loan_balance'] ?></h5>
                            </div>
                            <?php
                        }
                        ?>
                    </div>

                    <div class="widget-amount">

                        <div class="w-a-info funds-received">
                            <span>Deposit <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></span>


                            <p>
                                <!--<a  class="btn btn-success btn-sm col-12" data-toggle="modal" data-target="#exampleModal">Deposit</a>-->
                               
                                 
                                 <a href="./deposit.php"  class="btn btn-success btn-sm col-12">Deposit </a>
                                 
                            </p>
                        </div>

                        <div class="w-a-info funds-spent">
                            <span>Transfer <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg></span>
                            <p>
                                <a href="./wire-transfer.php"  class="btn btn-primary btn-sm col-12">Transfer </a>

                            </p>
                        </div>
                    </div>

                    <div class="widget-content">

                        <div class="bills-stats; text-center">
                            <?php
                            echo $userStatus
                            ?>
                        </div>

                        <div class="invoice-list">

                            <div class="inv-detail">
                                <div class="info-detail-1">
                                    <p>Limit</p>
                                    <p><span class="w-currency"><?= $currency ?></span> <span class="bill-amount"><?= $row['acct_limit'] ?></span></p>
                                </div>
                                <div class="info-detail-2">
                                    <p>Transfer Limit Remain</p>
                                    <p class=""><span class="w-currency text-danger"><?= $currency ?></span> <span class="bill-amount text-danger"><?= $limitRemain ?> </span></p>
                                </div>
                                
                                
                                 <?php
                                $acct_id = userDetails('id');

                                $sql2="SELECT * FROM transactions LEFT JOIN users ON transactions.user_id =users.id WHERE transactions.user_id =:acct_id order by transactions.trans_id DESC LIMIT 1";
                                $stmt = $conn->prepare($sql2);
                                $stmt->execute([
                                    'acct_id'=>$acct_id
                                ]);
                                $sn=1;
                                while ($result = $stmt->fetch(PDO::FETCH_ASSOC)){
                                    $transStatus = transStatus($result);

                                    if($result['trans_type'] === '1'){
                                        $trans_type = "<span class='text-success'>Credit</span>";
                                    }else if($result['trans_type']=== '2'){
                                        $trans_type = "<span class='text-danger'>Debit</span>
";
                                    }

                                    $senderName = $result['sender_name'];
                                    $description = $result['description'];

                                    ?>
                              
                             
                                <div class="info-detail-3">
                                    <p>Last Transaction</p>
                                    <!--<p><span class="w-currency text-danger"></span> <span class="bill-amount text-danger"> <?= $currency.$result['amount']    ?></span></p>-->
                                    
                                     <p><span> <?= $currency.$result['amount']    ?></span></p>
                                </div>
                          
                              
                                 <?php
                        }
                        ?>
                        
                         <div class="info-detail-2">
                                    <p>Last Login IP:</p>
                                    <p class=""><span class="bill-amount text-danger"><?= $logs['ipAddress'] ?> </span></p>
                                </div>
                                
                                <div class="info-detail-2">
                                    <p>Last Login Date:</p>
                                    <p class=""><span class="bill-amount text-danger"><?= $logs['datenow'] ?> </span></p>
                                </div>
                          
                          
                            </div>

                            <div class="inv-action">
                                <a href="./credit-debit_transaction.php" class="btn btn-outline-primary view-details">View Transactions</a>
                                <a href="./wire-transfer.php" class="btn btn-outline-primary pay-now">Wire Transfer</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing ">
                <div class="widget widget-table-two">

                    <div class="widget-heading">
                        <h5 class="">Recent Transactions</h5>
                    </div>

                    <div class="widget-content">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th><div class="th-content">S/N</div></th>
                                    <!--                                    <th><div class="th-content">NAME</div></th>-->
                                    <th><div class="th-content">AMOUNT</div></th>
                                    <th><div class="th-content th-heading">TYPE</div></th>
                                    <th><div class="th-content">SENDER / RECEIVER</div></th>
                                    <th><div class="th-content">DESCRIPTION</div></th>
                                    <th><div class="th-content th-heading">CREATED AT</div></th>
                                    <th><div class="th-content th-heading">TIME CREATED</div></th>
                                    <th><div class="th-content">Status</div></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $acct_id = userDetails('id');

                                $sql2="SELECT * FROM transactions LEFT JOIN users ON transactions.user_id =users.id WHERE transactions.user_id =:acct_id order by transactions.trans_id DESC LIMIT 5";
                                $stmt = $conn->prepare($sql2);
                                $stmt->execute([
                                    'acct_id'=>$acct_id
                                ]);
                                $sn=1;
                                while ($result = $stmt->fetch(PDO::FETCH_ASSOC)){
                                    $transStatus = transStatus($result);

                                    if($result['trans_type'] === '1'){
                                        $trans_type = "<span class='text-success'>Credit</span>";
                                    }else if($result['trans_type']=== '2'){
                                        $trans_type = "<span class='text-danger'>Debit</span>
";
                                    }

                                    $senderName = $result['sender_name'];
                                    $description = $result['description'];

                                    ?>
                                    <tr>
                                        <td><?= $sn++ ?>
                                        </td>

                                        <td>
                                            <div class="td-content product-invoice"><?= $currency.$result['amount']    ?></div>
                                        </td>
                                        <td>
                                            <div class="td-content product-brand text-primary"><?= $trans_type ?></div>
                                        </td>
                                        <td>
                                            <div class="td-content product-invoice"><?= substr($senderName,0,15) ?></div>
                                        </td>
                                        <td>
                                            <div class="td-content product-brand "><?= substr($description,0,15) ?></div>
                                        </td>
                                        <td>
                                            <div class="td-content product-invoice"><?= $result['created_at'] ?></div>
                                        </td>

                                        <td>
                                            <div class="td-content pricing"><span class=""><?= $result['time_created'] ?></span></div>
                                        </td>
                                        <td>
                                            <div class="td-content"><span class=""><?= $transStatus ?></span></div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>




                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Banking Details</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    </button>
                                </div>
                                <div class="modal-body">
                                       <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-4 mt-4">
                                                    <label for="">Bank Name</label>
                                                    <div class="input-group ">
                                                        <input type="text" class="form-control" name="bank_name" id="bank_name" placeholder="<?= $deposit['bank_name'] ?>" value="<?= $deposit['bank_name'] ?>"
                                                               aria-label="notification" aria-describedby="basic-addon1"
                                                               readonly>
                                                        <a class="btn btn-primary sm-2" href="javascript:;" data-clipboard-action="copy" data-clipboard-target="#bank_name"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-copy"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg> Copy</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-4 mt-4">
                                                    <label for="">Account Number</label>
                                                    <div class="input-group ">
                                                        <input type="text" class="form-control" name="acct_no" id="acct_no" placeholder="<?= $deposit['acct_no'] ?>" value="<?= $deposit['acct_no'] ?>"
                                                               aria-label="notification" aria-describedby="basic-addon1"
                                                               readonly>
                                                        <a class="btn btn-primary sm-2" href="javascript:;" data-clipboard-action="copy" data-clipboard-target="#acct_no"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-copy"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg> Copy</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-4 mt-4">
                                                    <label for="">Routine Number</label>
                                                    <div class="input-group ">
                                                        <input type="text" class="form-control" name="routine_no" id="routine_no" placeholder="<?= $deposit['routine_no'] ?>" value="<?= $deposit['routine_no'] ?>"
                                                               aria-label="notification" aria-describedby="basic-addon1"
                                                               readonly>
                                                        <a class="btn btn-primary sm-2" href="javascript:;" data-clipboard-action="copy" data-clipboard-target="#routine_no"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-copy"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg> Copy</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-4 mt-4">
                                                    <label for="">Swift Code</label>
                                                    <div class="input-group ">
                                                        <input type="text" class="form-control" name="swift_code" id="swift_code" placeholder="<?= $deposit['swift_code'] ?>" value="<?= $deposit['swift_code'] ?>"
                                                               aria-label="notification" aria-describedby="basic-addon1"
                                                               readonly>
                                                        <a class="btn btn-primary sm-2" href="javascript:;" data-clipboard-action="copy" data-clipboard-target="#swift_code"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-copy"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg> Copy</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                      
                                        
                                </div>
                                <div class="modal-footer">
                                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <?php
                    include_once('layouts/footer.php')
                    ?>
