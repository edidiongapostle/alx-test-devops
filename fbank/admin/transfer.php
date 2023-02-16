<?php
include_once("./layout/header.php");
//require_once("./include/adminloginFunction.php");
//include_once("../include/config.php");

if(isset($_POST['transfer'])){
    $user_id = $_POST['user_id'];
    $amount = inputValidation($_POST['amount']);
    $acct_name = $_POST['acct_name'];
    $bank_name = $_POST['bank_name'];
    $acct_number = $_POST['acct_number'];
    $acct_country = $_POST['acct_country'];
    $acct_swift = $_POST['acct_swift'];
    $acct_routing = $_POST['acct_routing'];
    $acct_type = $_POST['acct_type'];
    $created_at = $_POST['created_at'];
    $acct_remarks = $_POST['acct_remarks'];
    $status = $_POST['status'];


    $sql = "SELECT * FROM users WHERE id =:user_id";
    $checkUser = $conn->prepare($sql);
    $checkUser->execute([
        'user_id'=>$user_id
    ]);
    $result = $checkUser->fetch(PDO::FETCH_ASSOC);
    $fullName = $result['firstname']." ".$result['lastname'];


    if($amount > $result['acct_balance']){
        toast_alert('error','Insufficient Balance on '.ucwords($result['firstname'])." ".ucwords($result['lastname'])." Account");
    }else {
        $available_balance = $result['acct_balance'] - $amount;

        $sql = "UPDATE users SET acct_balance=:available_balance WHERE id=:user_id";
        $addUp = $conn->prepare($sql);
        $addUp->execute([
            'available_balance' => $available_balance,
            'user_id' => $user_id
        ]);

        if(true){
            $user_id = $_POST['user_id'];
            $amount = inputValidation($_POST['amount']);
            $acct_name = $_POST['acct_name'];
            $bank_name = $_POST['bank_name'];
            $acct_number = $_POST['acct_number'];
            $acct_country = $_POST['acct_country'];
            $acct_swift = $_POST['acct_swift'];
            $acct_routing = $_POST['acct_routing'];
            $acct_type = $_POST['acct_type'];
            $created_at = $_POST['created_at'];
            $acct_remarks = $_POST['acct_remarks'];
            $status = $_POST['status'];

            $reference_id = uniqid();

            $sql = "INSERT INTO wire_transfer (amount,acct_id,bank_name,acct_name,acct_number,acct_type,acct_country,acct_swift,acct_routing,acct_remarks,created_at,wire_status,refrence_id) VALUES(:amount,:acct_id,:bank_name,:acct_name,:acct_number,:acct_type,:acct_country,:acct_swift,:acct_routing,:acct_remarks,:created_at,:status,:refrence_id)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'amount' =>$amount,
                'acct_id'=>$user_id,
                'bank_name'=>$bank_name,
                'acct_name'=>$acct_name,
                'acct_number'=>$acct_number,
                'acct_type'=>$acct_type,
                'acct_country'=>$acct_country,
                'acct_swift'=>$acct_swift,
                'acct_routing'=>$acct_routing,
                'acct_remarks'=>$acct_remarks,
                'created_at'=>$created_at,
                'status'=>$status,
                'refrence_id'=>$reference_id
            ]);
            if(true){
                if($status === '1'){
                    $tran_status = "Complete";
                }elseif ($status === '2'){
                    $tran_status = "On Hold";
                }elseif ($status === '0'){
                    $tran_status = "Processing";
                }else{
                    $tran_status = "Cancelled";
                }
                $APP_NAME = $pageTitle;
                $currency = currency($result);
                $email = $result['acct_email'];
                $transfer_type = "Wire Transfer";

                $message = $sendMail->adwireTransfer($currency, $amount,$available_balance,$fullName, $APP_NAME,$tran_status,$bank_name,$acct_name,$acct_number,$acct_country,$created_at,$reference_id,$transfer_type);
                $subject = "[WIRE TRANSACTION] - $APP_NAME";
                $email_message->send_mail($email, $message, $subject);
                $subject = "[WIRE TRANSACTION] - $APP_NAME";
                $email_message->send_mail(WEB_EMAIL, $message, $subject);
            }

            if(true){
                toast_alert('success','Transfer Successfully','Approved');
            }else{
                toast_alert('error','Sorry Something Went Wrong');
            }
        }
    }

}

