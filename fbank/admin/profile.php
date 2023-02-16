<?php
include_once("./layout/header.php");
//require_once("./include/adminloginFunction.php");
//include_once("../include/config.php");


$fullName = $row['firstname']." ".$row['lastname'];

if(isset($_POST['upload_picture'])){
    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];
        $name = $file['name'];

        $path = pathinfo($name, PATHINFO_EXTENSION);

        $allowed = array('jpg', 'png', 'jpeg');


        $folder = "../assets/profile/";
        $n = $row['firstname'].$name;

        $destination = $folder . $n;
    }
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        $sql = "UPDATE admin SET image=:image WHERE id ='1'";
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'image'=>$n,
        ]);

        if(true){
            toast_alert("success","Your Image Uploaded Successfully", "Thanks!");
        }else{
            echo "invalid";
        }


    }
}

if(isset($_POST['profile'])){
    $admin_email = $_POST['email'];
    $acct_name = $_POST['firstname'];
    $admin_id = 1;
    $sql = "UPDATE admin SET admin_email=:admin_email,firstname=:firstname WHERE id=:admin_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'admin_email'=>$admin_email,
        'firstname'=>$acct_name,
        'admin_id'=>$admin_id
    ]);

    if(true){
        toast_alert('success','Account updated successfully','Approved');
    }else{
        toast_alert('error','Sorry something went wrong');
    }

}

if(isset($_POST['change_password'])) {
    $old_password = inputValidation($_POST['old_password']);
    $new_password = inputValidation($_POST['new_password']);
    $confirm_password = inputValidation($_POST['confirm_password']);

    $new_password2 = password_hash((string)$new_password, PASSWORD_BCRYPT);
    $verification = password_verify($old_password, $row['admin_password']);

    if ($verification === false) {
        toast_alert("error", "Incorrect Old Password");

    } else if ($new_password !== $confirm_password) {
        toast_alert("error", "Confirm Password not matched");

    } else if($new_password === $old_password){
        toast_alert('error', 'New Password Matched with Old Password');
    }else {
        $sql2 = "UPDATE admin SET admin_password=:admin_password WHERE id ='1'";
        $passwordUpdate = $conn->prepare($sql2);
        $passwordUpdate->execute([
            'admin_password' =>$new_password2,
        ]);
        if (true) {
            toast_alert('success', 'Your Password Change Successfully !', 'Approved');
        } else {
            toast_alert('error', 'Sorry Something Went Wrong');
        }
    }
}

?>
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="account-settings-container layout-top-spacing">

            <div class="account-content">
                <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="general-info" class="section general-info" enctype="multipart/form-data" method="POST">

                                <div class="info">
                                    <h6 class="">General Information</h6>
                                    <div class="row">
                                        <div class="col-lg-11 mx-auto">
                                            <div class="row">
                                                <div class="col-xl-2 col-lg-12 col-md-4 text-center">
                                                    <div class="upload mt-4 pr-md-4">
                                                        <center>
                                                            <input type="file" id="input-file-max-fs" class="dropify" data-default-file="../assets/profile/<?= $row['image']?>" name="image" data-max-file-size="2M" />
                                                        </center>
                                                        <p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i> Upload Picture</p>
                                                        <div class="form-group text-center" >
                                                            <button class="btn btn-primary " name="upload_picture">Save</button>
                                                        </div>
                                                    </div>
                                                
                                                </div>
                                            </form>
                            <form method="POST">
                                                <div class="col-xl-12 col-lg-12 col-md-8 mt-md-0 mt-4">
                                                    <div class="form">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="fullName">Full Name</label>
                                                                    <input type="text" class="form-control mb-4"  placeholder="Full Name" value="<?= $fullName?>" name="acct_name" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="">Email</label>
                                                                    <input type="email" class="form-control mb-4" value="<?= $row['admin_email'] ?>" name="email">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <button class="btn btn-primary text-center" name="profile">Save</button>
                                                        </div>







                                                    </div>
                                                </div>
                            </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>


                        <div class="col-xl-6 col-lg-6 col-md-6 offset-md-3  layout-spacing">
                            <form class="section about" method="post">
                                <div class="info">
                                    <h5 class="">Change Password</h5>
                                    <div class="row">
                                        <div class="col-md-11 mx-auto">
                                            <div class="form-group">
                                                <label>Old Password</label>
                                                <input type="password" class="form-control mb-4" name="old_password" placeholder="Old Password" value="">
                                            </div>
                                            <div class="form-group">
                                                <label>New Password</label>
                                                <input type="password" class="form-control mb-4" name="new_password" placeholder="New Password" value="">
                                            </div>

                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <input type="password" class="form-control mb-4" name="confirm_password" placeholder="Confirm Password">
                                            </div>

                                            <div class="form-group">
                                                <button class="btn btn-primary" name="change_password" > Change Password</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>


                    </div>
                </div>
            </div>
<?php
include_once("./layout/footer.php");
?>
