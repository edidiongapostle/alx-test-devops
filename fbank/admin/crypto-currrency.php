<?php
include_once("./layout/header.php");
require './include/adminloginFunction.php';

if(isset($_POST['delete_crypto_currency'])){
   

    $crypto_id = $_POST['crypto_id'];
    
    $del = $conn->prepare("DELETE FROM crypto_currency WHERE id =:id");
    $del->execute(['id'=>$crypto_id]);

    header("location:./crypto-currrency.php");
   
}


if(isset($_POST['crypto_save'])){
    $crypto_name = $_POST['crypto_name'];
    $wallet_address = $_POST['wallet_address'];

    $sql = "INSERT INTO crypto_currency (crypto_name,wallet_address)VALUES(:crypto_name,:wallet_address)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
       'crypto_name'=>$crypto_name,
        'wallet_address'=>$wallet_address
    ]);

    if(true){
        toast_alert('success','Wallet Add Successfully','Success');
    }else{
        toast_alert('error','Something Went Wrong');
    }

}

if(isset($_POST['crypto_edit'])){

    $crypto_name = $_POST['crypto_name'];
    $wallet_address = $_POST['wallet_address'];
    $crypto_id = $_POST['crypto_id'];

    $sql = "UPDATE crypto_currency set crypto_name=:crypto_name,wallet_address=:wallet_address WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
       'crypto_name'=>$crypto_name,
        'wallet_address'=>$wallet_address,
        'id'=>$crypto_id
    ]);

    if(true){
        toast_alert('success','Crypto Saved Successfully','Saved');
    }else{
        toast_alert('error','Sorry something went wrong');
    }
}

?>

<a href="" data-target="#editModal" data-toggle="modal" class="show-modal"></a>

<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="row">
            <div class="col-md-6">
                <div class="page-header">
                    <div class="page-title">
                        <h3>Crypto Payment</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-3">
                <button type="button" class="btn btn-primary mb-2 mr-2" data-toggle="modal" data-target="#exampleModal" style="float:right">
                    Add Crypto
                </button>
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
                                <th>Crypto Name</th>
                                <th>Wallet Address</th>
                                <th>Date</th>
                                <th class="text-center dt-no-sorting">Action</th>
                                <th hidden></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sql = "SELECT * FROM crypto_currency ORDER BY crypto_name ";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $sn=1;
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                $id = $row['id'];
                                ?>

                                <tr>
                                    <td><?= $sn++ ?></td>
                                    <td><?= $row['crypto_name'] ?></td>
                                    <td><?= $row['wallet_address'] ?></td>
                                    <td><?= $row['created_at'] ?></td>
                                    <td class="text-center"><a  class="btn btn-primary edit-crypto" data-name="<?= $row['crypto_name'] ?>" data-wallet-address="<?= $row['wallet_address'] ?>"  data-id="<?= $row['id']?>">Edit</a> </td>
                                    <td>
                                        <form action="./crypto-currrency.php" method="post" >
                                            <input type="text" hidden name="crypto_id" value="<?=$row['id']?>">
                                            <button class="btn btn-danger "  data-id="<?= $row['id'] ?>" name="delete_crypto_currency" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle text-white"  onclick="return confirm('Are you sure to delete?')"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></button>
                                        </form></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>S/N</th>
                                <th>Crypto Name</th>
                                <th>Wallet Address</th>
                                <th>Date</th>
                                <th class="text-center dt-no-sorting">Action</th>
                                <th hidden></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
    <!--ADD CRYPTO MODAL-->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Crypto</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>                            </button>
                        </div>
                        <form action="" method="post">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-11 mx-auto">
                                        <div class="form-group">
                                            <label>Crypto Name</label>
                                            <input type="text" class="form-control mb-4" name="crypto_name"  placeholder="Crypto Name" value="" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Wallet Address</label>
                                            <input type="text" class="form-control mb-4" name="wallet_address" placeholder="Wallet Address" value="" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                                <button name="crypto_save" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
<!--            END OF ADD CRYPTO MODAL-->

<!--            EDIT CRYPTO MODAL-->
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                

                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Crypto Currency</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>                            </button>
                        </div>
                        <form action="" method="post">
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-md-11 mx-auto">
                                        <div class="form-group">
                                            <label>Crypto Name</label>
                                            <input type="text" class="form-control mb-4" name="crypto_name" id="crypto_name" placeholder="Crypto Name" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Wallet Address</label>
                                            <input type="text" class="form-control mb-4" name="wallet_address" placeholder="Wallet Address" id="wallet_address" value="" required>
                                        </div>
                                        <input type="hidden" name="crypto_id" id="crypto_id">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                                <button name="crypto_edit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
<!--            END EDIT CRYPTO MODAL-->
<?php
include_once("./layout/footer.php");
?>
