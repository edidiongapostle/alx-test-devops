<?php
include_once("./layout/header.php");

$id = $_GET['id'];

$sql2 = "SELECT * FROM card WHERE seria_key=:seria_key";
$stmt = $conn->prepare($sql2);
$stmt->execute([
    'seria_key'=>$id
]);

$cardCheck = $stmt->fetch(PDO::FETCH_ASSOC);

$card_number = explode(' ',$cardCheck['card_number']);

$card_type = getCardType($cardCheck);

if(isset($_POST['hold_card'])){
    $status = 3;
    $sql2 = "UPDATE card SET card_status=:card_status WHERE seria_key=:seria_key";
    $stmt = $conn->prepare($sql2);
    $stmt->execute([
        'card_status'=>$status,
        'seria_key'=>$id
    ]);
    if(true){
        toast_alert('success','Credit Card On Hold Successfully','success');
    }else{
//        notify_alert('Sorry Something Went Wrong','danger','2000','Close');
        toast_alert('error','Sorry Something Went Wrong');
    }
    
    header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
die;
}

if(isset($_POST['active_card'])){
    $status = 1;

    $sql2 = "UPDATE card SET card_status=:card_status WHERE seria_key=:seria_key";
    $stmt = $conn->prepare($sql2);
    $stmt->execute([
        'card_status'=>$status,
        'seria_key'=>$id
    ]);
    if(true){
        toast_alert('success','Credit Card Active Successfully','success');
    }else{
        toast_alert('error','Sorry Something Went Wrong');
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
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 offset-md-3 layout-spacing">

                            <div class="widget widget-account-invoice-three">

                                <div class="card-wrapper-box">
                                    <div class="card-wrapper">
                                        <ul class="card-wrapper__row-list">
                                            <li class="card-wrapper__row">
                                                <div class="card-wrapper__row-div">
                                                    <div class="card-wrapper__reward">
                                                        <h4><?=$pageTitle?></h4>
                                                        <h1>Debit Card</h1>
                                                    </div>
                                                </div>
                                                <div class="card-wrapper__row-div">
                                                    <div class="card-wrapper__logo">
                                                        <!--<span><img src="../assets/settings/<?=$page['image']?>" alt="" width="15%"></span>-->
                                                        <!--<h2 class="brand-name"><?=$pageTitle?></h2>-->
                                                    </div>
                                                    <span class="brand-title">We understand your world</span>
                                                </div>
                                            </li>
                                            <li class="card-wrapper__row row-2">
                                                <ul class="list-unstyled card-wrapper__item-list">
                                                    <li>
                                                        <div class="card-petrol__wrapper">
                                                            <div class="card-petrol__wrapper-box"></div>
                                                            <div class="card-petrol__wire"></div>
                                                        </div>
                                                        <div class="card-chip__wrapper">
                                                            <div class="card-chip__wrapper-box">
                                                                <div class="card-chip_wrapper-box-line-1"></div>
                                                                <div class="card-chip_wrapper-box-line-2"></div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="card-cart__wrapper">

                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="card-sb__wrapper">

                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="card-train__wrapper">

                                                    </li>
                                                    <li>

                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="card-wrapper__row row-3">
                                                <div class="card-wrapper__card-number">
                                                    <p class="card-num text-white"><span><?=$card_number[0]?></span><span><?=$card_number[1]?></span><span><?=$card_number[2]?></span><span><?=$card_number[3]?></span></p>
                                                    <span class="card-month text-white">month/year</span>
                                                    <p class="card-date text-white"><span class="valid-up-to text-white">valid up to</span> <span class="text-white"><?=$cardCheck['card_expiration']?></span></p>
                                                </div>
                                                <ul class="list-unstyled card-wrapper__item-list">
                                                    <li></li>
                                                    <li></li>
                                                    <li></li>
                                                    <li></li>
                                                    <li></li>
                                                </ul>
                                            </li>
                                            <li class="card-wrapper__row row-4">
                                                <div class="card-wrapper__visa">
                                                    <span class="visa-electronic">electronic use only</span>
                                                    <span class="visa-no text-uppercase"><?=$cardCheck['card_name']?></span>
                                                    <div class="visa-platinum text-white">
                                                        <h4 class="text-white"><?=$card_type?></h4>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>


                                <div class="widget-content">

                                    <div class="bills-stats; text-center">
                                        <?=$cardStatus?>
                                    </div>

                                    <div class="invoice-list">

                                        <div class="inv-detail">
                                            <div class="info-detail-1">
                                                <p>Card Limit</p>
                                                <p><span class="w-currency"><?= $currency ?></span> <span class="bill-amount"><?=$cardCheck['card_limit'] ?></span></p>
                                            </div>
                                            <div class="info-detail-2">
                                                <p>Card Limit Remain</p>
                                                <p class=""><span class="w-currency text-danger"><?= $currency ?></span> <span class="bill-amount text-danger"><?= $cardCheck['card_limit_remain'] ?> </span></p>
                                            </div>
                                        </div>

                                        <div class="inv-action">
                                            <form method="POST">
                                                <div class="row">
                                                    
                                                    
                                                    
                                                    <?php
                                                    if($cardCheck['card_status']==='1'){
                                                    ?>
                                                    <div class="col-md-12 mb-3">

                                                        <button class="btn btn-danger btn-sm col-12" name="hold_card">Deactivate Card</button>

                                                    </div>
                                                    <?php
                                                    }
                                                    ?>

                                                  <?php
                                                    if($cardCheck['card_status']==='2'){
                                                    ?>
                                                    <div class="col-md-12">
                                                        <button class="btn btn-success btn-sm col-12" name="active_card">Active Card</button>
                                                    </div>
                                                    <?php
                                                    }
                                                    ?>


                                                    <?php
                                                    if($cardCheck['card_status']==='3'){
                                                    ?>
                                                    <div class="col-md-12">
                                                        <button class="btn btn-success btn-sm col-12" name="active_card">Active Card</button>
                                                    </div>
                                                    <?php
                                                    }
                                                    ?>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
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
