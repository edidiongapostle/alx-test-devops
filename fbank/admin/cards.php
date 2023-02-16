<?php
include_once("./layout/header.php");
?>


<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="page-header">
            <div class="page-title">
                <h3>Requested Cards</h3>
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
                                <th>Card Name</th>
                                <th>Card No</th>
                                <th>Expiration</th>
                                <th>CVC</th>
                                <th>Card Type</th>
                                <th>Created At</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sql="SELECT * FROM card order by id DESC";
                            $stmt = $conn->query($sql);
                            $sn=1;
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                $currency = currency($row);
                                $cardStatus = getCardStatus($row);
                                $card_type = getCardType($row);


                                ?>
                                <tr>
                                    <td><?= $sn++ ?></td>
                                    <td><?= $row['card_name'] ?></td>
                                    <td><?=$row['card_number'] ?></td>
                                    <td><?= $row['card_expiration'] ?></td>
                                    <td><?= $row['card_security'] ?></td>
                                    <td><?= $card_type ?></td>
                                    <td><?= $row['createdAt'] ?></td>
                                    <td><?= $cardStatus ?></td>
                                    <td class="text-center"><a href="./viewcard.php?id=<?php echo $row['seria_key']; ?>" class="btn btn-primary">View</a> </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>S/N</th>
                                <th>Card Name</th>
                                <th>Card No</th>
                                <th>Expiration</th>
                                <th>CVC</th>
                                <th>Card Type</th>
                                <th>Created At</th>
                                <th>Status</th>
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
