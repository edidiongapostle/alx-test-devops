<?php
$pageName = "Domestic Transaction";
// include_once("layouts/tranheader.php");
include_once("layouts/header.php");
$acct_id = userDetails('id');
// $crypto_name = cryptoName('crypto_name');




if (!$_SESSION['acct_no']) {
    header("location:../login.php");
    die;
}

?>
    <div id="content" class="main-content">
    <div class="layout-px-spacing">
    <div class="row layout-top-spacing" id="cancel-row">

    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <table id="default-ordering" class="table table-hover" style="width:100%">

                <thead>
                <tr>
                    <th>S/N</th>
                    <th>Amount</th>
                    <th>Transaction ID</th>
                    <th>Bank Name</th>
                    <th>Account Name</th>
                    <th>Account Number</th>
                    <th>Account Type</th>
                    <th>Account Name</th>
                    <th>Account Number</th>
                    <th>Transfer Type</th>
                    <th>Transfer Status</th>
                </tr>
                </thead>
                <tbody>


                <?php

                $sql2 ="SELECT * FROM domestic_transfer WHERE acct_id =:acct_id ORDER BY dom_id DESC";
                $wire = $conn->prepare($sql2);
                $wire->execute([
                    'acct_id'=>$acct_id
                ]);



                $sn=1;

                while ($result = $wire->fetch(PDO::FETCH_ASSOC)){
                    $transStatus = domestic($result);
                    ?>
                    <tr>
                        <td><?= $sn++ ?></td>

                        <td><?=$currency. $result['amount'] ?></td>
                        <td><?= $result['refrence_id'] ?></td>
                        <td><?= $result['bank_name'] ?></td>
                        <td><?= $result['acct_name'] ?></td>
                        <td><?= $result['acct_number'] ?></td>
                        <td><?= $result['trans_type'] ?></td>
                        <td><?= $result['acct_name'] ?></td>
                        <td><?= $result['acct_number'] ?></td>
                        <td><?= $result['trans_type'] ?></td>
                        <td><?= $transStatus ?></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <th>S/N</th>
                    <th>Amount</th>
                    <th>Transaction ID</th>
                    <th>Bank Name</th>
                    <th>Account Name</th>
                    <th>Account Number</th>
                    <th>Account Type</th>
                    <th>Account Name</th>
                    <th>Account Number</th>
                    <th>Transfer Type</th>
                    <th>Transfer Status</th>
                </tr>
                </tfoot>
            </table>
            
            <div class="d-print-none">
                                    <div class="float-end">
                                        <a href="javascript:window.print()"
                                            class="btn btn-success waves-effect waves-light me-1"><i
                                                class="fa fa-print"></i> Print Statement</a>
                                    </div>
                                </div>
                                
                                
        </div>
    </div>


<?php
include_once("layouts/footer.php");
?>