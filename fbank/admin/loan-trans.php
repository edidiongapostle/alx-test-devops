<?php
include_once("./layout/header.php");

?>


<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="page-header">
            <div class="page-title">
                <h3>Loan Request</h3>
            </div>
        </div>

        <div class="row layout-top-spacing" id="cancel-row">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4">
                        <table id="default-ordering" class="table table-hover" style="width:100%">
                            <thead>
                            <tr>
                                <th>S/N</th>

                                <th>Amount</th>
                                <th>Loan Remarks</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th class="text-center dt-no-sorting">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sql = "SELECT * FROM loan LEFT JOIN users ON loan.acct_id = users.id order by loan.loan_id DESC ";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $sn=1;
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                $dom_status = domesticTransaction($row);

                                $currency = currency($row);

                                if($row['loan_status'] === '0'){
                                    $tran_status = '<span class="text-success">Processing</span>';
                                }else if($row['loan_status'] === '1'){
                                    $tran_status = '<span class="text-success">Approved</span>';
                                }else if($row['loan_status']=== '3'){
                                    $tran_status = '<span class="text-danger">Declined</span>';
                                }else if($row['loan_status']=== '2') {
                                    $tran_status = '<span class="text-danger">On Hold</span>';
                                }

                                $_SESSION['loan_id'] = $row['acct_id'];

                                $fullName = $row['firstname']." ".$row['lastname'];
                                ?>
                                <tr>
                                    <td><?= $sn++ ?></td>

                                    <td><?=$currency.$row['amount'] ?></td>
                                    <td><?= $row['loan_remarks'] ?></td>
                                    <td><?= $tran_status ?></td>
                                    <td><?= $row['created_at'] ?></td>
                                    <td class="text-center"><a href="./viewloan-trans.php?id=<?php echo $row['loan_reference_id']; ?>" class="btn btn-primary">View</a> </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>S/N</th>

                                <th>Amount</th>
                                <th>Loan Remarks</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th class="text-center dt-no-sorting">Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>





            <?php
            include_once("./layout/footer.php");
            ?>
