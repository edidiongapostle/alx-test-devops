<?php
include_once("./layout/header.php");
//require_once("./include/adminloginFunction.php");
//include_once("../include/config.php");

if(isset($_POST['upload_picture'])){
    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];
        $name = $file['name'];

        $path = pathinfo($name, PATHINFO_EXTENSION);

        $allowed = array('jpg', 'png', 'jpeg','svg');


        $folder = "../assets/settings/";
        $n =$name;

        $destination = $folder . $n;
    }
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        $sql = "UPDATE settings SET image=:image WHERE id ='1'";
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'image'=>$n,
        ]);

        if(true){
            toast_alert("success","Your Image Uploaded Successfully", "Thanks!");
        }else{
            echo "invalid";
        }
        
        header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
die;


    }
}

if(isset($_POST['save_settings'])){
    $url_name = $_POST['url_name'];
    $about_us = $_POST['about_us'];
    $url_tel = $_POST['url_tel'];
    $url_email = $_POST['url_email'];
    $livechat = $_POST['livechat'];
    $trans_limit_max = $_POST['trans_limit_max'];
    $trans_limit_min = $_POST['trans_limit_min'];
    $twillio_status = $_POST['twillio_status'];
    $transfer = $_POST['transfer'];
    $billing_code = $_POST['billing_code'];
    $id="1";
    $sql = "UPDATE settings SET url_name=:url_name,url_tel=:url_tel,about_us=:about_us,url_email=:url_email,livechat=:livechat,trans_limit_min=:trans_limit_min,trans_limit_max=:trans_limit_max, twillio_status=:twillio_status,transfer:transfer,billing_code:billing_code WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'url_name'=>$url_name,
        'url_tel'=>$url_tel,
        'about_us'=>$about_us,
        'url_email'=>$url_email,
        'livechat'=>livechat,
        'trans_limit_min'=>$trans_limit_min,
        'trans_limit_max'=>$trans_limit_max,
        'twillio_status'=>$twillio_status,
        'transfer' => $transfer,
        'billing_code' => $billing_code,
        'id'=>$id
    ]);

    if(true){
        toast_alert('success','Website updated successfully','Approved');
    }else{
        toast_alert('error','Sorry something went wrong');
    }
    
    header('Location:'.$_SERVER['PHP_SELF'].'#'.$_SERVER['QUERY_STRING']);
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
                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing"> 
                            <form id="general-info" class="section general-info" enctype="multipart/form-data" method="POST"> 

                                <div class="info"> 
                                    <h6 class="">Upload Logo</h6> 
                                    <div class="row"> 
                                        <div class="col-lg-11 mx-auto"> 
                                            <div class="row"> 
                                                <div class="col-xl-12  text-center"> 
                                                    <div class="upload mt-4 pr-md-4"> 
                                                        <center> 
                                                            <input type="file" id="input-file-max-fs" class="dropify" data-default-file="../assets/settings/<?= $page['image']?>" name="image" data-max-file-size="2M" /> 
                                                        </center> 
                                                        <p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i> Upload Logo</p> 
                                                        <div class="form-group text-center" > 
                                                            <button class="btn btn-primary " name="upload_picture">Save</button> 
                                                        </div> 
                                                    </div> 
                                                </div> 
                            </form> 
                       </div>
                   

        <div class="col-xl-6 col-lg-6 col-md-6 offset-md-3  layout-spacing">
            <form method="POST">
                <div class="col-xl-12 col-lg-12 col-md-8 mt-md-0 mt-4">
                    <div class="form">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="fullName">BANK NAME</label>
                                    <input type="text" class="form-control mb-4"  placeholder="BANK NAME" value="<?=$page['url_name']?>" name="url_name" >
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">ABOUT US</label>
                                    <textarea class="form-control mb-4" rows="3" id="textarea-copy" placeholder="About Bank" value="" name="about_us" style="resize: none" required><?=$page['about_us']?></textarea>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">BANK TEL</label>
                                    <input type="number" class="form-control mb-4" value="<?=$page['url_tel']?>" name="url_tel">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">BANK EMAIL</label>
                                    <input type="email" class="form-control mb-4" value="<?=$page['url_email']?>" name="url_email">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">MIN - DEPOSIT LIMIT</label>
                                    <input type="number" class="form-control mb-4" value="<?=$page['trans_limit_min']?>" name="trans_limit_min">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">MAX - DEPOSIT LIMIT</label>
                                    <input type="number" class="form-control mb-4" value="<?=$page['trans_limit_max']?>" name="trans_limit_max">
                                </div>
                            </div>
                            
                              <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">Twillio <span class="text-danger">1 = ACTIVE, 0 = INACTIVE</span></label>
                                    <input type="number" class="form-control mb-4" value="<?=$page['twillio_status']?>" name="twillio_status">
                                </div>
                            </div>
                            
                            
                              <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">Transfer <span class="text-danger">1 = ACTIVE, 0 = INACTIVE</span></label>
                                    <input type="number" class="form-control mb-4" value="<?=$page['transfer']?>" name="transfer">
                                </div>
                            </div>
                            
                              <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">Billing <span class="text-danger">1 = ACTIVE, 0 = INACTIVE</span></label>
                                    <input type="number" class="form-control mb-4" value="<?=$page['billing_code']?>" name="billing_code">
                                </div>
                            </div>
                            
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">TAWK TO LIVECHAT URL</label>
                                    <input type="text" class="form-control mb-4" value="<?=$page['livechat']?>" name="livechat">
                                </div>
                            </div>

                        </div>

                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary text-center" name="save_settings" >Save</button>
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
