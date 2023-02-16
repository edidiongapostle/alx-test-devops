<?php

include_once("frontheader.php");
require_once("include/userClass.php");
require_once("include/loginFunction.php");


if(isset($_POST['SubmitContact'])){

   
    $FullName = $_POST['FullName'];
    $PhoneNumber = $_POST['PhoneNumber'];
    $email = $_POST['email'];
    $locationcus = $_POST['locationcus'];
    $Addresscus = $_POST['Addresscus'];
    $City = $_POST['City'];
    $Customer = $_POST['Customer'];
    $Messagecus = $_POST['Messagecus'];


    
    $sql9 = "INSERT INTO messages (FullName,PhoneNumber,locationcus,Addresscus,City,Customer,Messagecus) VALUES(:FullName,:PhoneNumber,:locationcus,:Addresscus,:City,:Customer,:Messagecus)";
    $stmt = $conn->prepare($sql9);
    $stmt->execute([
        'FullName'=>$FullName,
        'PhoneNumber' => $PhoneNumber,
        'locationcus' => $locationcus,
        'Addresscus' => $Addresscus,
        'City'=>$City,
        'Customer' => $Customer,
        'Messagecus' => $Messagecus,
    ]);

    // var_dump($sql9);
    // exit;
    
    if (true) {

        $message_body = "<p>".
                    "Full name: ".$FullName."<br>".
                    "Address: ".$Addresscus. "<br>".
                    "Email: ".$email."<br>".
                    "Mobile: ".$PhoneNumber."<br>".
                    "Location: ".$locationcus."<br>" .
                    "Address: ".$Addresscus."<br>".
                    "Are you a customer?: ".$Customer."</li>" .
                    "City: ".$City."<br>" .
                    "</p>";
        $message_body.= "<hr>";
        $message_body.= "<p>" .$Messagecus. "</p>";


        

        
        $APP_NAME = WEB_TITLE;
        $APP_URL = WEB_URL;
        
        $message = $sendMail->ContactMsg($message_body, $APP_NAME, $BANK_PHONE, $APP_URL);

        // User Email
        $subject = "Contact Form - $APP_NAME";
        $email_message->send_mail($email, $message, $subject);
        // Admin Email
        $subject = "Contact Form - $APP_NAME";
        $email_message->send_mail(WEB_EMAIL, $message, $subject);
        if (true) {
            header("Location:./contact.php");
        }

    }
}

?>