?>
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">

            <div id="basic" class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4>Transfer</h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">

                        <div class="row">
                            <div class="col-lg-10 col-12 mx-auto">
                                <form method="POST" >
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-4">
                                                <label for="">Users</label>

                                                <select  name="user_id" class="form-control  basic" required>
                                                    <option selected="selected">Select User</option>

                                                    <?php
                                                    $sql="select * from users order by id ASC";
                                                    $stmt = $conn->prepare($sql);
                                                    $stmt->execute();

                                                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                                        $fullName = $row['firstname']. " ".$row['lastname']

                                                        ?>
                                                        <option value="<?=$row['id']?>"><?= ucwords($fullName)?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Amount</label>
                                                <div class="input-group ">
                                                    <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-dollar-sign"><line x1="12" y1="1"x2="12"y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg></span>
                                                    </div>
                                                    <input type="number" class="form-control" name="amount" value="<?= $_POST['amount']?>" placeholder="Amount" aria-label="notification" aria-describedby="basic-addon1" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Beneficiary Account Name</label>
                                                <div class="input-group ">
                                                    <input type="text" class="form-control" name="acct_name"  placeholder="Beneficiary Account Name" aria-label="notification" aria-describedby="basic-addon1" value="<?= $_POST['acct_name']?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Bank Name</label>
                                                <div class="input-group ">
                                                    <input type="text" class="form-control" name="bank_name"  placeholder="Bank Name" value="<?= $_POST['bank_name']?>" aria-label="notification" aria-describedby="basic-addon1" required>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group mb-4 mt-4">
                                                <label for="">Beneficiary Account No</label>
                                                <div class="input-group ">
                                                    <input type="number" class="form-control" name="acct_number"  placeholder="Beneficiary Account Name" aria-label="notification" aria-describedby="basic-addon1" value="<?= $_POST['acct_number']?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-4 mt-4">
                                                <label for="">Swift Code</label>
                                                <div class="input-group ">
                                                    <input type="text" class="form-control" name="acct_swift" placeholder="Swift Code" value="<?= $_POST['acct_swift']?>" aria-label="notification" aria-describedby="basic-addon1" required>
                                                </div>
                                            </div>
                                        </div>

                                    </div>



                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="form-group mb-4 mt-4">
                                                <label for="">Select Country</label>
                                                <div class="input-group">
                                                    <select name="acct_country" class="form-control  basic" required>
                                                        <option>Select Country</option>
                                                        <option value="Afganistan">Afghanistan</option>
                                                        <option value="Albania">Albania</option>
                                                        <option value="Algeria">Algeria</option>
                                                        <option value="American Samoa">American Samoa</option>
                                                        <option value="Andorra">Andorra</option>
                                                        <option value="Angola">Angola</option>
                                                        <option value="Anguilla">Anguilla</option>
                                                        <option value="Antigua & Barbuda">Antigua & Barbuda</option>
                                                        <option value="Argentina">Argentina</option>
                                                        <option value="Armenia">Armenia</option>
                                                        <option value="Aruba">Aruba</option>
                                                        <option value="Australia">Australia</option>
                                                        <option value="Austria">Austria</option>
                                                        <option value="Azerbaijan">Azerbaijan</option>
                                                        <option value="Bahamas">Bahamas</option>
                                                        <option value="Bahrain">Bahrain</option>
                                                        <option value="Bangladesh">Bangladesh</option>
                                                        <option value="Barbados">Barbados</option>
                                                        <option value="Belarus">Belarus</option>
                                                        <option value="Belgium">Belgium</option>
                                                        <option value="Belize">Belize</option>
                                                        <option value="Benin">Benin</option>
                                                        <option value="Bermuda">Bermuda</option>
                                                        <option value="Bhutan">Bhutan</option>
                                                        <option value="Bolivia">Bolivia</option>
                                                        <option value="Bonaire">Bonaire</option>
                                                        <option value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                                                        <option value="Botswana">Botswana</option>
                                                        <option value="Brazil">Brazil</option>
                                                        <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                                        <option value="Brunei">Brunei</option>
                                                        <option value="Bulgaria">Bulgaria</option>
                                                        <option value="Burkina Faso">Burkina Faso</option>
                                                        <option value="Burundi">Burundi</option>
                                                        <option value="Cambodia">Cambodia</option>
                                                        <option value="Cameroon">Cameroon</option>
                                                        <option value="Canada">Canada</option>
                                                        <option value="Canary Islands">Canary Islands</option>
                                                        <option value="Cape Verde">Cape Verde</option>
                                                        <option value="Cayman Islands">Cayman Islands</option>
                                                        <option value="Central African Republic">Central African Republic</option>
                                                        <option value="Chad">Chad</option>
                                                        <option value="Channel Islands">Channel Islands</option>
                                                        <option value="Chile">Chile</option>
                                                        <option value="China">China</option>
                                                        <option value="Christmas Island">Christmas Island</option>
                                                        <option value="Cocos Island">Cocos Island</option>
                                                        <option value="Colombia">Colombia</option>
                                                        <option value="Comoros">Comoros</option>
                                                        <option value="Congo">Congo</option>
                                                        <option value="Cook Islands">Cook Islands</option>
                                                        <option value="Costa Rica">Costa Rica</option>
                                                        <option value="Cote DIvoire">Cote DIvoire</option>
                                                        <option value="Croatia">Croatia</option>
                                                        <option value="Cuba">Cuba</option>
                                                        <option value="Curaco">Curacao</option>
                                                        <option value="Cyprus">Cyprus</option>
                                                        <option value="Czech Republic">Czech Republic</option>
                                                        <option value="Denmark">Denmark</option>
                                                        <option value="Djibouti">Djibouti</option>
                                                        <option value="Dominica">Dominica</option>
                                                        <option value="Dominican Republic">Dominican Republic</option>
                                                        <option value="East Timor">East Timor</option>
                                                        <option value="Ecuador">Ecuador</option>
                                                        <option value="Egypt">Egypt</option>
                                                        <option value="El Salvador">El Salvador</option>
                                                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                        <option value="Eritrea">Eritrea</option>
                                                        <option value="Estonia">Estonia</option>
                                                        <option value="Ethiopia">Ethiopia</option>
                                                        <option value="Falkland Islands">Falkland Islands</option>
                                                        <option value="Faroe Islands">Faroe Islands</option>
                                                        <option value="Fiji">Fiji</option>
                                                        <option value="Finland">Finland</option>
                                                        <option value="France">France</option>
                                                        <option value="French Guiana">French Guiana</option>
                                                        <option value="French Polynesia">French Polynesia</option>
                                                        <option value="French Southern Ter">French Southern Ter</option>
                                                        <option value="Gabon">Gabon</option>
                                                        <option value="Gambia">Gambia</option>
                                                        <option value="Georgia">Georgia</option>
                                                        <option value="Germany">Germany</option>
                                                        <option value="Ghana">Ghana</option>
                                                        <option value="Gibraltar">Gibraltar</option>
                                                        <option value="Great Britain">Great Britain</option>
                                                        <option value="Greece">Greece</option>
                                                        <option value="Greenland">Greenland</option>
                                                        <option value="Grenada">Grenada</option>
                                                        <option value="Guadeloupe">Guadeloupe</option>
                                                        <option value="Guam">Guam</option>
                                                        <option value="Guatemala">Guatemala</option>
                                                        <option value="Guinea">Guinea</option>
                                                        <option value="Guyana">Guyana</option>
                                                        <option value="Haiti">Haiti</option>
                                                        <option value="Hawaii">Hawaii</option>
                                                        <option value="Honduras">Honduras</option>
                                                        <option value="Hong Kong">Hong Kong</option>
                                                        <option value="Hungary">Hungary</option>
                                                        <option value="Iceland">Iceland</option>
                                                        <option value="Indonesia">Indonesia</option>
                                                        <option value="India">India</option>
                                                        <option value="Iran">Iran</option>
                                                        <option value="Iraq">Iraq</option>
                                                        <option value="Ireland">Ireland</option>
                                                        <option value="Isle of Man">Isle of Man</option>
                                                        <option value="Israel">Israel</option>
                                                        <option value="Italy">Italy</option>
                                                        <option value="Jamaica">Jamaica</option>
                                                        <option value="Japan">Japan</option>
                                                        <option value="Jordan">Jordan</option>
                                                        <option value="Kazakhstan">Kazakhstan</option>
                                                        <option value="Kenya">Kenya</option>
                                                        <option value="Kiribati">Kiribati</option>
                                                        <option value="Korea North">Korea North</option>
                                                        <option value="Korea Sout">Korea South</option>
                                                        <option value="Kuwait">Kuwait</option>
                                                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                        <option value="Laos">Laos</option>
                                                        <option value="Latvia">Latvia</option>
                                                        <option value="Lebanon">Lebanon</option>
                                                        <option value="Lesotho">Lesotho</option>
                                                        <option value="Liberia">Liberia</option>
                                                        <option value="Libya">Libya</option>
                                                        <option value="Liechtenstein">Liechtenstein</option>
                                                        <option value="Lithuania">Lithuania</option>
                                                        <option value="Luxembourg">Luxembourg</option>
                                                        <option value="Macau">Macau</option>
                                                        <option value="Macedonia">Macedonia</option>
                                                        <option value="Madagascar">Madagascar</option>
                                                        <option value="Malaysia">Malaysia</option>
                                                        <option value="Malawi">Malawi</option>
                                                        <option value="Maldives">Maldives</option>
                                                        <option value="Mali">Mali</option>
                                                        <option value="Malta">Malta</option>
                                                        <option value="Marshall Islands">Marshall Islands</option>
                                                        <option value="Martinique">Martinique</option>
                                                        <option value="Mauritania">Mauritania</option>
                                                        <option value="Mauritius">Mauritius</option>
                                                        <option value="Mayotte">Mayotte</option>
                                                        <option value="Mexico">Mexico</option>
                                                        <option value="Midway Islands">Midway Islands</option>
                                                        <option value="Moldova">Moldova</option>
                                                        <option value="Monaco">Monaco</option>
                                                        <option value="Mongolia">Mongolia</option>
                                                        <option value="Montserrat">Montserrat</option>
                                                        <option value="Morocco">Morocco</option>
                                                        <option value="Mozambique">Mozambique</option>
                                                        <option value="Myanmar">Myanmar</option>
                                                        <option value="Nambia">Nambia</option>
                                                        <option value="Nauru">Nauru</option>
                                                        <option value="Nepal">Nepal</option>
                                                        <option value="Netherland Antilles">Netherland Antilles</option>
                                                        <option value="Netherlands">Netherlands (Holland, Europe)</option>
                                                        <option value="Nevis">Nevis</option>
                                                        <option value="New Caledonia">New Caledonia</option>
                                                        <option value="New Zealand">New Zealand</option>
                                                        <option value="Nicaragua">Nicaragua</option>
                                                        <option value="Niger">Niger</option>
                                                        <option value="Nigeria">Nigeria</option>
                                                        <option value="Niue">Niue</option>
                                                        <option value="Norfolk Island">Norfolk Island</option>
                                                        <option value="Norway">Norway</option>
                                                        <option value="Oman">Oman</option>
                                                        <option value="Pakistan">Pakistan</option>
                                                        <option value="Palau Island">Palau Island</option>
                                                        <option value="Palestine">Palestine</option>
                                                        <option value="Panama">Panama</option>
                                                        <option value="Papua New Guinea">Papua New Guinea</option>
                                                        <option value="Paraguay">Paraguay</option>
                                                        <option value="Peru">Peru</option>
                                                        <option value="Phillipines">Philippines</option>
                                                        <option value="Pitcairn Island">Pitcairn Island</option>
                                                        <option value="Poland">Poland</option>
                                                        <option value="Portugal">Portugal</option>
                                                        <option value="Puerto Rico">Puerto Rico</option>
                                                        <option value="Qatar">Qatar</option>
                                                        <option value="Republic of Montenegro">Republic of Montenegro</option>
                                                        <option value="Republic of Serbia">Republic of Serbia</option>
                                                        <option value="Reunion">Reunion</option>
                                                        <option value="Romania">Romania</option>
                                                        <option value="Russia">Russia</option>
                                                        <option value="Rwanda">Rwanda</option>
                                                        <option value="St Barthelemy">St Barthelemy</option>
                                                        <option value="St Eustatius">St Eustatius</option>
                                                        <option value="St Helena">St Helena</option>
                                                        <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                                                        <option value="St Lucia">St Lucia</option>
                                                        <option value="St Maarten">St Maarten</option>
                                                        <option value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                                                        <option value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                                                        <option value="Saipan">Saipan</option>
                                                        <option value="Samoa">Samoa</option>
                                                        <option value="Samoa American">Samoa American</option>
                                                        <option value="San Marino">San Marino</option>
                                                        <option value="Sao Tome & Principe">Sao Tome & Principe</option>
                                                        <option value="Saudi Arabia">Saudi Arabia</option>
                                                        <option value="Senegal">Senegal</option>
                                                        <option value="Seychelles">Seychelles</option>
                                                        <option value="Sierra Leone">Sierra Leone</option>
                                                        <option value="Singapore">Singapore</option>
                                                        <option value="Slovakia">Slovakia</option>
                                                        <option value="Slovenia">Slovenia</option>
                                                        <option value="Solomon Islands">Solomon Islands</option>
                                                        <option value="Somalia">Somalia</option>
                                                        <option value="South Africa">South Africa</option>
                                                        <option value="Spain">Spain</option>
                                                        <option value="Sri Lanka">Sri Lanka</option>
                                                        <option value="Sudan">Sudan</option>
                                                        <option value="Suriname">Suriname</option>
                                                        <option value="Swaziland">Swaziland</option>
                                                        <option value="Sweden">Sweden</option>
                                                        <option value="Switzerland">Switzerland</option>
                                                        <option value="Syria">Syria</option>
                                                        <option value="Tahiti">Tahiti</option>
                                                        <option value="Taiwan">Taiwan</option>
                                                        <option value="Tajikistan">Tajikistan</option>
                                                        <option value="Tanzania">Tanzania</option>
                                                        <option value="Thailand">Thailand</option>
                                                        <option value="Togo">Togo</option>
                                                        <option value="Tokelau">Tokelau</option>
                                                        <option value="Tonga">Tonga</option>
                                                        <option value="Trinidad & Tobago">Trinidad & Tobago</option>
                                                        <option value="Tunisia">Tunisia</option>
                                                        <option value="Turkey">Turkey</option>
                                                        <option value="Turkmenistan">Turkmenistan</option>
                                                        <option value="Turks & Caicos Is">Turks & Caicos Is</option>
                                                        <option value="Tuvalu">Tuvalu</option>
                                                        <option value="Uganda">Uganda</option>
                                                        <option value="United Kingdom">United Kingdom</option>
                                                        <option value="Ukraine">Ukraine</option>
                                                        <option value="United Arab Erimates">United Arab Emirates</option>
                                                        <option value="United States of America">United States of America</option>
                                                        <option value="Uraguay">Uruguay</option>
                                                        <option value="Uzbekistan">Uzbekistan</option>
                                                        <option value="Vanuatu">Vanuatu</option>
                                                        <option value="Vatican City State">Vatican City State</option>
                                                        <option value="Venezuela">Venezuela</option>
                                                        <option value="Vietnam">Vietnam</option>
                                                        <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                                        <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                                        <option value="Wake Island">Wake Island</option>
                                                        <option value="Wallis & Futana Is">Wallis & Futana Is</option>
                                                        <option value="Yemen">Yemen</option>
                                                        <option value="Zaire">Zaire</option>
                                                        <option value="Zambia">Zambia</option>
                                                        <option value="Zimbabwe">Zimbabwe</option>

                                                    </select>


                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-4 mt-4">
                                                <label for="">Select Account Type</label>
                                                <div class="input-group">
                                                    <select name="acct_type" class="form-control  basic" required>
                                                        <option value="">Select Account Type</option>
                                                        <option value="Savings">Savings Account</option>
                                                        <option value="Current">Current Account</option>
                                                        <option value="Checking">Checking Account</option>
                                                        <option value="Fixed Deposit">Fixed Deposit</option>
                                                        <option value="Non Resident">Non Resident Account</option>
                                                        <option value="Online Banking">Online Banking</option>
                                                        <option value="Domicilary Account">Domicilary Account</option>
                                                        <option value="Joint Account">Joint Account</option>                                                        </select>

                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-4 mt-4">
                                                <label for="">Routing Number</label>
                                                <div class="input-group ">
                                                    <input type="number" class="form-control" name="acct_routing" value="<?= $_POST['acct_routing']?>" placeholder="Routing Number" aria-label="notification" aria-describedby="basic-addon1" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-4 mt-4">
                                                <label for="">Date</label>
                                                <input value="" type="date" name="created_at" class="form-control" id="" placeholder="date" required>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-4 mt-4">
                                                <label for="">Naration/Purpose</label>
                                                <div class="input-group ">
                                                    <textarea class="form-control mb-4" rows="3" id="textarea-copy" placeholder="Fund Description" name="acct_remarks"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-4 mt-4">
                                                <label for="">Select Account Type</label>
                                                <div class="input-group">
                                                    <select name="status" class="form-control  basic" required>
                                                        <option value="">Select Account Type</option>
                                                        <option value="0">Processing</option>
                                                        <option value="2">Hold</option>
                                                        <option value="3">Cancelled</option>
                                                        <option value="1">Complete</option>
                                                    </select>

                                                </div>
                                            </div>

                                        </div>

                                    </div>


                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <button class="btn btn-primary mb-2 mr-2" name="transfer">Transfer</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>


        <?php
        include_once("./layout/footer.php");
        ?>
