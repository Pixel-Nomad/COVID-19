<?php
require('../../config.php');
session_start();
$alert = "";
$passwordSection = false;
if (isset($_SESSION['isloggedin'])) {
    if ($_SESSION['Verified']) {
        $connection = mysqli_connect($config['DB_URL'], $config['DB_USERNAME'], $config['DB_PASSWORD'], $config['DB_DATABASE']);
        if ($connection) {
            if (isset($_POST['submit3'])) {
                $id = $_SESSION['user-id'];
                $query = "DELETE FROM `appointments` WHERE `user_id` = $id";
                $result = mysqli_query($connection, $query);
                if ($result) {
                    $query = "DELETE FROM `users` WHERE `user_id` = $id";
                    $result2 = mysqli_query($connection, $query);
                    if ($result2) {
                        session_unset();
                        session_destroy();
                        header('location: ' . $config['URL'] . '/user/login');
                        exit();
                    }
                }
            }
            if (isset($_POST['update']) && isset($_POST['password'])) {
                $passwordSection = false;
                $id = $_SESSION['user-id'];
                $password   = $_POST['password'];
                if (strlen($password) >= 8) {
                    $password   = htmlentities($_POST['password']);
                    $encrypt     = sha1($password);
                    $query = "SELECT * FROM users WHERE user_id = $id AND `password` = '$encrypt'";
                    $result = mysqli_query($connection, $query);
                    $total  = mysqli_num_rows($result);
                    if ($total == 1) {
                        $query = "UPDATE `users` SET
                        `fname` = '" .
                            (($_SESSION['user-fname'] != $_POST['fname']) ? $_POST['fname'] : $_SESSION['user-fname'])
                            . "', `lname` = '" .
                            (($_SESSION['user-lname'] != $_POST['lname']) ? $_POST['lname'] : $_SESSION['user-lname'])
                            . "', `contact` = '" .
                            (($_SESSION['user-contact'] != $_POST['contact']) ? $_POST['contact'] : $_SESSION['user-contact'])
                            . "', `address` = '" .
                            (($_SESSION['user-address'] != $_POST['address']) ? $_POST['address'] : $_SESSION['user-address'])
                            . "', `city` = '" .
                            (($_SESSION['user-city'] != $_POST['city']) ? $_POST['city'] : $_SESSION['user-city'])
                            . "', `state` = '" .
                            (($_SESSION['user-state'] != $_POST['state']) ? $_POST['state'] : $_SESSION['user-state'])
                            . "', `postal` = '" .
                            (($_SESSION['user-postal'] != $_POST['postal']) ? $_POST['postal'] : $_SESSION['user-postal'])
                            . "', `country` = '" .
                            (($_SESSION['user-country'] != $_POST['country']) ? $_POST['country'] : $_SESSION['user-country'])
                            . "' WHERE `user_id` = $id";
                        $result = mysqli_query($connection, $query);
                        if ($result) {
                            $_SESSION['user-fname'] = ($_SESSION['user-fname'] != $_POST['fname']) ? $_POST['fname'] : $_SESSION['user-fname'];
                            $_SESSION['user-lname'] = ($_SESSION['user-lname'] != $_POST['lname']) ? $_POST['lname'] : $_SESSION['user-lname'];
                            $_SESSION['user-contact'] = ($_SESSION['user-contact'] != $_POST['contact']) ? $_POST['contact'] : $_SESSION['user-contact'];
                            $_SESSION['user-address'] = ($_SESSION['user-address'] != $_POST['address']) ? $_POST['address'] : $_SESSION['user-address'];
                            $_SESSION['user-city'] = ($_SESSION['user-city'] != $_POST['city']) ? $_POST['city'] : $_SESSION['user-city'];
                            $_SESSION['user-state'] = ($_SESSION['user-state'] != $_POST['state']) ? $_POST['state'] : $_SESSION['user-state'];
                            $_SESSION['user-postal'] = ($_SESSION['user-postal'] != $_POST['postal']) ? $_POST['postal'] : $_SESSION['user-postal'];
                            $_SESSION['user-country'] = ($_SESSION['user-country'] != $_POST['country']) ? $_POST['country'] : $_SESSION['user-country'];
                            $alert = '<div class="container mt-5">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    Profile Updated
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>';
                            // header('location: '.$config['URL'].'/user/settings');
                            // exit();
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
            if (isset($_POST['submit2']) && isset($_POST['password3'])) {
                $passwordSection = true;
                $id = $_SESSION['user-id'];
                $password3  = $_POST['password3'];
                if (strlen($password3) >= 8) {
                    $password3   = htmlentities($_POST['password3']);
                    $encrypt3     = sha1($password3);
                    $query = "SELECT * FROM `users` WHERE `user_id`= $id AND `password` = '$encrypt3'";
                    $result = mysqli_query($connection, $query);
                    $total  = mysqli_num_rows($result);
                    if ($total == 1) {
                        $password   = $_POST['password'];
                        if (strlen($password) >= 8) {
                            $password2   = $_POST['password2'];
                            if ($password == $password2) {
                                $password   = htmlentities($_POST['password']);
                                $encrypt     = sha1($password);
                                $query = "UPDATE `users` SET `password`='$encrypt' WHERE `user_id` = $id";
                                $result = mysqli_query($connection, $query);
                                if ($result) {
                                    session_unset();
                                    session_destroy();
                                    header('location: ' . $config['URL'] . '/user/login');
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
                        <a class="nav-link  " aria-current="page" href="<?php echo $config['URL'] ?>/index.php#home">Home</a>
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
                                <a class="nav-link" aria-current="page" href="<?php echo $config['URL'] ?>/user/appointments">My Appointments</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link navbar-hover" aria-current="page" href="<?php echo $config['URL'] ?>/user/reports">My Results/Reports</a>
                            </li>
                            <?php
                            if ($_SESSION['user-role'] != 'user') {
                            ?>
                                <li class="nav-item">
                                    <a class="nav-link navbar-hover" aria-current="page" href="<?php echo $config['URL'] ?>/management/admin">Admin Panel</a>
                                </li>
                    <?php
                            }
                        }
                    }
                    ?>
                </ul>
                <ul class="navbar-nav">
                    <?php
                    if (isset($_SESSION['isloggedin'])) {
                        if ($_SESSION['Verified']) {
                    ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $config['URL'] ?>/user/logout"><button type="button" class="btn btn-outline-danger">Logout</button></a>
                            </li>
                        <?php
                        } else {
                        ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $config['URL'] ?>/user/verify"><button type="button" class="btn btn-outline-warning">Verify</button></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $config['URL'] ?>/user/logout"><button type="button" class="btn btn-outline-danger">Logout</button></a>
                            </li>
                        <?php
                        }
                    } else {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $config['URL'] ?>/user/login"><button type="button" class="btn btn-outline-success">Login</button></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $config['URL'] ?>/user/register"><button type="button" class="btn btn-outline-success">Reigster</button></a>
                        </li>
                    <?php
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
                                            <input type="text" class="form-control" value="<?php echo $_SESSION['user-fname'] ?>" required name="fname" id="floatingInput" placeholder="name@example.com">
                                            <label for="floatingInput">First Name</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" value="<?php echo $_SESSION['user-address'] ?>" required name="address" id="floatingInput" placeholder="name@example.com">
                                            <label for="floatingInput">Address</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" value="<?php echo $_SESSION['user-state'] ?>" required name="state" id="floatingInput" placeholder="name@example.com">
                                            <label for="floatingInput">State</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" name="country" id="floatingCountry">
                                                <option value="<?php echo $_SESSION['user-country'] ?>" selected><?php echo $_SESSION['user-country'] ?></option>
                                                <option value="Afghanistan">Afghanistan</option>
                                                <option value="Aland Islands">Aland Islands</option>
                                                <option value="Albania">Albania</option>
                                                <option value="Algeria">Algeria</option>
                                                <option value="American Samoa">American Samoa</option>
                                                <option value="Andorra">Andorra</option>
                                                <option value="Angola">Angola</option>
                                                <option value="Anguilla">Anguilla</option>
                                                <option value="Antarctica">Antarctica</option>
                                                <option value="Antigua and Barbuda">Antigua and Barbuda</option>
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
                                                <option value="Bonaire, Sint Eustatius and Saba">Bonaire, Sint Eustatius and Saba</option>
                                                <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                                <option value="Botswana">Botswana</option>
                                                <option value="Bouvet Island">Bouvet Island</option>
                                                <option value="Brazil">Brazil</option>
                                                <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                                                <option value="Brunei Darussalam">Brunei Darussalam</option>
                                                <option value="Bulgaria">Bulgaria</option>
                                                <option value="Burkina Faso">Burkina Faso</option>
                                                <option value="Burundi">Burundi</option>
                                                <option value="Cambodia">Cambodia</option>
                                                <option value="Cameroon">Cameroon</option>
                                                <option value="Canada">Canada</option>
                                                <option value="Cape Verde">Cape Verde</option>
                                                <option value="Cayman Islands">Cayman Islands</option>
                                                <option value="Central African Republic">Central African Republic</option>
                                                <option value="Chad">Chad</option>
                                                <option value="Chile">Chile</option>
                                                <option value="China">China</option>
                                                <option value="Christmas Island">Christmas Island</option>
                                                <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                                                <option value="Colombia">Colombia</option>
                                                <option value="Comoros">Comoros</option>
                                                <option value="Congo">Congo</option>
                                                <option value="Congo, Democratic Republic of the Congo">Congo, Democratic Republic of the Congo</option>
                                                <option value="Cook Islands">Cook Islands</option>
                                                <option value="Costa Rica">Costa Rica</option>
                                                <option value="Cote D'Ivoire">Cote D'Ivoire</option>
                                                <option value="Croatia">Croatia</option>
                                                <option value="Cuba">Cuba</option>
                                                <option value="Curacao">Curacao</option>
                                                <option value="Cyprus">Cyprus</option>
                                                <option value="Czech Republic">Czech Republic</option>
                                                <option value="Denmark">Denmark</option>
                                                <option value="Djibouti">Djibouti</option>
                                                <option value="Dominica">Dominica</option>
                                                <option value="Dominican Republic">Dominican Republic</option>
                                                <option value="Ecuador">Ecuador</option>
                                                <option value="Egypt">Egypt</option>
                                                <option value="El Salvador">El Salvador</option>
                                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                <option value="Eritrea">Eritrea</option>
                                                <option value="Estonia">Estonia</option>
                                                <option value="Ethiopia">Ethiopia</option>
                                                <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                                                <option value="Faroe Islands">Faroe Islands</option>
                                                <option value="Fiji">Fiji</option>
                                                <option value="Finland">Finland</option>
                                                <option value="France">France</option>
                                                <option value="French Guiana">French Guiana</option>
                                                <option value="French Polynesia">French Polynesia</option>
                                                <option value="French Southern Territories">French Southern Territories</option>
                                                <option value="Gabon">Gabon</option>
                                                <option value="Gambia">Gambia</option>
                                                <option value="Georgia">Georgia</option>
                                                <option value="Germany">Germany</option>
                                                <option value="Ghana">Ghana</option>
                                                <option value="Gibraltar">Gibraltar</option>
                                                <option value="Greece">Greece</option>
                                                <option value="Greenland">Greenland</option>
                                                <option value="Grenada">Grenada</option>
                                                <option value="Guadeloupe">Guadeloupe</option>
                                                <option value="Guam">Guam</option>
                                                <option value="Guatemala">Guatemala</option>
                                                <option value="Guernsey">Guernsey</option>
                                                <option value="Guinea">Guinea</option>
                                                <option value="Guinea-Bissau">Guinea-Bissau</option>
                                                <option value="Guyana">Guyana</option>
                                                <option value="Haiti">Haiti</option>
                                                <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                                                <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                                                <option value="Honduras">Honduras</option>
                                                <option value="Hong Kong">Hong Kong</option>
                                                <option value="Hungary">Hungary</option>
                                                <option value="Iceland">Iceland</option>
                                                <option value="India">India</option>
                                                <option value="Indonesia">Indonesia</option>
                                                <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                                                <option value="Iraq">Iraq</option>
                                                <option value="Ireland">Ireland</option>
                                                <option value="Isle of Man">Isle of Man</option>
                                                <option value="Israel">Israel</option>
                                                <option value="Italy">Italy</option>
                                                <option value="Jamaica">Jamaica</option>
                                                <option value="Japan">Japan</option>
                                                <option value="Jersey">Jersey</option>
                                                <option value="Jordan">Jordan</option>
                                                <option value="Kazakhstan">Kazakhstan</option>
                                                <option value="Kenya">Kenya</option>
                                                <option value="Kiribati">Kiribati</option>
                                                <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                                                <option value="Korea, Republic of">Korea, Republic of</option>
                                                <option value="Kosovo">Kosovo</option>
                                                <option value="Kuwait">Kuwait</option>
                                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                                                <option value="Latvia">Latvia</option>
                                                <option value="Lebanon">Lebanon</option>
                                                <option value="Lesotho">Lesotho</option>
                                                <option value="Liberia">Liberia</option>
                                                <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                                                <option value="Liechtenstein">Liechtenstein</option>
                                                <option value="Lithuania">Lithuania</option>
                                                <option value="Luxembourg">Luxembourg</option>
                                                <option value="Macao">Macao</option>
                                                <option value="Macedonia, the Former Yugoslav Republic of">Macedonia, the Former Yugoslav Republic of</option>
                                                <option value="Madagascar">Madagascar</option>
                                                <option value="Malawi">Malawi</option>
                                                <option value="Malaysia">Malaysia</option>
                                                <option value="Maldives">Maldives</option>
                                                <option value="Mali">Mali</option>
                                                <option value="Malta">Malta</option>
                                                <option value="Marshall Islands">Marshall Islands</option>
                                                <option value="Martinique">Martinique</option>
                                                <option value="Mauritania">Mauritania</option>
                                                <option value="Mauritius">Mauritius</option>
                                                <option value="Mayotte">Mayotte</option>
                                                <option value="Mexico">Mexico</option>
                                                <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                                                <option value="Moldova, Republic of">Moldova, Republic of</option>
                                                <option value="Monaco">Monaco</option>
                                                <option value="Mongolia">Mongolia</option>
                                                <option value="Montenegro">Montenegro</option>
                                                <option value="Montserrat">Montserrat</option>
                                                <option value="Morocco">Morocco</option>
                                                <option value="Mozambique">Mozambique</option>
                                                <option value="Myanmar">Myanmar</option>
                                                <option value="Namibia">Namibia</option>
                                                <option value="Nauru">Nauru</option>
                                                <option value="Nepal">Nepal</option>
                                                <option value="Netherlands">Netherlands</option>
                                                <option value="Netherlands Antilles">Netherlands Antilles</option>
                                                <option value="New Caledonia">New Caledonia</option>
                                                <option value="New Zealand">New Zealand</option>
                                                <option value="Nicaragua">Nicaragua</option>
                                                <option value="Niger">Niger</option>
                                                <option value="Nigeria">Nigeria</option>
                                                <option value="Niue">Niue</option>
                                                <option value="Norfolk Island">Norfolk Island</option>
                                                <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                                <option value="Norway">Norway</option>
                                                <option value="Oman">Oman</option>
                                                <option value="Pakistan">Pakistan</option>
                                                <option value="Palau">Palau</option>
                                                <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                                                <option value="Panama">Panama</option>
                                                <option value="Papua New Guinea">Papua New Guinea</option>
                                                <option value="Paraguay">Paraguay</option>
                                                <option value="Peru">Peru</option>
                                                <option value="Philippines">Philippines</option>
                                                <option value="Pitcairn">Pitcairn</option>
                                                <option value="Poland">Poland</option>
                                                <option value="Portugal">Portugal</option>
                                                <option value="Puerto Rico">Puerto Rico</option>
                                                <option value="Qatar">Qatar</option>
                                                <option value="Reunion">Reunion</option>
                                                <option value="Romania">Romania</option>
                                                <option value="Russian Federation">Russian Federation</option>
                                                <option value="Rwanda">Rwanda</option>
                                                <option value="Saint Barthelemy">Saint Barthelemy</option>
                                                <option value="Saint Helena">Saint Helena</option>
                                                <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                                <option value="Saint Lucia">Saint Lucia</option>
                                                <option value="Saint Martin">Saint Martin</option>
                                                <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                                                <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                                                <option value="Samoa">Samoa</option>
                                                <option value="San Marino">San Marino</option>
                                                <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                                <option value="Saudi Arabia">Saudi Arabia</option>
                                                <option value="Senegal">Senegal</option>
                                                <option value="Serbia">Serbia</option>
                                                <option value="Serbia and Montenegro">Serbia and Montenegro</option>
                                                <option value="Seychelles">Seychelles</option>
                                                <option value="Sierra Leone">Sierra Leone</option>
                                                <option value="Singapore">Singapore</option>
                                                <option value="Sint Maarten">Sint Maarten</option>
                                                <option value="Slovakia">Slovakia</option>
                                                <option value="Slovenia">Slovenia</option>
                                                <option value="Solomon Islands">Solomon Islands</option>
                                                <option value="Somalia">Somalia</option>
                                                <option value="South Africa">South Africa</option>
                                                <option value="South Georgia and the South Sandwich Islands">South Georgia and the South Sandwich Islands</option>
                                                <option value="South Sudan">South Sudan</option>
                                                <option value="Spain">Spain</option>
                                                <option value="Sri Lanka">Sri Lanka</option>
                                                <option value="Sudan">Sudan</option>
                                                <option value="Suriname">Suriname</option>
                                                <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                                                <option value="Swaziland">Swaziland</option>
                                                <option value="Sweden">Sweden</option>
                                                <option value="Switzerland">Switzerland</option>
                                                <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                                                <option value="Taiwan, Province of China">Taiwan, Province of China</option>
                                                <option value="Tajikistan">Tajikistan</option>
                                                <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                                                <option value="Thailand">Thailand</option>
                                                <option value="Timor-Leste">Timor-Leste</option>
                                                <option value="Togo">Togo</option>
                                                <option value="Tokelau">Tokelau</option>
                                                <option value="Tonga">Tonga</option>
                                                <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                                <option value="Tunisia">Tunisia</option>
                                                <option value="Turkey">Turkey</option>
                                                <option value="Turkmenistan">Turkmenistan</option>
                                                <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                                                <option value="Tuvalu">Tuvalu</option>
                                                <option value="Uganda">Uganda</option>
                                                <option value="Ukraine">Ukraine</option>
                                                <option value="United Arab Emirates">United Arab Emirates</option>
                                                <option value="United Kingdom">United Kingdom</option>
                                                <option value="United States">United States</option>
                                                <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                                                <option value="Uruguay">Uruguay</option>
                                                <option value="Uzbekistan">Uzbekistan</option>
                                                <option value="Vanuatu">Vanuatu</option>
                                                <option value="Venezuela">Venezuela</option>
                                                <option value="Viet Nam">Viet Nam</option>
                                                <option value="Virgin Islands, British">Virgin Islands, British</option>
                                                <option value="Virgin Islands, U.s.">Virgin Islands, U.s.</option>
                                                <option value="Wallis and Futuna">Wallis and Futuna</option>
                                                <option value="Western Sahara">Western Sahara</option>
                                                <option value="Yemen">Yemen</option>
                                                <option value="Zambia">Zambia</option>
                                                <option value="Zimbabwe">Zimbabwe</option>
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
                                            <input type="text" class="form-control" value="<?php echo $_SESSION['user-lname'] ?>" required name="lname" id="floatingInput" placeholder="name@example.com">
                                            <label for="floatingInput">Last Name</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control" value="<?php echo $_SESSION['user-contact'] ?>" required name="contact" id="floatingInput" placeholder="name@example.com">
                                            <label for="floatingInput">Contact Number</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" value="<?php echo $_SESSION['user-city'] ?>" required name="city" id="floatingInput" placeholder="name@example.com">
                                            <label for="floatingInput">City</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control" value="<?php echo $_SESSION['user-postal'] ?>" required name="postal" id="floatingInput" placeholder="name@example.com">
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
                                            <input type="text" class="form-control" value="<?php echo $_SESSION['user-fname'] ?>" required name="fname" id="floatingInput" placeholder="name@example.com">
                                            <label for="floatingInput">First Name</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" value="<?php echo $_SESSION['user-lname'] ?>" required name="lname" id="floatingInput" placeholder="name@example.com">
                                            <label for="floatingInput">Last Name</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control" value="<?php echo $_SESSION['user-contact'] ?>" required name="contact" id="floatingInput" placeholder="name@example.com">
                                            <label for="floatingInput">Contact Number</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" value="<?php echo $_SESSION['user-address'] ?>" required name="address" id="floatingInput" placeholder="name@example.com">
                                            <label for="floatingInput">Address</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" value="<?php echo $_SESSION['user-city'] ?>" required name="city" id="floatingInput" placeholder="name@example.com">
                                            <label for="floatingInput">City</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" value="<?php echo $_SESSION['user-state'] ?>" required name="state" id="floatingInput" placeholder="name@example.com">
                                            <label for="floatingInput">State</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control" value="<?php echo $_SESSION['user-postal'] ?>" required name="postal" id="floatingInput" placeholder="name@example.com">
                                            <label for="floatingInput">Postal Code</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" name="country" id="floatingCountry">
                                                <option value="<?php echo $_SESSION['user-country'] ?>" selected><?php echo $_SESSION['user-country'] ?></option>
                                                <option value="Afghanistan">Afghanistan</option>
                                                <option value="Aland Islands">Aland Islands</option>
                                                <option value="Albania">Albania</option>
                                                <option value="Algeria">Algeria</option>
                                                <option value="American Samoa">American Samoa</option>
                                                <option value="Andorra">Andorra</option>
                                                <option value="Angola">Angola</option>
                                                <option value="Anguilla">Anguilla</option>
                                                <option value="Antarctica">Antarctica</option>
                                                <option value="Antigua and Barbuda">Antigua and Barbuda</option>
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
                                                <option value="Bonaire, Sint Eustatius and Saba">Bonaire, Sint Eustatius and Saba</option>
                                                <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                                <option value="Botswana">Botswana</option>
                                                <option value="Bouvet Island">Bouvet Island</option>
                                                <option value="Brazil">Brazil</option>
                                                <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                                                <option value="Brunei Darussalam">Brunei Darussalam</option>
                                                <option value="Bulgaria">Bulgaria</option>
                                                <option value="Burkina Faso">Burkina Faso</option>
                                                <option value="Burundi">Burundi</option>
                                                <option value="Cambodia">Cambodia</option>
                                                <option value="Cameroon">Cameroon</option>
                                                <option value="Canada">Canada</option>
                                                <option value="Cape Verde">Cape Verde</option>
                                                <option value="Cayman Islands">Cayman Islands</option>
                                                <option value="Central African Republic">Central African Republic</option>
                                                <option value="Chad">Chad</option>
                                                <option value="Chile">Chile</option>
                                                <option value="China">China</option>
                                                <option value="Christmas Island">Christmas Island</option>
                                                <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                                                <option value="Colombia">Colombia</option>
                                                <option value="Comoros">Comoros</option>
                                                <option value="Congo">Congo</option>
                                                <option value="Congo, Democratic Republic of the Congo">Congo, Democratic Republic of the Congo</option>
                                                <option value="Cook Islands">Cook Islands</option>
                                                <option value="Costa Rica">Costa Rica</option>
                                                <option value="Cote D'Ivoire">Cote D'Ivoire</option>
                                                <option value="Croatia">Croatia</option>
                                                <option value="Cuba">Cuba</option>
                                                <option value="Curacao">Curacao</option>
                                                <option value="Cyprus">Cyprus</option>
                                                <option value="Czech Republic">Czech Republic</option>
                                                <option value="Denmark">Denmark</option>
                                                <option value="Djibouti">Djibouti</option>
                                                <option value="Dominica">Dominica</option>
                                                <option value="Dominican Republic">Dominican Republic</option>
                                                <option value="Ecuador">Ecuador</option>
                                                <option value="Egypt">Egypt</option>
                                                <option value="El Salvador">El Salvador</option>
                                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                <option value="Eritrea">Eritrea</option>
                                                <option value="Estonia">Estonia</option>
                                                <option value="Ethiopia">Ethiopia</option>
                                                <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                                                <option value="Faroe Islands">Faroe Islands</option>
                                                <option value="Fiji">Fiji</option>
                                                <option value="Finland">Finland</option>
                                                <option value="France">France</option>
                                                <option value="French Guiana">French Guiana</option>
                                                <option value="French Polynesia">French Polynesia</option>
                                                <option value="French Southern Territories">French Southern Territories</option>
                                                <option value="Gabon">Gabon</option>
                                                <option value="Gambia">Gambia</option>
                                                <option value="Georgia">Georgia</option>
                                                <option value="Germany">Germany</option>
                                                <option value="Ghana">Ghana</option>
                                                <option value="Gibraltar">Gibraltar</option>
                                                <option value="Greece">Greece</option>
                                                <option value="Greenland">Greenland</option>
                                                <option value="Grenada">Grenada</option>
                                                <option value="Guadeloupe">Guadeloupe</option>
                                                <option value="Guam">Guam</option>
                                                <option value="Guatemala">Guatemala</option>
                                                <option value="Guernsey">Guernsey</option>
                                                <option value="Guinea">Guinea</option>
                                                <option value="Guinea-Bissau">Guinea-Bissau</option>
                                                <option value="Guyana">Guyana</option>
                                                <option value="Haiti">Haiti</option>
                                                <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                                                <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                                                <option value="Honduras">Honduras</option>
                                                <option value="Hong Kong">Hong Kong</option>
                                                <option value="Hungary">Hungary</option>
                                                <option value="Iceland">Iceland</option>
                                                <option value="India">India</option>
                                                <option value="Indonesia">Indonesia</option>
                                                <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                                                <option value="Iraq">Iraq</option>
                                                <option value="Ireland">Ireland</option>
                                                <option value="Isle of Man">Isle of Man</option>
                                                <option value="Israel">Israel</option>
                                                <option value="Italy">Italy</option>
                                                <option value="Jamaica">Jamaica</option>
                                                <option value="Japan">Japan</option>
                                                <option value="Jersey">Jersey</option>
                                                <option value="Jordan">Jordan</option>
                                                <option value="Kazakhstan">Kazakhstan</option>
                                                <option value="Kenya">Kenya</option>
                                                <option value="Kiribati">Kiribati</option>
                                                <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                                                <option value="Korea, Republic of">Korea, Republic of</option>
                                                <option value="Kosovo">Kosovo</option>
                                                <option value="Kuwait">Kuwait</option>
                                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                                                <option value="Latvia">Latvia</option>
                                                <option value="Lebanon">Lebanon</option>
                                                <option value="Lesotho">Lesotho</option>
                                                <option value="Liberia">Liberia</option>
                                                <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                                                <option value="Liechtenstein">Liechtenstein</option>
                                                <option value="Lithuania">Lithuania</option>
                                                <option value="Luxembourg">Luxembourg</option>
                                                <option value="Macao">Macao</option>
                                                <option value="Macedonia, the Former Yugoslav Republic of">Macedonia, the Former Yugoslav Republic of</option>
                                                <option value="Madagascar">Madagascar</option>
                                                <option value="Malawi">Malawi</option>
                                                <option value="Malaysia">Malaysia</option>
                                                <option value="Maldives">Maldives</option>
                                                <option value="Mali">Mali</option>
                                                <option value="Malta">Malta</option>
                                                <option value="Marshall Islands">Marshall Islands</option>
                                                <option value="Martinique">Martinique</option>
                                                <option value="Mauritania">Mauritania</option>
                                                <option value="Mauritius">Mauritius</option>
                                                <option value="Mayotte">Mayotte</option>
                                                <option value="Mexico">Mexico</option>
                                                <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                                                <option value="Moldova, Republic of">Moldova, Republic of</option>
                                                <option value="Monaco">Monaco</option>
                                                <option value="Mongolia">Mongolia</option>
                                                <option value="Montenegro">Montenegro</option>
                                                <option value="Montserrat">Montserrat</option>
                                                <option value="Morocco">Morocco</option>
                                                <option value="Mozambique">Mozambique</option>
                                                <option value="Myanmar">Myanmar</option>
                                                <option value="Namibia">Namibia</option>
                                                <option value="Nauru">Nauru</option>
                                                <option value="Nepal">Nepal</option>
                                                <option value="Netherlands">Netherlands</option>
                                                <option value="Netherlands Antilles">Netherlands Antilles</option>
                                                <option value="New Caledonia">New Caledonia</option>
                                                <option value="New Zealand">New Zealand</option>
                                                <option value="Nicaragua">Nicaragua</option>
                                                <option value="Niger">Niger</option>
                                                <option value="Nigeria">Nigeria</option>
                                                <option value="Niue">Niue</option>
                                                <option value="Norfolk Island">Norfolk Island</option>
                                                <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                                <option value="Norway">Norway</option>
                                                <option value="Oman">Oman</option>
                                                <option value="Pakistan">Pakistan</option>
                                                <option value="Palau">Palau</option>
                                                <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                                                <option value="Panama">Panama</option>
                                                <option value="Papua New Guinea">Papua New Guinea</option>
                                                <option value="Paraguay">Paraguay</option>
                                                <option value="Peru">Peru</option>
                                                <option value="Philippines">Philippines</option>
                                                <option value="Pitcairn">Pitcairn</option>
                                                <option value="Poland">Poland</option>
                                                <option value="Portugal">Portugal</option>
                                                <option value="Puerto Rico">Puerto Rico</option>
                                                <option value="Qatar">Qatar</option>
                                                <option value="Reunion">Reunion</option>
                                                <option value="Romania">Romania</option>
                                                <option value="Russian Federation">Russian Federation</option>
                                                <option value="Rwanda">Rwanda</option>
                                                <option value="Saint Barthelemy">Saint Barthelemy</option>
                                                <option value="Saint Helena">Saint Helena</option>
                                                <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                                <option value="Saint Lucia">Saint Lucia</option>
                                                <option value="Saint Martin">Saint Martin</option>
                                                <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                                                <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                                                <option value="Samoa">Samoa</option>
                                                <option value="San Marino">San Marino</option>
                                                <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                                <option value="Saudi Arabia">Saudi Arabia</option>
                                                <option value="Senegal">Senegal</option>
                                                <option value="Serbia">Serbia</option>
                                                <option value="Serbia and Montenegro">Serbia and Montenegro</option>
                                                <option value="Seychelles">Seychelles</option>
                                                <option value="Sierra Leone">Sierra Leone</option>
                                                <option value="Singapore">Singapore</option>
                                                <option value="Sint Maarten">Sint Maarten</option>
                                                <option value="Slovakia">Slovakia</option>
                                                <option value="Slovenia">Slovenia</option>
                                                <option value="Solomon Islands">Solomon Islands</option>
                                                <option value="Somalia">Somalia</option>
                                                <option value="South Africa">South Africa</option>
                                                <option value="South Georgia and the South Sandwich Islands">South Georgia and the South Sandwich Islands</option>
                                                <option value="South Sudan">South Sudan</option>
                                                <option value="Spain">Spain</option>
                                                <option value="Sri Lanka">Sri Lanka</option>
                                                <option value="Sudan">Sudan</option>
                                                <option value="Suriname">Suriname</option>
                                                <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                                                <option value="Swaziland">Swaziland</option>
                                                <option value="Sweden">Sweden</option>
                                                <option value="Switzerland">Switzerland</option>
                                                <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                                                <option value="Taiwan, Province of China">Taiwan, Province of China</option>
                                                <option value="Tajikistan">Tajikistan</option>
                                                <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                                                <option value="Thailand">Thailand</option>
                                                <option value="Timor-Leste">Timor-Leste</option>
                                                <option value="Togo">Togo</option>
                                                <option value="Tokelau">Tokelau</option>
                                                <option value="Tonga">Tonga</option>
                                                <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                                <option value="Tunisia">Tunisia</option>
                                                <option value="Turkey">Turkey</option>
                                                <option value="Turkmenistan">Turkmenistan</option>
                                                <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                                                <option value="Tuvalu">Tuvalu</option>
                                                <option value="Uganda">Uganda</option>
                                                <option value="Ukraine">Ukraine</option>
                                                <option value="United Arab Emirates">United Arab Emirates</option>
                                                <option value="United Kingdom">United Kingdom</option>
                                                <option value="United States">United States</option>
                                                <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                                                <option value="Uruguay">Uruguay</option>
                                                <option value="Uzbekistan">Uzbekistan</option>
                                                <option value="Vanuatu">Vanuatu</option>
                                                <option value="Venezuela">Venezuela</option>
                                                <option value="Viet Nam">Viet Nam</option>
                                                <option value="Virgin Islands, British">Virgin Islands, British</option>
                                                <option value="Virgin Islands, U.s.">Virgin Islands, U.s.</option>
                                                <option value="Wallis and Futuna">Wallis and Futuna</option>
                                                <option value="Western Sahara">Western Sahara</option>
                                                <option value="Yemen">Yemen</option>
                                                <option value="Zambia">Zambia</option>
                                                <option value="Zimbabwe">Zimbabwe</option>
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
                                        <br><br><br><br><br><br>
                                        <br><br>
                                    </div>
                                </div>
                        </div>
                </div>
            </div>
            <div class="container-fluid mt-4">
                <div class="card p-3 bg-light  mt-5">
                    <div class="row row-cols-1 row-cols-md-3 pt-3 m-4 gx-5">
                        <div class="col">
                            <img src="<?php echo $config['URL'] ?>/assets/image/logo/logo8.png" class="rounded mx-auto d-block" alt="...">
                            <p>The best way to prevent and slow down transmission is be well informed about the COVID-19 virus, the disease it causes and how it spreads.</p>
                            <br>
                            <p>Protect yourself and others from infec- tion by washing your hands or using an</p>
                        </div>
                        <div class="col mt-3">
                            <div class="row">
                                <h1 class="text-center"><b>Services</b></h1>
                            </div>
                            <br>
                            <div class="row px-5">
                                <div class="row">
                                    <div class="col">
                                        <h6><a href="<?php echo $config['URL'] ?>/index.php#home" class="text-dark remove-anchor-decoration">Home</a></h6>
                                        <h6><a href="<?php echo $config['URL'] ?>/index.php#about" class="text-dark remove-anchor-decoration">About</a></h6>
                                        <h6><a href="<?php echo $config['URL'] ?>/index.php#symptoms" class="text-dark remove-anchor-decoration">symptoms</a></h6>
                                        <h6><a href="<?php echo $config['URL'] ?>/index.php#protect" class="text-dark remove-anchor-decoration">How to Protect</a></h6>
                                        <h6><a href="<?php echo $config['URL'] ?>/index.php#faq" class="text-dark remove-anchor-decoration">Command Questions</a></h6>
                                        <h6><a href="<?php echo $config['URL'] ?>/index.php#experts" class="text-dark remove-anchor-decoration">See Experts</a></h6>
                                        <h6><a href="<?php echo $config['URL'] ?>/index.php#handwash" class="text-dark remove-anchor-decoration">How to wash hands</a></h6>
                                    </div>
                                    <div class="col">
                                        <h6><a href="<?php echo $config['URL'] ?>/hospitals" class="text-dark remove-anchor-decoration">Book Appointment</a></h6>
                                        <h6><a href="<?php echo $config['URL'] ?>/hospitals" class="text-dark remove-anchor-decoration">Book Covid Test</a></h6>
                                        <?php
                                        if (isset($_SESSION['isloggedin'])) {
                                            if ($_SESSION['Verified']) {
                                        ?>
                                                <h6><a href="<?php echo $config['URL'] ?>/user/appointments" class="text-dark remove-anchor-decoration">My Appointments</a></h6>
                                                <h6><a href="<?php echo $config['URL'] ?>/user/reports" class="text-dark remove-anchor-decoration">My Results/Reports</a></h6>
                                                <h6><a href="<?php echo $config['URL'] ?>/user/settings" class="text-dark remove-anchor-decoration">My Profile</a></h6>
                                            <?php
                                            } else {
                                            ?>
                                                <h6><a href="<?php echo $config['URL'] ?>/user/verify" class="text-dark remove-anchor-decoration">Verify</a></h6>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <h6><a href="<?php echo $config['URL'] ?>/user/login" class="text-dark remove-anchor-decoration">Login</a></h6>
                                            <h6><a href="<?php echo $config['URL'] ?>/user/register" class="text-dark remove-anchor-decoration">Register</a></h6>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col mt-3">
                            <h1><b>Contacts</b></h1>
                            <br>
                            <div class="row row-cols-2">
                                <div class="col-1">
                                    <h4><i class="fas fa-map-marker-alt" style="color: #00aea5;"></i> </h4>
                                </div>
                                <div class="col-9">
                                    <h5>Flat 20, Reynolds Neck, North Helenaville, FV77 8WS</h5>
                                </div>
                            </div>
                            <br>
                            <div class="row row-cols-2">
                                <div class="col-1">
                                    <h4><i class="fas fa-microphone-alt" style="color: #00aea5;"></i> </h4>
                                </div>
                                <div class="col-9">
                                    <h5>+2(305) 587-3407</h5>
                                </div>
                            </div>
                            <br>
                            <div class="row row-cols-2">
                                <div class="col-1">
                                    <h4><i class="fas fa-envelope" style="color: #00aea5;"></i> </h4>
                                </div>
                                <div class="col-9">
                                    <h5>info@example.com</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
            <script src="<?php echo $config['URL'] ?>/assets/js/global.js"></script>
</body>

</html>