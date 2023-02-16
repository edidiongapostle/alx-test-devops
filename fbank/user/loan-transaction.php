<?php
$pageName = "Loan Transaction";
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
                    <th>Reason</th>
                    <th>Loan Status</th>
                    <th class="text-center dt-no-sorting">Action</th>
                </tr>
                </thead>
                <tbody>


                <?php

                $sql2 ="SELECT * FROM loan WHERE acct_id =:acct_id ORDER BY loan_id DESC";
                $wire = $conn->prepare($sql2);
                $wire->execute([
                    'acct_id'=>$acct_id
                ]);



                $sn=1;

                while ($result = $wire->fetch(PDO::FETCH_ASSOC)){
                    $transStatus = loanModalStatus($result);
                    ?>
                    <tr>
                        <td><?= $sn++ ?></td>

                        <td><?=$currency. $result['amount'] ?></td>
                        <td><?= $result['loan_remarks'] ?></td>
                        <td><?= $transStatus ?></td>
                        <td class="text-center"><a href="./viewloantrans.php?id=<?php echo $result['loan_reference_id']; ?>" class="btn btn-primary btn-sm">View</a> </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <th>S/N</th>
                    <th>Amount</th>
                    <th>Reason</th>
                    <th>Loan Status</th>
                    <th class="invisible"></th>
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