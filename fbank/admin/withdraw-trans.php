<?php
include_once("./layout/header.php");
?> 


<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="page-header">
            <div class="page-title">
                <h3>All Withdrawal Transaction</h3>
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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Reference ID</th>
                                <th>Amount</th>
                                
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sql="SELECT * FROM withdrawal w LEFT JOIN users u ON w.user_id = u.id order by w.id DESC ";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $sn=1;
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                $wire_status = wireStatus($row['status']);
                                $currency = currency($row);

                                $fullName = $row['firstname']." ".$row['lastname'];
                                ?>
                                <tr>
                                    <td><?= $sn++ ?></td>
                                    <td><?= $fullName ?></td>
                                    <td><?=$row['acct_email'] ?></td>
                                    <td><?= $row['reference_id'] ?></td>
                                    <td><?=$currency.$row['amount'] ?></td>
                                    
                                   
                                    <td><?= $wire_status ?></td>
                                    <td><?= $row['createdAt'] ?></td>
                                    <td class="text-center"><a href="./viewwithdraw.php?id=<?php echo $row['reference_id']; ?>" class="btn btn-primary">View</a> </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                            
                        </table>
                    </div>
                </div>
            </div>

<?php
include_once("./layout/footer.php");
?>