<!-- ##### Contact Area Start ##### -->
<section class="contact-area section-padding-100-0">



    <!-- ##### Google Maps ##### -->
    <div class="map-area">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3103.7513266889077!2d-77.03532775068048!3d38.929660952549575!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89b7c81f6552cdad%3A0x3008675489a399bb!2s3110%2014th%20St%20NW%20%23101%2C%20Washington%2C%20DC%2020010%2C%20USA!5e0!3m2!1sen!2suk!4v1594078250412!5m2!1sen!2suk"
            width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false"
            tabindex="0"></iframe>
        <!-- Contact Area -->
        <div class="contact---area">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <!-- Contact Area -->
                        <div class="contact-form-area contact-page">
                            <h4 class="mb-50">Send a message</h4>

                            <form method="POST">
                            <!-- <form method="POST" id="form-contact" class="contact_us form-theme"> -->

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text"
                                                placeholder="Full Name * (With Title e.g. Mr., Mrs, Dr., Chief)"
                                                name="FullName" class="form-control full_name"  required>
                                        </div>

                                        <div class="col-md-6">
                                            <input type="email" placeholder="Email Address *"
                                                class="form-control email_address" name="email" required>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="number" placeholder="Phone Number *" name="PhoneNumber"
                                                class="form-control phone_number" required>
                                        </div>

                                        <div class="col-md-6">
                                            <select name="locationcus" class="country_location form-control"  required>
                                                <option value="">-- Where Do You Live?</option>
                                                <option value="Afghanistan">Afghanistan</option>
                                                <option value="Albania">Albania</option>
                                                <option value="Algeria">Algeria</option>
                                                <option value="Andorra">Andorra</option>
                                                <option value="Angola">Angola</option>
                                                <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                                <option value="Argentina">Argentina</option>
                                                <option value="Armenia">Armenia</option>
                                                <option value="Australia">Australia</option>
                                                <option value="Austria">Austria</option>
                                                <option value="Azerbaijan">Azerbaijan</option>
                                                <option value="Bahamas, The">Bahamas, The</option>
                                                <option value="Bahrain">Bahrain</option>
                                                <option value="Bangladesh">Bangladesh</option>
                                                <option value="Barbados">Barbados</option>
                                                <option value="Belarus">Belarus</option>
                                                <option value="Belgium">Belgium</option>
                                                <option value="Belize">Belize</option>
                                                <option value="Benin">Benin</option>
                                                <option value="Bhutan">Bhutan</option>
                                                <option value="Bolivia">Bolivia</option>
                                                <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                                <option value="Botswana">Botswana</option>
                                                <option value="Brazil">Brazil</option>
                                                <option value="Brunei">Brunei</option>
                                                <option value="Bulgaria">Bulgaria</option>
                                                <option value="Burkina Faso">Burkina Faso</option>
                                                <option value="Burma">Burma</option>
                                                <option value="Burundi">Burundi</option>
                                                <option value="Cambodia">Cambodia</option>
                                                <option value="Cameroon">Cameroon</option>
                                                <option value="Canada">Canada</option>
                                                <option value="Cape Verde">Cape Verde</option>
                                                <option value="Central Africa">Central Africa</option>
                                                <option value="Chad">Chad</option>
                                                <option value="Chile">Chile</option>
                                                <option value="China">China</option>
                                                <option value="Colombia">Colombia</option>
                                                <option value="Comoros">Comoros</option>
                                                <option value="Congo, Democratic Republic of the">Congo, Democratic
                                                    Republic of the</option>
                                                <option value="Costa Rica">Costa Rica</option>
                                                <option value="Cote dIvoire">Cote dIvoire</option>
                                                <option value="Crete">Crete</option>
                                                <option value="Croatia">Croatia</option>
                                                <option value="Cuba">Cuba</option>
                                                <option value="Cyprus">Cyprus</option>
                                                <option value="Czech Republic">Czech Republic</option>
                                                <option value="Denmark">Denmark</option>
                                                <option value="Djibouti">Djibouti</option>
                                                <option value="Dominican Republic">Dominican Republic</option>
                                                <option value="East Timor">East Timor</option>
                                                <option value="Ecuador">Ecuador</option>
                                                <option value="Egypt">Egypt</option>
                                                <option value="El Salvador">El Salvador</option>
                                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                <option value="Eritrea">Eritrea</option>
                                                <option value="Estonia">Estonia</option>
                                                <option value="Ethiopia">Ethiopia</option>
                                                <option value="Fiji">Fiji</option>
                                                <option value="Finland">Finland</option>
                                                <option value="France">France</option>
                                                <option value="Gabon">Gabon</option>
                                                <option value="Gambia, The">Gambia, The</option>
                                                <option value="Georgia">Georgia</option>
                                                <option value="Germany">Germany</option>
                                                <option value="Ghana">Ghana</option>
                                                <option value="Greece">Greece</option>
                                                <option value="Grenada">Grenada</option>
                                                <option value="Guadeloupe">Guadeloupe</option>
                                                <option value="Guatemala">Guatemala</option>
                                                <option value="Guinea">Guinea</option>
                                                <option value="Guinea-Bissau">Guinea-Bissau</option>
                                                <option value="Guyana">Guyana</option>
                                                <option value="Haiti">Haiti</option>
                                                <option value="Holy See">Holy See</option>
                                                <option value="Honduras">Honduras</option>
                                                <option value="Hong Kong">Hong Kong</option>
                                                <option value="Hungary">Hungary</option>
                                                <option value="Iceland">Iceland</option>
                                                <option value="India">India</option>
                                                <option value="Indonesia">Indonesia</option>
                                                <option value="Iran">Iran</option>
                                                <option value="Iraq">Iraq</option>
                                                <option value="Ireland">Ireland</option>
                                                <option value="Israel">Israel</option>
                                                <option value="Italy">Italy</option>
                                                <option value="Ivory Coast">Ivory Coast</option>
                                                <option value="Jamaica">Jamaica</option>
                                                <option value="Japan">Japan</option>
                                                <option value="Jordan">Jordan</option>
                                                <option value="Kazakhstan">Kazakhstan</option>
                                                <option value="Kenya">Kenya</option>
                                                <option value="Kiribati">Kiribati</option>
                                                <option value="Korea, North">Korea, North</option>
                                                <option value="Korea, South">Korea, South</option>
                                                <option value="Kosovo">Kosovo</option>
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
                                                <option value="Macau">Macau</option>
                                                <option value="Macedonia">Macedonia</option>
                                                <option value="Madagascar">Madagascar</option>
                                                <option value="Malawi">Malawi</option>
                                                <option value="Malaysia">Malaysia</option>
                                                <option value="Maldives">Maldives</option>
                                                <option value="Mali">Mali</option>
                                                <option value="Malta">Malta</option>
                                                <option value="Marshall Islands">Marshall Islands</option>
                                                <option value="Mauritania">Mauritania</option>
                                                <option value="Mauritius">Mauritius</option>
                                                <option value="Mexico">Mexico</option>
                                                <option value="Micronesia">Micronesia</option>
                                                <option value="Moldova">Moldova</option>
                                                <option value="Monaco">Monaco</option>
                                                <option value="Mongolia">Mongolia</option>
                                                <option value="Montenegro">Montenegro</option>
                                                <option value="Morocco">Morocco</option>
                                                <option value="Mozambique">Mozambique</option>
                                                <option value="Namibia">Namibia</option>
                                                <option value="Nauru">Nauru</option>
                                                <option value="Nepal">Nepal</option>
                                                <option value="Netherlands">Netherlands</option>
                                                <option value="New Zealand">New Zealand</option>
                                                <option value="Nicaragua">Nicaragua</option>
                                                <option value="Niger">Niger</option>
                                                <option value="Nigeria">Nigeria</option>
                                                <option value="North Korea">North Korea</option>
                                                <option value="Norway">Norway</option>
                                                <option value="Oman">Oman</option>
                                                <option value="Pakistan">Pakistan</option>
                                                <option value="Palau">Palau</option>
                                                <option value="Panama">Panama</option>
                                                <option value="Papua New Guinea">Papua New Guinea</option>
                                                <option value="Paraguay">Paraguay</option>
                                                <option value="Peru">Peru</option>
                                                <option value="Philippines">Philippines</option>
                                                <option value="Poland">Poland</option>
                                                <option value="Portugal">Portugal</option>
                                                <option value="Qatar">Qatar</option>
                                                <option value="Romania">Romania</option>
                                                <option value="Russia">Russia</option>
                                                <option value="Rwanda">Rwanda</option>
                                                <option value="Saint Lucia">Saint Lucia</option>
                                                <option value="Saint Vincent and the Grenadines">Saint Vincent and the
                                                    Grenadines</option>
                                                <option value="Samoa">Samoa</option>
                                                <option value="San Marino">San Marino</option>
                                                <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                                <option value="Saudi Arabia">Saudi Arabia</option>
                                                <option value="Scotland">Scotland</option>
                                                <option value="Senegal">Senegal</option>
                                                <option value="Serbia">Serbia</option>
                                                <option value="Seychelles">Seychelles</option>
                                                <option value="Sierra Leone">Sierra Leone</option>
                                                <option value="Singapore">Singapore</option>
                                                <option value="Slovakia">Slovakia</option>
                                                <option value="Slovenia">Slovenia</option>
                                                <option value="Solomon Islands">Solomon Islands</option>
                                                <option value="Somalia">Somalia</option>
                                                <option value="South Africa">South Africa</option>
                                                <option value="South Korea">South Korea</option>
                                                <option value="Spain">Spain</option>
                                                <option value="Sri Lanka">Sri Lanka</option>
                                                <option value="Sudan">Sudan</option>
                                                <option value="Suriname">Suriname</option>
                                                <option value="Swaziland">Swaziland</option>
                                                <option value="Sweden">Sweden</option>
                                                <option value="Switzerland">Switzerland</option>
                                                <option value="Syria">Syria</option>
                                                <option value="Taiwan">Taiwan</option>
                                                <option value="Tajikistan">Tajikistan</option>
                                                <option value="Tanzania">Tanzania</option>
                                                <option value="Thailand">Thailand</option>
                                                <option value="Tibet">Tibet</option>
                                                <option value="Timor-Leste">Timor-Leste</option>
                                                <option value="Togo">Togo</option>
                                                <option value="Tonga">Tonga</option>
                                                <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                                <option value="Tunisia">Tunisia</option>
                                                <option value="Turkey">Turkey</option>
                                                <option value="Turkmenistan">Turkmenistan</option>
                                                <option value="Tuvalu">Tuvalu</option>
                                                <option value="Uganda">Uganda</option>
                                                <option value="Ukraine">Ukraine</option>
                                                <option value="United Arab Emirates">United Arab Emirates</option>
                                                <option value="United Kingdom">United Kingdom</option>
                                                <option value="United States">United States</option>
                                                <option value="Uruguay">Uruguay</option>
                                                <option value="Uzbekistan">Uzbekistan</option>
                                                <option value="Vanuatu">Vanuatu</option>
                                                <option value="Venezuela">Venezuela</option>
                                                <option value="Vietnam">Vietnam</option>
                                                <option value="Yemen">Yemen</option>
                                                <option value="Zambia">Zambia</option>
                                                <option value="Zimbabwe">Zimbabwe</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" placeholder="Address *" name="Addresscus"
                                                class="form-control address"  required>
                                        </div>

                                        <div class="col-md-6">
                                            <input type="text" placeholder="City *" name="City"
                                                class="form-control city"  required>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label style="color:#fff">Are you a customer of
                                                <?= $pageTitle ?>?*</label><br />
                                            <select name="Customer" class="customer form-control" required>
                                                <option value="">-- Please Select --</option>
                                                <option value="Yes, I am">Yes</option>
                                                <option value="No, I'm Not">No</option>
                                            </select>
                                        </div>

                                        <div class="col-md-12">
                                            <textarea placeholder="Comment *" name="Messagecus"
                                                class="form-control message" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <input type="submit" name="SubmitContact" value="Send Message"
                                    class="submit btn btn-primary">
                                <!-- <button type="submit" class="btn btn-primary" name="SubmitContact" value="">Send
                                    Message</button> -->

                            </form>

                            <!-- <span style="background-color:white;" id="request_msg"></span> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ##### Contact Area End ##### -->

<!-- ##### Newsletter Area Start ###### -->
<section class="newsletter-area section-padding-100 bg-img jarallax" style="background-image: url(img/bg-img/6.jpg);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-lg-8">
                <div class="nl-content text-center">
                    <h2>Subscribe to our newsletter</h2>
                    <form action="#" method="post">
                        <input type="email" name="nl-email" id="nlemail" placeholder="Your e-mail">
                        <button type="submit">Subscribe</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- ##### Newsletter Area End ###### -->

<?php

    include_once("frontfooter.php");
    
    ?>