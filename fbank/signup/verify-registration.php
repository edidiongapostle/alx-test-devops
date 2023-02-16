<?php
$pageName  = "Registration";
require_once './layout/header.php';

if(isset($_POST['regSubmit'])){

    $acct_no = "9909".(substr(number_format(time() * rand(), 0, '', ''), 0, 6));
    $acct_type = "Savings";
    $acct_currency = "USD";
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $acct_occupation = $_POST['occupation'];
    $acct_status = "hold";
    $country = $_POST['country'];
    $acct_gender = $_POST['radio-name'];
    $address = $_POST['address'];
    $suite = $_POST['suite'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zipcode = $_POST['zipcode'];
    $acct_address = $address." ".$suite. " ".$city." ".$state." ".$zipcode;
    $acct_email = $_POST['acct_email'];
    $acct_phone = $_POST['phoneNumber'];
    $acct_username = $_POST['username'];
    $acct_password = $_POST['acct_password'];
    $confirmPassword = $_POST['confirmPassword'];
    $ssn = $_POST['ssn'];
    $confirm_ssn = $_POST['confirm-ssn'];
    $acct_dob = $_POST['dob'];
     $acct_pin = inputValidation($_POST['acct_pin']);



    if($acct_password !== $confirmPassword){
        notify_alert('Password not matched','danger','3000','close');

    }elseif ($ssn !== $confirm_ssn){
        notify_alert('SSN / TIN not matched','danger','3000','close');

    }else {
        //checking exiting email

        $usersVerified = "SELECT * FROM users WHERE acct_email=:acct_email or acct_username=:acct_username";
        $stmt = $conn->prepare($usersVerified);
        $stmt->execute([
            'acct_email' => $acct_email,
            'acct_username' => $acct_username
        ]);


        if ($stmt->rowCount() > 0) {
            notify_alert('Email or Username Already Exit', 'danger', '3000', 'close');
        } else {
            if (isset($_FILES['profile_pic'])) {
                $file = $_FILES['profile_pic'];
                $name = $file['name'];

                $path = pathinfo($name, PATHINFO_EXTENSION);

                $allowed = array('jpg', 'png', 'jpeg');


                $folder = "../assets/profile/";
                $n = time() . $name;

                $destination = $folder . $n;
            }
            if (move_uploaded_file($file['tmp_name'], $destination)) {

                if (isset($_FILES['frontID'])) {
                    $file = $_FILES['frontID'];
                    $name = $file['name'];

                    $path = pathinfo($name, PATHINFO_EXTENSION);

                    $allowed = array('jpg', 'png', 'jpeg');


                    $folder = "../assets/idcard/";
                    $frontid = time() . $name;

                    $destination = $folder . $n;
                }
                if (move_uploaded_file($file['tmp_name'], $destination)) {

                    if (isset($_FILES['backID'])) {
                        $file = $_FILES['backID'];
                        $name = $file['name'];

                        $path = pathinfo($name, PATHINFO_EXTENSION);

                        $allowed = array('jpg', 'png', 'jpeg');


                        $folder = "../assets/idcard/";
                        $backId = time() . $name;

                        $destination = $folder . $n;
                    }
                    if (move_uploaded_file($file['tmp_name'], $destination)) {

                        //INSERT INTO DATABASE
                        $registered = "INSERT INTO users (acct_username,firstname,lastname,acct_email,acct_password,acct_no,acct_type,acct_gender,acct_currency,acct_status,acct_phone,acct_occupation,country,state,acct_address,acct_dob,acct_pin,ssn,frontID,backID,image) VALUES(:acct_username,:firstname,:lastname,:acct_email,:acct_password,:acct_no,:acct_type,:acct_gender,:acct_currency,:acct_status,:acct_phone,:acct_occupation,:country,:state,:acct_address,:acct_dob,:acct_pin,:ssn,:frontID,:backID,:image)";
                        $reg = $conn->prepare($registered);
                        $reg->execute([
                            'acct_username' => $acct_username,
                            'firstname' => $firstname,
                            'lastname' => $lastname,
                            'acct_email' => $acct_email,
                            'acct_password' => password_hash((string)$acct_password, PASSWORD_BCRYPT),
                            'acct_no' => $acct_no,
                            'acct_type' => $acct_type,
                            'acct_gender' => $acct_gender,
                            'acct_currency' => $acct_currency,
                            'acct_status' => $acct_status,
                            'acct_phone' => $acct_phone,
                            'acct_occupation' => $acct_occupation,
                            'country' => $country,
                            'state' => $state,
                            'acct_address' => $acct_address,
                            'acct_dob' => $acct_dob,
                            'acct_pin' => $acct_pin,
                            'ssn' => $ssn,
                            'frontID' => $frontid,
                            'backID' => $backId,
                            'image'=>$n
                ]);


                if (true) {

                    if ($acct_currency === 'USD') {
                        $currency = "$";
                    } elseif ($acct_currency === 'EUR') {
                        $currency = "&euro;";
                    }

                    $fullName = $firstname . " " . $lastname;
                    //EMAIL SENDING
                    $email = $acct_email;
                    $APP_NAME = $pageTitle;
                    $APP_URL = WEB_URL;
                    $message = $sendMail->regMsgUser($fullName,$acct_no,$acct_status,$acct_email,$acct_phone,$acct_type,$acct_pin,$APP_NAME,$APP_URL);
                    //User Email
                    $subject = "Register - $APP_NAME";
                    $email_message->send_mail($email, $message, $subject);
                    // Admin Email
                    $subject = "User Register - $APP_NAME";
                    $email_message->send_mail(WEB_EMAIL, $message, $subject);
                }


            header("Location:../login.php");
            exit;
                // if (true) {
                //     toast_alert('success', 'Account Created Successfully, Kindly Check your mail for Confirmation', 'Approved');
                // } else {
                //     toast_alert('error', 'Sorry something went wrong');
                // }

                }
                }
            }

        }
    }


}
//require_once './layout/header.php';
?>



<section class="wizard-section">
    <div class="row no-gutters">
        <div class="col-lg-6 col-md-6 container-div">
            <div class="wizard-content-left d-flex justify-content-center align-items-center">
                <h1>Create Your Bank Account</h1>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 container-div">
            <div class="form-wizard">
                <form action="" method="post" role="form" enctype="multipart/form-data">
                    <div class="form-wizard-header">
                        <p>Fill all form field to go next step</p>
                        <ul class="list-unstyled form-wizard-steps clearfix">
                            <li class="active"><span>1</span></li>
                            <li><span>2</span></li>
                            <li><span>3</span></li>
                            <li><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg></span></li>
                        </ul>
                    </div>
                    <fieldset class="wizard-fieldset show">

                        <h5>Personal Info</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control wizard-required" id="fname" name="firstname">
                                    <label for="fname" class="wizard-form-text-label">First Name*</label>
                                    <div class="wizard-form-error"></div>
                                </div>
                            </div>
                           <div class="col-md-6">
                               <div class="form-group">
                                   <input type="text" class="form-control wizard-required" id="lname" name="lastname">
                                   <label for="lname" class="wizard-form-text-label">Last Name*</label>
                                   <div class="wizard-form-error"></div>
                               </div>
                           </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control wizard-required" id="occupation" name="occupation">
                                    <label for="occupation" class="wizard-form-text-label">Occupation</label>
                                    <div class="wizard-form-error"></div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="form-control" name="country" required>
                                        <option selected="selected">Select Country</option>
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
                        <!--<div class="form-group">-->
                        <!--    Gender-->
                        <!--    <div class="wizard-form-radio">-->
                        <!--        <input name="radio-name" id="radio1" type="radio" value="male">-->
                        <!--        <label for="radio1">Male</label>-->
                        <!--    </div>-->
                        <!--    <div class="wizard-form-radio">-->
                        <!--        <input name="radio-name" id="radio2" type="radio" value="female">-->
                        <!--        <label for="radio2">Female</label>-->
                        <!--    </div>-->
                        <!--</div>-->

                        <h5>Residential Address</h5>
                        <div class="form-group">
                            <input type="text" class="form-control wizard-required" id="address" name="address">
                            <input name="radio-name" id="text" type="text" value="male" hidden>
                            
                            <label for="address" class="wizard-form-text-label">Street Address*</label>
                            <div class="wizard-form-error"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control wizard" id="Suite" name="suite">
                                    <label for="Suite" class="wizard-form-text-label">Apt/Suite/Unit</label>
                                    <div class="wizard-form-error"></div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control wizard-required" id="city" name="city">
                                    <label for="city" class="wizard-form-text-label">City*</label>
                                    <div class="wizard-form-error"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control wizard-required" id="state" name="state">
                                    <label for="state" class="wizard-form-text-label">State*</label>
                                    <div class="wizard-form-error"></div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control wizard-required" id="zipcode" name="zipcode">
                                    <label for="zipcode" class="wizard-form-text-label">Zip Code*</label>
                                    <div class="wizard-form-error"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <a href="javascript:;" class="form-wizard-next-btn float-right">Next</a>
                        </div>
                    </fieldset>
                    <fieldset class="wizard-fieldset">
                        <h5>Create your login</h5>
                        <div class="form-group">
                            <input type="text" class="form-control wizard-required" id="email" name="acct_email">
                            <label for="email" class="wizard-form-text-label">Email Address*</label>
                            <div class="wizard-form-error"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="number" class="form-control wizard-required" id="phoneNumber" name="phoneNumber">
                                    <label for="phoneNumber" class="wizard-form-text-label">Phone Number*</label>
                                    <div class="wizard-form-error"></div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control wizard-required" id="username" name="username">
                                    <input type="text" name="acct_pin" id="acct_pin" value="1234" hidden>
                                    <label for="city" class="wizard-form-text-label">Username*</label>
                                    <div class="wizard-form-error"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="password" class="form-control wizard-required" id="pwd" name="acct_password">
                                    <label for="pwd" class="wizard-form-text-label">Password*</label>
                                    <div class="wizard-form-error"></div>
                                    <span class="wizard-password-eye"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg></span>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="password" class="form-control wizard-required" id="confirmPassword" name="confirmPassword">
                                    <label for="confirmPassword" class="wizard-form-text-label">Confirm Password*</label>
                                    <div class="wizard-form-error"></div>
                                    <span class="wizard-password-eye"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <a href="javascript:;" class="form-wizard-previous-btn float-left">Previous</a>

                            <a href="javascript:;" class="form-wizard-next-btn float-right">Next</a>
                        </div>
                    </fieldset>
                    <fieldset class="wizard-fieldset">
                        <h5>Verify your identity</h5>
                        <p>We'er required by law to collect your Social Security Number / TIN.</p>
                        <div id="Div1">
                            <div class="container">

                                <div class="row mb-3">
                                    <div class="col-md-2 mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock text-primary"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    </div>
                                    <div class="col-md-10">
                                        <h6>Security in mind</h6>
                                        We use your SSN or TIN to help keep your account safe and secure.
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-2 mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card text-primary"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                                    </div>
                                    <div class="col-md-10">
                                        <h6>Only for what you need</h6>
                                        Occasionally we'll need to provide you with tax documents, which require your SSN.
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-2 mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit text-primary"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    </div>
                                    <div class="col-md-10">
                                        <h6>No credit score impact</h6>
                                        Applying for <?=WEB_TITLE?> Account will never impact your credit score
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div id="Div2">
                            <div class="form-group">
                                <input type="password" class="form-control wizard-required" id="ssn" name="ssn">
                                <label for="ssn" class="wizard-form-text-label">Social Security Number / TIN*</label>
                                <div class="wizard-form-error"></div>
                                <span class="wizard-password-eye"><i class="far fa-eye"></i></span>
                            </div>

                            <div class="form-group">
                                <input type="password" class="form-control wizard-required" id="confirm-ssn" name="confirm-ssn">
                                <label for="confirm-ssn" class="wizard-form-text-label">Confirm SSN / TIN*</label>
                                <div class="wizard-form-error"></div>
                                <span class="wizard-password-eye"><i class="far fa-eye"></i></span>
                            </div>

                            <div class="form-group">
                                <input type="date" class="form-control wizard-required" id="dob" name="dob">
                                <label for="dob" class="wizard-form-text-label">Date of Birth*</label>
                                <div class="wizard-form-error"></div>
                                <span class="wizard-password-eye"><i class="far fa-eye"></i></span>
                            </div>


                        </div>

                        <div class="form-group clearfix">
                            <a href="javascript:;" class="form-wizard-previous-btn float-left">Previous</a>
                            <a class="form-wizard-next-btn float-right" id="Button1" value="Click" onclick="switchVisible();">Next post</a>
                            <a href="javascript:;" class="form-wizard-next-btn float-right" id="nextShow">Next time</a>
                        </div>
                    </fieldset>
                    <fieldset class="wizard-fieldset text-white">
                        <div class="mt-3">
                            <div class="form-group">
                                <label for="frontDoc">Upload Profile Image</label>
                                <input class="form-control" type="file" name="profile_pic" id="frontDoc" required/>
                            </div>
                        </div>


                        <div class="mt-3">
                            <div class="form-group">
                                <label for="frontDoc">ID CARD FRONT</label>
                                <input class="form-control" type="file" name="frontID" id="frontDoc" required/>
                            </div>

                            <div class="form-group">
                                <label for="">ID CARD BACK</label>
                                <input class="form-control" type="file" name="backID" id="" required/>
                            </div>
                        </div>


                        <div class="form-group clearfix">
                            <a href="javascript:;" class="form-wizard-previous-btn float-left">Previous</a>
<!--                            <a href="javascript:;" class="form-wizard-submit float-right">Submit</a>-->
                            <button class="form-wizard-submit float-right btn btn-primary" type="submit" name="regSubmit">Submit</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</section>





<?php
require_once './layout/footer.php';
?>
