<?php
include_once("./layout/header.php");
?>


<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="page-header">
            <div class="page-title">
                <h3>Domestic Transaction</h3>
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
                                <th>Bank Name</th>
                                <th>Account Name</th>
                                <th>Account Number</th>
                                <th>Account Type</th>
                                <th>Transfer Type</th>
                                <th>Transfer Status</th>
                                <th class="text-center dt-no-sorting">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sql = "SELECT * FROM domestic_transfer LEFT JOIN users ON domestic_transfer.acct_id = users.id order by domestic_transfer.dom_id DESC ";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $sn=1;
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                $dom_status = domesticTransaction($row);

                                $_SESSION['dom_id'] = $row['acct_id'];

                                $fullName = $row['firstname']." ".$row['lastname'];
                                $currency = currency($row);
                                ?>
                                <tr>
                                    <td><?= $sn++ ?></td>

                                    <td><?=$currency.$row['amount'] ?></td>
                                    <td><?= $row['bank_name'] ?></td>
                                    <td><?= $row['acct_name'] ?></td>
                                    <td><?= $row['acct_number'] ?></td>
                                    <td><?= $row['acct_type'] ?></td>
                                    <td><?= ucwords($row['trans_type']) ?></td>
                                    <td><?= $dom_status ?></td>
                                    <td class="text-center"><a href="./view-domtrans.php?id=<?php echo $row['refrence_id']; ?>" class="btn btn-primary">View</a> </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>S/N</th>

                                <th>Amount</th>
                                <th>Bank Name</th>
                                <th>Account Name</th>
                                <th>Account Number</th>
                                <th>Account Type</th>
                                <th>Transfer Type</th>
                                <th>Transfer Status</th>
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
