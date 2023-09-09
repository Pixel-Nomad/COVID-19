<?php
require('../../config.php');
session_start();
$alert = "";
$passwordSection = false;
if (isset($_SESSION['isloggedin'])) {
    if ($_SESSION['Verified']) {
        $connection = mysqli_connect($config['DB_URL'], $config['DB_USERNAME'], $config['DB_PASSWORD'], $config['DB_DATABASE']);
        if ($connection) {
            if (isset($_POST['submit3'])){
                $id = $_SESSION['user-id'];
                $query = "DELETE FROM `appointments` WHERE `user_id` = $id";
                $result = mysqli_query($connection,$query);
                if ($result) {
                    $query = "DELETE FROM `users` WHERE `user_id` = $id";
                    $result2 = mysqli_query($connection,$query);
                    if ($result2) {
                        session_unset();
                        session_destroy();
                        header('location: '.$config['URL'].'/user/login');
                        exit();
                    }
                }
            }
            if (isset($_POST['update']) && isset($_POST['password'])){
                $passwordSection = false;
                $id = $_SESSION['user-id'];
                $password   = $_POST['password'];
                if (strlen($password) >= 8) {
                    $password   = htmlentities($_POST['password']);
                    $encrypt     = sha1($password);
                    $query = "SELECT * FROM users WHERE user_id = $id AND `password` = '$encrypt'";
                    echo $query;
                    $result = mysqli_query($connection,$query);
                    $total  = mysqli_num_rows($result);
                    if ($total == 1){
                        $query = "UPDATE `users` SET
                        `fname` = '".
                        (($_SESSION['user-fname'] != $_POST['fname']) ? $_POST['fname'] : $_SESSION['user-fname'])
                        ."', `lname` = '".
                        (($_SESSION['user-lname'] != $_POST['lname']) ? $_POST['lname'] : $_SESSION['user-lname'])
                        ."', `contact` = '".
                        (($_SESSION['user-contact'] != $_POST['contact']) ? $_POST['contact'] : $_SESSION['user-contact'])
                        ."', `address` = '".
                        (($_SESSION['user-address'] != $_POST['address']) ? $_POST['address'] : $_SESSION['user-address'])
                        ."', `city` = '".
                        (($_SESSION['user-city'] != $_POST['city']) ? $_POST['city'] : $_SESSION['user-city'])
                        ."', `state` = '".
                        (($_SESSION['user-state'] != $_POST['state']) ? $_POST['state'] : $_SESSION['user-state'])
                        ."', `postal` = '".
                        (($_SESSION['user-postal'] != $_POST['postal']) ? $_POST['postal'] : $_SESSION['user-postal'])
                        ."', `country` = '".
                        (($_SESSION['user-country'] != $_POST['country']) ? $_POST['country'] : $_SESSION['user-country'])
                        ."' WHERE `user_id` = $id";
                        echo '<br>';
                        echo $query;
                        $result = mysqli_query($connection,$query);
                        if ($result) {
                            $_SESSION['user-fname'] = ($_SESSION['user-fname'] != $_POST['fname']) ? $_POST['fname'] : $_SESSION['user-fname'];
                            $_SESSION['user-lname'] = ($_SESSION['user-lname'] != $_POST['lname']) ? $_POST['lname'] : $_SESSION['user-lname'];
                            $_SESSION['user-contact'] = ($_SESSION['user-contact'] != $_POST['contact']) ? $_POST['contact'] : $_SESSION['user-contact'];
                            $_SESSION['user-address'] = ($_SESSION['user-address'] != $_POST['address']) ? $_POST['address'] : $_SESSION['user-address'];
                            $_SESSION['user-city'] = ($_SESSION['user-city'] != $_POST['city']) ? $_POST['city'] : $_SESSION['user-city'];
                            $_SESSION['user-state'] = ($_SESSION['user-state'] != $_POST['state']) ? $_POST['state'] : $_SESSION['user-state'];
                            $_SESSION['user-postal'] = ($_SESSION['user-postal'] != $_POST['postal']) ? $_POST['postal'] : $_SESSION['user-postal'];
                            $_SESSION['user-country'] = ($_SESSION['user-country'] != $_POST['country']) ? $_POST['country'] : $_SESSION['user-country'];
                            header('location: '.$config['URL'].'/user/settings');
                            exit();
                        } 
                    }
                } else {
                    $alert = '<div class="container mt-5">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Password must be 8 characters long
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>';
                }
            }
            if (isset($_POST['submit2']) && isset($_POST['password3'])){
                $passwordSection = true;
                $id = $_SESSION['user-id'];
                $password3  = $_POST['password3'];
                if (strlen($password3) >= 8) {
                    $password3   = htmlentities($_POST['password3']);
                    $encrypt3     = sha1($password3);
                    $query = "SELECT * FROM `users` WHERE `user_id`= $id AND `password` = '$encrypt3'";
                    $result = mysqli_query($connection,$query);
                    $total  = mysqli_num_rows($result);
                    if ($total == 1) {
                        $password   = $_POST['password'];
                        if (strlen($password) >= 8) {
                            $password2   = $_POST['password2'];
                            if ($password == $password2) {
                                $password   = htmlentities($_POST['password']);
                                $encrypt     = sha1($password);
                                $query = "UPDATE `users` SET `password`='$encrypt' WHERE `user_id` = $id";
                                $result = mysqli_query($connection,$query);
                                if ($result) {
                                    session_unset();
                                    session_destroy();
                                    header('location: '.$config['URL'].'/user/login');
                                    exit();
                                }
                            } else {
                                $alert = '<div class="container mt-5">
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        New password not matched 
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </div>';
                            }
                        } else {
                            $alert = '<div class="container mt-5">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    New password must be 8 characters long
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>';
                        }
                    } else {
                        $alert = '<div class="container mt-5">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Incorrect Password
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>';
                    }
                } else {
                    $alert = '<div class="container mt-5">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Password must be 8 characters long
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>';
                }
            }
        }
    } else {
        if (isset($_SERVER['HTTP_REFERER'])) {
            header('location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            header('location: ' . $config['URL']);
            exit();
        }
    }
} else {
    if (isset($_SERVER['HTTP_REFERER'])) {
        header('location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        header('location: ' . $config['URL']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href='<?php echo $config['URL'] ?>/assets/image/fav/fav.ico' type="image/x-icon">
    <link rel="shortcut icon" href='<?php echo $config['URL'] ?>/assets/image/fav/fav.ico' type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous" />
    <link rel="stylesheet" href="<?php echo $config['URL'] ?>/assets/css/global.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark navbar-hover">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="<?php echo $config['URL'] ?>/assets/image/logo/logo8.png" alt="" width="30" height="24">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link navbar-hover" aria-current="page" href="<?php echo $config['URL'] ?>/index.php#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link navbar-hover" aria-current="page" href="<?php echo $config['URL'] ?>/hospitals">Book Appointment</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link navbar-hover" aria-current="page" href="<?php echo $config['URL'] ?>/hospitals">Book Covid Test</a>
                    </li>
                    <?php
                    if (isset($_SESSION['isloggedin'])) {
                        if ($_SESSION['Verified']) {
                    ?>
                            <li class="nav-item">
                                <a class="nav-link navbar-hover" aria-current="page" href="<?php echo $config['URL'] ?>/user/appointments">My Appointments</a>
                            </li>
                    <?php
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <h1 class="text-center pt-3 pb-3">Account Settings</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <?php
                        if (!$passwordSection) {
                    ?>
                        <a href="#account-details" class="list-group-item list-group-item-action active" data-bs-toggle="tab">
                            <i class="fas fa-user me-2"></i> Account Details
                        </a>
                        <a href="#change-password" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                            <i class="fas fa-lock me-2"></i> Change Password
                        </a>
                        <a href="#delete-account" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                            <i class="fas fa-trash me-2"></i> Delete Account
                        </a>
                        <a href="#logout" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                    <?php
                        } else {
                    ?>
                        <a href="#account-details" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                            <i class="fas fa-user me-2"></i> Account Details
                        </a>
                        <a href="#change-password" class="list-group-item list-group-item-action active" data-bs-toggle="tab">
                            <i class="fas fa-lock me-2"></i> Change Password
                        </a>
                        <a href="#delete-account" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                            <i class="fas fa-trash me-2"></i> Delete Account
                        </a>
                        <a href="#logout" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                    <?php
                        }
                    ?>
                    
                </div>

            </div>
            <div class="col-md-9">
                <div class="tab-content">
                    <?php
                        if (!$passwordSection) {
                    ?>
                    <div id="account-details" class="tab-pane fade show active">
                    <?php
                        } else {
                    ?>
                    <div id="account-details" class="tab-pane fade">
                    <?php
                        }
                    ?>
                        <h4>Account Details</h4>
                        <form method="post">
                            <div class="row row-cols-md-2 d-none d-sm-none d-md-flex d-lg-flex d-xl-flex d-xxl-flex">
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" value="<?php echo $_SESSION['user-fname']?>" required name="fname" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput">First Name</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" value="<?php echo $_SESSION['user-address']?>"  required name="address" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput">Address</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" value="<?php echo $_SESSION['user-state']?>" required name="state" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput">State</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="country" id="floatingCountry">
                                            <option value="<?php echo $_SESSION['user-country']?>" disabled selected>Select your country</option>
                                            <option value="AF">Afghanistan</option>
                                            <option value="AX">Aland Islands</option>
                                            <option value="AL">Albania</option>
                                            <option value="DZ">Algeria</option>
                                            <option value="AS">American Samoa</option>
                                            <option value="AD">Andorra</option>
                                            <option value="AO">Angola</option>
                                            <option value="AI">Anguilla</option>
                                            <option value="AQ">Antarctica</option>
                                            <option value="AG">Antigua and Barbuda</option>
                                            <option value="AR">Argentina</option>
                                            <option value="AM">Armenia</option>
                                            <option value="AW">Aruba</option>
                                            <option value="AU">Australia</option>
                                            <option value="AT">Austria</option>
                                            <option value="AZ">Azerbaijan</option>
                                            <option value="BS">Bahamas</option>
                                            <option value="BH">Bahrain</option>
                                            <option value="BD">Bangladesh</option>
                                            <option value="BB">Barbados</option>
                                            <option value="BY">Belarus</option>
                                            <option value="BE">Belgium</option>
                                            <option value="BZ">Belize</option>
                                            <option value="BJ">Benin</option>
                                            <option value="BM">Bermuda</option>
                                            <option value="BT">Bhutan</option>
                                            <option value="BO">Bolivia</option>
                                            <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                                            <option value="BA">Bosnia and Herzegovina</option>
                                            <option value="BW">Botswana</option>
                                            <option value="BV">Bouvet Island</option>
                                            <option value="BR">Brazil</option>
                                            <option value="IO">British Indian Ocean Territory</option>
                                            <option value="BN">Brunei Darussalam</option>
                                            <option value="BG">Bulgaria</option>
                                            <option value="BF">Burkina Faso</option>
                                            <option value="BI">Burundi</option>
                                            <option value="KH">Cambodia</option>
                                            <option value="CM">Cameroon</option>
                                            <option value="CA">Canada</option>
                                            <option value="CV">Cape Verde</option>
                                            <option value="KY">Cayman Islands</option>
                                            <option value="CF">Central African Republic</option>
                                            <option value="TD">Chad</option>
                                            <option value="CL">Chile</option>
                                            <option value="CN">China</option>
                                            <option value="CX">Christmas Island</option>
                                            <option value="CC">Cocos (Keeling) Islands</option>
                                            <option value="CO">Colombia</option>
                                            <option value="KM">Comoros</option>
                                            <option value="CG">Congo</option>
                                            <option value="CD">Congo, Democratic Republic of the Congo</option>
                                            <option value="CK">Cook Islands</option>
                                            <option value="CR">Costa Rica</option>
                                            <option value="CI">Cote D'Ivoire</option>
                                            <option value="HR">Croatia</option>
                                            <option value="CU">Cuba</option>
                                            <option value="CW">Curacao</option>
                                            <option value="CY">Cyprus</option>
                                            <option value="CZ">Czech Republic</option>
                                            <option value="DK">Denmark</option>
                                            <option value="DJ">Djibouti</option>
                                            <option value="DM">Dominica</option>
                                            <option value="DO">Dominican Republic</option>
                                            <option value="EC">Ecuador</option>
                                            <option value="EG">Egypt</option>
                                            <option value="SV">El Salvador</option>
                                            <option value="GQ">Equatorial Guinea</option>
                                            <option value="ER">Eritrea</option>
                                            <option value="EE">Estonia</option>
                                            <option value="ET">Ethiopia</option>
                                            <option value="FK">Falkland Islands (Malvinas)</option>
                                            <option value="FO">Faroe Islands</option>
                                            <option value="FJ">Fiji</option>
                                            <option value="FI">Finland</option>
                                            <option value="FR">France</option>
                                            <option value="GF">French Guiana</option>
                                            <option value="PF">French Polynesia</option>
                                            <option value="TF">French Southern Territories</option>
                                            <option value="GA">Gabon</option>
                                            <option value="GM">Gambia</option>
                                            <option value="GE">Georgia</option>
                                            <option value="DE">Germany</option>
                                            <option value="GH">Ghana</option>
                                            <option value="GI">Gibraltar</option>
                                            <option value="GR">Greece</option>
                                            <option value="GL">Greenland</option>
                                            <option value="GD">Grenada</option>
                                            <option value="GP">Guadeloupe</option>
                                            <option value="GU">Guam</option>
                                            <option value="GT">Guatemala</option>
                                            <option value="GG">Guernsey</option>
                                            <option value="GN">Guinea</option>
                                            <option value="GW">Guinea-Bissau</option>
                                            <option value="GY">Guyana</option>
                                            <option value="HT">Haiti</option>
                                            <option value="HM">Heard Island and Mcdonald Islands</option>
                                            <option value="VA">Holy See (Vatican City State)</option>
                                            <option value="HN">Honduras</option>
                                            <option value="HK">Hong Kong</option>
                                            <option value="HU">Hungary</option>
                                            <option value="IS">Iceland</option>
                                            <option value="IN">India</option>
                                            <option value="ID">Indonesia</option>
                                            <option value="IR">Iran, Islamic Republic of</option>
                                            <option value="IQ">Iraq</option>
                                            <option value="IE">Ireland</option>
                                            <option value="IM">Isle of Man</option>
                                            <option value="IL">Israel</option>
                                            <option value="IT">Italy</option>
                                            <option value="JM">Jamaica</option>
                                            <option value="JP">Japan</option>
                                            <option value="JE">Jersey</option>
                                            <option value="JO">Jordan</option>
                                            <option value="KZ">Kazakhstan</option>
                                            <option value="KE">Kenya</option>
                                            <option value="KI">Kiribati</option>
                                            <option value="KP">Korea, Democratic People's Republic of</option>
                                            <option value="KR">Korea, Republic of</option>
                                            <option value="XK">Kosovo</option>
                                            <option value="KW">Kuwait</option>
                                            <option value="KG">Kyrgyzstan</option>
                                            <option value="LA">Lao People's Democratic Republic</option>
                                            <option value="LV">Latvia</option>
                                            <option value="LB">Lebanon</option>
                                            <option value="LS">Lesotho</option>
                                            <option value="LR">Liberia</option>
                                            <option value="LY">Libyan Arab Jamahiriya</option>
                                            <option value="LI">Liechtenstein</option>
                                            <option value="LT">Lithuania</option>
                                            <option value="LU">Luxembourg</option>
                                            <option value="MO">Macao</option>
                                            <option value="MK">Macedonia, the Former Yugoslav Republic of</option>
                                            <option value="MG">Madagascar</option>
                                            <option value="MW">Malawi</option>
                                            <option value="MY">Malaysia</option>
                                            <option value="MV">Maldives</option>
                                            <option value="ML">Mali</option>
                                            <option value="MT">Malta</option>
                                            <option value="MH">Marshall Islands</option>
                                            <option value="MQ">Martinique</option>
                                            <option value="MR">Mauritania</option>
                                            <option value="MU">Mauritius</option>
                                            <option value="YT">Mayotte</option>
                                            <option value="MX">Mexico</option>
                                            <option value="FM">Micronesia, Federated States of</option>
                                            <option value="MD">Moldova, Republic of</option>
                                            <option value="MC">Monaco</option>
                                            <option value="MN">Mongolia</option>
                                            <option value="ME">Montenegro</option>
                                            <option value="MS">Montserrat</option>
                                            <option value="MA">Morocco</option>
                                            <option value="MZ">Mozambique</option>
                                            <option value="MM">Myanmar</option>
                                            <option value="NA">Namibia</option>
                                            <option value="NR">Nauru</option>
                                            <option value="NP">Nepal</option>
                                            <option value="NL">Netherlands</option>
                                            <option value="AN">Netherlands Antilles</option>
                                            <option value="NC">New Caledonia</option>
                                            <option value="NZ">New Zealand</option>
                                            <option value="NI">Nicaragua</option>
                                            <option value="NE">Niger</option>
                                            <option value="NG">Nigeria</option>
                                            <option value="NU">Niue</option>
                                            <option value="NF">Norfolk Island</option>
                                            <option value="MP">Northern Mariana Islands</option>
                                            <option value="NO">Norway</option>
                                            <option value="OM">Oman</option>
                                            <option value="PK">Pakistan</option>
                                            <option value="PW">Palau</option>
                                            <option value="PS">Palestinian Territory, Occupied</option>
                                            <option value="PA">Panama</option>
                                            <option value="PG">Papua New Guinea</option>
                                            <option value="PY">Paraguay</option>
                                            <option value="PE">Peru</option>
                                            <option value="PH">Philippines</option>
                                            <option value="PN">Pitcairn</option>
                                            <option value="PL">Poland</option>
                                            <option value="PT">Portugal</option>
                                            <option value="PR">Puerto Rico</option>
                                            <option value="QA">Qatar</option>
                                            <option value="RE">Reunion</option>
                                            <option value="RO">Romania</option>
                                            <option value="RU">Russian Federation</option>
                                            <option value="RW">Rwanda</option>
                                            <option value="BL">Saint Barthelemy</option>
                                            <option value="SH">Saint Helena</option>
                                            <option value="KN">Saint Kitts and Nevis</option>
                                            <option value="LC">Saint Lucia</option>
                                            <option value="MF">Saint Martin</option>
                                            <option value="PM">Saint Pierre and Miquelon</option>
                                            <option value="VC">Saint Vincent and the Grenadines</option>
                                            <option value="WS">Samoa</option>
                                            <option value="SM">San Marino</option>
                                            <option value="ST">Sao Tome and Principe</option>
                                            <option value="SA">Saudi Arabia</option>
                                            <option value="SN">Senegal</option>
                                            <option value="RS">Serbia</option>
                                            <option value="CS">Serbia and Montenegro</option>
                                            <option value="SC">Seychelles</option>
                                            <option value="SL">Sierra Leone</option>
                                            <option value="SG">Singapore</option>
                                            <option value="SX">Sint Maarten</option>
                                            <option value="SK">Slovakia</option>
                                            <option value="SI">Slovenia</option>
                                            <option value="SB">Solomon Islands</option>
                                            <option value="SO">Somalia</option>
                                            <option value="ZA">South Africa</option>
                                            <option value="GS">South Georgia and the South Sandwich Islands</option>
                                            <option value="SS">South Sudan</option>
                                            <option value="ES">Spain</option>
                                            <option value="LK">Sri Lanka</option>
                                            <option value="SD">Sudan</option>
                                            <option value="SR">Suriname</option>
                                            <option value="SJ">Svalbard and Jan Mayen</option>
                                            <option value="SZ">Swaziland</option>
                                            <option value="SE">Sweden</option>
                                            <option value="CH">Switzerland</option>
                                            <option value="SY">Syrian Arab Republic</option>
                                            <option value="TW">Taiwan, Province of China</option>
                                            <option value="TJ">Tajikistan</option>
                                            <option value="TZ">Tanzania, United Republic of</option>
                                            <option value="TH">Thailand</option>
                                            <option value="TL">Timor-Leste</option>
                                            <option value="TG">Togo</option>
                                            <option value="TK">Tokelau</option>
                                            <option value="TO">Tonga</option>
                                            <option value="TT">Trinidad and Tobago</option>
                                            <option value="TN">Tunisia</option>
                                            <option value="TR">Turkey</option>
                                            <option value="TM">Turkmenistan</option>
                                            <option value="TC">Turks and Caicos Islands</option>
                                            <option value="TV">Tuvalu</option>
                                            <option value="UG">Uganda</option>
                                            <option value="UA">Ukraine</option>
                                            <option value="AE">United Arab Emirates</option>
                                            <option value="GB">United Kingdom</option>
                                            <option value="US">United States</option>
                                            <option value="UM">United States Minor Outlying Islands</option>
                                            <option value="UY">Uruguay</option>
                                            <option value="UZ">Uzbekistan</option>
                                            <option value="VU">Vanuatu</option>
                                            <option value="VE">Venezuela</option>
                                            <option value="VN">Viet Nam</option>
                                            <option value="VG">Virgin Islands, British</option>
                                            <option value="VI">Virgin Islands, U.s.</option>
                                            <option value="WF">Wallis and Futuna</option>
                                            <option value="EH">Western Sahara</option>
                                            <option value="YE">Yemen</option>
                                            <option value="ZM">Zambia</option>
                                            <option value="ZW">Zimbabwe</option>
                                            <!-- Add more countries as needed -->
                                        </select>
                                        <label for="floatingCountry">Country</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" required name="password" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput">Confirm Password</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" value="<?php echo $_SESSION['user-lname']?>" required name="lname" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput">Last Name</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" value="<?php echo $_SESSION['user-contact']?>" required name="contact" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput">Contact Number</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" value="<?php echo $_SESSION['user-city']?>" required name="city" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput">City</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" value="<?php echo $_SESSION['user-postal']?>" required name="postal" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput">Postal Code</label>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <input type="submit" class="btn btn-primary mt-2" value="Update" name="update">
                                    </div>
                                </div>
                                <?php
                                echo $alert
                                ?>
                            </div>
                        </form>
                        <form method="post">
                            <div class="row row-cols-1 row-cols-md-2 d-sm-flex d-md-none d-lg-none d-xl-none d-xxl-none">
                                <?php
                                echo $alert
                                ?>
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" value="<?php echo $_SESSION['user-fname']?>" required name="fname" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput">First Name</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" value="<?php echo $_SESSION['user-lname']?>" required name="lname" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput">Last Name</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" value="<?php echo $_SESSION['user-contact']?>" required name="contact" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput">Contact Number</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" value="<?php echo $_SESSION['user-address']?>" required name="address" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput">Address</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" value="<?php echo $_SESSION['user-city']?>" required name="city" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput">City</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" value="<?php echo $_SESSION['user-state']?>" required name="state" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput">State</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" value="<?php echo $_SESSION['user-postal']?>" required name="postal" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput">Postal Code</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="country" id="floatingCountry">
                                            <option value="<?php echo $_SESSION['user-country']?>" disabled selected>Select your country</option>
                                            <option value="AF">Afghanistan</option>
                                            <option value="AX">Aland Islands</option>
                                            <option value="AL">Albania</option>
                                            <option value="DZ">Algeria</option>
                                            <option value="AS">American Samoa</option>
                                            <option value="AD">Andorra</option>
                                            <option value="AO">Angola</option>
                                            <option value="AI">Anguilla</option>
                                            <option value="AQ">Antarctica</option>
                                            <option value="AG">Antigua and Barbuda</option>
                                            <option value="AR">Argentina</option>
                                            <option value="AM">Armenia</option>
                                            <option value="AW">Aruba</option>
                                            <option value="AU">Australia</option>
                                            <option value="AT">Austria</option>
                                            <option value="AZ">Azerbaijan</option>
                                            <option value="BS">Bahamas</option>
                                            <option value="BH">Bahrain</option>
                                            <option value="BD">Bangladesh</option>
                                            <option value="BB">Barbados</option>
                                            <option value="BY">Belarus</option>
                                            <option value="BE">Belgium</option>
                                            <option value="BZ">Belize</option>
                                            <option value="BJ">Benin</option>
                                            <option value="BM">Bermuda</option>
                                            <option value="BT">Bhutan</option>
                                            <option value="BO">Bolivia</option>
                                            <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                                            <option value="BA">Bosnia and Herzegovina</option>
                                            <option value="BW">Botswana</option>
                                            <option value="BV">Bouvet Island</option>
                                            <option value="BR">Brazil</option>
                                            <option value="IO">British Indian Ocean Territory</option>
                                            <option value="BN">Brunei Darussalam</option>
                                            <option value="BG">Bulgaria</option>
                                            <option value="BF">Burkina Faso</option>
                                            <option value="BI">Burundi</option>
                                            <option value="KH">Cambodia</option>
                                            <option value="CM">Cameroon</option>
                                            <option value="CA">Canada</option>
                                            <option value="CV">Cape Verde</option>
                                            <option value="KY">Cayman Islands</option>
                                            <option value="CF">Central African Republic</option>
                                            <option value="TD">Chad</option>
                                            <option value="CL">Chile</option>
                                            <option value="CN">China</option>
                                            <option value="CX">Christmas Island</option>
                                            <option value="CC">Cocos (Keeling) Islands</option>
                                            <option value="CO">Colombia</option>
                                            <option value="KM">Comoros</option>
                                            <option value="CG">Congo</option>
                                            <option value="CD">Congo, Democratic Republic of the Congo</option>
                                            <option value="CK">Cook Islands</option>
                                            <option value="CR">Costa Rica</option>
                                            <option value="CI">Cote D'Ivoire</option>
                                            <option value="HR">Croatia</option>
                                            <option value="CU">Cuba</option>
                                            <option value="CW">Curacao</option>
                                            <option value="CY">Cyprus</option>
                                            <option value="CZ">Czech Republic</option>
                                            <option value="DK">Denmark</option>
                                            <option value="DJ">Djibouti</option>
                                            <option value="DM">Dominica</option>
                                            <option value="DO">Dominican Republic</option>
                                            <option value="EC">Ecuador</option>
                                            <option value="EG">Egypt</option>
                                            <option value="SV">El Salvador</option>
                                            <option value="GQ">Equatorial Guinea</option>
                                            <option value="ER">Eritrea</option>
                                            <option value="EE">Estonia</option>
                                            <option value="ET">Ethiopia</option>
                                            <option value="FK">Falkland Islands (Malvinas)</option>
                                            <option value="FO">Faroe Islands</option>
                                            <option value="FJ">Fiji</option>
                                            <option value="FI">Finland</option>
                                            <option value="FR">France</option>
                                            <option value="GF">French Guiana</option>
                                            <option value="PF">French Polynesia</option>
                                            <option value="TF">French Southern Territories</option>
                                            <option value="GA">Gabon</option>
                                            <option value="GM">Gambia</option>
                                            <option value="GE">Georgia</option>
                                            <option value="DE">Germany</option>
                                            <option value="GH">Ghana</option>
                                            <option value="GI">Gibraltar</option>
                                            <option value="GR">Greece</option>
                                            <option value="GL">Greenland</option>
                                            <option value="GD">Grenada</option>
                                            <option value="GP">Guadeloupe</option>
                                            <option value="GU">Guam</option>
                                            <option value="GT">Guatemala</option>
                                            <option value="GG">Guernsey</option>
                                            <option value="GN">Guinea</option>
                                            <option value="GW">Guinea-Bissau</option>
                                            <option value="GY">Guyana</option>
                                            <option value="HT">Haiti</option>
                                            <option value="HM">Heard Island and Mcdonald Islands</option>
                                            <option value="VA">Holy See (Vatican City State)</option>
                                            <option value="HN">Honduras</option>
                                            <option value="HK">Hong Kong</option>
                                            <option value="HU">Hungary</option>
                                            <option value="IS">Iceland</option>
                                            <option value="IN">India</option>
                                            <option value="ID">Indonesia</option>
                                            <option value="IR">Iran, Islamic Republic of</option>
                                            <option value="IQ">Iraq</option>
                                            <option value="IE">Ireland</option>
                                            <option value="IM">Isle of Man</option>
                                            <option value="IL">Israel</option>
                                            <option value="IT">Italy</option>
                                            <option value="JM">Jamaica</option>
                                            <option value="JP">Japan</option>
                                            <option value="JE">Jersey</option>
                                            <option value="JO">Jordan</option>
                                            <option value="KZ">Kazakhstan</option>
                                            <option value="KE">Kenya</option>
                                            <option value="KI">Kiribati</option>
                                            <option value="KP">Korea, Democratic People's Republic of</option>
                                            <option value="KR">Korea, Republic of</option>
                                            <option value="XK">Kosovo</option>
                                            <option value="KW">Kuwait</option>
                                            <option value="KG">Kyrgyzstan</option>
                                            <option value="LA">Lao People's Democratic Republic</option>
                                            <option value="LV">Latvia</option>
                                            <option value="LB">Lebanon</option>
                                            <option value="LS">Lesotho</option>
                                            <option value="LR">Liberia</option>
                                            <option value="LY">Libyan Arab Jamahiriya</option>
                                            <option value="LI">Liechtenstein</option>
                                            <option value="LT">Lithuania</option>
                                            <option value="LU">Luxembourg</option>
                                            <option value="MO">Macao</option>
                                            <option value="MK">Macedonia, the Former Yugoslav Republic of</option>
                                            <option value="MG">Madagascar</option>
                                            <option value="MW">Malawi</option>
                                            <option value="MY">Malaysia</option>
                                            <option value="MV">Maldives</option>
                                            <option value="ML">Mali</option>
                                            <option value="MT">Malta</option>
                                            <option value="MH">Marshall Islands</option>
                                            <option value="MQ">Martinique</option>
                                            <option value="MR">Mauritania</option>
                                            <option value="MU">Mauritius</option>
                                            <option value="YT">Mayotte</option>
                                            <option value="MX">Mexico</option>
                                            <option value="FM">Micronesia, Federated States of</option>
                                            <option value="MD">Moldova, Republic of</option>
                                            <option value="MC">Monaco</option>
                                            <option value="MN">Mongolia</option>
                                            <option value="ME">Montenegro</option>
                                            <option value="MS">Montserrat</option>
                                            <option value="MA">Morocco</option>
                                            <option value="MZ">Mozambique</option>
                                            <option value="MM">Myanmar</option>
                                            <option value="NA">Namibia</option>
                                            <option value="NR">Nauru</option>
                                            <option value="NP">Nepal</option>
                                            <option value="NL">Netherlands</option>
                                            <option value="AN">Netherlands Antilles</option>
                                            <option value="NC">New Caledonia</option>
                                            <option value="NZ">New Zealand</option>
                                            <option value="NI">Nicaragua</option>
                                            <option value="NE">Niger</option>
                                            <option value="NG">Nigeria</option>
                                            <option value="NU">Niue</option>
                                            <option value="NF">Norfolk Island</option>
                                            <option value="MP">Northern Mariana Islands</option>
                                            <option value="NO">Norway</option>
                                            <option value="OM">Oman</option>
                                            <option value="PK">Pakistan</option>
                                            <option value="PW">Palau</option>
                                            <option value="PS">Palestinian Territory, Occupied</option>
                                            <option value="PA">Panama</option>
                                            <option value="PG">Papua New Guinea</option>
                                            <option value="PY">Paraguay</option>
                                            <option value="PE">Peru</option>
                                            <option value="PH">Philippines</option>
                                            <option value="PN">Pitcairn</option>
                                            <option value="PL">Poland</option>
                                            <option value="PT">Portugal</option>
                                            <option value="PR">Puerto Rico</option>
                                            <option value="QA">Qatar</option>
                                            <option value="RE">Reunion</option>
                                            <option value="RO">Romania</option>
                                            <option value="RU">Russian Federation</option>
                                            <option value="RW">Rwanda</option>
                                            <option value="BL">Saint Barthelemy</option>
                                            <option value="SH">Saint Helena</option>
                                            <option value="KN">Saint Kitts and Nevis</option>
                                            <option value="LC">Saint Lucia</option>
                                            <option value="MF">Saint Martin</option>
                                            <option value="PM">Saint Pierre and Miquelon</option>
                                            <option value="VC">Saint Vincent and the Grenadines</option>
                                            <option value="WS">Samoa</option>
                                            <option value="SM">San Marino</option>
                                            <option value="ST">Sao Tome and Principe</option>
                                            <option value="SA">Saudi Arabia</option>
                                            <option value="SN">Senegal</option>
                                            <option value="RS">Serbia</option>
                                            <option value="CS">Serbia and Montenegro</option>
                                            <option value="SC">Seychelles</option>
                                            <option value="SL">Sierra Leone</option>
                                            <option value="SG">Singapore</option>
                                            <option value="SX">Sint Maarten</option>
                                            <option value="SK">Slovakia</option>
                                            <option value="SI">Slovenia</option>
                                            <option value="SB">Solomon Islands</option>
                                            <option value="SO">Somalia</option>
                                            <option value="ZA">South Africa</option>
                                            <option value="GS">South Georgia and the South Sandwich Islands</option>
                                            <option value="SS">South Sudan</option>
                                            <option value="ES">Spain</option>
                                            <option value="LK">Sri Lanka</option>
                                            <option value="SD">Sudan</option>
                                            <option value="SR">Suriname</option>
                                            <option value="SJ">Svalbard and Jan Mayen</option>
                                            <option value="SZ">Swaziland</option>
                                            <option value="SE">Sweden</option>
                                            <option value="CH">Switzerland</option>
                                            <option value="SY">Syrian Arab Republic</option>
                                            <option value="TW">Taiwan, Province of China</option>
                                            <option value="TJ">Tajikistan</option>
                                            <option value="TZ">Tanzania, United Republic of</option>
                                            <option value="TH">Thailand</option>
                                            <option value="TL">Timor-Leste</option>
                                            <option value="TG">Togo</option>
                                            <option value="TK">Tokelau</option>
                                            <option value="TO">Tonga</option>
                                            <option value="TT">Trinidad and Tobago</option>
                                            <option value="TN">Tunisia</option>
                                            <option value="TR">Turkey</option>
                                            <option value="TM">Turkmenistan</option>
                                            <option value="TC">Turks and Caicos Islands</option>
                                            <option value="TV">Tuvalu</option>
                                            <option value="UG">Uganda</option>
                                            <option value="UA">Ukraine</option>
                                            <option value="AE">United Arab Emirates</option>
                                            <option value="GB">United Kingdom</option>
                                            <option value="US">United States</option>
                                            <option value="UM">United States Minor Outlying Islands</option>
                                            <option value="UY">Uruguay</option>
                                            <option value="UZ">Uzbekistan</option>
                                            <option value="VU">Vanuatu</option>
                                            <option value="VE">Venezuela</option>
                                            <option value="VN">Viet Nam</option>
                                            <option value="VG">Virgin Islands, British</option>
                                            <option value="VI">Virgin Islands, U.s.</option>
                                            <option value="WF">Wallis and Futuna</option>
                                            <option value="EH">Western Sahara</option>
                                            <option value="YE">Yemen</option>
                                            <option value="ZM">Zambia</option>
                                            <option value="ZW">Zimbabwe</option>
                                            <!-- Add more countries as needed -->
                                        </select>
                                        <label for="floatingCountry">Country</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" required name="password" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput">Confirm Password</label>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <input type="submit" class="btn btn-primary mt-2" value="Update" name="update">
                                    </div>
                                </div>
                            </div>

                        </form>
                        <br>
                    </div>
                    <?php
                        if (!$passwordSection) {
                    ?>
                    <div id="change-password" class="tab-pane fade">
                    <?php
                        } else {
                    ?>
                    <div id="change-password" class="tab-pane fade show active">
                    <?php
                        }
                    ?>
                        <h4>Change Password</h4>
                        <form method="post">
                            <div class="container">
                                <div class="row row-cols-1 row-cols-md-1 m-4">
                                    <div class="col">
                                        <div class="card-body">
                                            <?php
                                                echo $alert;
                                            ?>
                                            <div class="row row-cols-1 row-cols-md-1 m-4">
                                                <div class="col">
                                                    <div class="form-floating mb-3">
                                                        <input type="password" class="form-control" required name="password3" id="floatingInput" placeholder="name@example.com">
                                                        <label for="floatingInput">Enter Current Password</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input type="password" class="form-control" required name="password" id="floatingInput" placeholder="name@example.com">
                                                        <label for="floatingInput">Enter New Password</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input type="password" class="form-control" required name="password2" id="floatingInput" placeholder="name@example.com">
                                                        <label for="floatingInput">Re-Enter New Password</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-grid gap-2 col-6 mx-auto">
                                                <input type="submit" value="Update" class="btn btn-primary mt-3" name="submit2">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="delete-account" class="tab-pane fade">
                        <h4>Delete Account</h4>
                        <p>Are you sure you want to delete your account?</p>
                        <form method="post">
                            <input type="submit" class="btn btn-danger" name="submit3" value="Yes, Delete">
                        </form>
                    </div>
                    <div id="logout" class="tab-pane fade">
                        <h4>Logout</h4>
                        <p>Click the button below to logout:</p>
                        <a href='<?php echo $config['URL'] ?>/user/logout' class="btn btn-primary">Logout</a>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="<?php echo $config['URL'] ?>/assets/js/global.js"></script>
</body>

</html>