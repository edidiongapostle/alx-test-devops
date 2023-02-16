<?php
include_once("./layout/header.php");

?>


<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="page-header">
            <div class="page-title">
                <h3>Crypto Transaction</h3>
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
                                <th>Trans ID</th>
                                <th>Name</th>
                                <th>Wallet Address</th>
                                <th>Crypto Name</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="text-center dt-no-sorting">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sql = "SELECT d.*,u.*, c.crypto_name FROM deposit d INNER JOIN crypto_currency c ON d.crypto_id = c.id LEFT JOIN users u ON d.user_id = u.id ORDER BY d.d_id DESC ";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $sn=1;
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                $crypto_status = cryptoTransaction($row);

//                                $_SESSION['users_id'] = $row['user_id'];
                                $fullName = $row['firstname']." ".$row['lastname'];
                                $currency = currency($row);

                                ?>

                                <tr>
                                    <td><?= $sn++ ?></td>
                                    <td><?=$currency.$row['amount'] ?></td>
                                    <td><?= $row['refrence_id']?></td>
                                    <td><?=$fullName?></td>
                                    <td><?= $row['wallet_address'] ?></td>
                                    <td><?= $row['crypto_name'] ?></td>
                                    <td><?= $crypto_status ?></td>
                                    <td><?= $row['created_at'] ?></td>
                                    <td class="text-center"><a href="./viewcrypto-trans.php?id=<?php echo $row['refrence_id']; ?>" class="btn btn-primary">View</a> </td>
                                </tr>

                                <?php
                            }
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>S/N</th>

                                <th>Amount</th>
                                <th>Trans ID</th>
                                <th>Name</th>
                                <th>Wallet Address</th>
                                <th>Crypto Name</th>
                                <th>Status</th>
                                <th>Date</th>
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
