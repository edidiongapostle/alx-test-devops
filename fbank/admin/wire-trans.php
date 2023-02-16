<?php
include_once("./layout/header.php");
?>


<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="page-header">
            <div class="page-title">
                <h3>Wire Transaction</h3>
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
                                <th>Sender Name</th>
                                <th>Amount</th>
                                <th>Bank Name</th>
                                <th>Account Name</th>
                                <th>Account Number</th>
                                <th>Country</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sql="SELECT * FROM wire_transfer LEFT JOIN users ON wire_transfer.acct_id = users.id order by wire_transfer.wire_id DESC ";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $sn=1;
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                $wire_status = wireStatus($row);
                                $currency = currency($row);
                                if($row['trans_type'] === '1'){
                                    $trans_type = '<span class="text-success">Credit</span>';
                                }else if($row['trans_type']=== '2'){
                                    $trans_type = '<span class="text-danger">Debit</span>';
                                }
                                $_SESSION['wire_id'] = $row['id'];

                                $fullName = $row['firstname']." ".$row['lastname'];
                                ?>
                                <tr>
                                    <td><?= $sn++ ?></td>
                                    <td><?= $fullName ?></td>
                                    <td><?=$currency.$row['amount'] ?></td>
                                    <td><?= $row['bank_name'] ?></td>
                                    <td><?= $row['acct_name'] ?></td>
                                    <td><?= $row['acct_number'] ?></td>
                                    <td><?= $row['acct_country'] ?></td>
                                    <td><?= $wire_status ?></td>
                                    <td><?= $row['created_at'] ?></td>
                                    <td class="text-center"><a href="./viewwire-trans.php?id=<?php echo $row['refrence_id']; ?>" class="btn btn-primary">View</a> </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>S/N</th>
                                <th>Account Name</th>
                                <th>Amount</th>
                                <th>Bank Name</th>
                                <th>Account Name</th>
                                <th>Account Number</th>
                                <th>Country</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="invisible"></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>





<?php
include_once("./layout/footer.php");
?>
