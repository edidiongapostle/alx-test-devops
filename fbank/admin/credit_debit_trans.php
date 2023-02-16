<?php
include_once("./layout/header.php");
?>


<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="page-header">
            <div class="page-title">
                <h3>All Credit / Debit </h3>
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
                                <th>NAME</th>
                                <th>AMOUNT</th>
                                <th>TRANS TYPE</th>
                                <th>SENDER NAME</th>
                                <!--<th>DESCRIPTION</th>-->
                                <th>DATE</th>
                                <th>TIME</th>
                                <th>Edit</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sql="SELECT * FROM transactions LEFT JOIN users ON transactions.user_id = users.id order by transactions.trans_id DESC";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $sn=1;
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                if($row['trans_type'] === '1'){
                                    $trans_type = '<span class="text-success">Credit</span>';
                                }else if($row['trans_type']=== '2'){
                                    $trans_type = '<span class="text-danger">Debit</span>';
                                }
                                $currency = currency($row);
//                                session_start();
//                                $_SESSION['users_id'] = $row['user_id'];
                                $fullName = $row['firstname']." ".$row['lastname'];
                                ?>
                                <tr>
                                    <td><?= $sn++ ?></td>
                                    <td><?= $fullName ?></td>
                                    <td><?=$currency.$row['amount'] ?></td>
                                    <td><?= $trans_type ?></td>
                                    <td><?= $row['sender_name'] ?></td>
                                    <!--<td><?= $row['description'] ?></td>-->
                                    <td><?= $row['created_at'] ?></td>
                                    <td><?= $row['time_created'] ?></td>
                                    <!--<td class="text-center"><a href="./view-trans.php?id=<?php echo $row['refrence_id']; ?>" class="btn btn-primary">View</a> </td>-->
                                     <td class="text-center"><a href="./edit-trans.php?id=<?php echo $row['trans_id']; ?>" target="_blank" class="btn btn-primary">Edit</a> </td>
                                    <td class="text-center"><a href="./view-trans.php?id=<?php echo $row['trans_id']; ?>" target="_blank" class="btn btn-primary">View</a> </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>S/N</th>
                                <th>NAME</th>
                                <th>AMOUNT</th>
                                <th>TRANS TYPE</th>
                                <th>SENDER NAME</th>
                                <th>DESCRIPTION</th>
                                <th>CREATED AT</th>
                                <th>TIME CREATED</th>
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
