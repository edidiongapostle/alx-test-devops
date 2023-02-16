<?php
$pageName = "Virtual Card";
include_once("layouts/header.php");
require_once("../include/cardFunction.php");


if($acct_stat != 'active'){
    header("Location:./error.php");
    exit();
}
?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <?php
            $sql2 = "SELECT * FROM card WHERE user_id=:user_id";
            $stmt = $conn->prepare($sql2);
            $stmt->execute([
                'user_id'=>$user_id
            ]);

            $cardCheck = $stmt->fetch(PDO::FETCH_ASSOC);

            $card_number = explode(' ',$cardCheck['card_number']);

            $card_type = cardTypeName($card_number);

            $cardStatus = getCardStatus($cardCheck);

            if($stmt->rowCount() === 0){
            ?>

            <div class="payment-title bodyTag">

                <h1>Generate Credit Card</h1>
            </div>
            <div class="container preload">
                <div class="creditcard">
                    <div class="front">
                        <div id="ccsingle"></div>
                        <svg version="1.1" id="cardfront" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                             x="0px" y="0px" viewBox="0 0 750 471" style="enable-background:new 0 0 750 471;" xml:space="preserve">
                    <g id="Front">
                        <g id="CardBackground">
                            <g id="Page-1_1_">
                                <g id="amex_1_">
                                    <path id="Rectangle-1_1_" class="lightcolor grey" d="M40,0h670c22.1,0,40,17.9,40,40v391c0,22.1-17.9,40-40,40H40c-22.1,0-40-17.9-40-40V40
                            C0,17.9,17.9,0,40,0z" />
                                </g>
                            </g>
                            <path class="darkcolor greydark" d="M750,431V193.2c-217.6-57.5-556.4-13.5-750,24.9V431c0,22.1,17.9,40,40,40h670C732.1,471,750,453.1,750,431z" />
                        </g>
                        <text transform="matrix(1 0 0 1 60.106 295.0121)" id="svgnumber" class="st2 st3 st4">0123 4567 8910 1112</text>
                        <text transform="matrix(1 0 0 1 54.1064 428.1723)" id="svgname" class="st2 st5 st6"><?=$fullName?></text>
                        <text transform="matrix(1 0 0 1 54.1074 389.8793)" class="st7 st5 st8">cardholder name</text>
                        <text transform="matrix(1 0 0 1 479.7754 388.8793)" class="st7 st5 st8">expiration</text>
                        <text transform="matrix(1 0 0 1 65.1054 241.5)" class="st7 st5 st8">card number</text>
                        <g>
                            <text transform="matrix(1 0 0 1 574.4219 433.8095)" id="svgexpire" class="st2 st5 st9">01/23</text>
                            <text transform="matrix(1 0 0 1 479.3848 417.0097)" class="st2 st10 st11">VALID</text>
                            <text transform="matrix(1 0 0 1 479.3848 435.6762)" class="st2 st10 st11">THRU</text>
                            <polygon class="st2" points="554.5,421 540.4,414.2 540.4,427.9 		" />
                        </g>
                        <g id="cchip">
                            <g>
                                <path class="st2" d="M168.1,143.6H82.9c-10.2,0-18.5-8.3-18.5-18.5V74.9c0-10.2,8.3-18.5,18.5-18.5h85.3
                        c10.2,0,18.5,8.3,18.5,18.5v50.2C186.6,135.3,178.3,143.6,168.1,143.6z" />
                            </g>
                            <g>
                                <g>
                                    <rect x="82" y="70" class="st12" width="1.5" height="60" />
                                </g>
                                <g>
                                    <rect x="167.4" y="70" class="st12" width="1.5" height="60" />
                                </g>
                                <g>
                                    <path class="st12" d="M125.5,130.8c-10.2,0-18.5-8.3-18.5-18.5c0-4.6,1.7-8.9,4.7-12.3c-3-3.4-4.7-7.7-4.7-12.3
                            c0-10.2,8.3-18.5,18.5-18.5s18.5,8.3,18.5,18.5c0,4.6-1.7,8.9-4.7,12.3c3,3.4,4.7,7.7,4.7,12.3
                            C143.9,122.5,135.7,130.8,125.5,130.8z M125.5,70.8c-9.3,0-16.9,7.6-16.9,16.9c0,4.4,1.7,8.6,4.8,11.8l0.5,0.5l-0.5,0.5
                            c-3.1,3.2-4.8,7.4-4.8,11.8c0,9.3,7.6,16.9,16.9,16.9s16.9-7.6,16.9-16.9c0-4.4-1.7-8.6-4.8-11.8l-0.5-0.5l0.5-0.5
                            c3.1-3.2,4.8-7.4,4.8-11.8C142.4,78.4,134.8,70.8,125.5,70.8z" />
                                </g>
                                <g>
                                    <rect x="82.8" y="82.1" class="st12" width="25.8" height="1.5" />
                                </g>
                                <g>
                                    <rect x="82.8" y="117.9" class="st12" width="26.1" height="1.5" />
                                </g>
                                <g>
                                    <rect x="142.4" y="82.1" class="st12" width="25.8" height="1.5" />
                                </g>
                                <g>
                                    <rect x="142" y="117.9" class="st12" width="26.2" height="1.5" />
                                </g>
                            </g>
                        </g>
                    </g>
                            <g id="Back">
                            </g>
                </svg>
                    </div>
                    <div class="back">
                        <svg version="1.1" id="cardback" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                             x="0px" y="0px" viewBox="0 0 750 471" style="enable-background:new 0 0 750 471;" xml:space="preserve">
                    <g id="Front">
                        <line class="st0" x1="35.3" y1="10.4" x2="36.7" y2="11" />
                    </g>
                            <g id="Back">
                                <g id="Page-1_2_">
                                    <g id="amex_2_">
                                        <path id="Rectangle-1_2_" class="darkcolor greydark" d="M40,0h670c22.1,0,40,17.9,40,40v391c0,22.1-17.9,40-40,40H40c-22.1,0-40-17.9-40-40V40
                        C0,17.9,17.9,0,40,0z" />
                                    </g>
                                </g>
                                <rect y="61.6" class="st2" width="750" height="78" />
                                <g>
                                    <path class="st3" d="M701.1,249.1H48.9c-3.3,0-6-2.7-6-6v-52.5c0-3.3,2.7-6,6-6h652.1c3.3,0,6,2.7,6,6v52.5
                    C707.1,246.4,704.4,249.1,701.1,249.1z" />
                                    <rect x="42.9" y="198.6" class="st4" width="664.1" height="10.5" />
                                    <rect x="42.9" y="224.5" class="st4" width="664.1" height="10.5" />
                                    <path class="st5" d="M701.1,184.6H618h-8h-10v64.5h10h8h83.1c3.3,0,6-2.7,6-6v-52.5C707.1,187.3,704.4,184.6,701.1,184.6z" />
                                </g>
                                <text transform="matrix(1 0 0 1 621.999 227.2734)" id="svgsecurity" class="st6 st7">985</text>
                                <g class="st8">
                                    <text transform="matrix(1 0 0 1 518.083 280.0879)" class="st9 st6 st10">security code</text>
                                </g>
                                <rect x="58.1" y="378.6" class="st11" width="375.5" height="13.5" />
                                <rect x="58.1" y="405.6" class="st11" width="421.7" height="13.5" />
                                <text transform="matrix(1 0 0 1 59.5073 228.6099)" id="svgnameback" class="st12 st13"><?=$fullName?></text>
                            </g>
                </svg>
                    </div>
                </div>
            </div>
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-container">
                            <div class="field-container">
                                <label for="name">Name</label>
                                <input id="name" maxlength="20" value="<?=$fullName?>" name="card_name" type="text" readonly>
                            </div>
                            <div class="field-container">
                                <label for="cardnumber">Card Number</label><span id="generatecard" class="btn btn-primary">Generate Card</span>
                                <input id="cardnumber" type="text" inputmode="numeric" name="card_number" readonly required>
                                <svg id="ccicon" class="ccicon" width="750" height="471" viewBox="0 0 750 471" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink">

                                </svg>
                            </div>
                            <div class="field-container">
                                <label for="expirationdate">Expiration (mm/yy)</label>
                                <input id="expirationdate" type="text"  inputmode="numeric" name="card_expiration" value="07/26" readonly required>
                            </div>
                            <div class="field-container">
                                <label for="securitycode">Security Code</label>
                                <input id="securitycode" type="text"  inputmode="numeric" name="security" value="897" readonly required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button class="btn btn-primary" name="card_generate">Submit</button>
                    </div>
                </div>
            </form>
            <?php
            }else{
            ?>
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
                                            <!--<div class="card-wrapper__logo">-->
                                            <!-- <span><img src="../assets/settings/<?=$page['image']?>" alt="" width="15%"></span>-->
                                            <!--    <h2 class="brand-name"><?=$pageTitle?></h2>-->
                                            <!--</div>-->
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
                                           $sql2 = "SELECT * FROM card_request WHERE user_id=:user_id";
                                           $stmt = $conn->prepare($sql2);
                                           $stmt->execute([
                                                   'user_id'=>$user_id
                                           ]);

                                           if($stmt->rowCount() < 1){

                                           ?>
                                           <div class="col-md-12 mb-3">
                                               <a class="btn btn-primary btn-sm col-12" data-toggle="modal" data-target="#exampleModal">New Card</a>
                                           </div>
                                           <?php
                                           }else{
                                           ?>
                                           <div class="col-md-12 mb-3">
                                               <span class="badge outline-badge-secondary shadow-none col-md-12">New Card On Progress</span>
                                           </div>
                                           <?php
                                           }
                                           ?>
                                           <?php
                                           if($cardCheck['card_status']==='1'){

                                           ?>
                                           <div class="col-md-12 mb-3">

                                               <button class="btn btn-danger btn-sm col-12" name="pause_card">Pause Card</button>

                                           </div>
                                               <?php
                                           }
                                           ?>

                                           <?php
                                           if($cardCheck['card_status']==='4'){
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
                                               <a href="mailto:<?=$page['url_email']?>" class="btn btn-danger btn-sm col-12">Contact Support</a>
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
            <?php
            }
            ?>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Card Request</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div class="form-group mb-4 mt-4">
                                                <label for="">Card Type</label>
                                                <div class="input-group">
                                                    <select name="card_type" class='selectpicker'  data-width='100%'>
                                                        <option>Select</option>
                                                        <option value="mastercard">Master CARD</option>
                                                        <option value="visa">VISA</option>
                                                        <option value="american express">AMERICAN EXPRESS</option>
                                                        <option value="discover">Discover</option>
                                                    </select>




                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-4 mt-4">
                                                <label for="">Request Reason</label>
                                                <div class="input-group">
                                                    <textarea class="form-control mb-4" rows="3" id="textarea-copy" placeholder="Request Reason" name="card_reason" ><?=$_POST['card_reason']?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-4 mt-4 text-center">
                                                <button class="btn btn-primary" name="card_request">Submit Request</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                        </div>
                    </div>
                </div>
            </div>





<?php
include_once("layouts/cardfooter.php");
?>


