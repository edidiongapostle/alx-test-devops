<?php
include_once("./layout/header.php");
//require_once("./include/adminloginFunction.php");
//include_once("../include/config.php");


// virtual deposit
$sql7 = "SELECT * FROM virtual";
$stmt = $conn->prepare($sql7);
$stmt->execute();

$deposit = $stmt->fetch(PDO::FETCH_ASSOC);

$routine_no = $deposit['routine_no'];
$bank_name = $deposit['bank_name'];
$swift_code = $deposit['swift_code'];
$acct_no = $deposit['acct_no'];


if(isset($_POST['save_deposit'])){
    $acct_no = $_POST['acct_no'];
    $bank_name = $_POST['bank_name'];
    $routine_no = $_POST['routine_no'];
    $swift_code = $_POST['swift_code'];
    $id="1";
    $sql = "UPDATE virtual SET acct_no=:acct_no,bank_name=:bank_name,routine_no=:routine_no,swift_code=:swift_code WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'acct_no'=>$acct_no,
        'bank_name'=>$bank_name,
        'routine_no'=>$routine_no,
        'swift_code'=>$swift_code,
        'id'=>$id
    ]);

    if(true){
        toast_alert('success','Virtual updated successfully','Approved');
    }else{
        toast_alert('error','Sorry something went wrong');
    }
    
    header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
die;

}

?>
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="account-settings-container layout-top-spacing">

            <div class="account-content">
                <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                    <div class="row">
                        
        <div class="col-xl-6 col-lg-6 col-md-6 offset-md-3  layout-spacing">
            <form method="POST">
                <div class="col-xl-12 col-lg-12 col-md-8 mt-md-0 mt-4">
                    <div class="form">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">Bank Name</label>
                                    <input type="text" class="form-control mb-4" value="<?= $deposit['bank_name'] ?>" name="bank_name">
                                </div>
                            </div>
                           

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">Routine Number</label>
                                    <input type="text" class="form-control mb-4" value="<?= $deposit['routine_no'] ?>" name="routine_no">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">Account No</label>
                                    <input type="text" class="form-control mb-4" value="<?= $deposit['acct_no'] ?>" name="acct_no">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">Swift Code</label>
                                    <input type="text" class="form-control mb-4" value="<?= $deposit['swift_code'] ?>" name="swift_code">
                                </div>
                            </div>
                           
                        </div>

                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary text-center" name="save_deposit" >Save</button>
                        </div>







                    </div>
                </div>
            </form>

        </div>
        
         </div>
                </div>
            </div>



    </div>
</div>
</div>
<?php
include_once("./layout/footer.php");
?>
